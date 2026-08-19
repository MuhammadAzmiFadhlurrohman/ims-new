<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Berita Acara Aktivasi - {{ $subscription->internet_number }}</title>
    <style>
        @page {
            margin: 25px 30px 25px 30px;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table {
            margin-bottom: 15px;
            border-bottom: 2px solid #0891b2;
            padding-bottom: 10px;
        }
        .brand-title {
            font-size: 15px;
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
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 10px;
            margin-bottom: 2px;
            color: #0f172a;
        }
        .doc-number {
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            color: #475569;
            margin-bottom: 16px;
        }
        .body-text {
            text-align: justify;
            margin-bottom: 12px;
            font-size: 10px;
            color: #334155;
        }
        .data-table {
            margin-bottom: 12px;
            border: 1px solid #cbd5e1;
        }
        .data-table td {
            padding: 4.5px 8px;
            font-size: 9.5px;
            vertical-align: top;
            border-bottom: 1px solid #f1f5f9;
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
        .label-col {
            width: 30%;
            font-weight: bold;
            color: #475569;
        }
        .val-col {
            width: 70%;
            color: #0f172a;
            font-weight: 600;
        }
        .sign-table {
            margin-top: 25px;
            margin-bottom: 15px;
        }
        .sign-table td {
            text-align: center;
            font-size: 9.5px;
            width: 50%;
            vertical-align: top;
        }
        .footer-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #0891b2;
            color: #ffffff;
            padding: 8px 12px;
            font-size: 8px;
            border-radius: 4px;
        }
        .footer-banner td {
            vertical-align: top;
            color: #ffffff;
            font-size: 8px;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                <div style="height: 12px; width: 140px; background: linear-gradient(90deg, #94a3b8, #0284c7); border-radius: 2px;"></div>
            </td>
            <td style="width: 50%; text-align: right;">
                <div class="brand-title">PT. MEDIA SOLUSI NETWORK</div>
                <div class="brand-slogan">GET YOUR IT ACCESS</div>
            </td>
        </tr>
    </table>

    <div class="doc-main-title">BERITA ACARA AKTIVASI &amp; UJI TERIMA LAYANAN</div>
    <div class="doc-number">Nomor : {{ $subscription->internet_number }}/MSN-AKTIVASI/{{ date('m/Y') }}</div>

    <div class="body-text">
        Pada hari ini tanggal <strong>{{ $subscription->activation_finished_at ? \Carbon\Carbon::parse($subscription->activation_finished_at)->translatedFormat('d F Y') : ($subscription->activation_date ? \Carbon\Carbon::parse($subscription->activation_date)->translatedFormat('d F Y') : date('d F Y')) }}</strong>, telah dilaksanakan aktivasi dan uji terima layanan internet FTTH PT Media Solusi Network dengan rincian teknis sebagai berikut :
    </div>

    {{-- Rincian Teknis Aktivasi --}}
    <table class="data-table">
        <tr>
            <td colspan="2" class="section-header">1. DATA PELANGGAN &amp; LAYANAN</td>
        </tr>
        <tr>
            <td class="label-col">Nomor Pelanggan / Internet</td>
            <td class="val-col" style="color: #0284c7; font-weight: bold;">: {{ $subscription->internet_number }}</td>
        </tr>
        <tr>
            <td class="label-col">Nama Pelanggan</td>
            <td class="val-col">: {{ strtoupper($subscription->customer_name ?? '-') }}</td>
        </tr>
        <tr>
            <td class="label-col">Alamat Instalasi</td>
            <td class="val-col">: {{ $subscription->installation_address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Paket Berlangganan</td>
            <td class="val-col">: {{ $subscription->package?->name ?? 'UP TO NEW' }} ({{ $subscription->package?->speed_mbps ?? 20 }} Mbps)</td>
        </tr>
        <tr>
            <td class="label-col">Biaya Langganan</td>
            <td class="val-col">: Rp {{ number_format($subscription->custom_monthly_fee ?: ($subscription->package?->price ?? 200000), 0, ',', '.') }} / Bulan</td>
        </tr>
    </table>

    <table class="data-table">
        <tr>
            <td colspan="2" class="section-header">2. PARAMETER TEKNIS JARINGAN &amp; PERANGKAT</td>
        </tr>
        <tr>
            <td class="label-col">Username PPPoE</td>
            <td class="val-col" style="font-family: monospace;">: {{ $subscription->ont_username ?? $subscription->internet_number }}</td>
        </tr>
        <tr>
            <td class="label-col">Profil PPPoE</td>
            <td class="val-col">: {{ $subscription->pppoe_profile ?? 'jaringan FTTH Media Solusi Network' }}</td>
        </tr>
        <tr>
            <td class="label-col">Titik ODP &amp; Port</td>
            <td class="val-col">: {{ $subscription->odp?->name ?? $subscription->odp_code ?? 'ODP-CBT-01/01' }} (Port: {{ $subscription->odp_port ?? '1' }})</td>
        </tr>
        <tr>
            <td class="label-col">Serial Number ONU / GPON</td>
            <td class="val-col" style="font-family: monospace;">: {{ $subscription->gpon_onu ?? 'RTEGC702D47B' }}</td>
        </tr>
        <tr>
            <td class="label-col">Redaman Optik (Optical Power)</td>
            <td class="val-col">: {{ $subscription->optical_power_dbm ?? '-19.50 dBm' }} (Standar Baik: -15 s/d -24 dBm)</td>
        </tr>
        <tr>
            <td class="label-col">Status Pengujian Uji Terima</td>
            <td class="val-col">: [✓] Speedtest Sesuai Paket  &nbsp;|&nbsp; [✓] Ping &amp; Latency Stabil  &nbsp;|&nbsp; [✓] Browsing Lancar</td>
        </tr>
        <tr>
            <td class="label-col">Catatan Petugas Aktivasi</td>
            <td class="val-col">: {{ $subscription->activation_finished_note ?? 'Layanan telah aktif 100%, terhubung ke OLT Central dan siap digunakan.' }}</td>
        </tr>
    </table>

    <div class="body-text">
        Dengan ditandatanganinya berita acara ini, pelanggan menyatakan bahwa seluruh perangkat telah diterima dalam kondisi baik, konfigurasi internet telah selesai diuji, dan layanan telah beroperasi normal.
    </div>

    {{-- Signatures --}}
    <table class="sign-table">
        <tr>
            <td>
                <strong>Petugas Aktivasi / NOC</strong><br><br><br><br><br>
                <u>( ADMIN NOC )</u><br>
                <span style="font-size: 8px; color: #64748b;">NOC &amp; Network Engineer</span>
            </td>
            <td>
                <strong>Pelanggan / Penerima Layanan</strong><br><br><br><br><br>
                <u>( {{ strtoupper($subscription->customer_name ?? 'PELANGGAN') }} )</u><br>
                <span style="font-size: 8px; color: #64748b;">Tanda Tangan &amp; Nama Terang</span>
            </td>
        </tr>
    </table>

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
