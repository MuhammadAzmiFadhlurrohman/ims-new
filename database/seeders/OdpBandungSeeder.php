<?php

namespace Database\Seeders;

use App\Models\CustomerSubscription;
use App\Models\Odp;
use App\Models\Pop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OdpBandungSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure POP Utama Bandung exists
        $mainPop = Pop::firstOrCreate(
            ['code' => 'POP-BDG-MAIN'],
            ['name' => 'POP Utama Bandung Raya', 'description' => 'Server Distribusi Utama Kawasan Bandung Raya']
        );

        // 2. 30 Real Bandung ODP Nodes across all strategic areas
        $bandungOdps = [
            // ── BANDUNG PUSAT / KOTA ──
            [
                'code' => 'ODP-BDG-BRAGA-01',
                'name' => 'ODP Braga Sentral Heritage',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 14,
                'latitude' => -6.917500,
                'longitude' => 107.609600,
                'notes' => 'Tiang MSN No. 08 Depan Museum KAA Braga',
            ],
            [
                'code' => 'ODP-BDG-ASIAAFRIKA-01',
                'name' => 'ODP Asia Afrika Bisnis Sentra',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 15,
                'latitude' => -6.921300,
                'longitude' => 107.607400,
                'notes' => 'Tiang FO MSN No. 12 Depan Alun-Alun Bandung',
            ],
            [
                'code' => 'ODP-BDG-RIAU-01',
                'name' => 'ODP R.E. Martadinata Riau',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 13,
                'latitude' => -6.908200,
                'longitude' => 107.618500,
                'notes' => 'Tiang MSN No. 04 Dekat Factory Outlet Riau',
            ],
            [
                'code' => 'ODP-BDG-MERDEKA-01',
                'name' => 'ODP Merdeka Mall Sentral',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 8,
                'used_ports' => 7,
                'latitude' => -6.911400,
                'longitude' => 107.610200,
                'notes' => 'Tiang MSN No. 06 Depan BIP Mall',
            ],
            [
                'code' => 'ODP-BDG-DIPATIUKUR-01',
                'name' => 'ODP Dipati Ukur Kampus UNPAD',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 16,
                'latitude' => -6.892600,
                'longitude' => 107.616800,
                'notes' => 'Tiang MSN No. 01 Area UNPAD & ITHB',
            ],

            // ── BANDUNG UTARA ──
            [
                'code' => 'ODP-BDG-DAGO-01',
                'name' => 'ODP Dago Atas Cluster Asri',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 12,
                'latitude' => -6.882100,
                'longitude' => 107.616200,
                'notes' => 'Tiang MSN No. 22 Depan Simpang Dago',
            ],
            [
                'code' => 'ODP-BDG-DAGO-02',
                'name' => 'ODP Tubagus Ismail Residence',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 8,
                'used_ports' => 6,
                'latitude' => -6.886400,
                'longitude' => 107.622100,
                'notes' => 'Tiang MSN No. 14 Gang Tubagus Ismail VIII',
            ],
            [
                'code' => 'ODP-BDG-CIHAMPELAS-01',
                'name' => 'ODP Cihampelas Walk Ciwalk',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 14,
                'latitude' => -6.895800,
                'longitude' => 107.604100,
                'notes' => 'Tiang MSN No. 09 Area Cihampelas Ciwalk',
            ],
            [
                'code' => 'ODP-BDG-SUKAJADI-01',
                'name' => 'ODP Sukajadi PVJ Sentra',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 15,
                'latitude' => -6.890400,
                'longitude' => 107.597500,
                'notes' => 'Tiang MSN No. 17 Depan Paris Van Java',
            ],
            [
                'code' => 'ODP-BDG-SETIABUDI-01',
                'name' => 'ODP Setiabudi Regency',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 11,
                'latitude' => -6.862300,
                'longitude' => 107.593400,
                'notes' => 'Tiang MSN No. 31 Pintu Gerbang Setiabudi Regency',
            ],
            [
                'code' => 'ODP-BDG-GEGERKALONG-01',
                'name' => 'ODP Gegerkalong Kampus UPI',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 8,
                'used_ports' => 7,
                'latitude' => -6.867500,
                'longitude' => 107.588600,
                'notes' => 'Tiang MSN No. 05 Gerlong Hilir Dekat UPI',
            ],

            // ── BANDUNG SELATAN & BUAHBATU ──
            [
                'code' => 'ODP-BDG-BUAHBATU-01',
                'name' => 'ODP Buah Batu Kordon Node',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-BAGONG',
                'total_ports' => 16,
                'used_ports' => 13,
                'latitude' => -6.938500,
                'longitude' => 107.625800,
                'notes' => 'Tiang MSN No. 19 Depan Pasar Kordon Buahbatu',
            ],
            [
                'code' => 'ODP-BDG-BUAHBATU-02',
                'name' => 'ODP Cijawura Hilir Asri',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-BAGONG',
                'total_ports' => 8,
                'used_ports' => 6,
                'latitude' => -6.945200,
                'longitude' => 107.641200,
                'notes' => 'Tiang MSN No. 03 Komplek Cijawura',
            ],
            [
                'code' => 'ODP-BDG-BKR-01',
                'name' => 'ODP BKR Lingkar Selatan',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-BAGONG',
                'total_ports' => 16,
                'used_ports' => 12,
                'latitude' => -6.934100,
                'longitude' => 107.611500,
                'notes' => 'Tiang MSN No. 11 Perempatan Jl BKR Moch Toha',
            ],
            [
                'code' => 'ODP-BDG-MOHTOHA-01',
                'name' => 'ODP Moch Toha Exit Tol',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-BAGONG',
                'total_ports' => 8,
                'used_ports' => 8,
                'latitude' => -6.953200,
                'longitude' => 107.608400,
                'notes' => 'Tiang MSN No. 25 Dekat Gerbang Tol Moch Toha',
            ],
            [
                'code' => 'ODP-BDG-BATUNUNGGAL-01',
                'name' => 'ODP Batununggal Indah Estate',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-BAGONG',
                'total_ports' => 16,
                'used_ports' => 14,
                'latitude' => -6.956800,
                'longitude' => 107.628900,
                'notes' => 'Tiang MSN No. 09 Cluster Batununggal Indah',
            ],

            // ── BANDUNG TIMUR & GEDEBAGE ──
            [
                'code' => 'ODP-BDG-ANTAPANI-01',
                'name' => 'ODP Antapani Purwakarta Sentra',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 15,
                'latitude' => -6.914200,
                'longitude' => 107.658700,
                'notes' => 'Tiang MSN No. 07 Jl. Purwakarta Antapani',
            ],
            [
                'code' => 'ODP-BDG-ARCAMANIK-01',
                'name' => 'ODP Arcamanik Pacuan Kuda',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 11,
                'latitude' => -6.919800,
                'longitude' => 107.674200,
                'notes' => 'Tiang MSN No. 15 GOR Arcamanik',
            ],
            [
                'code' => 'ODP-BDG-GEDEBAGE-01',
                'name' => 'ODP Gedebage Al-Jabbar Sentra',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 10,
                'latitude' => -6.948200,
                'longitude' => 107.703400,
                'notes' => 'Tiang MSN No. 02 Akses Masjid Raya Al-Jabbar',
            ],
            [
                'code' => 'ODP-BDG-SUMMARECON-01',
                'name' => 'ODP Summarecon Bandung Cluster Emily',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 14,
                'latitude' => -6.955400,
                'longitude' => 107.698200,
                'notes' => 'Tiang MSN No. 01 Main Gate Summarecon Bandung',
            ],
            [
                'code' => 'ODP-BDG-CIBIRU-01',
                'name' => 'ODP Cibiru UIN Sunan Gunung Djati',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 8,
                'used_ports' => 7,
                'latitude' => -6.931500,
                'longitude' => 107.712500,
                'notes' => 'Tiang MSN No. 08 Dekat Kampus UIN Cibiru',
            ],
            [
                'code' => 'ODP-BDG-UJUNGBERUNG-01',
                'name' => 'ODP Ujungberung Alun-Alun',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 8,
                'used_ports' => 6,
                'latitude' => -6.910200,
                'longitude' => 107.695400,
                'notes' => 'Tiang MSN No. 12 Depan Alun-Alun Ujungberung',
            ],

            // ── BANDUNG BARAT, KOPO & CIMAHI ──
            [
                'code' => 'ODP-BDG-PASIRKALIKI-01',
                'name' => 'ODP Pasirkaliki Stasiun Hall',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 13,
                'latitude' => -6.910500,
                'longitude' => 107.601200,
                'notes' => 'Tiang MSN No. 06 Pintu Utara Stasiun Bandung',
            ],
            [
                'code' => 'ODP-BDG-PASTEUR-01',
                'name' => 'ODP Pasteur Gateway Residence',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 15,
                'latitude' => -6.896200,
                'longitude' => 107.581400,
                'notes' => 'Tiang MSN No. 20 Dekat Gerbang Tol Pasteur',
            ],
            [
                'code' => 'ODP-BDG-KOPO-01',
                'name' => 'ODP Kopo Permai Sentra',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-BAGONG',
                'total_ports' => 16,
                'used_ports' => 12,
                'latitude' => -6.941200,
                'longitude' => 107.589400,
                'notes' => 'Tiang MSN No. 18 Komplek Kopo Permai Blok B',
            ],
            [
                'code' => 'ODP-BDG-CIBADUYUT-01',
                'name' => 'ODP Cibaduyut Raya Sentra',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-BAGONG',
                'total_ports' => 8,
                'used_ports' => 7,
                'latitude' => -6.950100,
                'longitude' => 107.595200,
                'notes' => 'Tiang MSN No. 04 Dekat Tugu Sepatu Cibaduyut',
            ],
            [
                'code' => 'ODP-BDG-CIMAHI-01',
                'name' => 'ODP Cimahi Amir Machmud',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-MSN',
                'total_ports' => 16,
                'used_ports' => 14,
                'latitude' => -6.879500,
                'longitude' => 107.545200,
                'notes' => 'Tiang MSN No. 16 Alun-Alun Cimahi',
            ],

            // ── KABUPATEN BANDUNG (SOREANG & GADING TUTUKA) ──
            [
                'code' => 'ODP-BDG-SOREANG-01',
                'name' => 'ODP Soreang Alun-Alun Pemkab',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-SOREANG',
                'total_ports' => 16,
                'used_ports' => 14,
                'latitude' => -7.028900,
                'longitude' => 107.518900,
                'notes' => 'Tiang MSN No. 01 Komplek Kantor Pemkab Bandung',
            ],
            [
                'code' => 'ODP-BDG-GADINGTUTUKA-01',
                'name' => 'ODP Gading Tutuka Residence',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-SOREANG',
                'total_ports' => 16,
                'used_ports' => 13,
                'latitude' => -7.023400,
                'longitude' => 107.525600,
                'notes' => 'Tiang MSN No. 08 Cluster Gading Tutuka 2 Blok E',
            ],
            [
                'code' => 'ODP-BDG-BANJARAN-01',
                'name' => 'ODP Banjaran Sentra Niaga',
                'pop_code' => 'POP-BDG-MAIN',
                'olt_code' => 'OLT-SOREANG',
                'total_ports' => 8,
                'used_ports' => 6,
                'latitude' => -7.045200,
                'longitude' => 107.587400,
                'notes' => 'Tiang MSN No. 11 Pasar Banjaran',
            ],
        ];

        // 1. First, insert all new Bandung ODPs into odps table
        foreach ($bandungOdps as $odpData) {
            Odp::updateOrCreate(
                ['code' => $odpData['code']],
                $odpData
            );
        }

        // 2. Map old foreign key references in customer subscriptions to new Bandung ODPs
        $mapping = [
            'ODP-CBT-01/01' => 'ODP-BDG-BRAGA-01',
            'ODP-CBT-01/02' => 'ODP-BDG-ASIAAFRIKA-01',
            'ODP-CKR-01/01' => 'ODP-BDG-DAGO-01',
            'ODP-CKR-01/02' => 'ODP-BDG-BUAHBATU-01',
            'ODP-TMN-01/01' => 'ODP-BDG-ANTAPANI-01',
            'ODP-BKS-01/01' => 'ODP-BDG-PASIRKALIKI-01',
        ];

        foreach ($mapping as $oldCode => $newCode) {
            CustomerSubscription::where('odp_code', $oldCode)->update(['odp_code' => $newCode]);
        }

        // 3. Now safely delete all old non-Bandung ODPs
        Odp::where('code', 'like', '%CBT%')
            ->orWhere('code', 'like', '%CKR%')
            ->orWhere('code', 'like', '%TMN%')
            ->orWhere('code', 'like', '%BKS%')
            ->orWhere('name', 'like', '%Cibitung%')
            ->orWhere('name', 'like', '%Cikarang%')
            ->orWhere('name', 'like', '%Tambun%')
            ->orWhere('name', 'like', '%Bekasi%')
            ->delete();

        // 4. Also clean up any subscriptions with null/invalid odp_code to link to Bandung ODPs
        $availableCodes = array_column($bandungOdps, 'code');
        $subsWithoutOdp = CustomerSubscription::whereNull('odp_code')
            ->orWhere('odp_code', '')
            ->orWhereNotIn('odp_code', Odp::pluck('code'))
            ->get();

        foreach ($subsWithoutOdp as $idx => $sub) {
            $sub->update(['odp_code' => $availableCodes[$idx % count($availableCodes)]]);
        }
    }
}
