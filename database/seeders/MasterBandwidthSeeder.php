<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MasterBandwidthSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Disable Foreign Keys ──
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        }

        // ── 2. Truncate / Clear Old Data ──
        DB::table('building_service_categories')->delete();
        DB::table('building_types')->delete();
        DB::table('bandwidth_packages')->delete();
        DB::table('bandwidth_categories')->delete();

        // ── 3. Insert m_bandwith_kategori (8 Records) ──
        $categories = [
            [
                'code' => 'KB09212',
                'name' => 'UP TO NEW',
                'alias_name' => 'UP TO NEW',
                'registration_fee' => 100000,
                'has_registration_ppn' => true,
                'registration_ppn_percent' => 11,
                'has_billing_ppn' => true,
                'billing_ppn_percent' => 11,
                'is_active' => true,
            ],
            [
                'code' => 'KB1682',
                'name' => 'SMALL OFFICE HOME OFFICE',
                'alias_name' => 'UPTO SOHO',
                'registration_fee' => 500000,
                'has_registration_ppn' => true,
                'registration_ppn_percent' => 11,
                'has_billing_ppn' => true,
                'billing_ppn_percent' => 11,
                'is_active' => true,
            ],
            [
                'code' => 'KB22285',
                'name' => 'CORPORATE',
                'alias_name' => 'CORPORATE',
                'registration_fee' => 1500000,
                'has_registration_ppn' => true,
                'registration_ppn_percent' => 11,
                'has_billing_ppn' => true,
                'billing_ppn_percent' => 11,
                'is_active' => true,
            ],
            [
                'code' => 'KB58163',
                'name' => 'LASTMILE',
                'alias_name' => 'LASTMILE',
                'registration_fee' => 1500000,
                'has_registration_ppn' => true,
                'registration_ppn_percent' => 11,
                'has_billing_ppn' => true,
                'billing_ppn_percent' => 11,
                'is_active' => true,
            ],
            [
                'code' => 'KB69771',
                'name' => 'BROADBAND NEW',
                'alias_name' => 'UPTO BROADBAND',
                'registration_fee' => 300000,
                'has_registration_ppn' => true,
                'registration_ppn_percent' => 11,
                'has_billing_ppn' => true,
                'billing_ppn_percent' => 11,
                'is_active' => true,
            ],
            [
                'code' => 'KB69779',
                'name' => 'BROADBAND',
                'alias_name' => 'UPTO BROADBAND',
                'registration_fee' => 300000,
                'has_registration_ppn' => true,
                'registration_ppn_percent' => 11,
                'has_billing_ppn' => true,
                'billing_ppn_percent' => 11,
                'is_active' => false,
            ],
            [
                'code' => 'KBBOD1',
                'name' => 'BANDWITDH ON DEMAND',
                'alias_name' => 'BOD',
                'registration_fee' => 500000,
                'has_registration_ppn' => true,
                'registration_ppn_percent' => 11,
                'has_billing_ppn' => true,
                'billing_ppn_percent' => 11,
                'is_active' => true,
            ],
            [
                'code' => 'KBFRE02',
                'name' => 'BROADBAND FREE',
                'alias_name' => 'BF',
                'registration_fee' => 0,
                'has_registration_ppn' => true,
                'registration_ppn_percent' => 11,
                'has_billing_ppn' => true,
                'billing_ppn_percent' => 11,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            DB::table('bandwidth_categories')->insert(array_merge($cat, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // ── 4. Insert m_bandwith (All 73 exact records from User SQL) ──
        $rawBandwidths = [
            ['AG0001', 'KB22285', '75', '3500000', '0'],
            ['AG00012', 'KB22285', '80', '1', '0'],
            ['AG000122', 'KB22285', '100', '1', '0'],
            ['AG000125', 'KB22285', '30', '1', '0'],
            ['AG00013', 'KB22285', '100', '10000000', '0'],
            ['AG000133', 'KB58163', '1000', '1', '0'],
            ['AG000134', 'KB58163', '500', '1', '0'],
            ['AG0002', 'KB22285', '30', '750000', '0'],
            ['AG00021', 'KB22285', '15', '1', '0'],
            ['AG000233', 'KB22285', '50', '1', '0'],
            ['AG00024', 'KB22285', '50', '4800000', '0'],
            ['AG0003', 'KB58163', '10', '0', '0'],
            ['AG000312', 'KB58163', '0', '0', '0'],
            ['AG000321', 'KB22285', '350', '1', '0'],
            ['AG0004', 'KB58163', '20', '0', '0'],
            ['AG0005', 'KB58163', '30', '0', '0'],
            ['AG0006', 'KB58163', '40', '0', '0'],
            ['AG0007', 'KB58163', '50', '950000', '0'],
            ['AG0008', 'KB58163', '60', '0', '0'],
            ['AG0009345', 'KB09212', '25', '225000', '0'],
            ['AG00099', 'KB58163', '150', '1', '0'],
            ['AG00101', 'KB58163', '15', '1', '0'],
            ['AG00102', 'KB58163', '25', '1', '0'],
            ['AG0011', 'KB58163', '100', '1', '0'],
            ['AG00111', 'KB58163', '200', '1', '0'],
            ['AG00199', 'KB58163', '1', '1', '0'],
            ['AG0022', 'KB22285', '60', '10000000', '0'],
            ['AG00223', 'KB22285', '150', '1', '0'],
            ['AG002233', 'KB22285', '0', '0', '0'],
            ['AG002234', 'KB22285', '1', '1', '0'],
            ['AG00224', 'KB22285', '300', '1', '0'],
            ['AG00982', 'KBBOD1', '50', '500000', '0'],
            ['AG009822', 'KBBOD1', '200', '2000000', '0'],
            ['AG01298', 'KB58163', '64', '1', '0'],
            ['AG081234', 'KB09212', '30', '250000', '0'],
            ['AG09123', 'KB09212', '20', '200000', '0'],
            ['AG091928', 'KB09212', '10', '100000 (PDR)', '0'],
            ['AG091929', 'KB09212', '15', '150000 (PDR)', '0'],
            ['AG091930', 'KB09212', '30', '200000 (PDR)', '0'],
            ['AG098761', 'KB09212', '15', '165000', '0'],
            ['AG101231', 'KB22285', '120', '1', '0'],
            ['AG101298', 'KBFRE02', '10', '0', '0'],
            ['AG123412', 'KB58163', '30', '1', '0'],
            ['AG13890', 'KB69779', '25', '300000', '0'],
            ['AG16763', 'KB69779', '15', '225000', '0'],
            ['AG167632', 'KB69771', '20', '225000', '0'],
            ['AG19878', 'KB09212', '35', '300000', '0'],
            ['AG26001', 'KB69779', '1', '1', '0'],
            ['AG260012', 'KB69771', '1', '1', '0'],
            ['AG260060', 'KB69771', '10', '150000', '0'],
            ['AG260061', 'KB69771', '30', '300000', '0'],
            ['AG26007', 'KB69779', '10', '200000', '0'],
            ['AG260072', 'KB69771', '15', '200000', '0'],
            ['AG32490', 'KB1682', '20', '599000', '0'],
            ['AG35307', 'KB1682', '30', '699000', '0'],
            ['AG51334', 'KB1682', '10', '499000', '0'],
            ['AG58810', 'KB1682', '50', '899000', '0'],
            ['AG58899', 'KB1682', '40', '799000', '0'],
            ['AG657872', 'KB22285', '170', '1', '0'],
            ['AG68991', 'KB1682', '30', '655000', '0'],
            ['AG73234', 'KB69771', '20', '175000', '0'],
            ['AG789374', 'KB22285', '60', '1', '0'],
            ['AG88223', 'KB69771', '10', '125000', '0'],
            ['AG92760', 'KB69779', '20', '250000', '0'],
            ['AG927602', 'KB69771', '25', '250000', '0'],
            ['AG92761', 'KB1682', '100', '1900000', '0'],
            ['AG98273', 'KB69771', '5', '100000', '0'],
            ['AG99012', 'KB69771', '15', '150000', '0'],
            ['AGFREE12', 'KBFRE02', '15', '0', '0'],
            ['AGFREE23', 'KBFRE02', '20', '0', '0'],
            ['AGFREE34', 'KBFRE02', '25', '0', '0'],
            ['AGFREE45', 'KBFRE02', '30', '0', '0'],
        ];

        $catMap = collect($categories)->pluck('name', 'code')->toArray();

        foreach ($rawBandwidths as $item) {
            $code = $item[0];
            $catCode = $item[1];
            $speed = (int) $item[2];
            $rawPrice = $item[3];
            $disable = $item[4];

            $note = '';
            if (preg_match('/([0-9\.]+)\s*\((.*)\)/', $rawPrice, $m)) {
                $price = (float) $m[1];
                $note = ' (' . $m[2] . ')';
            } else {
                $price = (float) preg_replace('/[^0-9\.]/', '', $rawPrice);
            }

            $catName = $catMap[$catCode] ?? 'Internet';
            $name = "Paket {$speed} Mbps" . ($note ? $note : "");

            DB::table('bandwidth_packages')->insert([
                'code' => $code,
                'category_code' => $catCode,
                'name' => $name,
                'speed_mbps' => $speed,
                'price' => $price,
                'is_active' => ($disable === '0'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ── 5. Insert m_jns_bangunan (7 Records) ──
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
            DB::table('building_types')->insert([
                'code' => $b['code'],
                'name' => $b['name'],
                'user_create' => 'ADMIN',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ── 6. Insert m_layanan_bangunan (17 Records) ──
        $services = [
            ['code' => 'KLB001', 'building_type_code' => 'BN001', 'bandwidth_category_code' => 'KB69779'],
            ['code' => 'KLB002', 'building_type_code' => 'BN001', 'bandwidth_category_code' => 'KB1682'],
            ['code' => 'KLB111', 'building_type_code' => 'BN001', 'bandwidth_category_code' => 'KB69771'],
            ['code' => 'KLB003', 'building_type_code' => 'BN002', 'bandwidth_category_code' => 'KB1682'],
            ['code' => 'KLB004', 'building_type_code' => 'BN002', 'bandwidth_category_code' => 'KB69779'],
            ['code' => 'KLB027', 'building_type_code' => 'BN002', 'bandwidth_category_code' => 'KB09212'],
            ['code' => 'KLB15',  'building_type_code' => 'BN002', 'bandwidth_category_code' => 'KB69771'],
            ['code' => 'KLBF12', 'building_type_code' => 'BN002', 'bandwidth_category_code' => 'KBFRE02'],
            ['code' => 'KLB005', 'building_type_code' => 'BN003', 'bandwidth_category_code' => 'KB1682'],
            ['code' => 'KLB009', 'building_type_code' => 'BN003', 'bandwidth_category_code' => 'KB22285'],
            ['code' => 'KLB011', 'building_type_code' => 'BN003', 'bandwidth_category_code' => 'KB58163'],
            ['code' => 'KLB006', 'building_type_code' => 'BN004', 'bandwidth_category_code' => 'KB1682'],
            ['code' => 'KLB007', 'building_type_code' => 'BN005', 'bandwidth_category_code' => 'KB1682'],
            ['code' => 'KLB008', 'building_type_code' => 'BN006', 'bandwidth_category_code' => 'KB1682'],
            ['code' => 'KLB012', 'building_type_code' => 'BN006', 'bandwidth_category_code' => 'KB58163'],
            ['code' => 'KLB010', 'building_type_code' => 'BN007', 'bandwidth_category_code' => 'KBBOD1'],
            ['code' => 'KLB013', 'building_type_code' => 'BN007', 'bandwidth_category_code' => 'KB58163'],
        ];

        foreach ($services as $s) {
            DB::table('building_service_categories')->insert([
                'code' => $s['code'],
                'building_type_code' => $s['building_type_code'],
                'bandwidth_category_code' => $s['bandwidth_category_code'],
                'user_create' => 'ADMIN',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ── 7. Realign Existing Subscriptions & Mutations ──
        $packageReplacements = [
            'HOME-20M' => 'AG09123',  // UP TO NEW 20 Mbps
            'HOME-30M' => 'AG081234', // UP TO NEW 30 Mbps
            'HOME-50M' => 'AG58810',  // SOHO 50 Mbps
            'HOME-100M' => 'AG92761', // SOHO 100 Mbps
            'BIZ-100M' => 'AG00013',  // CORPORATE 100 Mbps
            'GAME-100M' => 'AG92761', // SOHO 100 Mbps
        ];

        foreach ($packageReplacements as $old => $new) {
            if (Schema::hasTable('customer_subscriptions') && Schema::hasColumn('customer_subscriptions', 'package_code')) {
                DB::table('customer_subscriptions')->where('package_code', $old)->update(['package_code' => $new]);
            }
            if (Schema::hasTable('package_mutations')) {
                if (Schema::hasColumn('package_mutations', 'old_package_code')) {
                    DB::table('package_mutations')->where('old_package_code', $old)->update(['old_package_code' => $new]);
                }
                if (Schema::hasColumn('package_mutations', 'new_package_code')) {
                    DB::table('package_mutations')->where('new_package_code', $old)->update(['new_package_code' => $new]);
                }
            }
        }

        // ── 8. Re-enable Foreign Keys ──
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }
    }
}
