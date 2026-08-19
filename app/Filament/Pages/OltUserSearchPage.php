<?php

namespace App\Filament\Pages;

use App\Models\CustomerSubscription;
use Filament\Pages\Page;

class OltUserSearchPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationGroup = 'OLT';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Cari User';

    protected static ?string $title = 'Cari Data User';

    protected static string $view = 'filament.pages.olt-user-search';

    public string $search_type = 'all';
    public string $search_keyword = '';
    public bool $has_searched = false;

    public function getHeading(): string
    {
        return '';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function doSearch(): void
    {
        $this->has_searched = true;
    }

    public function getSearchResultsProperty()
    {
        if (!$this->has_searched && empty($this->search_keyword)) {
            return collect();
        }

        $q = trim($this->search_keyword);
        if (empty($q)) {
            return collect();
        }

        $query = CustomerSubscription::query()->with(['odp.ponPort', 'olt', 'package']);

        if ($this->search_type === 'internet_number') {
            $query->where('internet_number', 'like', "%{$q}%");
        } elseif ($this->search_type === 'customer_name') {
            $query->where('customer_name', 'like', "%{$q}%");
        } elseif ($this->search_type === 'odp') {
            $query->where(function ($sq) use ($q) {
                $sq->where('odp_code', 'like', "%{$q}%")
                   ->orWhereHas('odp', fn ($oq) => $oq->where('name', 'like', "%{$q}%"));
            });
        } elseif ($this->search_type === 'gpon_onu') {
            $query->where('gpon_onu', 'like', "%{$q}%");
        } elseif ($this->search_type === 'phone') {
            $query->where('phone_number', 'like', "%{$q}%");
        } else {
            $query->where(function ($sq) use ($q) {
                $sq->where('internet_number', 'like', "%{$q}%")
                   ->orWhere('customer_name', 'like', "%{$q}%")
                   ->orWhere('phone_number', 'like', "%{$q}%")
                   ->orWhere('odp_code', 'like', "%{$q}%")
                   ->orWhere('gpon_onu', 'like', "%{$q}%")
                   ->orWhere('installation_address', 'like', "%{$q}%")
                   ->orWhereHas('odp', fn ($oq) => $oq->where('name', 'like', "%{$q}%"));
            });
        }

        return $query->limit(50)->get();
    }
}
