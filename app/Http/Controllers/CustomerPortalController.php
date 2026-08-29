<?php

namespace App\Http\Controllers;

use App\Models\BandwidthPackage;
use App\Models\CustomerSubscription;
use App\Models\MonthlyInvoice;
use App\Models\Odp;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerPortalController extends Controller
{
    const SESSION_LIFETIME_SECONDS = 3600; // 1 Jam Maksimal

    public function index()
    {
        $internetNumber = Session::get('customer_internet_number');
        $loginAt = Session::get('customer_login_at');

        if (!$internetNumber) {
            return view('portal.login');
        }

        // Check if session has exceeded 1 hour (3600s)
        if ($loginAt && (now()->timestamp - $loginAt > self::SESSION_LIFETIME_SECONDS)) {
            Session::forget(['customer_internet_number', 'customer_login_at']);
            return redirect('/')->with('session_expired', 'Sesi layanan Anda telah berakhir setelah 1 jam untuk menghemat beban server. Silakan masukkan nomor HP kembali jika diperlukan.');
        }

        $subscription = CustomerSubscription::where('internet_number', $internetNumber)->first();

        if (!$subscription) {
            Session::forget(['customer_internet_number', 'customer_login_at']);
            return view('portal.login');
        }

        // Remaining seconds in session
        $remainingSeconds = max(0, self::SESSION_LIFETIME_SECONDS - (now()->timestamp - ($loginAt ?? now()->timestamp)));

        // Active Package Details
        $currentPackage = BandwidthPackage::where('code', $subscription->package_code)->first();

        // Available packages for upgrade / downgrade
        $availablePackages = BandwidthPackage::where('is_active', true)->orderBy('price')->get();

        // Customer Tickets
        $tickets = Ticket::where('internet_number', $subscription->internet_number)
            ->orderByDesc('created_at')
            ->get();

        $activeTickets = $tickets->where('status', '!=', 'RESOLVED');
        $resolvedTickets = $tickets->where('status', 'RESOLVED');

        // Customer Invoices
        $invoices = MonthlyInvoice::where('internet_number', $subscription->internet_number)
            ->orderByDesc('created_at')
            ->get();

        $unpaidInvoices = $invoices->where('payment_status', '!=', 'PAID');
        $paidInvoices = $invoices->where('payment_status', 'PAID');
        $totalArrears = $unpaidInvoices->sum('total_amount');
        $hasArrears = $unpaidInvoices->count() > 0;

        // ODP Data
        $odp = Odp::where('code', $subscription->odp_code)->first();

        // Customer Devices & Equipment installed during installation
        $customerDevices = \App\Models\CustomerDevice::where('internet_number', $subscription->internet_number)->get();
        $rawEquipment = $subscription->installation_equipment ?? $subscription->survey_equipment ?? [];
        if (!is_array($rawEquipment) && is_string($rawEquipment)) {
            $rawEquipment = json_decode($rawEquipment, true) ?? [];
        }

        $installationEquipment = [];
        if (!empty($rawEquipment) && is_array($rawEquipment)) {
            foreach ($rawEquipment as $eq) {
                $itemName = $eq['item_name'] ?? $eq['type'] ?? $eq['equipment_name'] ?? $eq['item'] ?? $eq['name'] ?? 'Perangkat Fiber Optic';
                $categoryName = $eq['name'] ?? $eq['category'] ?? null;
                
                $upper = strtoupper($itemName);
                if (!$categoryName || $categoryName === $itemName) {
                    if (str_contains($upper, 'ZTE') || str_contains($upper, 'ONU') || str_contains($upper, 'ONT') || str_contains($upper, 'MODEM') || str_contains($upper, 'ROUTER') || str_contains($upper, 'HUAWEI') || str_contains($upper, 'FIBERHOME')) {
                        $categoryName = 'ONT / MODEM ROUTER';
                    } elseif (str_contains($upper, 'KABEL') || str_contains($upper, 'DROP') || str_contains($upper, 'CORE')) {
                        $categoryName = 'KABEL FIBER OPTIC';
                    } elseif (str_contains($upper, 'ROSET') || str_contains($upper, 'OTP')) {
                        $categoryName = 'ROSET OPTIK';
                    } elseif (str_contains($upper, 'PATCH') || str_contains($upper, 'PIGTAIL')) {
                        $categoryName = 'PATCH CORD / PIGTAIL';
                    } else {
                        $categoryName = 'PERALATAN FIBER';
                    }
                }

                $rawQty = (string)($eq['quantity'] ?? $eq['qty'] ?? '1');
                if (is_numeric(trim($rawQty))) {
                    $qty = str_contains($upper, 'KABEL') ? (trim($rawQty) . ' Meter') : (trim($rawQty) . ' Unit');
                } else {
                    $qty = $rawQty;
                }

                $sn = $eq['sn'] ?? $eq['serial_number'] ?? ($subscription->ont_sn ?? null);
                if (empty($sn) || $sn === '-') {
                    if (str_contains($upper, 'ZTE') || str_contains($upper, 'ONU') || str_contains($upper, 'ONT')) {
                        $sn = $subscription->ont_sn ?? ('ZTEGC' . strtoupper(substr(md5($subscription->internet_number . $itemName), 0, 8)));
                    } else {
                        $sn = '-';
                    }
                }

                $mac = $eq['mac'] ?? $eq['mac_address'] ?? ($subscription->ont_mac ?? null);
                if (empty($mac) || $mac === '-') {
                    if (str_contains($upper, 'ZTE') || str_contains($upper, 'ONU') || str_contains($upper, 'ONT')) {
                        $mac = $subscription->ont_mac ?? ('70:8B:CD:' . strtoupper(substr(chunk_split(substr(md5($subscription->internet_number . $itemName), 0, 6), 2, ':'), 0, 8)));
                    } else {
                        $mac = '-';
                    }
                }

                $status = $eq['status'] ?? 'DIPINJAMKAN (HAK PAKAI)';
                if (strtoupper($status) === 'AKTIF' || strtoupper($status) === 'TERPASANG' || empty($status)) {
                    $status = 'DIPINJAMKAN (HAK PAKAI)';
                }

                $installationEquipment[] = [
                    'name' => $categoryName,
                    'type' => $itemName,
                    'sn' => $sn,
                    'mac' => $mac,
                    'qty' => $qty,
                    'status' => $status,
                    'installed_at' => $subscription->installation_date ? $subscription->installation_date->translatedFormat('d F Y') : ($subscription->created_at ? $subscription->created_at->translatedFormat('d F Y') : 'Hari Instalasi'),
                ];
            }
        }

        if ($customerDevices->isEmpty() && empty($installationEquipment)) {
            $gponSn = $subscription->ont_sn ?? ('ZTEGC' . strtoupper(substr(md5($subscription->internet_number), 0, 8)));
            $macAddr = $subscription->ont_mac ?? ('70:8B:CD:' . strtoupper(substr(chunk_split(substr(md5($subscription->internet_number), 0, 6), 2, ':'), 0, 8)));
            
            $installationEquipment = [
                [
                    'name' => 'Optical Network Terminal (ONT / Modem Router)',
                    'type' => $subscription->router_model ? ($subscription->router_brand . ' ' . $subscription->router_model) : 'ZTE F670L Dual Band 5G Gigabit',
                    'sn' => $gponSn,
                    'mac' => $macAddr,
                    'qty' => '1 Unit',
                    'status' => 'DIPINJAMKAN (HAK PAKAI)',
                    'installed_at' => $subscription->installation_date ? $subscription->installation_date->translatedFormat('d F Y') : ($subscription->created_at ? $subscription->created_at->translatedFormat('d F Y') : 'Hari Instalasi'),
                ],
                [
                    'name' => 'Roset Optik (Wall Outlet Box)',
                    'type' => 'Roset 1-Core Mini OTP SC/UPC',
                    'sn' => '-',
                    'mac' => '-',
                    'qty' => '1 Unit',
                    'status' => 'TERPASANG',
                    'installed_at' => $subscription->installation_date ? $subscription->installation_date->translatedFormat('d F Y') : 'Hari Instalasi',
                ],
                [
                    'name' => 'Patch Cord Fiber Optic',
                    'type' => 'SC/UPC to SC/UPC 2 Meter Simplex',
                    'sn' => '-',
                    'mac' => '-',
                    'qty' => '1 Pcs',
                    'status' => 'TERPASANG',
                    'installed_at' => $subscription->installation_date ? $subscription->installation_date->translatedFormat('d F Y') : 'Hari Instalasi',
                ],
                [
                    'name' => 'Kabel Dropcore FTTH 1-Core 3-Seling',
                    'type' => 'Kabel Fiber Optic Drop Wire Outdoor',
                    'sn' => '-',
                    'mac' => '-',
                    'qty' => ($subscription->cable_length_meters ?? '75') . ' Meter',
                    'status' => 'TERPASANG KE ODP',
                    'installed_at' => $subscription->installation_date ? $subscription->installation_date->translatedFormat('d F Y') : 'Hari Instalasi',
                ],
            ];
        }

        return view('portal.dashboard', compact(
            'subscription',
            'currentPackage',
            'availablePackages',
            'tickets',
            'activeTickets',
            'resolvedTickets',
            'invoices',
            'unpaidInvoices',
            'paidInvoices',
            'totalArrears',
            'hasArrears',
            'odp',
            'customerDevices',
            'installationEquipment',
            'remainingSeconds'
        ));
    }

    public function login(Request $request)
    {
        $input = trim($request->input('phone_or_cid', ''));

        if (empty($input)) {
            return back()->with('error', 'Silakan masukkan nomor telepon WhatsApp atau ID Pelanggan Anda.');
        }

        // Clean formatting
        $cleanInput = preg_replace('/[^0-9a-zA-Z]/', '', $input);
        $cleanPhone = preg_replace('/[^0-9]/', '', $input);

        // Normalize Indonesian phone (+62 -> 0)
        if (str_starts_with($cleanPhone, '62')) {
            $normalizedPhone = '0' . substr($cleanPhone, 2);
        } elseif (str_starts_with($cleanPhone, '0')) {
            $normalizedPhone = $cleanPhone;
        } else {
            $normalizedPhone = '0' . $cleanPhone;
        }

        // Find customer by phone, alt phone, or internet number / CID
        $subscription = CustomerSubscription::where('internet_number', $input)
            ->orWhere('internet_number', $cleanInput)
            ->orWhere('phone_number', $input)
            ->orWhere('phone_number', $cleanPhone)
            ->orWhere('phone_number', $normalizedPhone)
            ->orWhere('alt_phone_number', $input)
            ->orWhere('alt_phone_number', $normalizedPhone)
            ->orWhere('customer_nik', $cleanPhone)
            ->first();

        if ($subscription) {
            Session::put('customer_internet_number', $subscription->internet_number);
            Session::put('customer_login_at', now()->timestamp);
            return redirect()->route('customer.portal')->with('success', 'Selamat datang kembali, ' . $subscription->customer_name . '!');
        }

        return back()->with('error', 'Nomor telepon atau ID Pelanggan tidak ditemukan. Pastikan nomor yang Anda masukkan terdaftar saat pemasangan, atau hubungi Customer Service.');
    }

    public function logout()
    {
        Session::forget(['customer_internet_number', 'customer_login_at']);
        return redirect('/')->with('info', 'Anda telah keluar dari Portal Layanan Pelanggan.');
    }

    public function submitTicket(Request $request)
    {
        $internetNumber = Session::get('customer_internet_number');
        $loginAt = Session::get('customer_login_at');

        if (!$internetNumber || ($loginAt && (now()->timestamp - $loginAt > self::SESSION_LIFETIME_SECONDS))) {
            Session::forget(['customer_internet_number', 'customer_login_at']);
            return redirect('/')->with('session_expired', 'Sesi Anda telah berakhir setelah 1 jam. Silakan login kembali.');
        }

        $subscription = CustomerSubscription::where('internet_number', $internetNumber)->firstOrFail();

        $request->validate([
            'category' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $category = $request->input('category');
        $desc = trim((string)$request->input('description', ''));

        // Append custom request context if upgrade/downgrade, relocation, or change password
        if ($category === 'LOS' || $category === 'GANGGUAN') {
            $issue = $request->input('issue_detail', 'Laporan Gangguan');
            $modem = $request->input('modem_status');
            $prefix = "[Kendala: {$issue}]" . ($modem ? " [Status Lampu Modem: {$modem}]" : "");
            $desc = $prefix . "\n" . ($desc ?: 'Pelanggan melaporkan kendala koneksi internet.');
        } elseif ($category === 'REQ_UPGRADE_DOWNGRADE') {
            $targetPkg = $request->input('target_package', 'Paket Baru');
            $effective = $request->input('effective_date', 'Segera');
            $desc = "[Permohonan Ubah Paket]: Target: {$targetPkg} (Waktu: {$effective})\n" . ($desc ?: 'Mohon proses upgrade/downgrade paket berlangganan.');
        } elseif ($category === 'REQ_RELOKASI') {
            $newAddr = $request->input('new_address', '-');
            $reloDate = $request->input('relocation_date', '-');
            $desc = "[Permohonan Relokasi/Pindah Alamat]: Alamat Baru: {$newAddr} (Rencana Tgl: {$reloDate})\n" . ($desc ?: 'Mohon jadwalkan survey/penarikan kabel relokasi.');
        } elseif ($category === 'GANTI_PASSWORD' || $category === 'BANTUAN_WIFI') {
            $newPass = $request->input('new_password') ?? $request->input('wifi_password', '-');
            $desc = "[Permohonan Ganti Password WiFi]: Password Baru: {$newPass}\n" . ($desc ?: 'Mohon bantu update password WiFi modem router.');
        } else {
            $desc = $desc ?: 'Pengajuan layanan pelanggan mandiri.';
        }

        $randomNo = rand(100, 999);
        $ticketNo = 'TKT-' . date('Ym') . '-' . $randomNo;

        Ticket::create([
            'ticket_number' => $ticketNo,
            'internet_number' => $subscription->internet_number,
            'reporter_name' => $subscription->customer_name,
            'reporter_phone' => $subscription->phone_number ?? '08123456789',
            'category' => $category,
            'priority' => ($category === 'LOS' || $category === 'GANGGUAN_TOTAL') ? 'HIGH' : 'NORMAL',
            'description' => $desc,
            'status' => 'OPEN',
            'assigned_technician' => 'Helpdesk NOC On-Duty',
            'resolution_notes' => 'Tiket sedang dalam antrean verifikasi tim teknisi NOC.',
        ]);

        return redirect()->route('customer.portal')->with('ticket_created', [
            'ticket_no' => $ticketNo,
            'category' => $category,
        ]);
    }
}
