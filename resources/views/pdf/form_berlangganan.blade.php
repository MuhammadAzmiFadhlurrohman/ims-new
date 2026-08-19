<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Form Berlangganan - {{ $subscription->internet_number }}</title>
    <style>
        @page {
            margin: 20px 25px 20px 25px;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table {
            margin-bottom: 12px;
            border-bottom: 2px solid #0891b2;
            padding-bottom: 8px;
        }
        .brand-title {
            font-size: 14px;
            font-weight: bold;
            color: #0284c7;
            letter-spacing: 0.5px;
        }
        .brand-slogan {
            font-size: 8px;
            color: #64748b;
            letter-spacing: 2px;
        }
        .doc-main-title {
            font-size: 14px;
            font-weight: 900;
            text-align: center;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 8px 0;
            color: #0f172a;
        }
        .section-header {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 4px 8px;
            letter-spacing: 0.5px;
        }
        .data-table {
            margin-bottom: 8px;
            border: 1px solid #cbd5e1;
        }
        .data-table td {
            padding: 3.5px 6px;
            font-size: 9px;
            vertical-align: top;
            border-bottom: 1px solid #f1f5f9;
        }
        .label-col {
            width: 28%;
            color: #475569;
            font-weight: 600;
        }
        .val-col {
            width: 72%;
            color: #0f172a;
            font-weight: bold;
        }
        .provider-box {
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            padding: 6px 8px;
            font-size: 8px;
            margin-top: 6px;
            color: #334155;
        }
        .sign-table {
            margin-top: 14px;
            margin-bottom: 12px;
        }
        .sign-table td {
            text-align: center;
            font-size: 9px;
            width: 50%;
            vertical-align: top;
        }
        .footer-banner {
            background: #0891b2;
            color: #ffffff;
            padding: 6px 10px;
            font-size: 7.5px;
            border-radius: 4px;
            margin-top: 10px;
        }
        .footer-banner td {
            vertical-align: top;
            color: #ffffff;
            font-size: 7.5px;
        }
    </style>
</head>
<body>

    {{-- Top Header --}}
    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                <div style="height: 10px; width: 140px; background: linear-gradient(90deg, #94a3b8, #0284c7); border-radius: 2px;"></div>
            </td>
            <td style="width: 50%; text-align: right;">
                <div class="brand-title">PT. MEDIA SOLUSI NETWORK</div>
                <div class="brand-slogan">GET YOUR IT ACCESS</div>
            </td>
        </tr>
    </table>

    <div class="doc-main-title">FORM BERLANGGANAN</div>

    {{-- 1. INFORMASI PELANGGAN --}}
    <table class="data-table">
        <tr>
            <td colspan="4" class="section-header">INFORMASI PELANGGAN</td>
        </tr>
        <tr>
            <td class="label-col" style="width: 20%;">Nomor FB</td>
            <td style="width: 30%; font-weight: bold; color: #0284c7;">: {{ $subscription->internet_number }}</td>
            <td class="label-col" style="width: 20%;">Tanggal Registrasi</td>
            <td style="width: 30%; font-weight: bold;">: {{ $subscription->created_at ? $subscription->created_at->translatedFormat('d F Y') : date('d F Y') }}</td>
        </tr>
    </table>

    {{-- 2. DATA DIRI --}}
    <table class="data-table">
        <tr>
            <td colspan="4" class="section-header">DATA DIRI</td>
        </tr>
        <tr>
            <td class="label-col">Nama Lengkap</td>
            <td colspan="3" class="val-col">: {{ strtoupper($subscription->customer_name ?? $subscription->customer?->name ?? '-') }}</td>
        </tr>
        <tr>
            <td class="label-col">Alamat Lengkap KTP</td>
            <td colspan="3" class="val-col">: {{ $subscription->address_ktp ?? $subscription->customer?->id_card_address ?? $subscription->installation_address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Nama Pemohon</td>
            <td colspan="3" class="val-col">: {{ strtoupper($subscription->customer_name ?? $subscription->customer?->name ?? '-') }}</td>
        </tr>
        <tr>
            <td class="label-col">No. KTP / SIM / Paspor</td>
            <td colspan="3" class="val-col">: {{ $subscription->customer_nik ?? $subscription->customer?->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Telepon / FAX</td>
            <td style="width: 30%; font-weight: bold;">: {{ $subscription->alt_phone_number ?? '-' }}</td>
            <td class="label-col" style="width: 20%;">Contact Person</td>
            <td style="width: 30%; font-weight: bold;">: {{ $subscription->pic_name ?? $subscription->customer_name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">No. Handphone (HP)</td>
            <td style="width: 30%; font-weight: bold;">: {{ $subscription->phone_number ?? $subscription->customer?->phone_number ?? '-' }}</td>
            <td class="label-col" style="width: 20%;">E-Mail</td>
            <td style="width: 30%; font-weight: bold;">: {{ $subscription->email ?? $subscription->customer?->email ?? '-' }}</td>
        </tr>
    </table>

    {{-- 3. INFORMASI PEMASANGAN --}}
    <table class="data-table">
        <tr>
            <td colspan="2" class="section-header">INFORMASI PEMASANGAN</td>
        </tr>
        <tr>
            <td class="label-col">Jenis Tempat Tinggal</td>
            <td class="val-col">: [X] {{ $subscription->building_type ?? 'Rumah Tinggal' }}</td>
        </tr>
        <tr>
            <td class="label-col">Alamat Penagihan</td>
            <td class="val-col">: {{ $subscription->installation_address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Alamat Pemasangan</td>
            <td class="val-col">: {{ $subscription->installation_address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Nomor HP Penagihan</td>
            <td class="val-col">: {{ $subscription->phone_number ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Jenis Produk</td>
            <td class="val-col">: {{ $subscription->package?->category?->name ?? 'UP TO NEW' }}</td>
        </tr>
        <tr>
            <td class="label-col">Kapasitas Layanan</td>
            <td class="val-col">: {{ $subscription->package?->speed_mbps ?? 20 }} Mbps</td>
        </tr>
        <tr>
            <td class="label-col">Biaya Layanan Bulanan</td>
            <td class="val-col">: Rp {{ number_format($subscription->custom_monthly_fee ?: ($subscription->package?->price ?? 200000), 0, ',', '.') }} / Bulan</td>
        </tr>
        <tr>
            <td class="label-col">Biaya Registrasi / Pasang</td>
            <td class="val-col">: Rp 100.000,00</td>
        </tr>
        <tr>
            <td class="label-col">Perangkat Terpasang</td>
            <td class="val-col">: ONT GPON / ONU (SN: {{ $subscription->gpon_onu ?? 'RTEGC702D47B' }})</td>
        </tr>
        <tr>
            <td class="label-col">Jadwal Pemasangan</td>
            <td class="val-col">: {{ $subscription->installation_date ? \Carbon\Carbon::parse($subscription->installation_date)->translatedFormat('d F Y') : ($subscription->created_at ? $subscription->created_at->translatedFormat('d F Y') : '-') }}</td>
        </tr>
    </table>

    <div style="font-size: 8px; color: #475569; margin: 4px 0 8px 0; text-align: justify;">
        Dengan menandatangani form berlangganan ini, pemohon menyatakan bahwa informasi yang diberikan adalah benar dan telah menyetujui seluruh syarat &amp; ketentuan berlangganan layanan internet PT Media Solusi Network.
    </div>

    {{-- Signatures --}}
    <table class="sign-table">
        <tr>
            <td>
                <strong>PT MEDIA SOLUSI NETWORK</strong><br><br><br><br>
                <u>( NUNU NUGRAHA )</u><br>
                <span style="font-size: 7.5px; color: #64748b;">Nama &amp; Tanda Tangan Provider</span>
            </td>
            <td>
                <strong>PEMOHON / PELANGGAN</strong><br><br><br><br>
                <u>( {{ strtoupper($subscription->customer_name ?? 'PELANGGAN') }} )</u><br>
                <span style="font-size: 7.5px; color: #64748b;">Nama &amp; Tanda Tangan Pelanggan</span>
            </td>
        </tr>
    </table>

    {{-- Box Provider --}}
    <div class="provider-box">
        <div style="font-weight: bold; margin-bottom: 2px; text-decoration: underline;">Untuk diisi oleh Provider:</div>
        <table style="width: 100%;">
            <tr>
                <td style="width: 60%; vertical-align: top; font-size: 7.5px;">
                    1. Pembayaran tagihan dilakukan di AWAL BULAN.<br>
                    2. Link tagihan akan dikirim melalui WhatsApp ke no HP terdaftar.<br>
                    3. Berlangganan minimal 6 BULAN (Denda Rp 500.000 jika berhenti sebelum 6 bulan).<br>
                    4. Perangkat yang terpasang adalah MILIK PT MSN dan dikembalikan jika berhenti.
                </td>
                <td style="width: 40%; vertical-align: top; font-size: 7.5px;">
                    <strong>Kelengkapan Dokumen:</strong><br>
                    [X] Fotocopy KTP / SIM / NPWP<br>
                    [X] Foto Rumah &amp; Titik Lokasi Peta<br>
                    [X] Formulir Berlangganan Tervalidasi
                </td>
            </tr>
        </table>
    </div>

    {{-- Footer --}}
    <table class="footer-banner">
        <tr>
            <td style="width: 40%;">
                <strong>OFFICE:</strong><br>
                Jl Raya Leuwigajah No. 223 Kel. Utama, Kec. Cimahi Selatan, Kota Cimahi, 40533
            </td>
            <td style="width: 35%;">
                <strong>OPERATIONAL:</strong><br>
                Jl Reog No 18, Kel. Turangga, Kec Lengkong, Kota Bandung, 40264
            </td>
            <td style="width: 25%; text-align: right;">
                <strong>KONTAK:</strong><br>
                0896-9662-9955 / (022)-7303384<br>
                ptmsn.co.id | info@ptmsn.co.id
            </td>
        </tr>
    </table>

</body>
</html>
