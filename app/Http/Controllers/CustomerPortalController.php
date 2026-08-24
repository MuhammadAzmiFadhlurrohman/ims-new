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
    public function index()
    {
        $internetNumber = Session::get('customer_internet_number');

        if (!$internetNumber) {
            return view('portal.login');
        }

        $subscription = CustomerSubscription::where('internet_number', $internetNumber)->first();

        if (!$subscription) {
            Session::forget('customer_internet_number');
            return view('portal.login');
        }

        // Active Package Details
        $currentPackage = BandwidthPackage::where('code', $subscription->package_code)->first();

        // Available packages for upgrade / downgrade
        $availablePackages = BandwidthPackage::where('is_active', true)->orderBy('price')->get();

        // Customer Tickets
        $tickets = Ticket::where('internet_number', $subscription->internet_number)
            ->orderByDesc('created_at')
            ->get();

        // Customer Invoices
        $invoices = MonthlyInvoice::where('internet_number', $subscription->internet_number)
            ->orderByDesc('created_at')
            ->get();

        // ODP Data
        $odp = Odp::where('code', $subscription->odp_code)->first();

        return view('portal.dashboard', compact(
            'subscription',
            'currentPackage',
            'availablePackages',
            'tickets',
            'invoices',
            'odp'
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
            return redirect()->route('customer.portal')->with('success', 'Selamat datang kembali, ' . $subscription->customer_name . '!');
        }

        return back()->with('error', 'Nomor telepon atau ID Pelanggan tidak ditemukan. Pastikan nomor yang Anda masukkan terdaftar saat pemasangan, atau hubungi Customer Service.');
    }

    public function logout()
    {
        Session::forget('customer_internet_number');
        return redirect()->route('customer.portal')->with('info', 'Anda telah keluar dari Portal Layanan Pelanggan.');
    }

    public function submitTicket(Request $request)
    {
        $internetNumber = Session::get('customer_internet_number');

        if (!$internetNumber) {
            return redirect()->route('customer.portal')->with('error', 'Sesi Anda telah berakhir, silakan login kembali.');
        }

        $subscription = CustomerSubscription::where('internet_number', $internetNumber)->firstOrFail();

        $request->validate([
            'category' => 'required|string',
            'description' => 'required|string',
        ]);

        $category = $request->input('category');
        $desc = $request->input('description');

        // Append custom request context if upgrade/downgrade or relocation
        if ($category === 'REQ_UPGRADE_DOWNGRADE' && $request->filled('target_package')) {
            $desc = "[Permohonan Ubah Paket]: Target paket baru: " . $request->input('target_package') . "\nCatatan: " . $desc;
        } elseif ($category === 'REQ_RELOKASI' && $request->filled('new_address')) {
            $desc = "[Permohonan Relokasi/Pindah Alamat]: Alamat Baru: " . $request->input('new_address') . "\nCatatan: " . $desc;
        } elseif ($category === 'BANTUAN_WIFI' && $request->filled('wifi_ssid')) {
            $desc = "[Bantuan Setting Router/WiFi]: Nama SSID/Pass Baru: " . $request->input('wifi_ssid') . "\nCatatan: " . $desc;
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
