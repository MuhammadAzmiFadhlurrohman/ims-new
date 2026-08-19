<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Tugas Survey - {{ $subscription->internet_number }}</title>
    <style>
        @page {
            margin: 25px 30px 25px 30px;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10.5px;
            color: #1e293b;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table {
            margin-bottom: 20px;
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
            font-size: 15px;
            font-weight: 900;
            text-align: center;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 15px;
            margin-bottom: 2px;
            color: #0f172a;
        }
        .doc-number {
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            color: #475569;
            margin-bottom: 22px;
        }
        .body-text {
            text-align: justify;
            margin-bottom: 16px;
            font-size: 10.5px;
            color: #334155;
        }
        .data-table {
            margin: 12px 0 20px 0;
        }
        .data-table td {
            padding: 5px 6px;
            font-size: 10.5px;
            vertical-align: top;
        }
        .label-col {
            width: 25%;
            font-weight: bold;
            color: #334155;
        }
        .val-col {
            width: 75%;
            color: #0f172a;
        }
        .sign-table {
            margin-top: 35px;
            margin-bottom: 25px;
        }
        .sign-table td {
            text-align: center;
            font-size: 10px;
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

    <div class="doc-main-title">SURAT TUGAS SURVEY</div>
    <div class="doc-number">Nomor : {{ $subscription->internet_number }}/MSN-NOC/{{ date('m/Y') }}</div>

    <div class="body-text">
        Dengan surat ini pada tanggal <strong>{{ $subscription->survey_date ? \Carbon\Carbon::parse($subscription->survey_date)->translatedFormat('d F Y') : date('d F Y') }}</strong>, PT Media Solusi Network menugaskan tim teknisi <strong>{{ is_array($subscription->survey_team) ? implode(', ', $subscription->survey_team) : ($subscription->survey_team ?? 'Abdul Ghani, Dandi Alrizqi, M.Reza Apriani') }}</strong> untuk melakukan survei lokasi pemasangan jaringan internet kepada pelanggan baru dengan rincian sebagai berikut :
    </div>

    {{-- Detail Pelanggan --}}
    <table class="data-table">
        <tr>
            <td class="label-col">Nama Pelanggan</td>
            <td class="val-col">: <strong>{{ strtoupper($subscription->customer_name ?? '-') }}</strong></td>
        </tr>
        <tr>
            <td class="label-col">Alamat Pemasangan</td>
            <td class="val-col">: {{ $subscription->installation_address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">PIC / Kontak</td>
            <td class="val-col">: {{ $subscription->pic_name ?? $subscription->customer_name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Nomor Telepon / HP</td>
            <td class="val-col">: <strong>{{ $subscription->phone_number ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="label-col">Paket Layanan</td>
            <td class="val-col">: {{ $subscription->package?->name ?? 'UP TO NEW' }}, {{ $subscription->package?->speed_mbps ?? 20 }} Mbps</td>
        </tr>
        <tr>
            <td class="label-col">Detail Pekerjaan</td>
            <td class="val-col">: Penarikan kabel FO ke titik ODP {{ $subscription->odp?->name ?? $subscription->odp_code ?? 'Terdekat' }} (Kordinat: {{ $subscription->lat_long ?? '-6.9369, 107.5904' }})</td>
        </tr>
    </table>

    <div class="body-text">
        Demikian surat tugas ini dibuat dan dapat dipertanggungjawabkan serta dapat digunakan sebagaimana mestinya, terimakasih.<br><br>
        Hormat Kami,<br>
        <strong>PT Media Solusi Network, Bandung</strong>
    </div>

    {{-- Signatures --}}
    <table class="sign-table">
        <tr>
            <td>
                <strong>Penanggung Jawab / NOC</strong><br><br><br><br><br>
                <u>( IPIN ARIPIN )</u><br>
                <span style="font-size: 8px; color: #64748b;">Coordinator NOC &amp; Survey</span>
            </td>
            <td>
                <strong>Pelanggan / Pemohon</strong><br><br><br><br><br>
                <u>( {{ strtoupper($subscription->customer_name ?? 'PELANGGAN') }} )</u><br>
                <span style="font-size: 8px; color: #64748b;">Pemohon Registrasi</span>
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
