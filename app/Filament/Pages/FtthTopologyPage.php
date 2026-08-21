<?php

namespace App\Filament\Pages;

use App\Models\CustomerSubscription;
use App\Models\Odp;
use App\Models\Olt;
use App\Models\PonPort;
use Filament\Pages\Page;

class FtthTopologyPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected static ?string $navigationGroup = 'OLT';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Topologi FTTH';

    protected static ?string $title = 'Topologi Jaringan FTTH (OLT ➔ PON ➔ ODP ➔ User)';

    protected static string $view = 'filament.pages.ftth-topology';

    public ?string $selectedOlt = null;

    public ?int $selectedPon = null;

    public ?string $selectedOdp = null;

    public string $search = '';

    public ?string $tracedUser = null;

    public array $collapsedPons = [];

    public array $collapsedOdps = [];

    public function mount(): void
    {
        // Select first OLT by default if available
        $firstOlt = Olt::query()->first();
        if ($firstOlt) {
            $this->selectedOlt = $firstOlt->code;
        }
    }

    public function getHeading(): string
    {
        return '';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function selectOlt(?string $code): void
    {
        $this->selectedOlt = $code;
        $this->selectedPon = null;
        $this->selectedOdp = null;
        $this->tracedUser = null;
    }

    public function selectPon(?int $id): void
    {
        $this->selectedPon = ($this->selectedPon === $id) ? null : $id;
        $this->selectedOdp = null;
    }

    public function selectOdp(?string $code): void
    {
        $this->selectedOdp = ($this->selectedOdp === $code) ? null : $code;
    }

    public function isPonCollapsed($ponId): bool
    {
        return !empty($this->collapsedPons[(string)$ponId]);
    }

    public function togglePon($ponId): void
    {
        $key = (string)$ponId;
        if (!empty($this->collapsedPons[$key])) {
            unset($this->collapsedPons[$key]);
        } else {
            $this->collapsedPons[$key] = true;
        }
    }

    public function isOdpCollapsed($odpCode): bool
    {
        return !empty($this->collapsedOdps[(string)$odpCode]);
    }

    public function toggleOdp($odpCode): void
    {
        $key = (string)$odpCode;
        if (!empty($this->collapsedOdps[$key])) {
            unset($this->collapsedOdps[$key]);
        } else {
            $this->collapsedOdps[$key] = true;
        }
    }

    public function expandAll(): void
    {
        $this->collapsedPons = [];
        $this->collapsedOdps = [];
    }

    public function collapseAll(): void
    {
        $this->collapsedPons = [];
        $this->collapsedOdps = [];
        foreach (PonPort::pluck('id') as $id) {
            $this->collapsedPons[(string)$id] = true;
        }
        foreach (Odp::pluck('code') as $code) {
            $this->collapsedOdps[(string)$code] = true;
        }
    }

    public function resetFilters(): void
    {
        $this->selectedOlt = null;
        $this->selectedPon = null;
        $this->selectedOdp = null;
        $this->search = '';
        $this->tracedUser = null;
        $this->expandAll();
    }

    public function traceUser(string $internetNo): void
    {
        $sub = CustomerSubscription::query()
            ->with(['odp.ponPort.olt'])
            ->where('internet_number', $internetNo)
            ->first();

        if ($sub && $sub->odp) {
            $this->tracedUser = $internetNo;
            $this->selectedOdp = $sub->odp_code;
            if ($sub->odp->ponPort) {
                $this->selectedPon = $sub->odp->ponPort->id;
                if ($sub->odp->ponPort->olt) {
                    $this->selectedOlt = $sub->odp->ponPort->olt->code;
                }
            } elseif ($sub->odp->olt_code) {
                $this->selectedOlt = $sub->odp->olt_code;
            }

            // Ensure uncollapsed
            unset($this->collapsedPons[(string)$this->selectedPon]);
            unset($this->collapsedOdps[(string)$this->selectedOdp]);
        }
    }

    /**
     * Get FTTH Overview Statistics
     */
    public function getStatsProperty(): array
    {
        $totalOlts = Olt::count();
        $totalPons = PonPort::count();
        $totalOdps = Odp::count();
        $totalSubs = CustomerSubscription::whereNotNull('odp_code')->count();
        $totalOdpCapacity = Odp::sum('total_ports') ?: ($totalOdps * 8);
        $usedOdpCapacity = Odp::sum('used_ports') ?: $totalSubs;

        $occupancyRate = $totalOdpCapacity > 0 ? round(($usedOdpCapacity / $totalOdpCapacity) * 100, 1) : 0;

        return [
            'total_olts' => $totalOlts,
            'total_pons' => $totalPons,
            'total_odps' => $totalOdps,
            'total_subs' => $totalSubs,
            'odp_capacity' => $totalOdpCapacity,
            'odp_used' => $usedOdpCapacity,
            'occupancy_rate' => $occupancyRate,
        ];
    }

    /**
     * Get Filtered Topology Tree Data
     */
    public function getTopologyTreeProperty()
    {
        $searchTerm = trim($this->search);

        $query = Olt::query()
            ->with(['pop'])
            ->with(['ponPorts' => function ($q) use ($searchTerm) {
                if ($this->selectedPon) {
                    $q->where('id', $this->selectedPon);
                }
                $q->with(['odps' => function ($odpQ) use ($searchTerm) {
                    if ($this->selectedOdp) {
                        $odpQ->where('code', $this->selectedOdp);
                    }
                    if (!empty($searchTerm)) {
                        $odpQ->where(function ($s) use ($searchTerm) {
                            $s->where('code', 'like', "%{$searchTerm}%")
                              ->orWhere('name', 'like', "%{$searchTerm}%")
                              ->orWhereHas('subscriptions', function ($subQ) use ($searchTerm) {
                                  $subQ->where('internet_number', 'like', "%{$searchTerm}%")
                                       ->orWhere('customer_name', 'like', "%{$searchTerm}%");
                              });
                        });
                    }
                    $odpQ->with(['subscriptions' => function ($subQ) use ($searchTerm) {
                        $subQ->with(['customer', 'package']);
                        if (!empty($searchTerm)) {
                            $subQ->where(function ($s) use ($searchTerm) {
                                $s->where('internet_number', 'like', "%{$searchTerm}%")
                                  ->orWhere('customer_name', 'like', "%{$searchTerm}%");
                            });
                        }
                    }]);
                }]);
            }]);

        if ($this->selectedOlt) {
            $query->where('code', $this->selectedOlt);
        }

        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('code', 'like', "%{$searchTerm}%")
                  ->orWhereHas('ponPorts.odps', function ($odpQ) use ($searchTerm) {
                      $odpQ->where('code', 'like', "%{$searchTerm}%")
                           ->orWhere('name', 'like', "%{$searchTerm}%")
                           ->orWhereHas('subscriptions', function ($subQ) use ($searchTerm) {
                               $subQ->where('internet_number', 'like', "%{$searchTerm}%")
                                    ->orWhere('customer_name', 'like', "%{$searchTerm}%");
                           });
                  });
            });
        }

        return $query->get();
    }

    /**
     * Search Suggestions for User / ODP Tracing
     */
    public function getSearchResultsProperty()
    {
        if (empty($this->search) || strlen($this->search) < 2) {
            return collect();
        }

        $term = trim($this->search);

        $users = CustomerSubscription::query()
            ->with(['odp.ponPort.olt', 'customer'])
            ->whereNotNull('odp_code')
            ->where(function ($q) use ($term) {
                $q->where('internet_number', 'like', "%{$term}%")
                  ->orWhere('customer_name', 'like', "%{$term}%");
            })
            ->limit(6)
            ->get();

        $odps = Odp::query()
            ->with(['ponPort.olt'])
            ->where('code', 'like', "%{$term}%")
            ->orWhere('name', 'like', "%{$term}%")
            ->limit(4)
            ->get();

        return [
            'users' => $users,
            'odps' => $odps,
        ];
    }
}
