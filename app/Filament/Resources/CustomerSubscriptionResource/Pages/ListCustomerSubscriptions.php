<?php

namespace App\Filament\Resources\CustomerSubscriptionResource\Pages;

use App\Filament\Resources\CustomerSubscriptionResource;
use App\Models\CustomerSubscription;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListCustomerSubscriptions extends ListRecords
{
    protected static string $resource = CustomerSubscriptionResource::class;

    public function getHeader(): ?View
    {
        $activeCustomers = CustomerSubscription::where(function ($q) {
            $q->whereIn('registration_status', ['LIVE', 'live', 'Live', '20', 'Aktif', 'AKTIF', 'aktif'])
              ->orWhereRaw('UPPER(registration_status) IN ("LIVE", "20", "AKTIF")');
        })->where('is_isolated', false)->where('is_terminated', false)->count();

        $isolatedCustomers = CustomerSubscription::where(function ($q) {
            $q->where('is_isolated', true)
              ->orWhereIn('registration_status', ['21', 'Suspend', 'SUSPEND', 'suspend', 'ISOLIR', 'Isolir', 'isolir'])
              ->orWhereRaw('UPPER(registration_status) IN ("21", "SUSPEND", "ISOLIR")');
        })->where('is_terminated', false)->count();

        $terminatedCustomers = CustomerSubscription::where(function ($q) {
            $q->where('is_terminated', true)
              ->orWhereIn('registration_status', ['23', 'Terminasi', 'TERMINASI', 'terminasi'])
              ->orWhereRaw('UPPER(registration_status) IN ("23", "TERMINASI")');
        })->count();

        $totalCustomers = $activeCustomers + $isolatedCustomers;

        return view('filament.headers.customer-subscription-header', [
            'totalCustomers' => $totalCustomers,
            'activeCustomers' => $activeCustomers,
            'isolatedCustomers' => $isolatedCustomers,
            'terminatedCustomers' => $terminatedCustomers,
        ]);
    }
}
