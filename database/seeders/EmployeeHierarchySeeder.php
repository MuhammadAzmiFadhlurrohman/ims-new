<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeHierarchySeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. DEPARTEMEN / DIVISI ───────────────────────────────────────────
        $departments = [
            [
                'code' => 'TEKNISI',
                'name' => 'Divisi Teknisi & Lapangan',
                'description' => 'Bertanggung jawab atas survey lapangan, penarikan kabel FO, instalasi ONT pelanggan, dan maintenance jaringan.',
            ],
            [
                'code' => 'NOC',
                'name' => 'Divisi Network Operations Center (NOC)',
                'description' => 'Bertanggung jawab atas monitoring jaringan, konfigurasi MikroTik, OLT, provisioning ODP/PON, dan aktivasi pelanggan.',
            ],
            [
                'code' => 'SALES',
                'name' => 'Divisi Sales & Marketing',
                'description' => 'Bertanggung jawab atas pemasaran paket internet, akuisisi pelanggan baru, dan penanganan calon pelanggan (leads).',
            ],
            [
                'code' => 'FINANCE',
                'name' => 'Divisi Finance & Billing',
                'description' => 'Bertanggung jawab atas verifikasi pembayaran, penerbitan invoice registrasi & bulanan, dan pelaporan keuangan.',
            ],
            [
                'code' => 'IT_DEV',
                'name' => 'Divisi IT Support & Developer',
                'description' => 'Bertanggung jawab atas pemeliharaan server, integrasi WhatsApp Gateway, Payment Gateway, dan pengembangan sistem IMS ONE.',
            ],
        ];

        foreach ($departments as $dept) {
            Department::updateOrCreate(['code' => $dept['code']], $dept);
        }

        // ── 2. JABATAN / POSITIONS ───────────────────────────────────────────
        $positions = [
            // Teknisi
            ['code' => 'POS-TEK-LEAD', 'department_code' => 'TEKNISI', 'name' => 'Koordinator Teknisi Lapangan'],
            ['code' => 'POS-TEK-SURV', 'department_code' => 'TEKNISI', 'name' => 'Teknisi Survey & Mapping'],
            ['code' => 'POS-TEK-INST', 'department_code' => 'TEKNISI', 'name' => 'Teknisi Instalasi & PSB'],
            ['code' => 'POS-TEK-MT',   'department_code' => 'TEKNISI', 'name' => 'Teknisi Maintenance & Splicer'],

            // NOC
            ['code' => 'POS-NOC-LEAD', 'department_code' => 'NOC', 'name' => 'Head of Network Operations Center'],
            ['code' => 'POS-NOC-ENG',  'department_code' => 'NOC', 'name' => 'Senior NOC & Network Engineer'],
            ['code' => 'POS-NOC-ACT',  'department_code' => 'NOC', 'name' => 'NOC Activation Specialist'],
            ['code' => 'POS-NOC-SUPP', 'department_code' => 'NOC', 'name' => 'NOC Support & Monitoring 24/7'],

            // Sales
            ['code' => 'POS-SALES-SPV', 'department_code' => 'SALES', 'name' => 'Sales Supervisor'],
            ['code' => 'POS-SALES-EXE', 'department_code' => 'SALES', 'name' => 'Direct Sales Executive'],

            // Finance
            ['code' => 'POS-FIN-MGR',  'department_code' => 'FINANCE', 'name' => 'Finance & Accounting Manager'],
            ['code' => 'POS-FIN-BILL', 'department_code' => 'FINANCE', 'name' => 'Billing & Collection Officer'],

            // IT
            ['code' => 'POS-IT-LEAD',  'department_code' => 'IT_DEV', 'name' => 'Lead Software Engineer'],
            ['code' => 'POS-IT-DEV',   'department_code' => 'IT_DEV', 'name' => 'Fullstack Web Developer'],
        ];

        foreach ($positions as $pos) {
            Position::updateOrCreate(['code' => $pos['code']], $pos);
        }

        // ── 3. DATA KARYAWAN / EMPLOYEES ─────────────────────────────────────
        $employees = [
            // ── TEKNISI ──
            [
                'nik' => '3273010101950001',
                'department_code' => 'TEKNISI',
                'position_code' => 'POS-TEK-LEAD',
                'name' => 'DEDI IRAWAN',
                'gender' => 'male',
                'phone_number' => '081223344550',
                'company_email' => 'dedi.irawan@imsone.net',
                'status_contract' => 'PERMANENT',
                'is_active' => true,
            ],
            [
                'nik' => '3273010202960002',
                'department_code' => 'TEKNISI',
                'position_code' => 'POS-TEK-SURV',
                'name' => 'DANDI ALRIZQI M',
                'gender' => 'male',
                'phone_number' => '081223344551',
                'company_email' => 'dandi.alrizqi@imsone.net',
                'status_contract' => 'PERMANENT',
                'is_active' => true,
            ],
            [
                'nik' => '3273010303970003',
                'department_code' => 'TEKNISI',
                'position_code' => 'POS-TEK-INST',
                'name' => 'DENI HAMDANI',
                'gender' => 'male',
                'phone_number' => '081223344552',
                'company_email' => 'deni.hamdani@imsone.net',
                'status_contract' => 'PERMANENT',
                'is_active' => true,
            ],
            [
                'nik' => '3273010404980004',
                'department_code' => 'TEKNISI',
                'position_code' => 'POS-TEK-INST',
                'name' => 'M. NUR PADILAH',
                'gender' => 'male',
                'phone_number' => '081223344553',
                'company_email' => 'nur.padilah@imsone.net',
                'status_contract' => 'PERMANENT',
                'is_active' => true,
            ],
            [
                'nik' => '3273010505990005',
                'department_code' => 'TEKNISI',
                'position_code' => 'POS-TEK-MT',
                'name' => 'REZA APRIANT',
                'gender' => 'male',
                'phone_number' => '081223344554',
                'company_email' => 'reza.apriant@imsone.net',
                'status_contract' => 'CONTRACT',
                'is_active' => true,
            ],
            [
                'nik' => '3273010606990006',
                'department_code' => 'TEKNISI',
                'position_code' => 'POS-TEK-SURV',
                'name' => 'AGUS SANTOSO',
                'gender' => 'male',
                'phone_number' => '081223344555',
                'company_email' => 'agus.santoso@imsone.net',
                'status_contract' => 'CONTRACT',
                'is_active' => true,
            ],
            [
                'nik' => '3273010707990007',
                'department_code' => 'TEKNISI',
                'position_code' => 'POS-TEK-INST',
                'name' => 'RIKI FIRMANSYAH',
                'gender' => 'male',
                'phone_number' => '081223344556',
                'company_email' => 'riki.firmansyah@imsone.net',
                'status_contract' => 'CONTRACT',
                'is_active' => true,
            ],

            // ── NOC ──
            [
                'nik' => '3273011111940011',
                'department_code' => 'NOC',
                'position_code' => 'POS-NOC-LEAD',
                'name' => 'HARRY SETIONO',
                'gender' => 'male',
                'phone_number' => '081334455660',
                'company_email' => 'harry.setiono@imsone.net',
                'status_contract' => 'PERMANENT',
                'is_active' => true,
            ],
            [
                'nik' => '3273011212950012',
                'department_code' => 'NOC',
                'position_code' => 'POS-NOC-ACT',
                'name' => 'KELVIN SULTAN A',
                'gender' => 'male',
                'phone_number' => '081334455661',
                'company_email' => 'kelvin.sultan@imsone.net',
                'status_contract' => 'PERMANENT',
                'is_active' => true,
            ],
            [
                'nik' => '3273011313960013',
                'department_code' => 'NOC',
                'position_code' => 'POS-NOC-ENG',
                'name' => 'FAHMI RAMADHAN',
                'gender' => 'male',
                'phone_number' => '081334455662',
                'company_email' => 'fahmi.ramadhan@imsone.net',
                'status_contract' => 'PERMANENT',
                'is_active' => true,
            ],
            [
                'nik' => '3273011414970014',
                'department_code' => 'NOC',
                'position_code' => 'POS-NOC-SUPP',
                'name' => 'ANDRI WIJAYA',
                'gender' => 'male',
                'phone_number' => '081334455663',
                'company_email' => 'andri.wijaya@imsone.net',
                'status_contract' => 'CONTRACT',
                'is_active' => true,
            ],
            [
                'nik' => '3273011515980015',
                'department_code' => 'NOC',
                'position_code' => 'POS-NOC-ACT',
                'name' => 'BAYU PRATAMA',
                'gender' => 'male',
                'phone_number' => '081334455664',
                'company_email' => 'bayu.pratama@imsone.net',
                'status_contract' => 'CONTRACT',
                'is_active' => true,
            ],

            // ── SALES ──
            [
                'nik' => '3273012121960021',
                'department_code' => 'SALES',
                'position_code' => 'POS-SALES-SPV',
                'name' => 'MAYA INDAH',
                'gender' => 'female',
                'phone_number' => '081556677880',
                'company_email' => 'maya.indah@imsone.net',
                'status_contract' => 'PERMANENT',
                'is_active' => true,
            ],
            [
                'nik' => '3273012222970022',
                'department_code' => 'SALES',
                'position_code' => 'POS-SALES-EXE',
                'name' => 'DIMAS PRATAMA',
                'gender' => 'male',
                'phone_number' => '081556677881',
                'company_email' => 'dimas.pratama@imsone.net',
                'status_contract' => 'CONTRACT',
                'is_active' => true,
            ],

            // ── FINANCE ──
            [
                'nik' => '3273013131950031',
                'department_code' => 'FINANCE',
                'position_code' => 'POS-FIN-MGR',
                'name' => 'RATNA DEWI',
                'gender' => 'female',
                'phone_number' => '081778899000',
                'company_email' => 'ratna.dewi@imsone.net',
                'status_contract' => 'PERMANENT',
                'is_active' => true,
            ],
            [
                'nik' => '3273013232980032',
                'department_code' => 'FINANCE',
                'position_code' => 'POS-FIN-BILL',
                'name' => 'SITI AISYAH',
                'gender' => 'female',
                'phone_number' => '081778899001',
                'company_email' => 'siti.aisyah@imsone.net',
                'status_contract' => 'PERMANENT',
                'is_active' => true,
            ],

            // ── IT ──
            [
                'nik' => '3273014141930041',
                'department_code' => 'IT_DEV',
                'position_code' => 'POS-IT-LEAD',
                'name' => 'MUHAMMAD AZMI',
                'gender' => 'male',
                'phone_number' => '081990011220',
                'company_email' => 'azmi@imsone.net',
                'status_contract' => 'PERMANENT',
                'is_active' => true,
            ],
        ];

        foreach ($employees as $emp) {
            Employee::updateOrCreate(['nik' => $emp['nik']], $emp);
        }
    }
}
