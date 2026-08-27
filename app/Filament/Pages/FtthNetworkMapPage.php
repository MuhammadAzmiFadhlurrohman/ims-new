<?php

namespace App\Filament\Pages;

use App\Models\FtthNetworkElement;
use App\Models\FtthProject;
use App\Models\Odp;
use App\Models\Olt;
use Filament\Pages\Page;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Livewire\WithFileUploads;
use SimpleXMLElement;
use ZipArchive;

class FtthNetworkMapPage extends Page
{
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'OLT';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Peta Jaringan & Jalur FTTH';

    protected static ?string $title = 'Peta Jaringan & Jalur Kabel FTTH (GIS Network Builder)';

    protected static string $view = 'filament.pages.ftth-network-map';

    public ?string $selectedOlt = null;
    public ?int $selectedProjectId = null;
    public $kmzFile = null;

    public function mount(): void
    {
        // Self-healing: auto migrate if table missing on production
        if (!Schema::hasTable('ftth_projects')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e) {
                // Direct DDL fallback if Artisan command cannot run
                if (!Schema::hasTable('ftth_projects')) {
                    Schema::create('ftth_projects', function (Blueprint $table) {
                        $table->id();
                        $table->string('name');
                        $table->string('code', 64)->nullable()->unique();
                        $table->text('description')->nullable();
                        $table->string('color', 20)->default('#0878E5');
                        $table->decimal('center_latitude', 10, 7)->nullable();
                        $table->decimal('center_longitude', 11, 7)->nullable();
                        $table->unsignedSmallInteger('default_zoom')->default(15);
                        $table->boolean('is_active')->default(true);
                        $table->timestamps();
                    });
                }
                if (Schema::hasTable('ftth_network_elements') && !Schema::hasColumn('ftth_network_elements', 'project_id')) {
                    Schema::table('ftth_network_elements', function (Blueprint $table) {
                        $table->foreignId('project_id')->nullable()->after('id')->constrained('ftth_projects')->nullOnDelete();
                        $table->index('project_id');
                    });
                }
            }
        }

        // Ensure at least one project exists
        $firstProject = FtthProject::first();
        if (!$firstProject) {
            $firstProject = FtthProject::create([
                'name' => 'Proyek Utama (Default)',
                'code' => 'PRJ-DEFAULT',
                'description' => 'Area pemetaan utama jaringan FTTH',
                'color' => '#0878E5',
            ]);
        }
        $this->selectedProjectId = $firstProject->id;
    }

    public function getHeading(): string
    {
        return '';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function getAllProjectsProperty()
    {
        if (!Schema::hasTable('ftth_projects')) {
            return collect();
        }
        return FtthProject::query()->withCount('elements')->orderBy('name')->get();
    }

    public function getCurrentProjectProperty()
    {
        if (!Schema::hasTable('ftth_projects') || empty($this->selectedProjectId)) {
            return null;
        }
        return FtthProject::find($this->selectedProjectId);
    }

    public function isDefaultProject(): bool
    {
        if (!$this->selectedProjectId) return false;
        $project = $this->currentProject;
        if (!$project) return false;
        return $project->code === 'PRJ-DEFAULT' || str_contains(strtolower($project->name), 'default') || str_contains(strtolower($project->name), 'utama');
    }

    public function getAllOltsProperty()
    {
        return Olt::query()->get(['id', 'code', 'name', 'ip_address', 'latitude', 'longitude']);
    }

    public function getAllOdpsProperty()
    {
        // ODP Master Database only belongs to Proyek Utama (Default).
        // New custom projects start completely empty without any clutter!
        if (!$this->isDefaultProject()) {
            return collect();
        }

        return Odp::query()
            ->with(['olt', 'ponPort'])
            ->withCount('subscriptions')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($odp) {
                $used = $odp->subscriptions_count ?: ($odp->used_ports ?? 0);
                $max = $odp->total_ports ?: 16;
                return [
                    'code' => $odp->code,
                    'name' => $odp->name ?? $odp->code,
                    'lat' => (float) $odp->latitude,
                    'lng' => (float) $odp->longitude,
                    'used_ports' => (int) $used,
                    'total_ports' => (int) $max,
                    'has_slot' => $used < $max,
                    'olt_code' => $odp->olt_code,
                    'olt_name' => $odp->olt ? $odp->olt->name : ($odp->olt_code ?? '-'),
                    'pon_name' => $odp->ponPort ? $odp->ponPort->name : '-',
                ];
            });
    }

    public function getCustomElementsProperty()
    {
        $query = FtthNetworkElement::query()->latest('id');

        if (!empty($this->selectedProjectId)) {
            $query->where('project_id', $this->selectedProjectId);
        }

        if (!empty($this->selectedOlt)) {
            $query->where(function ($q) {
                $q->where('olt_code', $this->selectedOlt)
                  ->orWhereNull('olt_code');
            });
        }
        return $query->get();
    }

    public function createProject(string $name, ?string $description = null)
    {
        $name = trim($name);
        if (empty($name)) {
            $this->dispatch('project-action-failed', ['message' => 'Nama proyek tidak boleh kosong!']);
            return;
        }

        $colors = ['#0878E5', '#059669', '#7C3AED', '#D97706', '#DB2777', '#2563EB', '#0D9488'];
        $randomColor = $colors[array_rand($colors)];

        $project = FtthProject::create([
            'name' => $name,
            'description' => $description,
            'color' => $randomColor,
        ]);

        $this->selectedProjectId = $project->id;

        $this->dispatch('project-created', [
            'message' => 'Proyek "' . $project->name . '" berhasil dibuat!',
            'project' => $project,
            'elements' => [],
            'odps' => [],
            'allProjects' => $this->allProjects->toArray(),
        ]);
    }

    public function switchProject(int $id)
    {
        $project = FtthProject::find($id);
        if (!$project) return;

        $this->selectedProjectId = $project->id;
        $elements = $this->customElements->toArray();
        $odps = $this->allOdps->toArray();

        $this->dispatch('project-switched', [
            'message' => 'Beralih ke proyek: ' . $project->name,
            'project' => $project,
            'elements' => $elements,
            'odps' => $odps,
            'allProjects' => $this->allProjects->toArray(),
        ]);
    }

    public function deleteProject(int $id)
    {
        $project = FtthProject::find($id);
        if (!$project) return;

        $projectName = $project->name;
        // Delete all elements belonging to this project
        FtthNetworkElement::where('project_id', $project->id)->delete();
        $project->delete();

        // Switch to the first available project or create default
        $fallback = FtthProject::first();
        if (!$fallback) {
            $fallback = FtthProject::create([
                'name' => 'Proyek Utama (Default)',
                'code' => 'PRJ-DEFAULT',
                'description' => 'Area pemetaan utama jaringan FTTH',
                'color' => '#0878E5',
            ]);
        }
        $this->selectedProjectId = $fallback->id;

        $this->dispatch('project-deleted', [
            'message' => 'Proyek "' . $projectName . '" berhasil dihapus!',
            'fallbackProject' => $fallback,
            'elements' => $this->customElements->toArray(),
            'odps' => $this->allOdps->toArray(),
            'allProjects' => $this->allProjects->toArray(),
        ]);
    }

    public function saveElement(array $data)
    {
        $category = $data['category'] ?? 'marker';
        $elementType = $data['element_type'] ?? 'pole';

        $defaultColors = [
            'olt' => '#7C3AED',
            'odc' => '#D97706',
            'odp' => '#0878E5',
            'pole' => '#334155',
            'joint_box' => '#059669',
            'customer' => '#DB2777',
            'feeder' => '#EF4444',
            'distribution' => '#0878E5',
            'dropcore' => '#F59E0B',
        ];

        $color = $data['color'] ?? ($defaultColors[$elementType] ?? '#0878E5');

        $element = FtthNetworkElement::create([
            'project_id' => $this->selectedProjectId,
            'name' => $data['name'] ?? ('Objek ' . strtoupper($elementType)),
            'category' => $category,
            'element_type' => $elementType,
            'olt_code' => $data['olt_code'] ?? ($this->selectedOlt ?: null),
            'latitude' => isset($data['latitude']) ? (float) $data['latitude'] : null,
            'longitude' => isset($data['longitude']) ? (float) $data['longitude'] : null,
            'path_coordinates' => isset($data['path_coordinates']) ? $data['path_coordinates'] : null,
            'length_meters' => isset($data['length_meters']) ? (int) $data['length_meters'] : null,
            'color' => $color,
            'notes' => $data['notes'] ?? null,
            'metadata' => $data['metadata'] ?? null,
        ]);

        $this->dispatch('element-saved', [
            'message' => 'Elemen jaringan "' . $element->name . '" berhasil disimpan!',
            'element' => $element,
        ]);

        return $element->toArray();
    }

    public function updateElement(int $id, array $data)
    {
        $element = FtthNetworkElement::find($id);
        if (!$element) {
            $this->dispatch('element-action-failed', ['message' => 'Elemen tidak ditemukan!']);
            return null;
        }

        $updateData = [];
        if (isset($data['name'])) $updateData['name'] = $data['name'];
        if (array_key_exists('latitude', $data)) $updateData['latitude'] = $data['latitude'] !== null ? (float) $data['latitude'] : null;
        if (array_key_exists('longitude', $data)) $updateData['longitude'] = $data['longitude'] !== null ? (float) $data['longitude'] : null;
        if (array_key_exists('path_coordinates', $data)) $updateData['path_coordinates'] = $data['path_coordinates'];
        if (array_key_exists('length_meters', $data)) $updateData['length_meters'] = (int) $data['length_meters'];
        if (array_key_exists('notes', $data)) $updateData['notes'] = $data['notes'];
        if (isset($data['color'])) $updateData['color'] = $data['color'];
        if (array_key_exists('metadata', $data)) $updateData['metadata'] = $data['metadata'];

        $element->update($updateData);

        $this->dispatch('element-updated', [
            'message' => 'Perubahan "' . $element->name . '" berhasil disimpan!',
            'element' => $element->fresh(),
        ]);

        return $element->toArray();
    }

    public function deleteElement(int $id)
    {
        $element = FtthNetworkElement::find($id);
        if ($element) {
            $name = $element->name;
            $element->delete();
            $this->dispatch('element-deleted', [
                'message' => 'Elemen "' . $name . '" berhasil dihapus!',
                'id' => $id,
            ]);
        }
    }

    public function clearAllCustomElements()
    {
        $query = FtthNetworkElement::query();
        if (!empty($this->selectedProjectId)) {
            $query->where('project_id', $this->selectedProjectId);
        }
        $count = $query->count();
        $query->delete();

        $this->dispatch('elements-cleared', [
            'message' => 'Berhasil membersihkan ' . $count . ' elemen dari proyek ini!',
        ]);
    }

    public function uploadElementPhoto(int $elementId, string $base64Data, ?string $caption = null)
    {
        $element = FtthNetworkElement::find($elementId);
        if (!$element) {
            $this->dispatch('element-action-failed', ['message' => 'Elemen tidak ditemukan!']);
            return;
        }

        try {
            // Extract base64 image data
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $type)) {
                $data = substr($base64Data, strpos($base64Data, ',') + 1);
                $type = strtolower($type[1]);
                if (!in_array($type, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                    $type = 'jpg';
                }
                $data = base64_decode($data);
                if ($data === false) {
                    throw new \Exception('Gagal mendekode gambar base64');
                }
            } else {
                $data = base64_decode($base64Data);
                $type = 'jpg';
            }

            $filename = 'ftth_elem_' . $elementId . '_' . time() . '_' . substr(md5(uniqid()), 0, 6) . '.' . $type;
            $dir = public_path('storage/ftth/photos');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            file_put_contents($dir . '/' . $filename, $data);
            $publicUrl = asset('storage/ftth/photos/' . $filename);

            $metadata = $element->metadata ?? [];
            if (!is_array($metadata)) {
                $metadata = json_decode($metadata, true) ?: [];
            }

            if (!isset($metadata['photos']) || !is_array($metadata['photos'])) {
                $metadata['photos'] = [];
            }

            $newPhoto = [
                'id' => 'photo_' . time() . '_' . substr(md5(uniqid()), 0, 4),
                'url' => $publicUrl,
                'caption' => $caption ?: 'Dokumentasi Lapangan',
                'created_at' => date('d M Y, H:i'),
            ];

            $metadata['photos'][] = $newPhoto;
            $element->update(['metadata' => $metadata]);

            $this->dispatch('element-photo-uploaded', [
                'message' => 'Foto dokumentasi berhasil disimpan!',
                'element' => $element->fresh(),
                'photo' => $newPhoto,
            ]);
        } catch (\Throwable $e) {
            $this->dispatch('element-action-failed', ['message' => 'Gagal mengunggah foto: ' . $e->getMessage()]);
        }
    }

    public function deleteElementPhoto(int $elementId, string $photoId)
    {
        $element = FtthNetworkElement::find($elementId);
        if (!$element) return;

        $metadata = $element->metadata ?? [];
        if (!is_array($metadata)) {
            $metadata = json_decode($metadata, true) ?: [];
        }

        if (isset($metadata['photos']) && is_array($metadata['photos'])) {
            $metadata['photos'] = array_values(array_filter($metadata['photos'], function ($p) use ($photoId) {
                return ($p['id'] ?? '') !== $photoId;
            }));
            $element->update(['metadata' => $metadata]);

            $this->dispatch('element-photo-deleted', [
                'message' => 'Foto dokumentasi berhasil dihapus!',
                'element' => $element->fresh(),
                'deletedPhotoId' => $photoId,
            ]);
        }
    }

    public function importKmzUpload()
    {
        if (!$this->kmzFile) {
            $this->dispatch('import-failed', ['message' => 'Silakan pilih file KMZ atau KML terlebih dahulu!']);
            return;
        }

        $path = $this->kmzFile->getRealPath();
        $extension = strtolower($this->kmzFile->getClientOriginalExtension());
        $originalFileName = $this->kmzFile->getClientOriginalName();
        $projectName = pathinfo($originalFileName, PATHINFO_FILENAME);
        $kmlContent = null;

        if ($extension === 'kmz') {
            $zip = new ZipArchive();
            if ($zip->open($path) === true) {
                // Find doc.kml or any .kml file inside the KMZ archive
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $filename = $zip->getNameIndex($i);
                    if (str_ends_with(strtolower($filename), '.kml')) {
                        $kmlContent = $zip->getFromIndex($i);
                        break;
                    }
                }
                $zip->close();
            }
        } elseif ($extension === 'kml') {
            $kmlContent = file_get_contents($path);
        }

        if (!$kmlContent) {
            $this->dispatch('import-failed', ['message' => 'Gagal mengekstrak data KML dari file yang diupload. Pastikan file KMZ/KML valid!']);
            return;
        }

        // Create or find project for this KMZ import
        $project = FtthProject::firstOrCreate(
            ['name' => $projectName],
            [
                'description' => 'Diimpor otomatis dari file KMZ: ' . $originalFileName,
                'color' => '#059669',
            ]
        );

        $this->selectedProjectId = $project->id;
        $imported = $this->parseAndSaveKml($kmlContent, $project->id);
        $this->kmzFile = null;

        $this->dispatch('kmz-imported', [
            'message' => 'Berhasil membuat proyek "' . $project->name . '" dan mengimpor ' . $imported['total'] . ' objek (' . $imported['markers'] . ' titik & ' . $imported['lines'] . ' kabel)!',
            'count' => $imported['total'],
            'project' => $project,
            'elements' => FtthNetworkElement::where('project_id', $project->id)->latest('id')->get()->toArray(),
            'allProjects' => $this->allProjects->toArray(),
        ]);
    }

    protected function parseAndSaveKml(string $kmlContent, ?int $projectId = null): array
    {
        // Clean Google Earth extension prefixes and XML namespaces
        $cleanKml = str_replace(['gx:', 'kml:'], '', $kmlContent);
        $cleanKml = preg_replace('/\sxmlns[^=]*="[^"]*"/i', '', $cleanKml);

        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($cleanKml);

        $markersCount = 0;
        $linesCount = 0;
        $targetProjectId = $projectId ?: $this->selectedProjectId;

        if ($xml) {
            $placemarks = $xml->xpath('//Placemark') ?: [];
            $recordsToInsert = [];
            $now = now();

            foreach ($placemarks as $pm) {
                $name = trim((string) ($pm->name ?? 'Objek Tanpa Nama'));
                $description = trim((string) ($pm->description ?? ''));

                // 1. Find all Points inside Placemark (including nested MultiGeometry)
                $points = $pm->xpath('.//Point') ?: [];
                foreach ($points as $pt) {
                    if (isset($pt->coordinates)) {
                        $coordsStr = trim((string) $pt->coordinates);
                        $parts = explode(',', $coordsStr);
                        if (count($parts) >= 2) {
                            $lng = (float) trim($parts[0]);
                            $lat = (float) trim($parts[1]);

                            if ($lat != 0 && $lng != 0) {
                                $type = $this->classifyMarkerType($name, $description);
                                $colorMap = [
                                    'olt' => '#7C3AED',
                                    'odc' => '#D97706',
                                    'pole' => '#334155',
                                    'joint_box' => '#059669',
                                    'customer' => '#DB2777',
                                ];

                                $recordsToInsert[] = [
                                    'project_id' => $targetProjectId,
                                    'name' => $name,
                                    'category' => 'marker',
                                    'element_type' => $type,
                                    'olt_code' => $this->selectedOlt ?: null,
                                    'latitude' => $lat,
                                    'longitude' => $lng,
                                    'path_coordinates' => null,
                                    'length_meters' => null,
                                    'color' => $colorMap[$type] ?? '#334155',
                                    'notes' => $description ? strip_tags($description) : null,
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                ];
                                $markersCount++;
                            }
                        }
                    }
                }

                // 2. Find all LineStrings inside Placemark (including nested MultiGeometry)
                $lineStrings = $pm->xpath('.//LineString') ?: [];
                foreach ($lineStrings as $ls) {
                    if (isset($ls->coordinates)) {
                        $coordsStr = trim((string) $ls->coordinates);
                        $rawPoints = preg_split('/[\s\n\r]+/', $coordsStr);
                        $lineCoords = [];

                        foreach ($rawPoints as $rp) {
                            $rp = trim($rp);
                            if (!$rp) continue;
                            $parts = explode(',', $rp);
                            if (count($parts) >= 2) {
                                $lng = (float) trim($parts[0]);
                                $lat = (float) trim($parts[1]);
                                if ($lat != 0 && $lng != 0) {
                                    $lineCoords[] = [$lat, $lng];
                                }
                            }
                        }

                        if (count($lineCoords) >= 2) {
                            $type = $this->classifyLineType($name, $description);
                            $colorMap = [
                                'feeder' => '#EF4444',
                                'distribution' => '#0878E5',
                                'dropcore' => '#F59E0B',
                            ];

                            $calcDist = 0;
                            for ($i = 0; $i < count($lineCoords) - 1; $i++) {
                                $calcDist += $this->calcDistMeters($lineCoords[$i][0], $lineCoords[$i][1], $lineCoords[$i+1][0], $lineCoords[$i+1][1]);
                            }

                            $recordsToInsert[] = [
                                'project_id' => $targetProjectId,
                                'name' => $name,
                                'category' => 'line',
                                'element_type' => $type,
                                'olt_code' => $this->selectedOlt ?: null,
                                'latitude' => null,
                                'longitude' => null,
                                'path_coordinates' => json_encode($lineCoords),
                                'length_meters' => $calcDist,
                                'color' => $colorMap[$type] ?? '#0878E5',
                                'notes' => $description ? strip_tags($description) : null,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                            $linesCount++;
                        }
                    }
                }
            }

            // Bulk insert in chunks for blazing performance
            if (!empty($recordsToInsert)) {
                foreach (array_chunk($recordsToInsert, 100) as $chunk) {
                    FtthNetworkElement::insert($chunk);
                }
            }
        }

        return [
            'total' => $markersCount + $linesCount,
            'markers' => $markersCount,
            'lines' => $linesCount,
        ];
    }

    protected function classifyMarkerType(string $name, string $description): string
    {
        $text = strtolower($name . ' ' . $description);

        if (str_contains($text, 'olt') || str_contains($text, 'core') || str_contains($text, 'server') || str_contains($text, 'headend')) {
            return 'olt';
        }
        if (str_contains($text, 'odc') || str_contains($text, 'fdt') || str_contains($text, 'cabinet') || str_contains($text, 'rk ')) {
            return 'odc';
        }
        if (str_contains($text, 'hh') || str_contains($text, 'handhole') || str_contains($text, 'joint') || str_contains($text, 'closure') || str_contains($text, 'fosc') || str_contains($text, 'splice')) {
            return 'joint_box';
        }
        if (str_contains($text, 'pelanggan') || str_contains($text, 'ont') || str_contains($text, 'customer') || str_contains($text, 'rumah') || str_contains($text, 'home')) {
            return 'customer';
        }
        return 'pole'; // Default marker type is pole / tiang
    }

    protected function classifyLineType(string $name, string $description): string
    {
        $text = strtolower($name . ' ' . $description);

        if (str_contains($text, 'feeder') || str_contains($text, 'backbone') || str_contains($text, 'trunk') || str_contains($text, '96c') || str_contains($text, '48c')) {
            return 'feeder';
        }
        if (str_contains($text, 'drop') || str_contains($text, 'dc ') || str_contains($text, '1c') || str_contains($text, '2c') || str_contains($text, 'pelanggan')) {
            return 'dropcore';
        }
        return 'distribution'; // Default line type is distribution
    }

    protected function calcDistMeters($lat1, $lon1, $lat2, $lon2): int
    {
        $R = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return (int) round($R * $c);
    }
}
