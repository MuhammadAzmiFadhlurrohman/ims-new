<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RbacPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Berdasarkan Matriks Hak Akses Per Divisi (RBAC Blueprint & Matrix ISP)
     */
    public function run(): void
    {
        // 1. Reset cache izin Spatie
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Daftar 7 Role Utama ISP
        $roles = [
            'super_admin' => 'Super Administrator',
            'director' => 'Direktur / Management',
            'finance' => 'Finance & Billing',
            'noc_support' => 'NOC / Network Support',
            'field_technician' => 'Teknisi Lapangan',
            'customer_service' => 'Customer Service / Helpdesk',
            'sales_marketing' => 'Sales & Marketing',
        ];

        $roleModels = [];
        foreach ($roles as $roleKey => $roleLabel) {
            $roleModels[$roleKey] = Role::firstOrCreate(
                ['name' => $roleKey, 'guard_name' => 'web']
            );
        }

        // 3. Pemetaan Hak Akses (Permission Matrix Mapping)

        // --- A. SUPER ADMIN (Full Access ke Semua Fitur & Shield) ---
        $allPermissions = Permission::all();
        $roleModels['super_admin']->syncPermissions($allPermissions);

        // --- B. DIREKTUR / MANAGEMENT (View Only ke Semua Modul Operasional) ---
        $directorPermissions = [
            'view_any_customer', 'view_customer',
            'view_any_customer::subscription', 'view_customer::subscription',
            'view_any_installation::pipeline', 'view_installation::pipeline',
            'view_any_monthly::invoice', 'view_monthly::invoice',
            'view_any_bandwidth::package', 'view_bandwidth::package',
            'view_any_ticket', 'view_ticket',
            'view_any_odp', 'view_odp',
        ];
        $this->assignSafePermissions($roleModels['director'], $directorPermissions);

        // --- C. FINANCE & BILLING ---
        // - Customer & Subscriptions: View Only
        // - Pipeline: View Only
        // - Invoice Bulanan: Full CRUD + Adjust
        // - Paket Bandwidth & Tiket: View Only
        $financePermissions = [
            'view_any_customer', 'view_customer',
            'view_any_customer::subscription', 'view_customer::subscription',
            'view_any_installation::pipeline', 'view_installation::pipeline',
            'view_any_monthly::invoice', 'view_monthly::invoice', 'create_monthly::invoice',
            'update_monthly::invoice', 'delete_monthly::invoice', 'delete_any_monthly::invoice',
            'restore_monthly::invoice', 'restore_any_monthly::invoice', 'replicate_monthly::invoice',
            'view_any_bandwidth::package', 'view_bandwidth::package',
            'view_any_ticket', 'view_ticket',
        ];
        $this->assignSafePermissions($roleModels['finance'], $financePermissions);

        // --- D. NOC / NETWORK SUPPORT ---
        // - Customer: View Only
        // - Subscriptions: Update
        // - Pipeline PSB: Verifikasi / Update
        // - Invoices: View Only
        // - ODP / Network: Full CRUD
        // - Bandwidth Packages: View & Update
        // - Tiket Gangguan: View & Update (Assign / Analisa)
        $nocPermissions = [
            'view_any_customer', 'view_customer',
            'view_any_customer::subscription', 'view_customer::subscription', 'update_customer::subscription',
            'view_any_installation::pipeline', 'view_installation::pipeline', 'update_installation::pipeline',
            'view_any_monthly::invoice', 'view_monthly::invoice',
            'view_any_odp', 'view_odp', 'create_odp', 'update_odp',
            'delete_odp', 'delete_any_odp', 'restore_odp', 'restore_any_odp', 'replicate_odp',
            'view_any_bandwidth::package', 'view_bandwidth::package', 'update_bandwidth::package',
            'view_any_ticket', 'view_ticket', 'update_ticket',
        ];
        $this->assignSafePermissions($roleModels['noc_support'], $nocPermissions);

        // --- E. TEKNISI LAPANGAN ---
        // - Customer & Subscriptions: View Only
        // - Pipeline PSB: Update (Eksekusi Lapangan)
        // - ODP: View Only
        // - Tiket Gangguan: View & Update (Progress Lapangan)
        $technicianPermissions = [
            'view_any_customer', 'view_customer',
            'view_any_customer::subscription', 'view_customer::subscription',
            'view_any_installation::pipeline', 'view_installation::pipeline', 'update_installation::pipeline',
            'view_any_odp', 'view_odp',
            'view_any_ticket', 'view_ticket', 'update_ticket',
        ];
        $this->assignSafePermissions($roleModels['field_technician'], $technicianPermissions);

        // --- F. CUSTOMER SERVICE / HELPDESK ---
        // - Customer: Full CRUD
        // - Subscriptions: Update
        // - Pipeline PSB: View Only
        // - Invoices & Paket: View Only
        // - Tiket Gangguan: Full CRUD (Buat & Update)
        $csPermissions = [
            'view_any_customer', 'view_customer', 'create_customer', 'update_customer',
            'delete_customer', 'delete_any_customer', 'restore_customer', 'restore_any_customer', 'replicate_customer',
            'view_any_customer::subscription', 'view_customer::subscription', 'update_customer::subscription',
            'view_any_installation::pipeline', 'view_installation::pipeline',
            'view_any_monthly::invoice', 'view_monthly::invoice',
            'view_any_bandwidth::package', 'view_bandwidth::package',
            'view_any_ticket', 'view_ticket', 'create_ticket', 'update_ticket',
            'delete_ticket', 'delete_any_ticket', 'restore_ticket', 'restore_any_ticket', 'replicate_ticket',
        ];
        $this->assignSafePermissions($roleModels['customer_service'], $csPermissions);

        // --- G. SALES / MARKETING ---
        // - Customer & Paket & Tiket: View Only
        // - Subscriptions: Create (Draft Baru)
        // - Pipeline PSB: Create (Input PSB Baru)
        $salesPermissions = [
            'view_any_customer', 'view_customer',
            'view_any_customer::subscription', 'view_customer::subscription', 'create_customer::subscription',
            'view_any_installation::pipeline', 'view_installation::pipeline', 'create_installation::pipeline',
            'view_any_bandwidth::package', 'view_bandwidth::package',
            'view_any_ticket', 'view_ticket',
        ];
        $this->assignSafePermissions($roleModels['sales_marketing'], $salesPermissions);

        // 4. Buat / Perbarui Akun Demo untuk Setiap Divisi
        $demoUsers = [
            [
                'name' => 'Administrator MSN',
                'email' => 'admin@msn.net.id',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ],
            [
                'name' => 'Direktur Utama MSN',
                'email' => 'direktur@msn.net.id',
                'password' => Hash::make('password'),
                'role' => 'director',
            ],
            [
                'name' => 'Finance & Billing MSN',
                'email' => 'finance@msn.net.id',
                'password' => Hash::make('password'),
                'role' => 'finance',
            ],
            [
                'name' => 'NOC Engineer MSN',
                'email' => 'noc@msn.net.id',
                'password' => Hash::make('password'),
                'role' => 'noc_support',
            ],
            [
                'name' => 'Teknisi Lapangan FTTH',
                'email' => 'teknisi@msn.net.id',
                'password' => Hash::make('password'),
                'role' => 'field_technician',
            ],
            [
                'name' => 'Customer Care & Helpdesk',
                'email' => 'cs@msn.net.id',
                'password' => Hash::make('password'),
                'role' => 'customer_service',
            ],
            [
                'name' => 'Sales & Marketing MSN',
                'email' => 'sales@msn.net.id',
                'password' => Hash::make('password'),
                'role' => 'sales_marketing',
            ],
        ];

        foreach ($demoUsers as $userData) {
            $roleName = $userData['role'];
            unset($userData['role']);

            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            $user->syncRoles([$roleName]);
        }
    }

    /**
     * Helper untuk assign permissions yang ada di database.
     */
    private function assignSafePermissions(Role $role, array $permissionNames): void
    {
        $existing = Permission::whereIn('name', $permissionNames)->get();
        $role->syncPermissions($existing);
    }
}
