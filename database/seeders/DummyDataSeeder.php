<?php

namespace Database\Seeders;

use App\Models\BandwidthCategory;
use App\Models\BandwidthPackage;
use App\Models\CompanyBank;
use App\Models\CoverageLead;
use App\Models\Customer;
use App\Models\CustomerDevice;
use App\Models\CustomerSubscription;
use App\Models\InstallationPipeline;
use App\Models\MonthlyInvoice;
use App\Models\Odp;
use App\Models\Pop;
use App\Models\RegistrationInvoice;
use App\Models\Ticket;
use App\Models\WhatsappGateway;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori & Paket Bandwidth
        $catHome = BandwidthCategory::updateOrCreate(
            ['code' => 'MSN-HOME'],
            [
                'name' => 'MSN Home Fiber',
                'alias_name' => 'Paket Residensial / Rumah',
                'registration_fee' => 150000,
                'has_registration_ppn' => true,
                'registration_ppn_percent' => 11,
                'has_billing_ppn' => true,
                'billing_ppn_percent' => 11,
                'is_active' => true,
            ]
        );

        $catBiz = BandwidthCategory::updateOrCreate(
            ['code' => 'MSN-BIZ'],
            [
                'name' => 'MSN Business Pro (1:1 Dedicated)',
                'alias_name' => 'Paket Bisnis & Korporasi',
                'registration_fee' => 500000,
                'has_registration_ppn' => true,
                'registration_ppn_percent' => 11,
                'has_billing_ppn' => true,
                'billing_ppn_percent' => 11,
                'is_active' => true,
            ]
        );

        $catGamer = BandwidthCategory::updateOrCreate(
            ['code' => 'MSN-GAMER'],
            [
                'name' => 'MSN Gamers & Streamers',
                'alias_name' => 'Paket Ultra Low Latency',
                'registration_fee' => 250000,
                'has_registration_ppn' => true,
                'registration_ppn_percent' => 11,
                'has_billing_ppn' => true,
                'billing_ppn_percent' => 11,
                'is_active' => true,
            ]
        );

        $packages = [
            ['code' => 'HOME-20M', 'category_code' => 'MSN-HOME', 'name' => 'Home Basic 20 Mbps', 'speed_mbps' => 20, 'price' => 165000],
            ['code' => 'HOME-30M', 'category_code' => 'MSN-HOME', 'name' => 'Home Family 30 Mbps', 'speed_mbps' => 30, 'price' => 220000],
            ['code' => 'HOME-50M', 'category_code' => 'MSN-HOME', 'name' => 'Home Super 50 Mbps', 'speed_mbps' => 50, 'price' => 330000],
            ['code' => 'HOME-100M', 'category_code' => 'MSN-HOME', 'name' => 'Home Ultimate 100 Mbps', 'speed_mbps' => 100, 'price' => 550000],
            ['code' => 'BIZ-50M', 'category_code' => 'MSN-BIZ', 'name' => 'Biz Dedicated 50 Mbps', 'speed_mbps' => 50, 'price' => 1250000],
            ['code' => 'BIZ-100M', 'category_code' => 'MSN-BIZ', 'name' => 'Biz Dedicated 100 Mbps', 'speed_mbps' => 100, 'price' => 2200000],
            ['code' => 'GAME-100M', 'category_code' => 'MSN-GAMER', 'name' => 'Gamer Pro 100 Mbps', 'speed_mbps' => 100, 'price' => 750000],
        ];

        foreach ($packages as $pkg) {
            BandwidthPackage::updateOrCreate(['code' => $pkg['code']], $pkg);
        }

        // 2. POP (Point of Presence) & ODP (Optical Distribution Point)
        $pops = [
            ['code' => 'POP-CBT-01', 'name' => 'POP Central Cibitung', 'description' => 'Server Distribusi Utama Kawasan Cibitung'],
            ['code' => 'POP-CKR-01', 'name' => 'POP Cikarang Barat', 'description' => 'Node Distribusi Kawasan Industri & Residensial Cikarang'],
            ['code' => 'POP-TMN-01', 'name' => 'POP Tambun Selatan', 'description' => 'Node Distribusi Grand Wisata & Tambun'],
            ['code' => 'POP-BKS-01', 'name' => 'POP Bekasi Timur', 'description' => 'Node Distribusi Duren Jaya & Sekitarnya'],
        ];

        foreach ($pops as $p) {
            Pop::updateOrCreate(['code' => $p['code']], $p);
        }

        $odps = [
            ['code' => 'ODP-CBT-01/01', 'pop_code' => 'POP-CBT-01', 'name' => 'ODP Cibitung Permai Blok A', 'total_ports' => 8, 'used_ports' => 5, 'latitude' => '-6.258712', 'longitude' => '107.094512', 'notes' => 'Tiang MSN No. 12 Depan Blok A1'],
            ['code' => 'ODP-CBT-01/02', 'pop_code' => 'POP-CBT-01', 'name' => 'ODP Cibitung Permai Blok B', 'total_ports' => 8, 'used_ports' => 4, 'latitude' => '-6.259200', 'longitude' => '107.095200', 'notes' => 'Tiang MSN No. 18 Pertigaan Blok B3'],
            ['code' => 'ODP-CKR-01/01', 'pop_code' => 'POP-CKR-01', 'name' => 'ODP Graha Asri Cluster Bougenville', 'total_ports' => 16, 'used_ports' => 8, 'latitude' => '-6.294500', 'longitude' => '107.168900', 'notes' => 'Tiang PLN No. 45 Depan Pos Satpam'],
            ['code' => 'ODP-CKR-01/02', 'pop_code' => 'POP-CKR-01', 'name' => 'ODP Jababeka Residence Blok C', 'total_ports' => 16, 'used_ports' => 11, 'latitude' => '-6.302100', 'longitude' => '107.154200', 'notes' => 'Tiang Telco MSN No. 05'],
            ['code' => 'ODP-TMN-01/01', 'pop_code' => 'POP-TMN-01', 'name' => 'ODP Grand Wisata Festive Garden', 'total_ports' => 16, 'used_ports' => 9, 'latitude' => '-6.275400', 'longitude' => '107.042100', 'notes' => 'FAT Box Tiang MSN No. 22'],
            ['code' => 'ODP-BKS-01/01', 'pop_code' => 'POP-BKS-01', 'name' => 'ODP Duren Jaya Jl Melati', 'total_ports' => 8, 'used_ports' => 6, 'latitude' => '-6.234100', 'longitude' => '107.012500', 'notes' => 'Tiang MSN No. 08'],
        ];

        foreach ($odps as $o) {
            Odp::updateOrCreate(['code' => $o['code']], $o);
        }

        // 3. Data Pelanggan (Customers)
        $customers = [
            [
                'nik' => '3216061205880001',
                'name' => 'Bambang Supriyanto',
                'gender' => 'male',
                'birth_date' => '1988-05-12',
                'email' => 'bambang.supri@gmail.com',
                'phone_number' => '081298765432',
                'alt_phone_number' => '085712345678',
                'id_card_address' => 'Perum Cibitung Permai Blok A2 No. 14, RT 003/RW 012, Kel. Wanasari, Kec. Cibitung, Bekasi',
                'rt' => '003',
                'rw' => '012',
                'village_code' => '3216061001',
            ],
            [
                'nik' => '3216064508920003',
                'name' => 'Siti Rahmawati',
                'gender' => 'female',
                'birth_date' => '1992-08-15',
                'email' => 'siti.rahma92@yahoo.com',
                'phone_number' => '081388997766',
                'alt_phone_number' => null,
                'id_card_address' => 'Jl. Graha Asri Raya Cluster Bougenville No. 8, RT 005/RW 008, Kel. Jatireja, Kec. Cikarang Timur, Bekasi',
                'rt' => '005',
                'rw' => '008',
                'village_code' => '3216081002',
            ],
            [
                'nik' => '3216062301850002',
                'name' => 'Hendra Setiawan',
                'gender' => 'male',
                'birth_date' => '1985-01-23',
                'email' => 'hendra.setiawan@solusinet.id',
                'phone_number' => '081211223344',
                'alt_phone_number' => '081900112233',
                'id_card_address' => 'Grand Wisata Cluster Festive Garden Blok AA1 No. 5, RT 001/RW 015, Kel. Lambangjaya, Kec. Tambun Selatan, Bekasi',
                'rt' => '001',
                'rw' => '015',
                'village_code' => '3216071004',
            ],
            [
                'nik' => '3216066703950004',
                'name' => 'Dewi Lestari',
                'gender' => 'female',
                'birth_date' => '1995-03-27',
                'email' => 'dewi.lestari@gmail.com',
                'phone_number' => '085699887711',
                'alt_phone_number' => null,
                'id_card_address' => 'Jl. Duren Jaya No. 45 RT 002/RW 004, Kel. Duren Jaya, Kec. Bekasi Timur, Kota Bekasi',
                'rt' => '002',
                'rw' => '004',
                'village_code' => '3275031001',
            ],
            [
                'nik' => '3216061011800005',
                'name' => 'PT Sumber Rezeki Logistik (Bpk. Agus Santoso)',
                'gender' => 'male',
                'birth_date' => '1980-11-10',
                'email' => 'finance@sumberrezeki-log.co.id',
                'phone_number' => '081199881122',
                'alt_phone_number' => '02189876543',
                'id_card_address' => 'Kawasan Industri Jababeka 2 Blok EE No. 12A, Cikarang Selatan, Bekasi',
                'rt' => '001',
                'rw' => '001',
                'village_code' => '3216091001',
            ],
            [
                'nik' => '3216061809930006',
                'name' => 'Rian Pratama (Cyber Net Cafe)',
                'gender' => 'male',
                'birth_date' => '1993-09-18',
                'email' => 'rian.cybernet@gmail.com',
                'phone_number' => '087812349988',
                'alt_phone_number' => null,
                'id_card_address' => 'Ruko Cibitung Square Blok B No. 3, Jl. Teuku Umar KM 45, Cibitung, Bekasi',
                'rt' => '004',
                'rw' => '006',
                'village_code' => '3216061001',
            ],
            [
                'nik' => '3216062904990007',
                'name' => 'Fajar Nugraha',
                'gender' => 'male',
                'birth_date' => '1999-04-29',
                'email' => 'fajar.nugraha@outlook.com',
                'phone_number' => '089655443322',
                'alt_phone_number' => null,
                'id_card_address' => 'Perum Cibitung Permai Blok B5 No. 20, RT 004/RW 012, Cibitung',
                'rt' => '004',
                'rw' => '012',
                'village_code' => '3216061001',
            ],
            [
                'nik' => '3216065512960008',
                'name' => 'Nurul Hidayah',
                'gender' => 'female',
                'birth_date' => '1996-12-15',
                'email' => 'nurul.hidayah@gmail.com',
                'phone_number' => '081377889900',
                'alt_phone_number' => null,
                'id_card_address' => 'Jl. Anggrek No. 12 RT 003/RW 005, Duren Jaya, Bekasi Timur',
                'rt' => '003',
                'rw' => '005',
                'village_code' => '3275031001',
            ],
        ];

        foreach ($customers as $c) {
            Customer::updateOrCreate(['nik' => $c['nik']], $c);
        }

        // 4. Langganan Internet (Customer Subscriptions)
        $subscriptions = [
            [
                'internet_number' => 'MSN-2026-0001',
                'customer_nik' => '3216061205880001',
                'customer_name' => 'Bambang Supriyanto',
                'package_code' => 'HOME-30M',
                'pop_code' => 'POP-CBT-01',
                'odp_code' => 'ODP-CBT-01/01',
                'odp_port' => 3,
                'installation_address' => 'Perum Cibitung Permai Blok A2 No. 14, RT 003/RW 012, Wanasari, Cibitung',
                'building_number' => 'A2/14',
                'rt' => '003',
                'rw' => '012',
                'village_code' => '3216061001',
                'building_type' => 'RUMAH_TINGGAL',
                'lat_long' => '-6.258712, 107.094512',
                'maps_url' => 'https://maps.google.com/?q=-6.258712,107.094512',
                'ont_username' => 'bambang_cbt01',
                'ont_password' => 'msn#pass123',
                'pppoe_profile' => 'HOME-30M-PROFILE',
                'registration_status' => 'LIVE',
                'billing_cycle_day' => 5,
                'discount_amount' => 0,
                'is_isolated' => false,
                'is_terminated' => false,
                'sales_name' => 'Dedi Irawan',
            ],
            [
                'internet_number' => 'MSN-2026-0002',
                'customer_nik' => '3216064508920003',
                'customer_name' => 'Siti Rahmawati',
                'package_code' => 'HOME-50M',
                'pop_code' => 'POP-CKR-01',
                'odp_code' => 'ODP-CKR-01/01',
                'odp_port' => 2,
                'installation_address' => 'Jl. Graha Asri Raya Cluster Bougenville No. 8, Jatireja, Cikarang Timur',
                'building_number' => 'B/08',
                'rt' => '005',
                'rw' => '008',
                'village_code' => '3216081002',
                'building_type' => 'RUMAH_TINGGAL',
                'lat_long' => '-6.302145, 107.168923',
                'maps_url' => 'https://maps.google.com/?q=-6.302145,107.168923',
                'ont_username' => 'siti_ckr02',
                'ont_password' => 'msn#pass456',
                'pppoe_profile' => 'HOME-50M-PROFILE',
                'registration_status' => 'LIVE',
                'billing_cycle_day' => 10,
                'discount_amount' => 20000,
                'discount_note' => 'Promo Diskon Loyalitas Pelanggan',
                'is_isolated' => false,
                'is_terminated' => false,
                'sales_name' => 'Rina Kartika',
            ],
            [
                'internet_number' => 'MSN-2026-0003',
                'customer_nik' => '3216062301850002',
                'customer_name' => 'Hendra Setiawan',
                'package_code' => 'HOME-100M',
                'pop_code' => 'POP-TMN-01',
                'odp_code' => 'ODP-TMN-01/01',
                'odp_port' => 5,
                'installation_address' => 'Grand Wisata Cluster Festive Garden Blok AA1 No. 5, Lambangjaya, Tambun Selatan',
                'building_number' => 'AA1/05',
                'rt' => '001',
                'rw' => '015',
                'village_code' => '3216071004',
                'building_type' => 'RUMAH_TINGGAL',
                'lat_long' => '-6.284512, 107.054321',
                'maps_url' => 'https://maps.google.com/?q=-6.284512,107.054321',
                'ont_username' => 'hendra_tmn03',
                'ont_password' => 'msn#pass789',
                'pppoe_profile' => 'HOME-100M-PROFILE',
                'registration_status' => 'LIVE',
                'billing_cycle_day' => 1,
                'discount_amount' => 0,
                'is_isolated' => false,
                'is_terminated' => false,
                'sales_name' => 'Dedi Irawan',
            ],
            [
                'internet_number' => 'MSN-2026-0004',
                'customer_nik' => '3216066703950004',
                'customer_name' => 'Dewi Lestari',
                'package_code' => 'HOME-20M',
                'pop_code' => 'POP-BKS-01',
                'odp_code' => 'ODP-BKS-01/01',
                'odp_port' => 4,
                'installation_address' => 'Jl. Duren Jaya No. 45, Duren Jaya, Bekasi Timur',
                'building_number' => '45',
                'rt' => '002',
                'rw' => '004',
                'village_code' => '3275031001',
                'building_type' => 'RUMAH_TINGGAL',
                'lat_long' => '-6.239812, 107.012345',
                'maps_url' => 'https://maps.google.com/?q=-6.239812,107.012345',
                'ont_username' => 'dewi_bks04',
                'ont_password' => 'msn#pass321',
                'pppoe_profile' => 'HOME-20M-PROFILE',
                'registration_status' => 'LIVE',
                'billing_cycle_day' => 15,
                'discount_amount' => 0,
                'is_isolated' => true,
                'is_terminated' => false,
                'sales_name' => 'Rina Kartika',
            ],
            [
                'internet_number' => 'MSN-2026-0005',
                'customer_nik' => '3216061011800005',
                'customer_name' => 'PT Sumber Rezeki Logistik (Bpk. Agus Santoso)',
                'package_code' => 'BIZ-100M',
                'pop_code' => 'POP-CKR-01',
                'odp_code' => 'ODP-CKR-01/02',
                'odp_port' => 1,
                'installation_address' => 'Kawasan Industri Jababeka 2 Blok EE No. 12A, Cikarang Selatan',
                'building_number' => 'EE/12A',
                'rt' => '001',
                'rw' => '001',
                'village_code' => '3216091001',
                'building_type' => 'KANTOR_KORPORASI',
                'lat_long' => '-6.319012, 107.142345',
                'maps_url' => 'https://maps.google.com/?q=-6.319012,107.142345',
                'ont_username' => 'biz_sumberrezeki',
                'ont_password' => 'biz#msn#corp99',
                'pppoe_profile' => 'BIZ-100M-PROFILE',
                'registration_status' => 'LIVE',
                'billing_cycle_day' => 1,
                'discount_amount' => 0,
                'is_isolated' => false,
                'is_terminated' => false,
                'sales_name' => 'Andi Wijaya',
            ],
            [
                'internet_number' => 'MSN-2026-0006',
                'customer_nik' => '3216061809930006',
                'customer_name' => 'Rian Pratama (Cyber Net Cafe)',
                'package_code' => 'GAME-100M',
                'pop_code' => 'POP-CBT-01',
                'odp_code' => 'ODP-CBT-01/02',
                'odp_port' => 1,
                'installation_address' => 'Ruko Cibitung Square Blok B No. 3, Jl. Teuku Umar KM 45, Cibitung',
                'building_number' => 'B/03',
                'rt' => '004',
                'rw' => '006',
                'village_code' => '3216061001',
                'building_type' => 'RUKO_USAHA',
                'lat_long' => '-6.261234, 107.098765',
                'maps_url' => 'https://maps.google.com/?q=-6.261234,107.098765',
                'ont_username' => 'game_cybernet',
                'ont_password' => 'game#msn#pro77',
                'pppoe_profile' => 'GAME-100M-PROFILE',
                'registration_status' => 'LIVE',
                'billing_cycle_day' => 20,
                'discount_amount' => 50000,
                'discount_note' => 'Diskon Promosi Komunitas Gamer',
                'is_isolated' => false,
                'is_terminated' => false,
                'sales_name' => 'Andi Wijaya',
            ],
            [
                'internet_number' => 'MSN-2026-0007',
                'customer_nik' => '3216062904990007',
                'customer_name' => 'Fajar Nugraha',
                'package_code' => 'HOME-30M',
                'pop_code' => 'POP-CBT-01',
                'odp_code' => 'ODP-CBT-01/02',
                'odp_port' => 4,
                'installation_address' => 'Perum Cibitung Permai Blok B5 No. 20, Cibitung',
                'building_number' => 'B5/20',
                'rt' => '004',
                'rw' => '012',
                'village_code' => '3216061001',
                'building_type' => 'RUMAH_TINGGAL',
                'lat_long' => '-6.259988, 107.096543',
                'maps_url' => 'https://maps.google.com/?q=-6.259988,107.096543',
                'ont_username' => 'fajar_cbt07',
                'ont_password' => 'msn#pass654',
                'pppoe_profile' => 'HOME-30M-PROFILE',
                'registration_status' => 'INS', // Sedang tahap instalasi lapangan
                'billing_cycle_day' => 1,
                'discount_amount' => 0,
                'is_isolated' => false,
                'is_terminated' => false,
                'sales_name' => 'Dedi Irawan',
            ],
            [
                'internet_number' => 'MSN-2026-0008',
                'customer_nik' => '3216065512960008',
                'customer_name' => 'Nurul Hidayah',
                'package_code' => 'HOME-20M',
                'pop_code' => 'POP-BKS-01',
                'odp_code' => 'ODP-BKS-01/01',
                'odp_port' => 6,
                'installation_address' => 'Jl. Anggrek No. 12 RT 003/RW 005, Duren Jaya, Bekasi Timur',
                'building_number' => '12',
                'rt' => '003',
                'rw' => '005',
                'village_code' => '3275031001',
                'building_type' => 'RUMAH_TINGGAL',
                'lat_long' => '-6.241122, 107.014567',
                'maps_url' => 'https://maps.google.com/?q=-6.241122,107.014567',
                'ont_username' => 'nurul_bks08',
                'ont_password' => 'msn#pass888',
                'pppoe_profile' => 'HOME-20M-PROFILE',
                'registration_status' => 'SUR', // Sedang tahap survei lokasi
                'billing_cycle_day' => 1,
                'discount_amount' => 0,
                'is_isolated' => false,
                'is_terminated' => false,
                'sales_name' => 'Rina Kartika',
            ],
        ];

        foreach ($subscriptions as $s) {
            CustomerSubscription::updateOrCreate(['internet_number' => $s['internet_number']], $s);
        }

        // 5. Perangkat Pelanggan (Customer Devices)
        $devices = [
            ['internet_number' => 'MSN-2026-0001', 'device_type' => 'ONT', 'brand' => 'ZTE', 'model' => 'ZXHN F609 V3', 'serial_number' => 'ZTEGC7849102', 'mac_address' => '74:B5:7E:11:22:33', 'ownership_status' => 'RENTAL', 'installed_at' => '2026-01-15'],
            ['internet_number' => 'MSN-2026-0002', 'device_type' => 'ONT', 'brand' => 'Huawei', 'model' => 'HG8245H5', 'serial_number' => '48575443A1B2C3D4', 'mac_address' => 'E4:C3:2A:44:55:66', 'ownership_status' => 'RENTAL', 'installed_at' => '2026-02-10'],
            ['internet_number' => 'MSN-2026-0003', 'device_type' => 'ONT', 'brand' => 'FiberHome', 'model' => 'AN5506-04-F', 'serial_number' => 'FHTT89012345', 'mac_address' => '90:4E:91:77:88:99', 'ownership_status' => 'RENTAL', 'installed_at' => '2026-02-20'],
            ['internet_number' => 'MSN-2026-0003', 'device_type' => 'ROUTER', 'brand' => 'Totolink', 'model' => 'A720R Dual Band AC1200', 'serial_number' => 'TTLA720R55441', 'mac_address' => '00:1E:58:AA:BB:CC', 'ownership_status' => 'PURCHASED', 'installed_at' => '2026-02-20'],
            ['internet_number' => 'MSN-2026-0004', 'device_type' => 'ONT', 'brand' => 'ZTE', 'model' => 'ZXHN F609 V3', 'serial_number' => 'ZTEGC9988112', 'mac_address' => '74:B5:7E:AA:33:44', 'ownership_status' => 'RENTAL', 'installed_at' => '2026-03-05'],
            ['internet_number' => 'MSN-2026-0005', 'device_type' => 'ONT', 'brand' => 'Huawei', 'model' => 'EchoLife EG8145V5', 'serial_number' => '48575443EEFF1122', 'mac_address' => 'F0:8A:76:12:34:56', 'ownership_status' => 'RENTAL', 'installed_at' => '2026-03-12'],
            ['internet_number' => 'MSN-2026-0005', 'device_type' => 'ROUTER', 'brand' => 'MikroTik', 'model' => 'RB4011iGS+RM', 'serial_number' => 'MTK4011998822', 'mac_address' => 'B8:69:F4:99:88:77', 'ownership_status' => 'RENTAL', 'installed_at' => '2026-03-12'],
            ['internet_number' => 'MSN-2026-0006', 'device_type' => 'ONT', 'brand' => 'ZTE', 'model' => 'ZXHN F670L Gigabit', 'serial_number' => 'ZTEGC670L9988', 'mac_address' => '74:B5:7E:88:99:AA', 'ownership_status' => 'RENTAL', 'installed_at' => '2026-04-01'],
        ];

        foreach ($devices as $d) {
            CustomerDevice::updateOrCreate(['serial_number' => $d['serial_number']], $d);
        }

        // 6. Pipeline Pemasangan Baru (Installation Pipeline)
        $pipelines = [
            [
                'code' => 'PSB-2026-0001',
                'internet_number' => 'MSN-2026-0001',
                'verified_at' => '2026-01-10',
                'verified_note' => 'Dokumen KTP dan formulir registrasi lengkap & valid',
                'survey_scheduled_at' => '2026-01-12',
                'survey_team' => 'Tim Alpha (Ahmad & Doni)',
                'survey_note' => 'Jarak ODP ke rumah 85 meter. Redaman ODP -18.2 dBm. OK pasang.',
                'survey_finished_at' => '2026-01-12',
                'installation_scheduled_at' => '2026-01-15',
                'installation_team' => 'Tim Alpha (Ahmad & Doni)',
                'installation_note' => 'Tarik kabel dropcore 1 core 95m, splicing ODP port 3, pasang Roset & ONT ZTE F609.',
                'installation_finished_at' => '2026-01-15',
                'activation_scheduled_at' => '2026-01-15',
                'activation_team' => 'NOC Team (Irfan)',
                'activation_note' => 'PPPoE profile HOME-30M up, redaman ONT -19.4 dBm. Speedtest stabil 31.2 Mbps.',
                'activation_finished_at' => '2026-01-15',
            ],
            [
                'code' => 'PSB-2026-0007',
                'internet_number' => 'MSN-2026-0007',
                'verified_at' => '2026-08-10',
                'verified_note' => 'KTP dan form digital valid, DP/Biaya pasang telah lunas.',
                'survey_scheduled_at' => '2026-08-11',
                'survey_team' => 'Tim Beta (Budi & Eko)',
                'survey_note' => 'Jarak ODP 60 meter, tiang melintas jalan komplek.',
                'survey_finished_at' => '2026-08-11',
                'installation_scheduled_at' => '2026-08-15',
                'installation_team' => 'Tim Beta (Budi & Eko)',
                'installation_note' => 'Sedang pengerjaan penarikan kabel dropcore.',
            ],
            [
                'code' => 'PSB-2026-0008',
                'internet_number' => 'MSN-2026-0008',
                'verified_at' => '2026-08-14',
                'verified_note' => 'Pendaftaran online melalui WhatsApp Leads',
                'survey_scheduled_at' => '2026-08-16',
                'survey_team' => 'Tim Charlie (Rizal & Yoga)',
                'survey_note' => 'Menunggu pelaksanaan survei redaman ODP terdekat.',
            ],
        ];

        foreach ($pipelines as $pipe) {
            InstallationPipeline::updateOrCreate(['code' => $pipe['code']], $pipe);
        }

        // 7. Tagihan Bulanan (Monthly Invoices)
        $invoices = [
            [
                'invoice_number' => 'INV/202608/0001',
                'internet_number' => 'MSN-2026-0001',
                'package_code' => 'HOME-30M',
                'billing_month' => 8,
                'billing_year' => 2026,
                'billing_period_text' => 'Agustus 2026',
                'subtotal' => 220000,
                'discount' => 0,
                'ppn_amount' => 24200,
                'penalty_amount' => 0,
                'total_amount' => 244200,
                'payment_status' => 'PAID',
                'payment_method' => 'MIDTRANS',
                'payment_channel' => 'BCA_VA',
                'amount_paid' => 244200,
                'paid_at' => Carbon::create(2026, 8, 4, 14, 25, 0),
                'expires_at' => Carbon::create(2026, 8, 20, 23, 59, 59),
            ],
            [
                'invoice_number' => 'INV/202608/0002',
                'internet_number' => 'MSN-2026-0002',
                'package_code' => 'HOME-50M',
                'billing_month' => 8,
                'billing_year' => 2026,
                'billing_period_text' => 'Agustus 2026',
                'subtotal' => 330000,
                'discount' => 20000,
                'discount_note' => 'Potongan Promo Loyalitas',
                'ppn_amount' => 34100,
                'penalty_amount' => 0,
                'total_amount' => 344100,
                'payment_status' => 'PAID',
                'payment_method' => 'MIDTRANS',
                'payment_channel' => 'QRIS',
                'amount_paid' => 344100,
                'paid_at' => Carbon::create(2026, 8, 8, 10, 15, 30),
                'expires_at' => Carbon::create(2026, 8, 20, 23, 59, 59),
            ],
            [
                'invoice_number' => 'INV/202608/0003',
                'internet_number' => 'MSN-2026-0003',
                'package_code' => 'HOME-100M',
                'billing_month' => 8,
                'billing_year' => 2026,
                'billing_period_text' => 'Agustus 2026',
                'subtotal' => 550000,
                'discount' => 0,
                'ppn_amount' => 60500,
                'penalty_amount' => 0,
                'total_amount' => 610500,
                'payment_status' => 'PAID',
                'payment_method' => 'BANK_TRANSFER',
                'payment_channel' => 'BCA_MANUAL',
                'amount_paid' => 610500,
                'paid_at' => Carbon::create(2026, 8, 2, 9, 30, 0),
                'expires_at' => Carbon::create(2026, 8, 20, 23, 59, 59),
            ],
            [
                'invoice_number' => 'INV/202608/0004',
                'internet_number' => 'MSN-2026-0004',
                'package_code' => 'HOME-20M',
                'billing_month' => 8,
                'billing_year' => 2026,
                'billing_period_text' => 'Agustus 2026',
                'subtotal' => 165000,
                'discount' => 0,
                'ppn_amount' => 18150,
                'penalty_amount' => 10000,
                'total_amount' => 193150,
                'payment_status' => 'UNPAID', // Belum bayar / Isolir
                'payment_method' => null,
                'payment_channel' => null,
                'amount_paid' => 0,
                'paid_at' => null,
                'expires_at' => Carbon::create(2026, 8, 15, 23, 59, 59),
                'adjustment_note' => 'Menunggak lebih dari 7 hari, status layanan diisolir otomatis oleh sistem.',
            ],
            [
                'invoice_number' => 'INV/202608/0005',
                'internet_number' => 'MSN-2026-0005',
                'package_code' => 'BIZ-100M',
                'billing_month' => 8,
                'billing_year' => 2026,
                'billing_period_text' => 'Agustus 2026',
                'subtotal' => 2200000,
                'discount' => 0,
                'ppn_amount' => 242000,
                'penalty_amount' => 0,
                'total_amount' => 2442000,
                'payment_status' => 'PAID',
                'payment_method' => 'BANK_TRANSFER',
                'payment_channel' => 'MANDIRI_CORPORATE',
                'amount_paid' => 2442000,
                'paid_at' => Carbon::create(2026, 8, 1, 11, 0, 0),
                'expires_at' => Carbon::create(2026, 8, 20, 23, 59, 59),
            ],
            [
                'invoice_number' => 'INV/202608/0006',
                'internet_number' => 'MSN-2026-0006',
                'package_code' => 'GAME-100M',
                'billing_month' => 8,
                'billing_year' => 2026,
                'billing_period_text' => 'Agustus 2026',
                'subtotal' => 750000,
                'discount' => 50000,
                'discount_note' => 'Diskon Komunitas Gamer',
                'ppn_amount' => 77000,
                'penalty_amount' => 0,
                'total_amount' => 777000,
                'payment_status' => 'PENDING',
                'payment_method' => 'MIDTRANS',
                'payment_channel' => 'QRIS',
                'amount_paid' => 0,
                'paid_at' => null,
                'expires_at' => Carbon::create(2026, 8, 20, 23, 59, 59),
            ],
        ];

        foreach ($invoices as $inv) {
            MonthlyInvoice::updateOrCreate(['invoice_number' => $inv['invoice_number']], $inv);
        }

        // 8. Tagihan Registrasi PSB (Registration Invoices)
        $regInvoices = [
            [
                'invoice_number' => 'INV/PSB/202601/0001',
                'internet_number' => 'MSN-2026-0001',
                'registration_fee' => 150000,
                'ppn_amount' => 16500,
                'total_amount' => 166500,
                'payment_status' => 'PAID',
                'payment_method' => 'CASH_TEKNISI',
                'paid_at' => Carbon::create(2026, 1, 15, 16, 0, 0),
            ],
            [
                'invoice_number' => 'INV/PSB/202608/0007',
                'internet_number' => 'MSN-2026-0007',
                'registration_fee' => 150000,
                'ppn_amount' => 16500,
                'total_amount' => 166500,
                'payment_status' => 'PAID',
                'payment_method' => 'MIDTRANS_QRIS',
                'paid_at' => Carbon::create(2026, 8, 10, 13, 20, 0),
            ],
        ];

        foreach ($regInvoices as $reg) {
            RegistrationInvoice::updateOrCreate(['invoice_number' => $reg['invoice_number']], $reg);
        }

        // 9. Tiket Gangguan & Keluhan (Tickets)
        $tickets = [
            [
                'ticket_number' => 'TKT-202608-001',
                'internet_number' => 'MSN-2026-0001',
                'reporter_name' => 'Bambang Supriyanto',
                'reporter_phone' => '081298765432',
                'category' => 'LOS',
                'priority' => 'HIGH',
                'description' => 'Lampu indikator LOS di modem berkedip merah sejak pagi jam 07:00 WIB, koneksi mati total.',
                'status' => 'RESOLVED',
                'assigned_technician' => 'Ahmad Fauzi',
                'resolution_notes' => 'Pengecekan di lapangan menemukan konektor SC di Roset kendor. Telah dibersihkan dan dipasang ulang. Redaman normal kembali di -19.2 dBm.',
                'optical_power_dbm' => '-19.2 dBm',
                'resolved_at' => Carbon::create(2026, 8, 14, 11, 30, 0),
            ],
            [
                'ticket_number' => 'TKT-202608-002',
                'internet_number' => 'MSN-2026-0002',
                'reporter_name' => 'Siti Rahmawati',
                'reporter_phone' => '081388997766',
                'category' => 'LAMBAT',
                'priority' => 'MEDIUM',
                'description' => 'Koneksi terasa lambat saat streaming malam hari di lantai 2 rumah.',
                'status' => 'RESOLVED',
                'assigned_technician' => 'Budi Santoso',
                'resolution_notes' => 'Optimasi frekuensi kanal Wi-Fi (ganti channel 6 ke 11) dan rekomendasi penambahan Access Point extender di lantai 2.',
                'optical_power_dbm' => '-20.1 dBm',
                'resolved_at' => Carbon::create(2026, 8, 13, 16, 45, 0),
            ],
            [
                'ticket_number' => 'TKT-202608-003',
                'internet_number' => 'MSN-2026-0003',
                'reporter_name' => 'Hendra Setiawan',
                'reporter_phone' => '081211223344',
                'category' => 'KABEL_PUTUS',
                'priority' => 'CRITICAL',
                'description' => 'Kabel fiber optik depan gang tertabrak truk muatan barang, kabel putus menggelantung di jalan.',
                'status' => 'IN_PROGRESS',
                'assigned_technician' => 'Tim Alpha (Ahmad & Doni)',
                'resolution_notes' => 'Tim teknisi sedang dalam perjalanan menuju lokasi membawa fusion splicer dan kabel pengganti.',
                'optical_power_dbm' => null,
                'resolved_at' => null,
            ],
            [
                'ticket_number' => 'TKT-202608-004',
                'internet_number' => 'MSN-2026-0006',
                'reporter_name' => 'Rian Pratama',
                'reporter_phone' => '087812349988',
                'category' => 'LAINNYA',
                'priority' => 'LOW',
                'description' => 'Permintaan permohonan port forwarding untuk server game lokal di warnet.',
                'status' => 'OPEN',
                'assigned_technician' => 'NOC Engineer',
                'resolution_notes' => null,
                'optical_power_dbm' => '-18.5 dBm',
                'resolved_at' => null,
            ],
            [
                'ticket_number' => 'TKT-202608-005',
                'internet_number' => 'MSN-2026-0002',
                'reporter_name' => 'Siti Rahmawati',
                'reporter_phone' => '081388997766',
                'category' => 'PASSWORD',
                'priority' => 'MEDIUM',
                'description' => 'Permintaan ubah password Wi-Fi menjadi: Rahma@2026!',
                'status' => 'OPEN',
                'assigned_technician' => null,
                'resolution_notes' => null,
                'optical_power_dbm' => null,
                'resolved_at' => null,
            ],
            [
                'ticket_number' => 'TKT-202608-006',
                'internet_number' => 'MS6331420201008',
                'reporter_name' => 'Dadang Purnama',
                'reporter_phone' => '081572110618',
                'category' => 'COVERAGE',
                'priority' => 'MEDIUM',
                'description' => 'Permohonan cek titik ODP terdekat untuk perluasan ruko samping mesjid.',
                'status' => 'OPEN',
                'assigned_technician' => null,
                'resolution_notes' => null,
                'optical_power_dbm' => null,
                'resolved_at' => null,
            ],
        ];

        foreach ($tickets as $t) {
            Ticket::updateOrCreate(['ticket_number' => $t['ticket_number']], $t);
        }

        // 10. Prospek Coverage Area (Coverage Leads)
        $leads = [
            [
                'name' => 'Dr. Wahyu Triatmo',
                'phone_number' => '081288776655',
                'address' => 'Perum Mutiara Gading Timur Blok C5 No. 10, Mustikajaya, Bekasi',
                'lat_long' => '-6.291234, 107.034567',
                'status' => 'IN_COVERAGE',
                'notes' => 'Minat paket Home 50M. Tiang ODP terdekat berjarak 40 meter dari rumah.',
            ],
            [
                'name' => 'Ibu Ratna Juwita',
                'phone_number' => '085711223399',
                'address' => 'Kampung Babakan RT 002/RW 001, Mustikasari, Bekasi',
                'lat_long' => '-6.305678, 107.045678',
                'status' => 'OUT_OF_COVERAGE',
                'notes' => 'Belum ada jalur FO MSN. Jarak ODP terdekat masih > 600 meter.',
            ],
            [
                'name' => 'Toko Bangunan Berkah Mandiri',
                'phone_number' => '081399001122',
                'address' => 'Jl. Raya Teuku Umar KM 42, Cibitung',
                'lat_long' => '-6.256789, 107.087654',
                'status' => 'NEW',
                'notes' => 'Menghubungi lewat Chatbot WhatsApp menanyakan tarif paket kantor/bisnis.',
            ],
        ];

        foreach ($leads as $lead) {
            CoverageLead::create($lead);
        }

        // 11. Rekening Bank Perusahaan (Company Banks)
        $banks = [
            ['bank_name' => 'BCA (Bank Central Asia)', 'account_number' => '8410987654', 'account_holder' => 'PT MEDIA SOLUSI NETWORK', 'is_active' => true],
            ['bank_name' => 'Bank Mandiri', 'account_number' => '1560019876543', 'account_holder' => 'PT MEDIA SOLUSI NETWORK', 'is_active' => true],
            ['bank_name' => 'BRI (Bank Rakyat Indonesia)', 'account_number' => '034101002233501', 'account_holder' => 'PT MEDIA SOLUSI NETWORK', 'is_active' => true],
        ];

        foreach ($banks as $b) {
            CompanyBank::updateOrCreate(['account_number' => $b['account_number']], $b);
        }

        // 12. WhatsApp Gateway Configuration
        WhatsappGateway::updateOrCreate(
            ['name' => 'Primary Gateway MSN'],
            [
                'api_url' => 'https://api.whatsapp-gateway.msn.net.id/send',
                'api_key' => 'msn_wa_live_key_998877665544',
                'sender_number' => '081280009000',
                'is_active' => true,
            ]
        );
    }
}
