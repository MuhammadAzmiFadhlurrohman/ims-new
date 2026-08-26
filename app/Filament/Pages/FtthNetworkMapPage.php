<?php

namespace App\Filament\Pages;

use App\Models\FtthNetworkElement;
use App\Models\Odp;
use App\Models\Olt;
use Filament\Pages\Page;
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
    public $kmzFile = null;

    public function getHeading(): string
    {
        return '';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function getAllOltsProperty()
    {
        return Olt::query()->get(['id', 'code', 'name', 'ip_address', 'latitude', 'longitude']);
    }

    public function getAllOdpsProperty()
    {
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
        if (!empty($this->selectedOlt)) {
            $query->where(function ($q) {
                $q->where('olt_code', $this->selectedOlt)
                  ->orWhereNull('olt_code');
            });
        }
        return $query->get();
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

    public function importKmzUpload()
    {
        if (!$this->kmzFile) {
            $this->dispatch('import-failed', ['message' => 'Silakan pilih file KMZ atau KML terlebih dahulu!']);
            return;
        }

        $path = $this->kmzFile->getRealPath();
        $extension = strtolower($this->kmzFile->getClientOriginalExtension());
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

        $imported = $this->parseAndSaveKml($kmlContent);
        $this->kmzFile = null;

        $this->dispatch('kmz-imported', [
            'message' => 'Berhasil mengimpor ' . $imported['total'] . ' objek jaringan (' . $imported['markers'] . ' titik & ' . $imported['lines'] . ' jalur kabel) dari KMZ!',
            'count' => $imported['total'],
            'elements' => FtthNetworkElement::latest('id')->get()->toArray(),
        ]);
    }

    protected function parseAndSaveKml(string $kmlContent): array
    {
        // Clean Google Earth extension prefixes and XML namespaces
        $cleanKml = str_replace(['gx:', 'kml:'], '', $kmlContent);
        $cleanKml = preg_replace('/\sxmlns[^=]*="[^"]*"/i', '', $cleanKml);

        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($cleanKml);

        $markersCount = 0;
        $linesCount = 0;

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

    protected function classifyMarkerType(string $name, string $desc): string
    {
        $text = strtolower($name . ' ' . $desc);
        if (str_contains($text, 'olt') || str_contains($text, 'server') || str_contains($text, 'headend') || str_contains($text, 'core')) {
            return 'olt';
        }
        if (str_contains($text, 'odc') || str_contains($text, 'fdt') || str_contains($text, 'cabinet')) {
            return 'odc';
        }
        if (str_contains($text, 'joint') || str_contains($text, 'sambung') || str_contains($text, 'closure') || str_contains($text, 'fosc') || str_contains($text, 'jb') || str_contains($text, 'handhole') || str_contains($text, 'manhole') || preg_match('/\bhh\b/i', $text) || str_starts_with($text, 'hh ') || str_starts_with($text, 'hh-')) {
            return 'joint_box';
        }
        if (str_contains($text, 'customer') || str_contains($text, 'pelanggan') || str_contains($text, 'ont') || str_contains($text, 'rumah') || str_contains($text, 'user')) {
            return 'customer';
        }
        return 'pole';
    }

    protected function classifyLineType(string $name, string $desc): string
    {
        $text = strtolower($name . ' ' . $desc);
        if (str_contains($text, 'feeder') || str_contains($text, 'backbone') || str_contains($text, '48c') || str_contains($text, '96c') || str_contains($text, '24c')) {
            return 'feeder';
        }
        if (str_contains($text, 'drop') || str_contains($text, 'dropcore') || str_contains($text, '1c') || str_contains($text, '2c') || str_contains($text, 'pelanggan')) {
            return 'dropcore';
        }
        return 'distribution';
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
