<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\CustomerSubscription;
use App\Models\MonthlyInvoice;

class SampleInvoiceSeeder extends Seeder
{
    public function run(): void
    {
        // 1. JAENUDIN
        Customer::updateOrCreate(['nik' => '3273010101880001'], [
            'name' => 'JAENUDIN',
            'gender' => 'male',
            'phone_number' => '081234567890',
            'id_card_address' => 'Jl. Sukajadi No. 12, Bandung',
        ]);
        CustomerSubscription::updateOrCreate(['internet_number' => 'MSN-2026-1066'], [
            'customer_nik' => '3273010101880001',
            'customer_name' => 'JAENUDIN',
            'gender' => 'male',
            'city' => 'KOTA BANDUNG',
            'registration_status' => 'LIVE',
            'package_code' => 'HOME-20M',
            'installation_address' => 'Jl. Sukajadi No. 12, Bandung',
        ]);
        MonthlyInvoice::updateOrCreate(['invoice_number' => 'INV/12110224/08/2026'], [
            'internet_number' => 'MSN-2026-1066',
            'package_code' => 'HOME-20M',
            'billing_month' => 8,
            'billing_year' => 2026,
            'billing_period_text' => 'Aug 2026',
            'subtotal' => 225000,
            'total_amount' => 225000,
            'payment_status' => 'UNPAID',
            'payment_method' => 'MIDTRANS',
        ]);

        // 2. NURHASANAH
        Customer::updateOrCreate(['nik' => '3273010101880002'], [
            'name' => 'NURHASANAH',
            'gender' => 'female',
            'phone_number' => '081234567891',
            'id_card_address' => 'Jl. Buah Batu No. 45, Bandung',
        ]);
        CustomerSubscription::updateOrCreate(['internet_number' => 'MSN-2026-3679'], [
            'customer_nik' => '3273010101880002',
            'customer_name' => 'NURHASANAH',
            'gender' => 'female',
            'city' => 'KOTA BANDUNG',
            'registration_status' => '21',
            'status_type' => 'Temporary Delete',
            'package_code' => 'HOME-20M',
            'installation_address' => 'Jl. Buah Batu No. 45, Bandung',
        ]);
        MonthlyInvoice::updateOrCreate(['invoice_number' => 'INV/12010622/08/2026'], [
            'internet_number' => 'MSN-2026-3679',
            'package_code' => 'HOME-20M',
            'billing_month' => 8,
            'billing_year' => 2026,
            'billing_period_text' => 'Aug 2026',
            'subtotal' => 200000,
            'total_amount' => 200000,
            'payment_status' => 'UNPAID',
            'payment_method' => 'MIDTRANS',
        ]);

        // 3. REZA CAHYA NUR FITRI
        Customer::updateOrCreate(['nik' => '3273010101880003'], [
            'name' => 'REZA CAHYA NUR FITRI',
            'gender' => 'female',
            'phone_number' => '081234567892',
            'id_card_address' => 'Komp. Margahayu Kencana Blok B3, Kab. Bandung',
        ]);
        CustomerSubscription::updateOrCreate(['internet_number' => 'MSN-2026-8526'], [
            'customer_nik' => '3273010101880003',
            'customer_name' => 'REZA CAHYA NUR FITRI',
            'gender' => 'female',
            'city' => 'KABUPATEN BANDUNG',
            'registration_status' => 'LIVE',
            'package_code' => 'HOME-20M',
            'installation_address' => 'Komp. Margahayu Kencana Blok B3, Kab. Bandung',
        ]);
        MonthlyInvoice::updateOrCreate(['invoice_number' => 'INV/12710226/08/2026'], [
            'internet_number' => 'MSN-2026-8526',
            'package_code' => 'HOME-20M',
            'billing_month' => 8,
            'billing_year' => 2026,
            'billing_period_text' => 'Aug 2026',
            'subtotal' => 165000,
            'total_amount' => 165000,
            'payment_status' => 'UNPAID',
            'payment_method' => 'MIDTRANS',
        ]);

        // 4. CECEP SUHENDAR
        Customer::updateOrCreate(['nik' => '3273010101880004'], [
            'name' => 'CECEP SUHENDAR',
            'gender' => 'male',
            'phone_number' => '081234567893',
            'id_card_address' => 'Jl. Pasirluyu No. 10, Bandung',
        ]);
        CustomerSubscription::updateOrCreate(['internet_number' => 'MSN-2026-9051'], [
            'customer_nik' => '3273010101880004',
            'customer_name' => 'CECEP SUHENDAR',
            'gender' => 'male',
            'city' => 'KOTA BANDUNG',
            'registration_status' => 'LIVE',
            'package_code' => 'HOME-20M',
            'installation_address' => 'Jl. Pasirluyu No. 10, Bandung',
        ]);
        MonthlyInvoice::updateOrCreate(['invoice_number' => 'INV/11910224/08/2026'], [
            'internet_number' => 'MSN-2026-9051',
            'package_code' => 'HOME-20M',
            'billing_month' => 8,
            'billing_year' => 2026,
            'billing_period_text' => 'Aug 2026',
            'subtotal' => 200000,
            'total_amount' => 200000,
            'payment_status' => 'PAID',
            'payment_method' => 'MANUAL',
            'paid_at' => '2026-08-12 08:35:05',
            'expires_at' => '2026-08-31 23:59:00',
        ]);
    }
}
