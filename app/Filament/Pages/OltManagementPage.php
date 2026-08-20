<?php

namespace App\Filament\Pages;

use App\Models\Customer;
use App\Models\CustomerSubscription;
use App\Models\Odp;
use App\Models\Olt;
use App\Models\PonPort;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class OltManagementPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static string $view = 'filament.pages.olt-management';

    protected static bool $shouldRegisterNavigation = false;

    public ?string $olt_code = null;

    public ?int $pon_id = null;

    public ?string $odp_code = null;

    // ── Forms: Tambah PON ──
    public string $new_pon_name = '';

    public int $new_pon_max_ports = 8;

    // ── Forms: Edit PON ──
    public bool $showEditPonModal = false;

    public ?int $editing_pon_id = null;

    public string $edit_pon_name = '';

    public int $edit_pon_max_ports = 8;

    // ── Forms: Tambah ODP ──
    public string $new_odp_name = '';

    public int $new_odp_max_user = 8;

    public string $new_odp_lat = '-6.92976';

    public string $new_odp_long = '107.5933';

    // ── Forms: Edit ODP ──
    public bool $showEditOdpModal = false;

    public ?string $editing_odp_code = null;

    public string $edit_odp_name = '';

    public int $edit_odp_max_user = 8;

    public string $edit_odp_lat = '';

    public string $edit_odp_long = '';

    // ── Forms: Tambah User ──
    public string $new_user_internet_number = '';

    public string $new_user_name = '';

    public string $new_user_notes = '';

    // ── Forms: Edit User ──
    public bool $showEditUserModal = false;

    public ?string $editing_user_internet_no = null;

    public string $edit_user_name = '';

    public string $edit_user_status = 'AKTIF';

    public string $edit_user_notes = '';

    public string $edit_user_gpon_onu = '';

    // ── Modal Riwayat ──
    public bool $showHistoryModal = false;

    protected $queryString = [
        'olt_code' => ['except' => '', 'as' => 'olt'],
        'pon_id' => ['except' => null, 'as' => 'pon'],
        'odp_code' => ['except' => null, 'as' => 'odp'],
    ];

    public function mount(): void
    {
        if (empty($this->olt_code)) {
            $firstOlt = Olt::first();
            $this->olt_code = $firstOlt ? $firstOlt->code : 'OLT-MSN';
        }
    }

    public function getTitle(): string
    {
        $currentOlt = Olt::where('code', $this->olt_code)->first();
        $oltName = $currentOlt ? strtoupper($currentOlt->name) : 'OLT MSN';

        return "MANAJEMEN {$oltName}";
    }

    public function getHeading(): string
    {
        return '';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    // ── Level Navigation ──
    public function selectPon(int $id): void
    {
        $this->pon_id = $id;
        $this->odp_code = null;
    }

    public function selectOdp(string $code): void
    {
        $this->odp_code = $code;
    }

    public function backToOlt(): void
    {
        $this->pon_id = null;
        $this->odp_code = null;
    }

    public function backToPon(): void
    {
        $this->odp_code = null;
    }

    // ── CRUD PON ──
    public function addPon(): void
    {
        $this->validate([
            'new_pon_name' => 'required|string|max:100',
            'new_pon_max_ports' => 'required|integer|min:1|max:128',
        ]);

        $maxPortNo = PonPort::where('olt_code', $this->olt_code)->max('port_number') ?? 0;

        PonPort::create([
            'olt_code' => $this->olt_code,
            'name' => $this->new_pon_name,
            'port_number' => $maxPortNo + 1,
            'max_ports' => $this->new_pon_max_ports,
            'used_ports' => 0,
            'total_subscribers' => 0,
        ]);

        $this->new_pon_name = '';
        $this->new_pon_max_ports = 8;

        Notification::make()->title('PON baru berhasil ditambahkan')->success()->send();
    }

    public function openEditPon(int $id): void
    {
        $pon = PonPort::findOrFail($id);
        $this->editing_pon_id = $id;
        $this->edit_pon_name = $pon->name;
        $this->edit_pon_max_ports = $pon->max_ports ?? 8;
        $this->showEditPonModal = true;
    }

    public function updatePon(): void
    {
        $this->validate([
            'edit_pon_name' => 'required|string|max:100',
            'edit_pon_max_ports' => 'required|integer|min:1|max:128',
        ]);

        if ($this->editing_pon_id) {
            $pon = PonPort::findOrFail($this->editing_pon_id);
            $pon->update([
                'name' => $this->edit_pon_name,
                'max_ports' => $this->edit_pon_max_ports,
            ]);

            $this->showEditPonModal = false;
            Notification::make()->title('Data PON berhasil diperbarui')->success()->send();
        }
    }

    public function deletePon(int $id): void
    {
        $pon = PonPort::findOrFail($id);
        $pon->delete();

        if ($this->pon_id === $id) {
            $this->pon_id = null;
            $this->odp_code = null;
        }

        Notification::make()->title('PON berhasil dihapus')->warning()->send();
    }

    // ── CRUD ODP ──
    public function addOdp(): void
    {
        $this->validate([
            'new_odp_name' => 'required|string|max:100',
            'new_odp_max_user' => 'required|integer|min:1|max:128',
        ]);

        $code = 'ODP-'.strtoupper(preg_replace('/[^A-Za-z0-9]/', '-', $this->new_odp_name));
        $existing = Odp::where('code', $code)->first();
        if ($existing) {
            $code .= '-'.rand(10, 99);
        }

        $currentOlt = Olt::where('code', $this->olt_code)->first();

        Odp::create([
            'code' => $code,
            'name' => $this->new_odp_name,
            'olt_code' => $this->olt_code,
            'pon_port_id' => $this->pon_id,
            'pop_code' => $currentOlt?->pop_code,
            'total_ports' => $this->new_odp_max_user,
            'used_ports' => 0,
            'latitude' => $this->new_odp_lat,
            'longitude' => $this->new_odp_long,
        ]);

        // update used ports in PON
        if ($this->pon_id) {
            $pon = PonPort::find($this->pon_id);
            if ($pon) {
                $pon->increment('used_ports');
            }
        }

        $this->new_odp_name = '';
        Notification::make()->title('ODP baru berhasil ditambahkan')->success()->send();
    }

    public function openEditOdp(string $code): void
    {
        $odp = Odp::findOrFail($code);
        $this->editing_odp_code = $code;
        $this->edit_odp_name = $odp->name;
        $this->edit_odp_max_user = $odp->total_ports ?? 8;
        $this->edit_odp_lat = $odp->latitude ?? '';
        $this->edit_odp_long = $odp->longitude ?? '';
        $this->showEditOdpModal = true;
    }

    public function updateOdp(): void
    {
        $this->validate([
            'edit_odp_name' => 'required|string|max:100',
            'edit_odp_max_user' => 'required|integer|min:1|max:128',
        ]);

        if ($this->editing_odp_code) {
            $odp = Odp::findOrFail($this->editing_odp_code);
            $odp->update([
                'name' => $this->edit_odp_name,
                'total_ports' => $this->edit_odp_max_user,
                'latitude' => $this->edit_odp_lat,
                'longitude' => $this->edit_odp_long,
            ]);

            $this->showEditOdpModal = false;
            Notification::make()->title('Data ODP berhasil diperbarui')->success()->send();
        }
    }

    public function deleteOdp(string $code): void
    {
        $odp = Odp::findOrFail($code);
        $odp->delete();

        if ($this->pon_id) {
            $pon = PonPort::find($this->pon_id);
            if ($pon && $pon->used_ports > 0) {
                $pon->decrement('used_ports');
            }
        }

        if ($this->odp_code === $code) {
            $this->odp_code = null;
        }

        Notification::make()->title('ODP berhasil dihapus')->warning()->send();
    }

    // ── CRUD USER ──
    public function addUser(): void
    {
        $this->validate([
            'new_user_internet_number' => 'required|string|max:50',
            'new_user_name' => 'required|string|max:150',
        ]);

        $nik = '320'.rand(1000000000000, 9999999999999);
        $customer = Customer::create([
            'nik' => $nik,
            'name' => $this->new_user_name,
            'phone_number' => '081'.rand(10000000, 99999999),
            'id_card_address' => 'Bandung, Jawa Barat',
            'email' => strtolower(str_replace(' ', '', $this->new_user_name)).'@gmail.com',
        ]);

        $currentOlt = Olt::where('code', $this->olt_code)->first();

        CustomerSubscription::create([
            'internet_number' => $this->new_user_internet_number,
            'customer_nik' => $customer->nik,
            'customer_name' => $this->new_user_name,
            'olt_code' => $this->olt_code,
            'odp_code' => $this->odp_code,
            'pop_code' => $currentOlt?->pop_code,
            'package_code' => 'HOME-20M',
            'installation_address' => 'Bandung, Jawa Barat',
            'registration_status' => 'AKTIF',
            'special_request' => $this->new_user_notes,
            'gpon_onu' => 'gpon-onu_1/'.($this->pon_id ?? 1).'/'.rand(1, 16).':'.rand(1, 32).' sn RTEGC'.rand(1000000, 9999999),
        ]);

        // update used ports in ODP
        if ($this->odp_code) {
            $odp = Odp::find($this->odp_code);
            if ($odp) {
                $odp->increment('used_ports');
            }
        }

        $this->new_user_internet_number = '';
        $this->new_user_name = '';
        $this->new_user_notes = '';

        Notification::make()->title('Pelanggan baru berhasil ditambahkan ke ODP')->success()->send();
    }

    public function openEditUser(string $internetNumber): void
    {
        $sub = CustomerSubscription::findOrFail($internetNumber);
        $this->editing_user_internet_no = $internetNumber;
        $this->edit_user_name = $sub->customer_name;
        $this->edit_user_status = $sub->registration_status ?? 'AKTIF';
        $this->edit_user_notes = $sub->special_request ?? '';
        $this->edit_user_gpon_onu = $sub->gpon_onu ?? '';
        $this->showEditUserModal = true;
    }

    public function updateUser(): void
    {
        $this->validate([
            'edit_user_name' => 'required|string|max:150',
        ]);

        if ($this->editing_user_internet_no) {
            $sub = CustomerSubscription::findOrFail($this->editing_user_internet_no);
            $sub->update([
                'customer_name' => $this->edit_user_name,
                'registration_status' => $this->edit_user_status,
                'special_request' => $this->edit_user_notes,
                'gpon_onu' => $this->edit_user_gpon_onu,
            ]);

            if ($sub->customer) {
                $sub->customer->update(['name' => $this->edit_user_name]);
            }

            $this->showEditUserModal = false;
            Notification::make()->title('Data Pelanggan berhasil diperbarui')->success()->send();
        }
    }

    public function deleteUser(string $internetNumber): void
    {
        $sub = CustomerSubscription::findOrFail($internetNumber);
        $sub->delete();

        if ($this->odp_code) {
            $odp = Odp::find($this->odp_code);
            if ($odp && $odp->used_ports > 0) {
                $odp->decrement('used_ports');
            }
        }

        Notification::make()->title('Pelanggan berhasil dihapus dari ODP')->warning()->send();
    }

    public function openHistoryModal(): void
    {
        $this->showHistoryModal = true;
    }

    // ── View Data Providers ──
    public function getCurrentOltProperty()
    {
        return Olt::where('code', $this->olt_code)->first() ?? Olt::first();
    }

    public function getCurrentPonProperty()
    {
        return $this->pon_id ? PonPort::find($this->pon_id) : null;
    }

    public function getCurrentOdpProperty()
    {
        return $this->odp_code ? Odp::find($this->odp_code) : null;
    }

    public function getPonsProperty()
    {
        return PonPort::where('olt_code', $this->olt_code)
            ->withCount('odps')
            ->orderBy('port_number')
            ->get();
    }

    public function getOdpsProperty()
    {
        if (! $this->pon_id) {
            return collect();
        }

        return Odp::where('pon_port_id', $this->pon_id)->withCount('subscriptions')->get();
    }

    public function getUsersProperty()
    {
        if (! $this->odp_code) {
            return collect();
        }

        return CustomerSubscription::where('odp_code', $this->odp_code)->with(['package', 'customer'])->get();
    }
}
