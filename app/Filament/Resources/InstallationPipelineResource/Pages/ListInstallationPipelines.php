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

    public function getHeader(): ?View
    {
        $totalPipelines = CustomerSubscription::whereNotIn('registration_status', ['20', 'LIVE', 'Live', 'aktif', 'Aktif', 'AKTIF'])->count();
        $pendingCount = CustomerSubscription::whereIn('registration_status', ['01', '02', '03', '04', '05', '06', 'PENDING', 'SURVEY', 'survey'])->count();
        $readyInstallCount = CustomerSubscription::whereIn('registration_status', ['07', '08', '09', '10', '11', '12', '13', '14', '15', 'PASANG', 'INSTALL'])->count();

        return view('filament.headers.installation-pipeline-header', [
            'totalPipelines' => $totalPipelines,
            'pendingCount' => $pendingCount,
            'readyInstallCount' => $readyInstallCount,
        ]);
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
