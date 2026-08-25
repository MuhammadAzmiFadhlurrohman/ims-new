<?php

namespace Database\Seeders;

use App\Models\FtthNetworkElement;
use App\Models\Odp;
use App\Models\Olt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

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

        // Helper to fetch actual street/alley geometry from OSM routing
        $fetchStreetRoute = function (array $waypoints) use ($calcDist) {
            if (count($waypoints) < 2) return $waypoints;

            $fullPolyline = [];

            for ($i = 0; $i < count($waypoints) - 1; $i++) {
                $p1 = $waypoints[$i];
                $p2 = $waypoints[$i + 1];

                $lat1 = $p1[0]; $lon1 = $p1[1];
                $lat2 = $p2[0]; $lon2 = $p2[1];

                $routed = false;

                // Try OSM footway/pedestrian routing (follows narrow Indonesian gang & residential streets)
                $url = "https://routing.openstreetmap.de/routed-foot/route/v1/foot/{$lon1},{$lat1};{$lon2},{$lat2}?overview=full&geometries=geojson";
                try {
                    $response = Http::timeout(5)->get($url);
                    if ($response->successful() && isset($response->json()['routes'][0]['geometry']['coordinates'])) {
                        $coords = $response->json()['routes'][0]['geometry']['coordinates'];
                        foreach ($coords as $c) {
                            $fullPolyline[] = [(float)$c[1], (float)$c[0]];
                        }
                        $routed = true;
                    }
                } catch (\Throwable $e) {}

                if (!$routed) {
                    // Fallback to OSRM driving
                    $url2 = "https://router.project-osrm.org/route/v1/driving/{$lon1},{$lat1};{$lon2},{$lat2}?overview=full&geometries=geojson";
                    try {
                        $response2 = Http::timeout(5)->get($url2);
                        if ($response2->successful() && isset($response2->json()['routes'][0]['geometry']['coordinates'])) {
                            $coords2 = $response2->json()['routes'][0]['geometry']['coordinates'];
                            foreach ($coords2 as $c) {
                                $fullPolyline[] = [(float)$c[1], (float)$c[0]];
                            }
                            $routed = true;
                        }
                    } catch (\Throwable $e) {}
                }

                if (!$routed) {
                    $fullPolyline[] = [$lat1, $lon1];
                    $fullPolyline[] = [$lat2, $lon2];
                }

                usleep(100000);
            }

            // Remove adjacent duplicate coordinates
            $cleanPolyline = [];
            foreach ($fullPolyline as $pt) {
                if (empty($cleanPolyline) || ($cleanPolyline[count($cleanPolyline)-1][0] !== $pt[0] || $cleanPolyline[count($cleanPolyline)-1][1] !== $pt[1])) {
                    $cleanPolyline[] = $pt;
                }
            }

            return $cleanPolyline;
        };

        // Helper to sum total polyline length in meters
        $calcPolylineLength = function (array $coords) use ($calcDist) {
            $total = 0;
            for ($i = 0; $i < count($coords) - 1; $i++) {
                $total += $calcDist($coords[$i][0], $coords[$i][1], $coords[$i+1][0], $coords[$i+1][1]);
            }
            return $total;
        };

        // Clear existing elements to avoid duplicate seed
        FtthNetworkElement::truncate();

        // 1. OLT Core Server Nodes
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

        // 2. ODC / FDT Distribution Cabinets
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

        // 3. Tiang Fiber (Poles) & Joint Boxes
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

        // 4. Feeder Cables (Red Lines) following actual streets
        $feeder1Points = [
            [-6.92750, 107.59200], // OLT MSN
            [-6.92810, 107.59240], // Tiang P01
            [-6.92900, 107.59280]  // ODC Kordon
        ];
        $feeder1Street = $fetchStreetRoute($feeder1Points);
        FtthNetworkElement::create([
            'name' => 'Kabel Feeder 48 Core (OLT Core ➔ ODC Kordon)',
            'category' => 'line',
            'element_type' => 'feeder',
            'olt_code' => 'OLT-MSN',
            'path_coordinates' => $feeder1Street,
            'length_meters' => $calcPolylineLength($feeder1Street),
            'color' => '#EF4444',
            'notes' => 'Feeder Utama Backbone ADSS 48 Core Menyusuri Jalan'
        ]);

        $feeder2Points = [
            [-6.92900, 107.59280], // ODC Kordon
            [-6.93040, 107.59400], // Tiang JB-01
            [-6.93230, 107.59600], // Tiang P03
            [-6.93420, 107.59800], // Tiang JB-02
            [-6.93480, 107.60050]  // ODC Diskominfo
        ];
        $feeder2Street = $fetchStreetRoute($feeder2Points);
        FtthNetworkElement::create([
            'name' => 'Kabel Feeder 24 Core (ODC Kordon ➔ ODC Diskominfo)',
            'category' => 'line',
            'element_type' => 'feeder',
            'olt_code' => 'OLT-MSN',
            'path_coordinates' => $feeder2Street,
            'length_meters' => $calcPolylineLength($feeder2Street),
            'color' => '#EF4444',
            'notes' => 'Kabel Feeder Inter-ODC 24 Core Menyusuri Jalan Raya'
        ]);

        $feeder3Points = [
            [-6.93600, 107.59050], // OLT Bagong
            [-6.93708, 107.59106],
            [-6.93780, 107.58900]  // ODC Sufia
        ];
        $feeder3Street = $fetchStreetRoute($feeder3Points);
        FtthNetworkElement::create([
            'name' => 'Kabel Feeder 24 Core (OLT Bagong ➔ ODC Sufia)',
            'category' => 'line',
            'element_type' => 'feeder',
            'olt_code' => 'OLT-BAGONG',
            'path_coordinates' => $feeder3Street,
            'length_meters' => $calcPolylineLength($feeder3Street),
            'color' => '#EF4444',
            'notes' => 'Feeder Sukamulya-Sufia Menyusuri Gang'
        ]);

        // 5. Distribution Cables (Blue Lines) following actual streets
        $pon4Odps = Odp::where('pon_port_id', 4)->orderBy('code')->get();
        if ($pon4Odps->count() >= 2) {
            $pon4Points = [[-6.92900, 107.59280]]; // From ODC Kordon
            foreach ($pon4Odps as $odp) {
                $pon4Points[] = [(float)$odp->latitude, (float)$odp->longitude];
            }
            $pon4Street = $fetchStreetRoute($pon4Points);
            FtthNetworkElement::create([
                'name' => 'Kabel Distribusi 24 Core (PON 4: Kordon ➔ Reog ➔ Raja Mantri ➔ Sri Rejeki)',
                'category' => 'line',
                'element_type' => 'distribution',
                'olt_code' => 'OLT-MSN',
                'path_coordinates' => $pon4Street,
                'length_meters' => $calcPolylineLength($pon4Street),
                'color' => '#0878E5',
                'notes' => 'Jalur Distribusi 5 ODP Aktif PON 4 Mengikuti Rute Jalan'
            ]);
        }

        $pon5Odps = Odp::where('pon_port_id', 5)->orderBy('code')->get();
        if ($pon5Odps->count() >= 2) {
            $pon5Points = [[-6.93480, 107.60050]]; // From ODC Diskominfo
            foreach ($pon5Odps as $odp) {
                $pon5Points[] = [(float)$odp->latitude, (float)$odp->longitude];
            }
            $pon5Street = $fetchStreetRoute($pon5Points);
            FtthNetworkElement::create([
                'name' => 'Kabel Distribusi 12 Core (PON 5: Komplek Diskominfo ODP 1-7)',
                'category' => 'line',
                'element_type' => 'distribution',
                'olt_code' => 'OLT-MSN',
                'path_coordinates' => $pon5Street,
                'length_meters' => $calcPolylineLength($pon5Street),
                'color' => '#0878E5',
                'notes' => 'Jalur Distribusi 7 ODP Diskominfo PON 5 Mengikuti Jalan Komplek'
            ]);
        }

        $pon3Odps = Odp::where('pon_port_id', 3)->orderBy('code')->get();
        if ($pon3Odps->count() >= 2) {
            $pon3Points = [[-6.93780, 107.58900]]; // From ODC Sufia
            foreach ($pon3Odps as $odp) {
                $pon3Points[] = [(float)$odp->latitude, (float)$odp->longitude];
            }
            $pon3Street = $fetchStreetRoute($pon3Points);
            FtthNetworkElement::create([
                'name' => 'Kabel Distribusi 12 Core (PON 3: Sufia Utara ➔ Selatan ➔ Barat)',
                'category' => 'line',
                'element_type' => 'distribution',
                'olt_code' => 'OLT-MSN',
                'path_coordinates' => $pon3Street,
                'length_meters' => $calcPolylineLength($pon3Street),
                'color' => '#0878E5',
                'notes' => 'Jalur Distribusi 3 ODP Sufia PON 3 Mengikuti Gang'
            ]);
        }

        // 6. Dropcore Lines & Customers
        $dropcorePoints = [
            [-6.92976, 107.5933], // ODP Kordon
            [-6.92995, 107.5936]  // Customer House
        ];
        $dropcoreStreet = $fetchStreetRoute($dropcorePoints);
        FtthNetworkElement::create([
            'name' => 'Dropcore 1 Core (ODP Kordon ➔ Rumah Pelanggan #MSN-0102)',
            'category' => 'line',
            'element_type' => 'dropcore',
            'olt_code' => 'OLT-MSN',
            'path_coordinates' => $dropcoreStreet,
            'length_meters' => $calcPolylineLength($dropcoreStreet),
            'color' => '#F59E0B',
            'notes' => 'Dropcore Fiber Optic 1 Core G.657A Mengikuti Gang'
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
