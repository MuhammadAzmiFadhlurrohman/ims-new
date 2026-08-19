<?php

namespace App\Filament\Resources\CustomerSubscriptionResource\Pages;

use App\Filament\Resources\CustomerSubscriptionResource;
use App\Models\CustomerSubscription;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomerSubscription extends ViewRecord
{
    protected static string $resource = CustomerSubscriptionResource::class;

    protected static string $view = 'filament.resources.customer-subscription.pages.view-customer-subscription';

    protected static ?string $title = 'Detail Profile Pelanggan';

    public function getHeading(): string
    {
        return '';
    }

    public function getRealLogs(): array
    {
        $record = $this->record;
        $logs = [];

        // 1. Status Aktif / Saat ini
        if (in_array($record->registration_status, ['LIVE', '20', 'Aktif'])) {
            $logs[] = [
                'status' => 'Aktif',
                'status_type' => 'aktif',
                'slot' => null,
                'header' => null,
                'description' => 'Tanggal Aktif : ' . ($record->activation_finished_at ? \Carbon\Carbon::parse($record->activation_finished_at)->translatedFormat('d F Y') : ($record->updated_at ? $record->updated_at->translatedFormat('d F Y') : '-')),
                'team' => null,
                'note' => null,
                'date' => $record->updated_at ? $record->updated_at->translatedFormat('d F Y H:i') . ' WIB' : ($record->created_at ? $record->created_at->translatedFormat('d F Y H:i') . ' WIB' : '-'),
                'user' => $record->admin_name ?? 'ADMIN SYSTEM',
            ];
        }

        // 2. Selesai Aktivasi
        if ($record->activation_finished_at || $record->activation_finished_note) {
            $logs[] = [
                'status' => 'Selesai Aktivasi',
                'status_type' => 'done',
                'slot' => null,
                'header' => null,
                'description' => $record->activation_finished_at ? 'Tanggal selesai : ' . \Carbon\Carbon::parse($record->activation_finished_at)->translatedFormat('Y-m-d') : 'Aktivasi selesai',
                'team' => null,
                'note' => $record->activation_finished_note ? 'Catatan Selesai : ' . $record->activation_finished_note : null,
                'date' => $record->activation_finished_at ? \Carbon\Carbon::parse($record->activation_finished_at)->translatedFormat('d F Y H:i') . ' WIB' : ($record->updated_at ? $record->updated_at->translatedFormat('d F Y H:i') . ' WIB' : '-'),
                'user' => $record->admin_name ?? 'NOC',
            ];
        }

        // 3. Jadwal Aktivasi Terbit
        if ($record->activation_date) {
            $teamStr = is_array($record->activation_team) ? implode(', ', $record->activation_team) : $record->activation_team;
            $logs[] = [
                'status' => 'Jadwal Aktivasi Terbit',
                'status_type' => 'step',
                'slot' => \Carbon\Carbon::parse($record->activation_date)->translatedFormat('d F Y') . ($record->activation_time_slot ? ' ' . $record->activation_time_slot : ''),
                'header' => 'POSTING AKTIVASI',
                'description' => null,
                'team' => $teamStr ? 'Team : ' . $teamStr : null,
                'note' => $record->activation_note ? 'Catatan : ' . $record->activation_note : null,
                'date' => $record->activation_date ? \Carbon\Carbon::parse($record->activation_date)->translatedFormat('d F Y H:i') . ' WIB' : '-',
                'user' => $record->admin_name ?? 'ADMIN',
            ];
        }

        // 4. Selesai Instalasi
        if ($record->installation_finished_at || $record->installation_finished_note) {
            $logs[] = [
                'status' => 'Selesai Instalasi',
                'status_type' => 'done',
                'slot' => null,
                'header' => null,
                'description' => $record->installation_finished_at ? 'Tanggal selesai : ' . \Carbon\Carbon::parse($record->installation_finished_at)->translatedFormat('Y-m-d') : 'Instalasi selesai',
                'team' => null,
                'note' => $record->installation_finished_note ? 'Catatan Selesai : ' . $record->installation_finished_note : null,
                'date' => $record->installation_finished_at ? \Carbon\Carbon::parse($record->installation_finished_at)->translatedFormat('d F Y H:i') . ' WIB' : '-',
                'user' => $record->admin_name ?? 'TEKNISI',
            ];
        }

        // 5. Jadwal Instalasi Terbit
        if ($record->installation_date) {
            $teamStr = is_array($record->installation_team) ? implode(', ', $record->installation_team) : $record->installation_team;
            $logs[] = [
                'status' => 'Jadwal Instalasi Terbit',
                'status_type' => 'step',
                'slot' => \Carbon\Carbon::parse($record->installation_date)->translatedFormat('d F Y') . ($record->installation_time_slot ? ' ' . $record->installation_time_slot : ''),
                'header' => 'POSTING INSTALASI',
                'description' => null,
                'team' => $teamStr ? 'Team : ' . $teamStr : null,
                'note' => $record->installation_note ? 'Catatan : ' . $record->installation_note : null,
                'date' => $record->installation_date ? \Carbon\Carbon::parse($record->installation_date)->translatedFormat('d F Y H:i') . ' WIB' : '-',
                'user' => $record->admin_name ?? 'ADMIN',
            ];
        }

        // 6. Selesai Survey
        if ($record->survey_finished_at || $record->survey_finished_note) {
            $logs[] = [
                'status' => 'Selesai Survey',
                'status_type' => 'done',
                'slot' => null,
                'header' => null,
                'description' => $record->survey_finished_at ? 'Tanggal selesai : ' . \Carbon\Carbon::parse($record->survey_finished_at)->translatedFormat('Y-m-d') : 'Survey selesai',
                'team' => null,
                'note' => $record->survey_finished_note ? 'Catatan Selesai : ' . $record->survey_finished_note : null,
                'date' => $record->survey_finished_at ? \Carbon\Carbon::parse($record->survey_finished_at)->translatedFormat('d F Y H:i') . ' WIB' : '-',
                'user' => $record->admin_name ?? 'SURVEYOR',
            ];
        }

        // 7. Jadwal Survey Terbit
        if ($record->survey_date) {
            $teamStr = is_array($record->survey_team) ? implode(', ', $record->survey_team) : $record->survey_team;
            $logs[] = [
                'status' => 'Jadwal Survey Terbit',
                'status_type' => 'step',
                'slot' => \Carbon\Carbon::parse($record->survey_date)->translatedFormat('d F Y') . ($record->survey_time_slot ? ' ' . $record->survey_time_slot : ''),
                'header' => 'POSTING SURVEY',
                'description' => null,
                'team' => $teamStr ? 'Team : ' . $teamStr : null,
                'note' => $record->survey_note ? 'Catatan : ' . $record->survey_note : null,
                'date' => $record->survey_date ? \Carbon\Carbon::parse($record->survey_date)->translatedFormat('d F Y H:i') . ' WIB' : '-',
                'user' => $record->admin_name ?? 'ADMIN',
            ];
        }

        // 8. Registrasi / Pendaftaran Awal (Selalu ada dari created_at)
        $logs[] = [
            'status' => 'Data Input',
            'status_type' => 'step',
            'slot' => null,
            'header' => 'REGISTRASI PELANGGAN',
            'description' => 'Paket Layanan : ' . ($record->package?->name ?? $record->package_code ?? '-'),
            'team' => 'Sales : ' . ($record->sales_name ?? '-'),
            'note' => $record->special_request ? 'Permintaan Khusus : ' . $record->special_request : null,
            'date' => $record->created_at ? $record->created_at->translatedFormat('d F Y H:i') . ' WIB' : '-',
            'user' => $record->admin_name ?? $record->sales_name ?? 'SALES',
        ];

        return $logs;
    }

    public function getEquipmentList(): array
    {
        $equipment = $this->record->installation_equipment;
        if (empty($equipment) || !is_array($equipment)) {
            $equipment = [
                ['name' => 'ONU', 'type' => 'BR013, ZTE F660', 'qty' => '1 UNIT', 'status' => $this->record->sales_name ?? 'NUNU NUGRAHA'],
                ['name' => 'ROSET', 'type' => 'BR006, ROSET', 'qty' => '1 UNIT', 'status' => $this->record->sales_name ?? 'NUNU NUGRAHA'],
                ['name' => 'PIGTAIL', 'type' => 'BR008, PIGTAIL', 'qty' => '1 UNIT', 'status' => $this->record->sales_name ?? 'NUNU NUGRAHA'],
                ['name' => 'PATCH CORD', 'type' => 'BR012, PATCH CORD', 'qty' => '1 UNIT', 'status' => $this->record->sales_name ?? 'NUNU NUGRAHA'],
                ['name' => 'KABEL', 'type' => 'BR001, FO 2 CORE', 'qty' => '200 METER', 'status' => $this->record->sales_name ?? 'NUNU NUGRAHA'],
            ];
            $this->record->update(['installation_equipment' => $equipment]);
        }
        return $equipment;
    }

    public function addDevice(string $name, string $type, string $qty, string $status): void
    {
        $equipment = $this->getEquipmentList();
        $equipment[] = [
            'name' => $name,
            'type' => $type,
            'qty' => $qty,
            'status' => $status,
        ];
        $this->record->update(['installation_equipment' => $equipment]);
        \Filament\Notifications\Notification::make()
            ->title('Perangkat berhasil ditambahkan')
            ->success()
            ->send();
    }

    public function deleteDevice(int $index): void
    {
        $equipment = $this->getEquipmentList();
        if (isset($equipment[$index])) {
            unset($equipment[$index]);
            $equipment = array_values($equipment);
            $this->record->update(['installation_equipment' => $equipment]);
            \Filament\Notifications\Notification::make()
                ->title('Perangkat berhasil dihapus')
                ->success()
                ->send();
        }
    }

    public function updatePpoe(string $username, string $password): void
    {
        $this->record->update([
            'ont_username' => $username,
            'ont_password' => $password,
        ]);
        \Filament\Notifications\Notification::make()
            ->title('ID PPOE berhasil diperbarui')
            ->success()
            ->send();
    }

    public function updateConfiguration(
        string $username,
        string $password,
        string $popName,
        string $popDesc,
        string $mediaAccess,
        string $oltIndex,
        string $notes
    ): void {
        $this->record->update([
            'ont_username' => $username,
            'ont_password' => $password,
            'pppoe_profile' => $popDesc,
            'media_access' => $mediaAccess,
            'odp_code' => $oltIndex,
            'special_request' => $notes,
        ]);

        \Filament\Notifications\Notification::make()
            ->title('Data konfigurasi berhasil diperbarui')
            ->success()
            ->send();
    }
}
