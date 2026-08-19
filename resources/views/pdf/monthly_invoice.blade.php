<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>INVOICE - {{ $invoice->invoice_number }}</title>
    <style>
        @page {
            margin: 12px 20px 12px 20px;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9px;
            color: #1e293b;
            line-height: 1.25;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-container {
            width: 100%;
            margin-bottom: 8px;
        }
        .header-decor {
            width: 55%;
            height: 38px;
            background: #263238;
            position: relative;
            border-bottom: 4px solid #00bcd4;
        }
        .header-logo-col {
            width: 45%;
            text-align: right;
            vertical-align: middle;
        }
        .logo-img {
            max-height: 38px;
        }
        .invoice-title-wrapper {
            text-align: center;
            margin: 4px 0 10px 0;
        }
        .invoice-title {
            font-size: 15px;
            font-weight: 900;
            font-style: italic;
            text-decoration: underline;
            letter-spacing: 2px;
            color: #0f172a;
        }
        .invoice-subtitle {
            font-size: 7.5px;
            font-style: italic;
            font-weight: bold;
            letter-spacing: 1px;
            color: #64748b;
            margin-top: 1px;
        }
        .info-box {
            border: 1px solid #334155;
            padding: 6px 8px;
            font-size: 8.5px;
            line-height: 1.35;
            min-height: 55px;
        }
        .info-box-title {
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 2px;
            text-transform: uppercase;
        }
        .main-table {
            width: 100%;
            border: 1px solid #334155;
            margin-top: 8px;
        }
        .main-table th {
            background-color: #000000;
            color: #ffffff;
            font-size: 8.5px;
            font-weight: bold;
            padding: 4px 6px;
            border: 1px solid #334155;
            text-align: center;
        }
        .main-table td {
            border: 1px solid #334155;
            padding: 4px 6px;
            font-size: 8.5px;
            vertical-align: middle;
        }
        .highlight-cyan {
            background-color: #00bcd4 !important;
            color: #000000 !important;
            font-weight: bold;
        }
        .signature-table {
            width: 100%;
            border: 1px solid #334155;
            margin-top: 8px;
        }
        .signature-table th {
            background-color: #000000;
            color: #ffffff;
            font-size: 8.5px;
            font-weight: bold;
            padding: 3px 6px;
            border: 1px solid #334155;
            text-align: center;
        }
        .signature-table td {
            border: 1px solid #334155;
            padding: 6px 8px;
            font-size: 8.5px;
            text-align: center;
            vertical-align: top;
        }
        .cut-divider {
            border: none;
            border-top: 1.5px dashed #94a3b8;
            margin: 12px 0 8px 0;
        }
        .slip-header-table {
            width: 100%;
            margin-bottom: 4px;
        }
        .slip-title {
            font-size: 10px;
            font-weight: 900;
            text-align: right;
            letter-spacing: 0.5px;
        }
        .slip-table {
            width: 100%;
            border: 1px solid #334155;
            margin-bottom: 8px;
        }
        .slip-table td {
            border: 1px solid #334155;
            padding: 3.5px 6px;
            font-size: 8.5px;
        }
        .notes-list {
            margin: 4px 0 10px 0;
            padding-left: 12px;
            font-size: 7.5px;
            color: #334155;
            line-height: 1.3;
        }
        .notes-list li {
            margin-bottom: 2px;
        }
        .footer-banner {
            background-color: #00a8b5;
            color: #ffffff;
            padding: 6px 10px;
            margin-top: 10px;
            font-size: 7px;
            line-height: 1.25;
        }
        .footer-banner td {
            vertical-align: top;
            padding: 0 4px;
        }
        .footer-label {
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 1px;
        }
        .link-btn {
            display: inline-block;
            color: #0284c7;
            text-decoration: underline;
            font-weight: bold;
            font-size: 10px;
            margin-top: 4px;
        }
    </style>
</head>
<body>

    @php
        $custName = $subscription->customer_name ?? ($customer->name ?? 'IDA PARIDAH');
        $custAddress = $subscription->installation_address ?? ($customer->address ?? 'JL BBK TAROGONG 442/196B NO. 00, RT00/RW00, KEL. BABAKAN ASIH, KEC. BOJONGLOA KALER, KOTA BANDUNG, JAWA BARAT');
        $packageName = $invoice->package->name ?? ($subscription->package->name ?? 'LAYANAN BROADBAND NEW 15 MBps');
        $periode = $invoice->billing_period_text ?? date('M Y', strtotime($invoice->created_at ?? now()));
        $jatuhTempo = 'Tanggal 20 Setiap Bulan';
        if (!empty($subscription->due_date_day)) {
            $jatuhTempo = "Tanggal {$subscription->due_date_day} Setiap Bulan";
        }
        $adminName = 'Ida Mayasari';
    @endphp

    <!-- ── 1. HEADER SECTION ── -->
    <table class="header-container">
        <tr>
            <td style="width: 50%; vertical-align: middle;">
                <div class="header-decor" style="border-radius: 4px;">
                    <table style="width: 100%; height: 100%;">
                        <tr>
                            <td style="padding-left: 10px; color: #00bcd4; font-weight: 900; font-size: 11px; letter-spacing: 1px;">
                                PT MEDIA SOLUSI NETWORK
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td class="header-logo-col">
                <table style="width: 100%; text-align: right;">
                    <tr>
                        <td style="text-align: right; vertical-align: middle;">
                            <div style="font-size: 13px; font-weight: 900; color: #008ba3; letter-spacing: 0.5px;">Media Solusi</div>
                            <div style="font-size: 12px; font-weight: 800; color: #334155; margin-top: -2px;">Network</div>
                            <div style="font-size: 6.5px; font-weight: bold; color: #64748b; letter-spacing: 1px;">INTERNET SERVICE PROVIDER</div>
                        </td>
                        <td style="width: 42px; text-align: right; padding-left: 6px;">
                            <div style="width: 36px; height: 36px; border: 2px solid #00bcd4; border-radius: 6px; text-align: center; line-height: 36px; font-size: 16px; font-weight: 900; color: #008ba3;">
                                MSN
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ── 2. INVOICE TITLE ── -->
    <div class="invoice-title-wrapper">
        <div class="invoice-title">INVOICE</div>
        <div class="invoice-subtitle">TAGIHAN</div>
    </div>

    <!-- ── 3. CUSTOMER & INVOICE DETAILS ── -->
    <table style="width: 100%; margin-bottom: 8px;">
        <tr>
            <!-- Left: Customer Box -->
            <td style="width: 48%; vertical-align: top; padding-right: 4px;">
                <div class="info-box">
                    <div class="info-box-title">{{ strtoupper($custName) }}</div>
                    <div style="font-size: 8px; color: #334155; text-transform: uppercase;">
                        {{ $custAddress }}
                    </div>
                </div>
            </td>

            <!-- Spacer -->
            <td style="width: 4%;"></td>

            <!-- Right: Company & Invoice Info Box -->
            <td style="width: 48%; vertical-align: top; padding-left: 4px;">
                <div class="info-box">
                    <div class="info-box-title" style="font-size: 9px;">PT MEDIA SOLUSI NETWORK</div>
                    <table style="width: 100%; font-size: 8px; margin-top: 2px;">
                        <tr>
                            <td style="width: 40%; font-weight: bold; padding: 0.5px 0;">No tagihan</td>
                            <td style="width: 5%;">:</td>
                            <td style="font-family: monospace; font-weight: bold;">{{ $invoice->invoice_number }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 0.5px 0;">Nomor Pelanggan</td>
                            <td>:</td>
                            <td style="font-family: monospace; font-weight: bold;">{{ $invoice->internet_number }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 0.5px 0;">Periode Pemakaian</td>
                            <td>:</td>
                            <td>{{ $periode }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 0.5px 0;">Jatuh Tempo</td>
                            <td>:</td>
                            <td style="color: #b91c1c; font-weight: bold;">{{ $jatuhTempo }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <!-- ── 4. ITEM & AMOUNT TABLE ── -->
    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 6%;">No</th>
                <th style="width: 58%;">Layanan</th>
                <th style="width: 12%;">Qty</th>
                <th style="width: 24%;">Tagihan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; height: 22px;">1</td>
                <td style="font-weight: bold; text-transform: uppercase;">
                    LAYANAN BROADBAND {{ $packageName }}
                </td>
                <td style="text-align: center;">1</td>
                <td style="text-align: right; font-weight: bold;">
                    Rp {{ number_format($subtotal, 2, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td colspan="2" rowspan="3" style="vertical-align: top; background: #fafafa;">
                    <div style="font-style: italic; font-size: 8px; margin-top: 2px;">
                        <strong>Terbilang :</strong> {{ $terbilang }} Rupiah
                    </div>
                </td>
                <td style="font-weight: bold; text-align: right; background: #f8fafc; font-size: 8px;">POTONGAN</td>
                <td style="text-align: right; font-size: 8px;">{{ number_format($discount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; text-align: right; background: #f8fafc; font-size: 8px;">PPN</td>
                <td style="text-align: right; font-size: 8px;">Rp {{ number_format($ppn, 2, ',', '.') }} (include)</td>
            </tr>
            <tr>
                <td class="highlight-cyan" style="text-align: center; font-size: 8px; text-transform: uppercase;">TAGIHAN BULAN INI</td>
                <td class="highlight-cyan" style="text-align: right; font-size: 9.5px; font-weight: 900;">
                    Rp {{ number_format($total, 2, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- ── 5. SIGNATURES & PAYMENT LINK SECTION ── -->
    <table class="signature-table">
        <thead>
            <tr>
                <th style="width: 34%;">Pembayaran</th>
                <th style="width: 33%;">Mengetahui</th>
                <th style="width: 33%;">Pelanggan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <!-- Col 1: Link Pembayaran -->
                <td style="text-align: center; vertical-align: middle; height: 60px;">
                    <div style="font-size: 8px; font-weight: bold; color: #0284c7; margin-bottom: 3px;">
                        LINK PEMBAYARAN :
                    </div>
                    <a href="{{ $paymentUrl }}" target="_blank" class="link-btn">
                        Klik Disini
                    </a>
                </td>

                <!-- Col 2: Mengetahui -->
                <td style="text-align: center; vertical-align: bottom; height: 60px;">
                    <div style="margin-top: 35px; border-bottom: 1px solid #334155; display: inline-block; min-width: 110px; font-weight: bold;">
                        {{ $adminName }}
                    </div>
                    <div style="font-size: 8px; color: #64748b; margin-top: 2px;">Keuangan</div>
                </td>

                <!-- Col 3: Pelanggan -->
                <td style="text-align: center; vertical-align: bottom; height: 60px;">
                    <div style="margin-top: 35px; border-bottom: 1px solid #334155; display: inline-block; min-width: 110px; font-weight: bold; text-transform: uppercase;">
                        {{ $custName }}
                    </div>
                    <div style="font-size: 8px; color: #64748b; margin-top: 2px;">Pelanggan</div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- ── 6. PERFORATED CUT DIVIDER ── -->
    <hr class="cut-divider">

    <!-- ── 7. SLIP PEMBAYARAN ── -->
    <table class="slip-header-table">
        <tr>
            <td style="font-size: 9px; font-weight: bold; color: #0f172a;">PT. MEDIA SOLUSI NETWORK</td>
            <td class="slip-title">SLIP PEMBAYARAN</td>
        </tr>
    </table>

    <table class="slip-table">
        <tr>
            <td style="width: 50%;"><strong>Nomor Tagihan :</strong> {{ $invoice->invoice_number }}</td>
            <td style="width: 50%;"><strong>Periode Tagihan :</strong> {{ $periode }}</td>
        </tr>
        <tr>
            <td><strong>Nomor Pelanggan :</strong> {{ $invoice->internet_number }}</td>
            <td><strong>Jatuh Tempo :</strong> {{ $jatuhTempo }}</td>
        </tr>
        <tr>
            <td><strong>Nama Pelanggan :</strong> {{ strtoupper($custName) }}</td>
            <td><strong>Jumlah Tagihan :</strong> <strong>Rp {{ number_format($total, 2, ',', '.') }}</strong></td>
        </tr>
    </table>

    <!-- Slip Signatures -->
    <table style="width: 100%; margin-bottom: 6px;">
        <tr>
            <td style="width: 50%; text-align: center; font-size: 8px;">
                <div>Petugas</div>
                <div style="margin-top: 28px; font-weight: bold;">TTD / Nama</div>
            </td>
            <td style="width: 50%; text-align: center; font-size: 8px;">
                <div>Pelanggan</div>
                <div style="margin-top: 28px; font-weight: bold; text-transform: uppercase;">{{ $custName }}</div>
            </td>
        </tr>
    </table>

    <!-- Catatan -->
    <div style="font-size: 7.5px; font-weight: bold; color: #334155; margin-bottom: 2px;">catatan :</div>
    <ul class="notes-list">
        <li>Apabila pelanggan belum melakukan pembayaran sampai dengan jatuh tempo (Maksimal {{ $jatuhTempo }}), maka akan dilakukan pemutusan koneksi sementara terhitung mulai pukul 24.00 pada tanggal akhir periode sebelumnya.</li>
        <li>Untuk pelanggan yang melakukan pembayaran melalui <strong>Transfer Bank</strong>, mohon memberikan konfirmasi via Whatsapp ke nomor <strong>089508416636</strong> dengan mencantumkan bukti pembayaran.</li>
    </ul>

    <!-- ── 8. BOTTOM FOOTER BANNER ── -->
    <table class="footer-banner" style="width: 100%; border-radius: 3px;">
        <tr>
            <td style="width: 27%;">
                <span class="footer-label">OFFICE</span>
                Jl Raya Leuwigajah No. 222 Kel. Utama, Kec. Cimahi Selatan, Kota Cimahi, 40533
            </td>
            <td style="width: 32%;">
                <span class="footer-label">OPERATIONAL</span>
                Jl Kayu Agung II No 9, Kel. Turangga, Kec. Lengkong, Kota Bandung, 40264
            </td>
            <td style="width: 22%;">
                <span class="footer-label">TELEPON</span>
                022-3050-0111<br>0852-2013-7627
            </td>
            <td style="width: 19%; text-align: right;">
                <span class="footer-label">EMAIL & WEB</span>
                ptmsn.co.id<br>info@ptmsn.co.id
            </td>
        </tr>
    </table>

</body>
</html>
