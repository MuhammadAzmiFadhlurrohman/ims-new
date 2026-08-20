<?php

namespace App\Console\Commands;

use App\Models\BandwidthCategory;
use App\Models\BandwidthPackage;
use App\Models\Customer;
use App\Models\CustomerSubscription;
use App\Models\Employee;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\MonthlyInvoice;
use App\Models\Odp;
use App\Models\Pop;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateLegacyDataCommand extends Command
{
    protected $signature = 'ims:migrate-legacy';

    protected $description = 'Migrate legacy data from ims_v3 database connection (m_bandwith, m_barang, m_jns_bangunan, m_status, etc.) to IMS MSN modern schema';

    public function handle()
    {
        $this->info('==================================================');
        $this->info(' Starting IMS MSN Legacy Data Migration (ims_v3) ');
        $this->info('==================================================');

        try {
            $legacyDb = DB::connection('legacy_mysql');
            $legacyDb->getPdo();
        } catch (Exception $e) {
            $this->error('Gagal terhubung ke koneksi legacy_mysql: '.$e->getMessage());
            $this->warn('Pastikan database ims_v3 aktif dan konfigurasi LEGACY_DB_* di .env sudah benar.');

            return 1;
        }

        // 0. Status Mappings dari m_status_*
        $statusRegMap = [];
        if ($legacyDb->getSchemaBuilder()->hasTable('m_status_registrasi')) {
            $statusRegMap = $legacyDb->table('m_status_registrasi')->pluck('desc_registrasi', 'status_reg')->toArray();
        }

        $statusBillMap = [];
        if ($legacyDb->getSchemaBuilder()->hasTable('m_status_bill_lay')) {
            $statusBillMap = $legacyDb->table('m_status_bill_lay')->pluck('desc_bill_lay', 'status_bill_lay')->toArray();
        }

        // 1. Migrasi Master POP
        $this->info('1. Memproses Master POP (m_pop)...');
        if ($legacyDb->getSchemaBuilder()->hasTable('m_pop')) {
            $pops = $legacyDb->table('m_pop')->get();
            foreach ($pops as $row) {
                Pop::updateOrCreate(
                    ['code' => $row->kode_pop ?? 'POP-DEFAULT'],
                    [
                        'name' => $row->nama_pop ?? $row->kode_pop ?? 'POP Default',
                        'description' => $row->keterangan ?? null,
                    ]
                );
            }
            $this->info("   Done: Migrasi {$pops->count()} POP.");
        } else {
            Pop::firstOrCreate(['code' => 'POP-MAIN'], ['name' => 'POP Utama MSN']);
        }

        // 2. Migrasi Master ODP
        $this->info('2. Memproses Master ODP (m_odp)...');
        if ($legacyDb->getSchemaBuilder()->hasTable('m_odp')) {
            $odps = $legacyDb->table('m_odp')->get();
            foreach ($odps as $row) {
                Odp::updateOrCreate(
                    ['code' => $row->kode_odp ?? 'ODP-01'],
                    [
                        'pop_code' => $row->kode_pop ?? 'POP-MAIN',
                        'name' => $row->nama_odp ?? $row->kode_odp ?? 'ODP-01',
                        'total_ports' => (int) ($row->jml_port ?? 8),
                        'notes' => $row->lokasi ?? null,
                    ]
                );
            }
            $this->info("   Done: Migrasi {$odps->count()} ODP.");
        }

        // 3. Migrasi Master Kategori Bandwidth (m_bandwith_kategori)
        $this->info('3. Memproses Master Kategori Bandwidth (m_bandwith_kategori)...');
        if ($legacyDb->getSchemaBuilder()->hasTable('m_bandwith_kategori')) {
            $cats = $legacyDb->table('m_bandwith_kategori')->get();
            foreach ($cats as $row) {
                BandwidthCategory::updateOrCreate(
                    ['code' => $row->kode_kategori_bandwith],
                    [
                        'name' => $row->nama_kategori_bandwith ?? $row->kode_kategori_bandwith,
                        'alias_name' => $row->alias_nama_kategori ?? null,
                        'registration_fee' => (float) ($row->biaya_reg ?? 0),
                        'has_registration_ppn' => isset($row->ppn_reg) && $row->ppn_reg > 0,
                        'registration_ppn_percent' => (float) ($row->ppn_reg_nom ?? 11),
                        'has_billing_ppn' => isset($row->ppn_bill) && $row->ppn_bill > 0,
                        'billing_ppn_percent' => (float) ($row->ppn_bill_nom ?? 11),
                        'is_active' => $row->disable == 0,
                    ]
                );
            }
            $this->info("   Done: Migrasi {$cats->count()} Kategori Bandwidth.");
        } else {
            BandwidthCategory::firstOrCreate(
                ['code' => 'MSN-HOME'],
                ['name' => 'MSN Home BroadBand', 'is_active' => true]
            );
        }

        // 4. Migrasi Master Paket Bandwidth (m_bandwith)
        $this->info('4. Memproses Master Paket Bandwidth (m_bandwith)...');
        if ($legacyDb->getSchemaBuilder()->hasTable('m_bandwith')) {
            $packages = $legacyDb->table('m_bandwith')->get();
            foreach ($packages as $row) {
                $catCode = $row->kode_kategori_bandwith ?? 'MSN-HOME';
                if (! BandwidthCategory::where('code', $catCode)->exists()) {
                    $catCode = BandwidthCategory::first()->code ?? 'MSN-HOME';
                }

                $cleanPrice = preg_replace('/[^0-9.]/', '', $row->harga_bandwith ?? '0');
                $price = (float) ($cleanPrice ?: 0);

                BandwidthPackage::updateOrCreate(
                    ['code' => $row->kode_bandwith],
                    [
                        'category_code' => $catCode,
                        'name' => 'Paket '.($row->nominal_bandwith ?? '0').' Mbps ('.$row->kode_bandwith.')',
                        'speed_mbps' => (int) ($row->nominal_bandwith ?? 20),
                        'price' => $price,
                        'is_active' => $row->disable == '0',
                    ]
                );
            }
            $this->info("   Done: Migrasi {$packages->count()} Paket Bandwidth.");
        }

        // 5. Migrasi Kategori Barang (m_jns_barang) & Barang (m_barang)
        $this->info('5. Memproses Master Barang & Jenis Barang (m_jns_barang, m_barang)...');
        if ($legacyDb->getSchemaBuilder()->hasTable('m_jns_barang')) {
            $jnsBarangs = $legacyDb->table('m_jns_barang')->get();
            foreach ($jnsBarangs as $jb) {
                ItemCategory::updateOrCreate(
                    ['code' => $jb->kode_jns_barang],
                    ['name' => $jb->nama_jns_barang ?? $jb->kode_jns_barang]
                );
            }
            $this->info("   Done: Migrasi {$jnsBarangs->count()} Jenis Barang.");
        }

        if ($legacyDb->getSchemaBuilder()->hasTable('m_barang')) {
            $barangs = $legacyDb->table('m_barang')->get();
            foreach ($barangs as $br) {
                $catCode = $br->kode_jns_barang ?? 'JB001';
                if (! ItemCategory::where('code', $catCode)->exists()) {
                    $catCode = ItemCategory::first()->code ?? 'JB001';
                }

                Item::updateOrCreate(
                    ['code' => $br->kode_barang],
                    [
                        'category_code' => $catCode,
                        'name' => ($br->nama_barang ?? 'Barang').' '.($br->tipe_barang ?? ''),
                        'brand' => $br->nama_barang ?? null,
                        'unit' => 'PCS',
                        'stock' => 10,
                        'unit_price' => (float) ($br->biaya_kelebihan ?? 0),
                    ]
                );
            }
            $this->info("   Done: Migrasi {$barangs->count()} Master Barang.");
        }

        // 6. Migrasi Karyawan Legacy (tb_m_karyawan)
        $this->info('6. Memproses Master Karyawan Legacy (tb_m_karyawan)...');
        if ($legacyDb->getSchemaBuilder()->hasTable('tb_m_karyawan')) {
            $employees = $legacyDb->table('tb_m_karyawan')->get();
            foreach ($employees as $emp) {
                Employee::updateOrCreate(
                    ['nik' => $emp->nik_karyawan ?? $emp->nik ?? ('EMP-'.rand(1000, 9999))],
                    [
                        'name' => $emp->nama_karyawan ?? $emp->nama ?? 'Karyawan Legacy',
                        'phone_number' => $emp->nomor_hp ?? null,
                        'company_email' => $emp->email ?? null,
                        'is_active' => true,
                    ]
                );
            }
            $this->info("   Done: Migrasi {$employees->count()} Karyawan.");
        }

        // 7. Migrasi Master Pelanggan (m_pelanggan)
        $this->info('7. Memproses Data Master Pelanggan (m_pelanggan)...');
        if ($legacyDb->getSchemaBuilder()->hasTable('m_pelanggan')) {
            $customers = $legacyDb->table('m_pelanggan')->get();
            $cCount = 0;
            foreach ($customers as $row) {
                $nik = $row->nik_penduduk ?? $row->id_pelanggan ?? ('NIK-'.sprintf('%06d', ++$cCount));
                Customer::updateOrCreate(
                    ['nik' => $nik],
                    [
                        'name' => $row->nama_penduduk ?? $row->nama ?? 'Pelanggan Legacy',
                        'gender' => isset($row->jenis_kelamin) ? ($row->jenis_kelamin == 1 ? 'male' : 'female') : null,
                        'birth_date' => $row->tanggal_lahir ?? null,
                        'email' => $row->email ?? null,
                        'phone_number' => $row->nomor_hp ?? '081234567890',
                        'alt_phone_number' => $row->nomor_hp_2 ?? null,
                        'id_card_address' => $row->alamat_ktp ?? '-',
                        'rt' => $row->rt_ktp ?? null,
                        'rw' => $row->rw_ktp ?? null,
                        'village_code' => $row->kode_wilayah_kelurahan_ktp ?? null,
                    ]
                );
            }
            $this->info("   Done: Migrasi {$customers->count()} Pelanggan.");
        }

        // 8. Migrasi Subskripsi (trx_batchjob_register) dengan mapping status_reg
        $this->info('8. Memproses Subskripsi Aktif (trx_batchjob_register & m_status_registrasi)...');
        if ($legacyDb->getSchemaBuilder()->hasTable('trx_batchjob_register')) {
            $subs = $legacyDb->table('trx_batchjob_register')->get();
            foreach ($subs as $row) {
                $nik = $row->nik_penduduk ?? Customer::first()->nik ?? 'NIK-DEFAULT';
                $pkg = $row->kode_bandwith ?? 'HOME-20M';
                if (! BandwidthPackage::where('code', $pkg)->exists()) {
                    $pkg = BandwidthPackage::first()->code ?? 'HOME-20M';
                }

                $regCode = $row->status_reg ?? '20';
                $regStatusText = $statusRegMap[$regCode] ?? ($regCode == '20' ? 'Aktif' : $regCode);

                CustomerSubscription::updateOrCreate(
                    ['internet_number' => $row->nomor_internet],
                    [
                        'customer_nik' => $nik,
                        'customer_name' => $row->nama_pelanggan ?? 'Pelanggan',
                        'package_code' => $pkg,
                        'pop_code' => $row->kode_pop ?? null,
                        'odp_code' => $row->kode_odp ?? null,
                        'odp_port' => $row->port_odp ?? null,
                        'installation_address' => $row->alamat_pasang ?? '-',
                        'building_number' => $row->nomor_bangunan ?? null,
                        'rt' => $row->rt_pasang ?? null,
                        'rw' => $row->rw_pasang ?? null,
                        'village_code' => $row->kode_wilayah_kelurahan_pasang ?? null,
                        'building_type' => $row->jenis_bangunan ?? null,
                        'lat_long' => $row->lon_lat ?? null,
                        'maps_url' => $row->loc_maps ?? null,
                        'ont_username' => $row->ont_us ?? null,
                        'ont_password' => $row->ont_ps ?? null,
                        'pppoe_profile' => $row->pppoe_profile ?? 'default',
                        'registration_status' => $regStatusText,
                        'billing_cycle_day' => (int) ($row->periode_billing ?? 1),
                        'discount_amount' => (float) ($row->potongan ?? 0),
                        'discount_note' => $row->potongan_note ?? null,
                        'is_isolated' => isset($row->is_suspend) && $row->is_suspend == '1',
                        'is_terminated' => isset($row->is_termin) && $row->is_termin == '1',
                        'is_locked' => isset($row->islock) && $row->islock == '1',
                        'sales_name' => $row->nama_sales ?? null,
                    ]
                );
            }
            $this->info("   Done: Migrasi {$subs->count()} Subskripsi.");
        }

        // 9. Migrasi Invoice Bulanan (trx_billing_layanan & m_status_bill_lay)
        $this->info('9. Memproses Tagihan Bulanan (trx_billing_layanan & m_status_bill_lay)...');
        if ($legacyDb->getSchemaBuilder()->hasTable('trx_billing_layanan')) {
            $invoices = $legacyDb->table('trx_billing_layanan')->get();
            foreach ($invoices as $row) {
                $subExists = CustomerSubscription::where('internet_number', $row->nomor_internet)->exists();
                if (! $subExists) {
                    continue;
                }

                $pkg = $row->kode_bandwith ?? 'HOME-20M';
                if (! BandwidthPackage::where('code', $pkg)->exists()) {
                    $pkg = BandwidthPackage::first()->code ?? 'HOME-20M';
                }

                $billCode = $row->status_bill_lay ?? '15';
                $statusText = $statusBillMap[$billCode] ?? ($billCode == '15' ? 'PAID' : 'UNPAID');

                MonthlyInvoice::updateOrCreate(
                    ['invoice_number' => $row->no_invoice ?? ('INV/'.$row->nomor_internet.'/'.($row->bulan ?? '01').($row->tahun ?? '2026'))],
                    [
                        'internet_number' => $row->nomor_internet,
                        'package_code' => $pkg,
                        'billing_month' => (int) ($row->bulan ?? 1),
                        'billing_year' => (int) ($row->tahun ?? 2026),
                        'billing_period_text' => $row->periode_text ?? ('Periode '.($row->bulan ?? 1).'/'.($row->tahun ?? 2026)),
                        'subtotal' => (float) ($row->subtotal ?? $row->total ?? 0),
                        'discount' => (float) ($row->potongan ?? 0),
                        'ppn_amount' => (float) ($row->ppn ?? 0),
                        'penalty_amount' => (float) ($row->denda ?? 0),
                        'total_amount' => (float) ($row->total ?? 0),
                        'payment_status' => strtoupper(trim($statusText)),
                        'payment_method' => $row->metode_bayar ?? null,
                        'amount_paid' => isset($row->status_bayar) && strtoupper($row->status_bayar) == 'PAID' ? (float) ($row->total ?? 0) : null,
                        'paid_at' => $row->tgl_bayar ?? null,
                    ]
                );
            }
            $this->info("   Done: Migrasi {$invoices->count()} Invoice.");
        }

        $this->info('==================================================');
        $this->info(' Legacy Migration Completed Successfully!         ');
        $this->info('==================================================');

        return 0;
    }
}
