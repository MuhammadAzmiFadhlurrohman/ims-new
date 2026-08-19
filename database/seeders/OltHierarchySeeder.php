<?php

namespace Database\Seeders;

use App\Models\BandwidthCategory;
use App\Models\BandwidthPackage;
use App\Models\Customer;
use App\Models\CustomerSubscription;
use App\Models\Odp;
use App\Models\Olt;
use App\Models\PonPort;
use App\Models\Pop;
use Illuminate\Database\Seeder;

class OltHierarchySeeder extends Seeder
{
    public function run(): void
    {
        // 1. POP
        $pop = Pop::firstOrCreate(
            ['code' => 'POP-MAIN'],
            ['name' => 'POP Pusat MSN', 'description' => 'Main Datacenter & POP']
        );

        // 2. Package & Category
        $cat = BandwidthCategory::firstOrCreate(
            ['code' => 'MSN-HOME'],
            ['name' => 'MediaNet Home FTTH', 'is_active' => true]
        );

        $pkg20 = BandwidthPackage::firstOrCreate(
            ['code' => 'HOME-20M'],
            [
                'category_code' => $cat->code,
                'name' => 'UP TO NEW',
                'speed_mbps' => 20,
                'price' => 200000,
                'is_active' => true,
            ]
        );

        $pkg30 = BandwidthPackage::firstOrCreate(
            ['code' => 'HOME-30M'],
            [
                'category_code' => $cat->code,
                'name' => 'UP TO NEW',
                'speed_mbps' => 30,
                'price' => 250000,
                'is_active' => true,
            ]
        );

        $pkg50 = BandwidthPackage::firstOrCreate(
            ['code' => 'HOME-50M'],
            [
                'category_code' => $cat->code,
                'name' => 'UP TO NEW',
                'speed_mbps' => 50,
                'price' => 350000,
                'is_active' => true,
            ]
        );

        // 3. OLTs
        $oltsData = [
            ['code' => 'OLT-MSN', 'name' => 'OLT MSN', 'ip_address' => '10.10.10.1', 'brand' => 'ZTE C320', 'total_pon_ports' => 8],
            ['code' => 'OLT-BAGONG', 'name' => 'OLT Bagong', 'ip_address' => '10.10.10.2', 'brand' => 'Huawei MA5608T', 'total_pon_ports' => 8],
            ['code' => 'OLT-SOREANG', 'name' => 'OLT Soreang', 'ip_address' => '10.10.10.3', 'brand' => 'HSGQ', 'total_pon_ports' => 4],
        ];

        foreach ($oltsData as $data) {
            Olt::updateOrCreate(
                ['code' => $data['code']],
                array_merge($data, ['pop_code' => $pop->code])
            );
        }

        // ══════════════════════════════════════════════════════════════
        // 4. OLT MSN: PONs & ODPs
        // ══════════════════════════════════════════════════════════════

        // PON 1 (0/8)
        PonPort::updateOrCreate(
            ['olt_code' => 'OLT-MSN', 'name' => 'PON 1'],
            ['port_number' => 1, 'max_ports' => 8, 'used_ports' => 0, 'total_subscribers' => 0]
        );

        // PON 2 / MS SUMARECON (1/8)
        $pon2 = PonPort::updateOrCreate(
            ['olt_code' => 'OLT-MSN', 'name' => 'PON 2 / MS SUMARECON'],
            ['port_number' => 2, 'max_ports' => 8, 'used_ports' => 1, 'total_subscribers' => 2]
        );
        Odp::updateOrCreate(
            ['code' => 'ODP-SUMARECON-01'],
            [
                'name' => 'SUMARECON CLUSTER 1',
                'olt_code' => 'OLT-MSN',
                'pon_port_id' => $pon2->id,
                'pop_code' => $pop->code,
                'total_ports' => 8,
                'used_ports' => 2,
                'latitude' => '-6.94500',
                'longitude' => '107.61200',
            ]
        );

        // PON 3 / MS SUFIA (3/4)
        $pon3 = PonPort::updateOrCreate(
            ['olt_code' => 'OLT-MSN', 'name' => 'PON 3 / MS SUFIA'],
            ['port_number' => 3, 'max_ports' => 4, 'used_ports' => 3, 'total_subscribers' => 8]
        );
        $odpsPon3 = [
            ['code' => 'ODP-SUFIA-01', 'name' => 'SUFIA UTARA', 'total_ports' => 8, 'used_ports' => 3, 'latitude' => '-6.93810', 'longitude' => '107.58910'],
            ['code' => 'ODP-SUFIA-02', 'name' => 'SUFIA SELATAN', 'total_ports' => 8, 'used_ports' => 4, 'latitude' => '-6.93920', 'longitude' => '107.58990'],
            ['code' => 'ODP-SUFIA-03', 'name' => 'SUFIA BARAT', 'total_ports' => 8, 'used_ports' => 1, 'latitude' => '-6.94010', 'longitude' => '107.58850'],
        ];
        foreach ($odpsPon3 as $op3) {
            $odpObj = Odp::updateOrCreate(
                ['code' => $op3['code']],
                array_merge($op3, [
                    'olt_code' => 'OLT-MSN',
                    'pon_port_id' => $pon3->id,
                    'pop_code' => $pop->code,
                ])
            );

            // Add users in SUFIA UTARA
            if ($op3['code'] === 'ODP-SUFIA-01') {
                for ($u = 1; $u <= 3; $u++) {
                    $nik = "320411223344000{$u}";
                    $custName = "USER SUFIA UTARA {$u}";
                    Customer::updateOrCreate(
                        ['nik' => $nik],
                        ['name' => $custName, 'phone_number' => "08123456780{$u}", 'id_card_address' => "JL SUFIA UTARA NO {$u}", 'email' => "sufia{$u}@gmail.com"]
                    );
                    CustomerSubscription::updateOrCreate(
                        ['internet_number' => "MS3300{$u}2021"],
                        [
                            'customer_nik' => $nik,
                            'customer_name' => $custName,
                            'package_code' => $pkg30->code,
                            'pop_code' => $pop->code,
                            'olt_code' => 'OLT-MSN',
                            'odp_code' => $odpObj->code,
                            'installation_address' => "JL SUFIA UTARA NO {$u}",
                            'phone_number' => "08123456780{$u}",
                            'registration_status' => 'AKTIF',
                            'gpon_onu' => "gpon-onu_1/3/4:{$u} sn RTEGC702SUF{$u}",
                            'special_request' => '',
                            'building_type' => 'RUMAH-PRIBADI',
                        ]
                    );
                }
            }
        }

        // PON 4 / MS MSN (5/8)
        $pon4 = PonPort::updateOrCreate(
            ['olt_code' => 'OLT-MSN', 'name' => 'PON 4 / MS MSN'],
            ['port_number' => 4, 'max_ports' => 8, 'used_ports' => 5, 'total_subscribers' => 18]
        );
        $odpsMsnPon4 = [
            ['code' => 'ODP-KORDON', 'name' => 'KORDON', 'total_ports' => 8, 'used_ports' => 2, 'latitude' => '-6.92976', 'longitude' => '107.5933'],
            ['code' => 'ODP-MSN-REOG', 'name' => 'MSN REOG', 'total_ports' => 16, 'used_ports' => 5, 'latitude' => '-6.93120', 'longitude' => '107.5950'],
            ['code' => 'ODP-INDOMART', 'name' => 'INDOMART', 'total_ports' => 8, 'used_ports' => 3, 'latitude' => '-6.93340', 'longitude' => '107.5972'],
            ['code' => 'ODP-POS-RAJA-MANTRI', 'name' => 'POS RAJA MANTRI', 'total_ports' => 8, 'used_ports' => 6, 'latitude' => '-6.93510', 'longitude' => '107.5988'],
            ['code' => 'ODP-SRI-REJEKI', 'name' => 'SRI REJEKI', 'total_ports' => 8, 'used_ports' => 2, 'latitude' => '-6.93620', 'longitude' => '107.6010'],
        ];

        foreach ($odpsMsnPon4 as $odpData) {
            Odp::updateOrCreate(
                ['code' => $odpData['code']],
                array_merge($odpData, [
                    'olt_code' => 'OLT-MSN',
                    'pon_port_id' => $pon4->id,
                    'pop_code' => $pop->code,
                ])
            );
        }

        // Users in POS RAJA MANTRI (Gambar 4)
        $usersRajaMantri = [
            [
                'internet_number' => 'MS6331420201008',
                'customer_name' => 'DADANG PURNAMA',
                'customer_nik' => '3204123456780001',
                'phone_number' => '081572110618',
                'installation_address' => 'JL. RAJAMANTRI KIDUL NO 6 MESJID NURUL FALLAH',
                'registration_status' => 'REQ. TERMINASI',
                'gpon_onu' => 'gpon-onu_1/2/4:4 sn RTEGC702D47B (OLT KYA)',
                'special_request' => '',
                'package_code' => $pkg30->code,
            ],
            [
                'internet_number' => 'MS24173620201013',
                'customer_name' => 'IR HADI NURZAMAN',
                'customer_nik' => '3204123456780002',
                'phone_number' => '081809964235',
                'installation_address' => 'JL GUNTUR SARI 4 NO. 22',
                'registration_status' => 'AKTIF',
                'gpon_onu' => 'gpon-onu_1/2/4:16 sn RTEGC7025D71',
                'special_request' => '',
                'package_code' => $pkg30->code,
            ],
            [
                'internet_number' => 'MS6923220201008',
                'customer_name' => 'TK nurul falah',
                'customer_nik' => '3204123456780003',
                'phone_number' => '081572110618',
                'installation_address' => 'JL. RAJAMANTRI KIDUL NO 6',
                'registration_status' => 'AKTIF',
                'gpon_onu' => '1/2/4:17 sn RTEGC7028686',
                'special_request' => '',
                'package_code' => $pkg30->code,
            ],
            [
                'internet_number' => 'MS44120920201020',
                'customer_name' => 'YAYASAN NURUL FALAH',
                'customer_nik' => '3204123456780004',
                'phone_number' => '081220194833',
                'installation_address' => 'JL. RAJAMANTRI KIDUL NO 8',
                'registration_status' => 'AKTIF',
                'gpon_onu' => 'gpon-onu_1/2/4:18 sn RTEGC7029A12',
                'special_request' => 'Pemasangan lantai 2',
                'package_code' => $pkg50->code,
            ],
            [
                'internet_number' => 'MS88129020201102',
                'customer_name' => 'DRS. H. AHMAD HIDAYAT',
                'customer_nik' => '3204123456780005',
                'phone_number' => '081321908871',
                'installation_address' => 'JL. RAJAMANTRI WETAN NO 14',
                'registration_status' => 'AKTIF',
                'gpon_onu' => 'gpon-onu_1/2/4:19 sn RTEGC7026723',
                'special_request' => '',
                'package_code' => $pkg30->code,
            ],
            [
                'internet_number' => 'MS55210920201115',
                'customer_name' => 'H. BUDI SANTOSO',
                'customer_nik' => '3204123456780006',
                'phone_number' => '081122334455',
                'installation_address' => 'JL. RAJAMANTRI KIDUL NO 12',
                'registration_status' => 'AKTIF',
                'gpon_onu' => 'gpon-onu_1/2/4:20 sn RTEGC7023341',
                'special_request' => 'Prioritas VIP',
                'package_code' => $pkg50->code,
            ],
        ];

        foreach ($usersRajaMantri as $u) {
            Customer::updateOrCreate(
                ['nik' => $u['customer_nik']],
                [
                    'name' => $u['customer_name'],
                    'phone_number' => $u['phone_number'],
                    'id_card_address' => $u['installation_address'],
                    'email' => strtolower(str_replace([' ', '.'], '', $u['customer_name'])) . '@gmail.com',
                ]
            );

            CustomerSubscription::updateOrCreate(
                ['internet_number' => $u['internet_number']],
                [
                    'customer_nik' => $u['customer_nik'],
                    'customer_name' => $u['customer_name'],
                    'package_code' => $u['package_code'],
                    'pop_code' => $pop->code,
                    'olt_code' => 'OLT-MSN',
                    'odp_code' => 'ODP-POS-RAJA-MANTRI',
                    'installation_address' => $u['installation_address'],
                    'phone_number' => $u['phone_number'],
                    'registration_status' => $u['registration_status'],
                    'gpon_onu' => $u['gpon_onu'],
                    'special_request' => $u['special_request'],
                    'building_type' => 'RUMAH-PRIBADI',
                ]
            );
        }

        // PON 5 / MS DISKOMINFO (7/8)
        $pon5 = PonPort::updateOrCreate(
            ['olt_code' => 'OLT-MSN', 'name' => 'PON 5 / MS DISKOMINFO'],
            ['port_number' => 5, 'max_ports' => 8, 'used_ports' => 7, 'total_subscribers' => 20]
        );
        for ($d = 1; $d <= 7; $d++) {
            Odp::updateOrCreate(
                ['code' => "ODP-DISKOMINFO-0{$d}"],
                [
                    'name' => "ODP DISKOMINFO {$d}",
                    'olt_code' => 'OLT-MSN',
                    'pon_port_id' => $pon5->id,
                    'pop_code' => $pop->code,
                    'total_ports' => 8,
                    'used_ports' => 3,
                    'latitude' => "-6.93" . (50 + $d),
                    'longitude' => "107.60" . (10 + $d),
                ]
            );
        }

        // ══════════════════════════════════════════════════════════════
        // 5. OLT BAGONG: PONs, ODPs & Subscribers (Gambar 3 Coverage)
        // ══════════════════════════════════════════════════════════════
        $ponSukamulya = PonPort::updateOrCreate(
            ['olt_code' => 'OLT-BAGONG', 'name' => 'PON 11 / MS SUKAMULYA'],
            [
                'port_number' => 11,
                'max_ports' => 16,
                'used_ports' => 2,
                'total_subscribers' => 18,
            ]
        );

        $odpSukamulya4 = Odp::updateOrCreate(
            ['code' => 'ODP-SUKAMULYA-4'],
            [
                'name' => 'SUKAMULYA [4]',
                'olt_code' => 'OLT-BAGONG',
                'pon_port_id' => $ponSukamulya->id,
                'pop_code' => $pop->code,
                'total_ports' => 16,
                'used_ports' => 11,
                'latitude' => '-6.93708',
                'longitude' => '107.59106',
            ]
        );

        $odpSukamulya5 = Odp::updateOrCreate(
            ['code' => 'ODP-SUKAMULYA-5'],
            [
                'name' => 'SUKAMULYA [5]',
                'olt_code' => 'OLT-BAGONG',
                'pon_port_id' => $ponSukamulya->id,
                'pop_code' => $pop->code,
                'total_ports' => 16,
                'used_ports' => 7,
                'latitude' => '-6.93749',
                'longitude' => '107.59094',
            ]
        );

        // Add subscribers in Sukamulya [4]
        for ($i = 1; $i <= 11; $i++) {
            $num = sprintf('%02d', $i);
            $nik = "32049988776600{$num}";
            $name = "PELANGGAN SUKAMULYA {$i}";

            Customer::updateOrCreate(
                ['nik' => $nik],
                [
                    'name' => $name,
                    'phone_number' => "0812998877{$num}",
                    'id_card_address' => "JL. SUKAMULYA RT {$num}/RW 04",
                    'email' => "sukamulya{$i}@gmail.com",
                ]
            );

            CustomerSubscription::updateOrCreate(
                ['internet_number' => "MS7700{$num}2021"],
                [
                    'customer_nik' => $nik,
                    'customer_name' => $name,
                    'package_code' => $pkg30->code,
                    'pop_code' => $pop->code,
                    'olt_code' => 'OLT-BAGONG',
                    'odp_code' => $odpSukamulya4->code,
                    'installation_address' => "JL. SUKAMULYA RT {$num}/RW 04",
                    'phone_number' => "0812998877{$num}",
                    'registration_status' => 'AKTIF',
                    'gpon_onu' => "gpon-onu_1/11/4:{$i} sn HWTC702D{$num}",
                    'special_request' => '',
                    'building_type' => 'RUMAH-PRIBADI',
                ]
            );
        }

        // Add subscribers in Sukamulya [5]
        for ($i = 1; $i <= 7; $i++) {
            $num = sprintf('%02d', $i);
            $nik = "32048877665500{$num}";
            $name = "WARGA SUKAMULYA {$i}";

            Customer::updateOrCreate(
                ['nik' => $nik],
                [
                    'name' => $name,
                    'phone_number' => "0813887766{$num}",
                    'id_card_address' => "JL. SUKAMULYA BLOK B NO {$i}",
                    'email' => "wargasukamulya{$i}@gmail.com",
                ]
            );

            CustomerSubscription::updateOrCreate(
                ['internet_number' => "MS8800{$num}2021"],
                [
                    'customer_nik' => $nik,
                    'customer_name' => $name,
                    'package_code' => $pkg20->code,
                    'pop_code' => $pop->code,
                    'olt_code' => 'OLT-BAGONG',
                    'odp_code' => $odpSukamulya5->code,
                    'installation_address' => "JL. SUKAMULYA BLOK B NO {$i}",
                    'phone_number' => "0813887766{$num}",
                    'registration_status' => 'AKTIF',
                    'gpon_onu' => "gpon-onu_1/11/5:{$i} sn HWTC803E{$num}",
                    'special_request' => '',
                    'building_type' => 'RUMAH-PRIBADI',
                ]
            );
        }

        // ══════════════════════════════════════════════════════════════
        // 6. OLT SOREANG: PONs & ODPs
        // ══════════════════════════════════════════════════════════════
        $ponSoreangKota = PonPort::updateOrCreate(
            ['olt_code' => 'OLT-SOREANG', 'name' => 'PON 1 / SOREANG KOTA'],
            [
                'port_number' => 1,
                'max_ports' => 8,
                'used_ports' => 2,
                'total_subscribers' => 5,
            ]
        );

        Odp::updateOrCreate(
            ['code' => 'ODP-SOREANG-ALUN2'],
            [
                'name' => 'ODP SOREANG ALUN-ALUN',
                'olt_code' => 'OLT-SOREANG',
                'pon_port_id' => $ponSoreangKota->id,
                'pop_code' => $pop->code,
                'total_ports' => 8,
                'used_ports' => 3,
                'latitude' => '-7.02890',
                'longitude' => '107.51890',
            ]
        );

        Odp::updateOrCreate(
            ['code' => 'ODP-GADING-TUTUKA'],
            [
                'name' => 'ODP GADING TUTUKA',
                'olt_code' => 'OLT-SOREANG',
                'pon_port_id' => $ponSoreangKota->id,
                'pop_code' => $pop->code,
                'total_ports' => 16,
                'used_ports' => 2,
                'latitude' => '-7.02340',
                'longitude' => '107.52560',
            ]
        );
    }
}
