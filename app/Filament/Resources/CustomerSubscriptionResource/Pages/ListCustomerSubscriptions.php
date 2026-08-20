<?php

namespace App\Filament\Resources\CustomerSubscriptionResource\Pages;

use App\Filament\Pages\DataPelangganMatrixPage;
use App\Filament\Resources\CustomerSubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerSubscriptions extends ListRecords
{
    protected static string $resource = CustomerSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back_to_matrix')
                ->label('← Kembali ke Data Pelanggan Matrix')
                ->url(fn (): string => DataPelangganMatrixPage::getUrl())
                ->color('secondary'),
            Actions\CreateAction::make(),
        ];
    }
}
