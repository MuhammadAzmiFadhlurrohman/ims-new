<?php

namespace Database\Seeders;

use App\Models\BandwidthCategory;
use App\Models\BandwidthPackage;
use App\Models\BuildingType;
use App\Models\BuildingServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingTypeAndServiceSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Categories if missing or update
        $categories = [
            ['code' => 'KB09212', 'name' => 'UP TO NEW', 'alias_name' => 'UP TO NEW', 'registration_fee' => 100000],
            ['code' => 'KB1682', 'name' => 'SMALL OFFICE HOME OFFICE', 'alias_name' => 'UPTO SOHO', 'registration_fee' => 500000],
            ['code' => 'KB22285', 'name' => 'CORPORATE', 'alias_name' => 'CORPORATE', 'registration_fee' => 1500000],
            ['code' => 'KB58163', 'name' => 'LASTMILE', 'alias_name' => 'LASTMILE', 'registration_fee' => 1500000],
            ['code' => 'KB69771', 'name' => 'BROADBAND NEW', 'alias_name' => 'UPTO BROADBAND', 'registration_fee' => 300000],
            ['code' => 'KB69779', 'name' => 'BROADBAND', 'alias_name' => 'UPTO BROADBAND', 'registration_fee' => 300000],
            ['code' => 'KBBOD1', 'name' => 'BANDWITDH ON DEMAND', 'alias_name' => 'BOD', 'registration_fee' => 500000],
            ['code' => 'KBFRE02', 'name' => 'BROADBAND FREE', 'alias_name' => 'BF', 'registration_fee' => 0],
        ];

        foreach ($categories as $c) {
            BandwidthCategory::updateOrCreate(
                ['code' => $c['code']],
                [
                    'name' => $c['name'],
                    'alias_name' => $c['alias_name'],
                    'registration_fee' => $c['registration_fee'],
                    'has_registration_ppn' => true,
                    'registration_ppn_percent' => 11,
                    'has_billing_ppn' => true,
                    'billing_ppn_percent' => 11,
                    'is_active' => true,
                ]
            );
        }

        // 2. Seed Jenis Bangunan (m_jns_bangunan)
        $buildings = [
            ['code' => 'BN001', 'name' => 'KOS-KOSAN'],
            ['code' => 'BN002', 'name' => 'RUMAH-PRIBADI'],
            ['code' => 'BN003', 'name' => 'RUMAH-KANTOR'],
            ['code' => 'BN004', 'name' => 'RUKO'],
            ['code' => 'BN005', 'name' => 'APARTEMEN'],
            ['code' => 'BN006', 'name' => 'GEDUNG'],
            ['code' => 'BN007', 'name' => 'OUTDOR/EVENT'],
        ];

        foreach ($buildings as $b) {
            DB::table('building_types')->updateOrInsert(
                ['code' => $b['code']],
                [
                    'name' => $b['name'],
                    'user_create' => 'ADMIN',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // 3. Seed Layanan Bangunan (m_layanan_bangunan)
        $services = [
            ['code' => 'KLB001', 'building_type_code' => 'BN001', 'bandwidth_category_code' => 'KB69779'], // KOS-KOSAN -> BROADBAND
            ['code' => 'KLB002', 'building_type_code' => 'BN001', 'bandwidth_category_code' => 'KB1682'],  // KOS-KOSAN -> SOHO
            ['code' => 'KLB111', 'building_type_code' => 'BN001', 'bandwidth_category_code' => 'KB69771'], // KOS-KOSAN -> BROADBAND NEW
            ['code' => 'KLB003', 'building_type_code' => 'BN002', 'bandwidth_category_code' => 'KB1682'],  // RUMAH-PRIBADI -> SOHO
            ['code' => 'KLB004', 'building_type_code' => 'BN002', 'bandwidth_category_code' => 'KB69779'], // RUMAH-PRIBADI -> BROADBAND
            ['code' => 'KLB027', 'building_type_code' => 'BN002', 'bandwidth_category_code' => 'KB09212'], // RUMAH-PRIBADI -> UP TO NEW
            ['code' => 'KLB15',  'building_type_code' => 'BN002', 'bandwidth_category_code' => 'KB69771'], // RUMAH-PRIBADI -> BROADBAND NEW
            ['code' => 'KLBF12', 'building_type_code' => 'BN002', 'bandwidth_category_code' => 'KBFRE02'], // RUMAH-PRIBADI -> BROADBAND FREE
            ['code' => 'KLB005', 'building_type_code' => 'BN003', 'bandwidth_category_code' => 'KB1682'],  // RUMAH-KANTOR -> SOHO
            ['code' => 'KLB009', 'building_type_code' => 'BN003', 'bandwidth_category_code' => 'KB22285'], // RUMAH-KANTOR -> CORPORATE
            ['code' => 'KLB011', 'building_type_code' => 'BN003', 'bandwidth_category_code' => 'KB58163'], // RUMAH-KANTOR -> LASTMILE
            ['code' => 'KLB006', 'building_type_code' => 'BN004', 'bandwidth_category_code' => 'KB1682'],  // RUKO -> SOHO
            ['code' => 'KLB007', 'building_type_code' => 'BN005', 'bandwidth_category_code' => 'KB1682'],  // APARTEMEN -> SOHO
            ['code' => 'KLB008', 'building_type_code' => 'BN006', 'bandwidth_category_code' => 'KB1682'],  // GEDUNG -> SOHO
            ['code' => 'KLB012', 'building_type_code' => 'BN006', 'bandwidth_category_code' => 'KB58163'], // GEDUNG -> LASTMILE
            ['code' => 'KLB010', 'building_type_code' => 'BN007', 'bandwidth_category_code' => 'KBBOD1'],  // OUTDOR/EVENT -> BOD
            ['code' => 'KLB013', 'building_type_code' => 'BN007', 'bandwidth_category_code' => 'KB58163'], // OUTDOR/EVENT -> LASTMILE
        ];

        foreach ($services as $s) {
            DB::table('building_service_categories')->updateOrInsert(
                ['code' => $s['code']],
                [
                    'building_type_code' => $s['building_type_code'],
                    'bandwidth_category_code' => $s['bandwidth_category_code'],
                    'user_create' => 'ADMIN',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
