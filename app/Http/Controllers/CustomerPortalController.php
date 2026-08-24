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
            'description' => 'required|string',
        ]);

        $category = $request->input('category');
        $desc = $request->input('description');

        // Append custom request context if upgrade/downgrade, relocation, or change password
        if ($category === 'REQ_UPGRADE_DOWNGRADE' && $request->filled('target_package')) {
            $desc = "[Permohonan Ubah Paket]: Target paket baru: " . $request->input('target_package') . "\nCatatan: " . $desc;
        } elseif ($category === 'REQ_RELOKASI' && $request->filled('new_address')) {
            $desc = "[Permohonan Relokasi/Pindah Alamat]: Alamat Baru: " . $request->input('new_address') . "\nCatatan: " . $desc;
        } elseif ($category === 'GANTI_PASSWORD' || $category === 'BANTUAN_WIFI') {
            $newPass = $request->input('new_password') ?? $request->input('wifi_password', '-');
            $desc = "[Permohonan Ganti Password]: Password Baru: " . $newPass . "\nCatatan: " . ($desc ?: 'Mohon bantu update password WiFi modem router.');
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
