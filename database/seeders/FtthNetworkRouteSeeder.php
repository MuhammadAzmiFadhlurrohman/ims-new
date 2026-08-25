<?php

namespace Database\Seeders;

use App\Models\FtthNetworkElement;
use App\Models\Odp;
use App\Models\Olt;
use Illuminate\Database\Seeder;

class FtthNetworkRouteSeeder extends Seeder
{
    public function run(): void
    {
        // Helper to calculate distance in meters
        $calcDist = function ($lat1, $lon1, $lat2, $lon2) {
            $R = 6371000;
            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);
            $a = sin($dLat / 2) * sin($dLat / 2) +
                 cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                 sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            return (int) round($R * $c);
        };

        // Clear existing elements to avoid duplicate seed
        FtthNetworkElement::truncate();

        // 2. OLT Core Server Nodes
        FtthNetworkElement::create([
            'name' => 'OLT Core Server MSN (Headend)',
            'category' => 'marker',
            'element_type' => 'olt',
            'olt_code' => 'OLT-MSN',
            'latitude' => -6.92750,
            'longitude' => 107.59200,
            'color' => '#8B5CF6',
            'notes' => 'Central Core OLT Server 10G Uplink'
        ]);

        FtthNetworkElement::create([
            'name' => 'OLT Mini Core Bagong',
            'category' => 'marker',
            'element_type' => 'olt',
            'olt_code' => 'OLT-BAGONG',
            'latitude' => -6.93600,
            'longitude' => 107.59050,
            'color' => '#8B5CF6',
            'notes' => 'Sub-Core Hub Sukamulya'
        ]);

        // 3. ODC / FDT Distribution Cabinets
        FtthNetworkElement::create([
            'name' => 'ODC-KRD-01 (FDT 144 Core)',
            'category' => 'marker',
            'element_type' => 'odc',
            'olt_code' => 'OLT-MSN',
            'latitude' => -6.92900,
            'longitude' => 107.59280,
            'color' => '#F59E0B',
            'notes' => 'Cabinet ODC Sentral Wilayah Kordon & Reog'
        ]);

        FtthNetworkElement::create([
            'name' => 'ODC-DSK-01 (FDT 96 Core)',
            'category' => 'marker',
            'element_type' => 'odc',
            'olt_code' => 'OLT-MSN',
            'latitude' => -6.93480,
            'longitude' => 107.60050,
            'color' => '#F59E0B',
            'notes' => 'Cabinet ODC Komplek Diskominfo'
        ]);

        FtthNetworkElement::create([
            'name' => 'ODC-SFA-01 (FDT 48 Core)',
            'category' => 'marker',
            'element_type' => 'odc',
            'olt_code' => 'OLT-MSN',
            'latitude' => -6.93780,
            'longitude' => 107.58900,
            'color' => '#F59E0B',
            'notes' => 'Cabinet ODC Sufia Residence'
        ]);

        // 4. Tiang Fiber (Poles) & Joint Boxes
        $poles = [
            ['name' => 'Tiang Fiber MSN-P01', 'lat' => -6.92810, 'lng' => 107.59240, 'type' => 'pole', 'notes' => 'Tiang Besi 7m Sudut Jalan'],
            ['name' => 'Tiang Fiber MSN-P02 (JB-01)', 'lat' => -6.93040, 'lng' => 107.59400, 'type' => 'joint_box', 'notes' => 'Joint Closure FOSC 24 Core'],
            ['name' => 'Tiang Fiber MSN-P03', 'lat' => -6.93230, 'lng' => 107.59600, 'type' => 'pole', 'notes' => 'Tiang PLN Span 40m'],
            ['name' => 'Tiang Fiber MSN-P04 (JB-02)', 'lat' => -6.93420, 'lng' => 107.59800, 'type' => 'joint_box', 'notes' => 'Joint Closure Branching Reog-Indomart'],
            ['name' => 'Tiang Fiber DSK-P01', 'lat' => -6.93500, 'lng' => 107.60080, 'type' => 'pole', 'notes' => 'Tiang Utama Diskominfo'],
            ['name' => 'Tiang Fiber SFA-P01', 'lat' => -6.93870, 'lng' => 107.58950, 'type' => 'pole', 'notes' => 'Tiang Gg. Sufia'],
        ];

        foreach ($poles as $p) {
            FtthNetworkElement::create([
                'name' => $p['name'],
                'category' => 'marker',
                'element_type' => $p['type'],
                'olt_code' => 'OLT-MSN',
                'latitude' => $p['lat'],
                'longitude' => $p['lng'],
                'color' => $p['type'] === 'joint_box' ? '#10B981' : '#64748B',
                'notes' => $p['notes']
            ]);
        }

        // 5. Feeder Cables (Red Lines)
        $feeder1Coords = [
            [-6.92750, 107.59200],
            [-6.92810, 107.59240],
            [-6.92900, 107.59280]
        ];
        FtthNetworkElement::create([
            'name' => 'Kabel Feeder 48 Core (OLT Core ➔ ODC Kordon)',
            'category' => 'line',
            'element_type' => 'feeder',
            'olt_code' => 'OLT-MSN',
            'path_coordinates' => $feeder1Coords,
            'length_meters' => $calcDist(-6.92750, 107.59200, -6.92900, 107.59280),
            'color' => '#EF4444',
            'notes' => 'Feeder Utama Backbone ADSS 48 Core'
        ]);

        $feeder2Coords = [
            [-6.92900, 107.59280],
            [-6.93040, 107.59400],
            [-6.93230, 107.59600],
            [-6.93420, 107.59800],
            [-6.93480, 107.60050]
        ];
        FtthNetworkElement::create([
            'name' => 'Kabel Feeder 24 Core (ODC Kordon ➔ ODC Diskominfo)',
            'category' => 'line',
            'element_type' => 'feeder',
            'olt_code' => 'OLT-MSN',
            'path_coordinates' => $feeder2Coords,
            'length_meters' => $calcDist(-6.92900, 107.59280, -6.93480, 107.60050),
            'color' => '#EF4444',
            'notes' => 'Kabel Feeder Inter-ODC 24 Core'
        ]);

        $feeder3Coords = [
            [-6.93600, 107.59050],
            [-6.93708, 107.59106],
            [-6.93780, 107.58900]
        ];
        FtthNetworkElement::create([
            'name' => 'Kabel Feeder 24 Core (OLT Bagong ➔ ODC Sufia)',
            'category' => 'line',
            'element_type' => 'feeder',
            'olt_code' => 'OLT-BAGONG',
            'path_coordinates' => $feeder3Coords,
            'length_meters' => $calcDist(-6.93600, 107.59050, -6.93780, 107.58900),
            'color' => '#EF4444',
            'notes' => 'Feeder Sukamulya-Sufia'
        ]);

        // 6. Distribution Cables (Blue Lines)
        $pon4Odps = Odp::where('pon_port_id', 4)->orderBy('code')->get();
        if ($pon4Odps->count() >= 2) {
            $pon4Coords = [[-6.92900, 107.59280]];
            foreach ($pon4Odps as $odp) {
                $pon4Coords[] = [(float)$odp->latitude, (float)$odp->longitude];
            }
            $pon4Len = 0;
            for ($i = 0; $i < count($pon4Coords) - 1; $i++) {
                $pon4Len += $calcDist($pon4Coords[$i][0], $pon4Coords[$i][1], $pon4Coords[$i+1][0], $pon4Coords[$i+1][1]);
            }
            FtthNetworkElement::create([
                'name' => 'Kabel Distribusi 24 Core (PON 4: Kordon ➔ Reog ➔ Raja Mantri ➔ Sri Rejeki)',
                'category' => 'line',
                'element_type' => 'distribution',
                'olt_code' => 'OLT-MSN',
                'path_coordinates' => $pon4Coords,
                'length_meters' => $pon4Len,
                'color' => '#0878E5',
                'notes' => 'Jalur Distribusi 5 ODP Aktif PON 4'
            ]);
        }

        $pon5Odps = Odp::where('pon_port_id', 5)->orderBy('code')->get();
        if ($pon5Odps->count() >= 2) {
            $pon5Coords = [[-6.93480, 107.60050]];
            foreach ($pon5Odps as $odp) {
                $pon5Coords[] = [(float)$odp->latitude, (float)$odp->longitude];
            }
            $pon5Len = 0;
            for ($i = 0; $i < count($pon5Coords) - 1; $i++) {
                $pon5Len += $calcDist($pon5Coords[$i][0], $pon5Coords[$i][1], $pon5Coords[$i+1][0], $pon5Coords[$i+1][1]);
            }
            FtthNetworkElement::create([
                'name' => 'Kabel Distribusi 12 Core (PON 5: Komplek Diskominfo ODP 1-7)',
                'category' => 'line',
                'element_type' => 'distribution',
                'olt_code' => 'OLT-MSN',
                'path_coordinates' => $pon5Coords,
                'length_meters' => $pon5Len,
                'color' => '#0878E5',
                'notes' => 'Jalur Distribusi 7 ODP Diskominfo PON 5'
            ]);
        }

        $pon3Odps = Odp::where('pon_port_id', 3)->orderBy('code')->get();
        if ($pon3Odps->count() >= 2) {
            $pon3Coords = [[-6.93780, 107.58900]];
            foreach ($pon3Odps as $odp) {
                $pon3Coords[] = [(float)$odp->latitude, (float)$odp->longitude];
            }
            $pon3Len = 0;
            for ($i = 0; $i < count($pon3Coords) - 1; $i++) {
                $pon3Len += $calcDist($pon3Coords[$i][0], $pon3Coords[$i][1], $pon3Coords[$i+1][0], $pon3Coords[$i+1][1]);
            }
            FtthNetworkElement::create([
                'name' => 'Kabel Distribusi 12 Core (PON 3: Sufia Utara ➔ Selatan ➔ Barat)',
                'category' => 'line',
                'element_type' => 'distribution',
                'olt_code' => 'OLT-MSN',
                'path_coordinates' => $pon3Coords,
                'length_meters' => $pon3Len,
                'color' => '#0878E5',
                'notes' => 'Jalur Distribusi 3 ODP Sufia PON 3'
            ]);
        }

        // 7. Dropcore Lines & Customers
        $dropcore1 = [
            [-6.92976, 107.5933],
            [-6.92995, 107.5936]
        ];
        FtthNetworkElement::create([
            'name' => 'Dropcore 1 Core (ODP Kordon ➔ Rumah Pelanggan #MSN-0102)',
            'category' => 'line',
            'element_type' => 'dropcore',
            'olt_code' => 'OLT-MSN',
            'path_coordinates' => $dropcore1,
            'length_meters' => $calcDist(-6.92976, 107.5933, -6.92995, 107.5936),
            'color' => '#F59E0B',
            'notes' => 'Dropcore Fiber Optic 1 Core G.657A'
        ]);

        FtthNetworkElement::create([
            'name' => 'Rumah Pelanggan (Bpk. Hendra - MSN-0102)',
            'category' => 'marker',
            'element_type' => 'customer',
            'olt_code' => 'OLT-MSN',
            'latitude' => -6.92995,
            'longitude' => 107.5936,
            'color' => '#EC4899',
            'notes' => 'ONT Fiberhome - Paket 50 Mbps'
        ]);
    }
}
