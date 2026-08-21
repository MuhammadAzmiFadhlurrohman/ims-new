<?php

namespace App\Filament\Resources\InstallationPipelineResource\Pages;

use App\Filament\Resources\InstallationPipelineResource;
use App\Models\CustomerSubscription;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListInstallationPipelines extends ListRecords
{
    protected static string $resource = InstallationPipelineResource::class;

    protected static ?string $title = 'Registrasion';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Registrasi Baru')
                ->icon('heroicon-m-user-plus'),
        ];
    }


    public function updateStatusType(string $key, string $statusType): void
    {
        $record = CustomerSubscription::find($key);
        if ($record) {
            $record->update([
                'status_type' => $statusType,
            ]);

            Notification::make()
                ->title('Status Tipe Berhasil Diubah')
                ->body("Status untuk {$record->customer_name} telah diubah menjadi {$statusType}.")
                ->success()
                ->send();
        }
    }
}
