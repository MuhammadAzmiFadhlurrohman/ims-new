<?php

namespace App\Filament\Resources\InstallationPipelineResource\Pages;

use App\Filament\Resources\InstallationPipelineResource;
use App\Models\Customer;
use Filament\Resources\Pages\CreateRecord;

class CreateInstallationPipeline extends CreateRecord
{
    protected static string $resource = InstallationPipelineResource::class;

    protected static ?string $title = 'Form Registration';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! empty($data['customer_nik'])) {
            $addr = $data['address_ktp'] ?? $data['installation_address'] ?? '-';
            Customer::updateOrCreate(
                ['nik' => $data['customer_nik']],
                [
                    'name' => $data['customer_name'] ?? 'Pelanggan Baru',
                    'email' => $data['email'] ?? null,
                    'phone_number' => $data['phone_number'] ?? null,
                    'address' => $addr,
                    'id_card_address' => $addr,
                    'gender' => $data['gender'] ?? 'male',
                    'birth_date' => $data['birth_date'] ?? null,
                    'is_corporate' => ! empty($data['is_corporate']),
                    'pic_name' => $data['pic_name'] ?? null,
                    'province' => $data['province_ktp'] ?? $data['province'] ?? null,
                    'city' => $data['city_ktp'] ?? $data['city'] ?? null,
                    'district' => $data['district_ktp'] ?? $data['district'] ?? null,
                    'id_card_photo' => $data['id_card_photo'] ?? null,
                    'house_photo' => $data['house_photo'] ?? null,
                ]
            );
        }

        if (empty($data['registration_status'])) {
            $data['registration_status'] = 'Data Input';
        }

        if (empty($data['ont_username']) && ! empty($data['internet_number'])) {
            $cleanNum = preg_replace('/[^0-9]/', '', $data['internet_number']);
            $data['ont_username'] = ! empty($cleanNum) ? $cleanNum : $data['internet_number'];
        }

        if (empty($data['ont_password'])) {
            $data['ont_password'] = (string) rand(100000, 999999);
        }

        return $data;
    }
}
