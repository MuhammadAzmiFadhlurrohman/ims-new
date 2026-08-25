<?php

namespace App\Filament\Pages;

use App\Models\FtthNetworkElement;
use App\Models\Odp;
use App\Models\Olt;
use Filament\Pages\Page;

class FtthNetworkMapPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'OLT';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Peta Jaringan & Jalur FTTH';

    protected static ?string $title = 'Peta Jaringan & Jalur Kabel FTTH (GIS Network Builder)';

    protected static string $view = 'filament.pages.ftth-network-map';

    public ?string $selectedOlt = null;

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

        // Default colors by element type
        $defaultColors = [
            'olt' => '#8B5CF6',
            'odc' => '#F59E0B',
            'odp' => '#0878E5',
            'pole' => '#64748B',
            'joint_box' => '#10B981',
            'customer' => '#EC4899',
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
}
