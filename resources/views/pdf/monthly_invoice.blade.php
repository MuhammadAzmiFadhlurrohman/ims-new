<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>INVOICE - {{ $invoice->invoice_number }}</title>
    <style>
        @page {
            margin: 18px 25px 14px 25px;
            size: a4 portrait;
        }
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 8.5pt;
            color: #000000;
            line-height: 1.25;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* ── HEADER ── */
        .header-table {
            width: 100%;
            margin-bottom: 6px;
        }
        .header-left-col {
            width: 54%;
            vertical-align: middle;
        }
        .header-mesh-banner {
            width: 100%;
            height: 48px;
            background-color: #2b3940;
            position: relative;
            overflow: hidden;
            border-bottom: 3.5px solid #00bcd4;
        }
        .header-right-col {
            width: 46%;
            text-align: right;
            vertical-align: middle;
            padding-left: 10px;
        }

        /* ── INVOICE TITLE ── */
        .invoice-title-container {
            text-align: center;
            margin: 4px 0 10px 0;
        }
        .invoice-title-text {
            font-size: 15pt;
            font-weight: bold;
            font-style: italic;
            letter-spacing: 1.5px;
            color: #000000;
            display: inline-block;
            border-bottom: 1.5px solid #000000;
            padding: 0 40px 1px 40px;
        }
        .invoice-subtitle-text {
            font-size: 7.5pt;
            font-style: italic;
            font-weight: bold;
            color: #475569;
            letter-spacing: 0.5px;
            margin-top: 1px;
            text-align: center;
            padding-left: 80px;
        }

        /* ── CUSTOMER & COMPANY INFO BOX ── */
        .info-container-table {
            width: 100%;
            border: 1.5px solid #000000;
            margin-bottom: 10px;
            border-collapse: collapse;
        }
        .info-customer-col {
            width: 48%;
            vertical-align: top;
            padding: 8px 10px;
            border-right: 1.5px solid #000000;
        }
        .info-company-col {
            width: 52%;
            vertical-align: top;
            padding: 8px 10px;
        }
        .customer-name-heading {
            font-size: 9.5pt;
            font-weight: bold;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .customer-divider-line {
            border-top: 1px solid #000000;
            margin: 5px 0 6px 0;
            width: 100%;
        }
        .customer-address-text {
            font-size: 8pt;
            line-height: 1.35;
            color: #000000;
            text-transform: uppercase;
        }
        .company-name-heading {
            font-size: 9.5pt;
            font-weight: bold;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 6px;
        }
        .meta-kv-table {
            width: 100%;
            font-size: 8.5pt;
        }
        .meta-kv-table td {
            padding: 1.5px 0;
            vertical-align: top;
        }
        .meta-kv-label {
            width: 38%;
            color: #000000;
        }
        .meta-kv-sep {
            width: 4%;
            text-align: center;
            color: #000000;
        }
        .meta-kv-value {
            width: 58%;
            color: #000000;
        }

        /* ── MAIN BILLING TABLE ── */
        .main-table {
            width: 100%;
            border: 1.5px solid #000000;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .main-table th {
            background-color: #000000;
            color: #ffffff;
            font-size: 8.5pt;
            font-weight: bold;
            padding: 4px 6px;
            border: 1px solid #000000;
        }
        .main-table td {
            border: 1px solid #000000;
            padding: 4px 6px;
            font-size: 8.5pt;
            vertical-align: middle;
        }
        .cell-cyan-tagihan {
            background-color: #00c2cb !important;
            color: #000000 !important;
            font-weight: bold;
        }

        /* ── SIGNATURE / PAYMENT BOX ── */
        .sig-table {
            width: 100%;
            border: 1.5px solid #000000;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .sig-table th {
            background-color: #000000;
            color: #ffffff;
            font-size: 8.5pt;
            font-weight: bold;
            padding: 4px 6px;
            border: 1px solid #000000;
            text-align: center;
        }
        .sig-table td {
            border: 1px solid #000000;
            padding: 6px 10px;
            font-size: 8.5pt;
            text-align: center;
            vertical-align: middle;
            height: 85px;
        }

        /* ── PERFORATION DIVIDER ── */
        .perforated-cut-line {
            border: none;
            border-top: 1.5px dashed #334155;
            margin: 10px 0 8px 0;
            width: 100%;
        }

        /* ── SLIP PEMBAYARAN ── */
        .slip-header-table {
            width: 100%;
            margin-bottom: 4px;
        }
        .slip-company-name {
            font-size: 9.5pt;
            font-weight: bold;
            color: #000000;
            text-transform: uppercase;
        }
        .slip-title {
            font-size: 9.5pt;
            font-weight: bold;
            text-align: right;
            color: #000000;
            letter-spacing: 0.5px;
        }
        .slip-table {
            width: 100%;
            border: 1.5px solid #000000;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .slip-table td {
            border: 1px solid #000000;
            padding: 3.5px 6px;
            font-size: 8pt;
        }
        .slip-sig-table {
            width: 100%;
            margin-top: 2px;
            margin-bottom: 4px;
        }
        .slip-sig-table td {
            text-align: center;
            font-size: 8pt;
            vertical-align: top;
            width: 50%;
        }
        .slip-notes-heading {
            font-size: 7.5pt;
            color: #000000;
            margin-top: 2px;
            margin-bottom: 1px;
        }
        .slip-notes-list {
            margin: 0 0 6px 0;
            padding-left: 14px;
            font-size: 7.2pt;
            color: #000000;
            line-height: 1.25;
        }
        .slip-notes-list li {
            margin-bottom: 1px;
        }

        /* ── FOOTER BANNER ── */
        .footer-banner {
            width: 100%;
            background-color: #00a8b5;
            color: #ffffff;
            padding: 5px 8px;
            font-size: 6.8pt;
            line-height: 1.2;
            border-collapse: collapse;
        }
        .footer-banner td {
            vertical-align: top;
            padding: 0 4px;
            color: #ffffff;
        }
        .footer-icon-circle {
            display: inline-block;
            width: 13px;
            height: 13px;
            background-color: #ffffff;
            border-radius: 50%;
            text-align: center;
            line-height: 13px;
            margin-right: 3px;
            vertical-align: middle;
        }
        .footer-label {
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #ffffff;
        }
    </style>
</head>
<body>

    @php
        // Resolve Customer Name
        $custName = $subscription->customer_name ?? ($customer->name ?? 'TOMI RUSMAN');
        
        // Resolve Customer Full Address
        $custAddress = $subscription->installation_address 
            ?? ($customer->id_card_address 
            ?? ($customer->address 
            ?? ($subscription->address_ktp 
            ?? 'JLN KOPO GG PASAHDI NO 216/198A RT 001 RW 003 KEL BBKN ASIH KEC BOJONGLOA KALER NO. 216/198A, RT001/RW003, KEL. BABAKAN ASIH, KEC. BOJONGLOA KALER, KOTA BANDUNG, JAWA BARAT')));

        // Resolve Package Name
        $rawPackageName = $invoice->package->name ?? ($subscription->package->name ?? 'UP TO NEW 30 MBps');
        $rawPackageName = preg_replace('/^LAYANAN\s+/i', '', $rawPackageName);
        $displayPackageName = 'LAYANAN ' . strtoupper($rawPackageName);

        // Resolve Periode
        $periode = $invoice->billing_period_text ?? date('M Y', strtotime($invoice->created_at ?? now()));

        // Resolve Jatuh Tempo
        $cycleDay = $subscription->billing_cycle_day ?? ($subscription->due_date_day ?? 20);
        $jatuhTempo = "Tanggal {$cycleDay} Setiap Bulan";

        // Admin Signature
        $adminName = $subscription->admin_name ?? 'Ida Mayasari';
    @endphp

    <!-- ── 1. HEADER SECTION ── -->
    <table class="header-table">
        <tr>
            <!-- Left: High-Tech Geometric Network Banner -->
            <td class="header-left-col">
                <div class="header-mesh-banner">
                    <svg width="100%" height="48" viewBox="0 0 350 48" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Dark background base -->
                        <rect width="350" height="48" fill="#263339" />
                        <!-- Geometric network mesh pattern -->
                        <g stroke="#3a4d56" stroke-width="1" opacity="0.65">
                            <line x1="15" y1="10" x2="65" y2="28" />
                            <line x1="65" y1="28" x2="115" y2="12" />
                            <line x1="115" y1="12" x2="175" y2="35" />
                            <line x1="175" y1="35" x2="225" y2="15" />
                            <line x1="225" y1="15" x2="285" y2="38" />
                            <line x1="285" y1="38" x2="340" y2="18" />

                            <line x1="40" y1="40" x2="65" y2="28" />
                            <line x1="65" y1="28" x2="90" y2="44" />
                            <line x1="90" y1="44" x2="175" y2="35" />
                            <line x1="175" y1="35" x2="200" y2="45" />
                            <line x1="200" y1="45" x2="285" y2="38" />

                            <line x1="15" y1="10" x2="115" y2="12" />
                            <line x1="115" y1="12" x2="225" y2="15" />
                            <line x1="225" y1="15" x2="340" y2="18" />
                        </g>
                        <!-- Network Nodes -->
                        <g fill="#00bcd4">
                            <circle cx="15" cy="10" r="2.2" />
                            <circle cx="65" cy="28" r="2.5" />
                            <circle cx="115" cy="12" r="2.2" />
                            <circle cx="175" cy="35" r="2.8" />
                            <circle cx="225" cy="15" r="2.2" />
                            <circle cx="285" cy="38" r="2.5" />
                            <circle cx="340" cy="18" r="2.2" />
                            <circle cx="40" cy="40" r="1.8" fill="#4dd0e1" />
                            <circle cx="90" cy="44" r="1.8" fill="#4dd0e1" />
                            <circle cx="200" cy="45" r="1.8" fill="#4dd0e1" />
                        </g>
                    </svg>
                </div>
            </td>

            <!-- Right: Media Solusi Network Brand Logo -->
            <td class="header-right-col">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <!-- Logo Icon -->
                        <td style="width: 48px; vertical-align: middle; text-align: right; padding-right: 6px;">
                            <svg width="42" height="42" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Outer Geometric Hexagonal / M-N Shield Structure -->
                                <path d="M12 42V18L28 6L38 14V38L28 46L12 42Z" stroke="#0097a7" stroke-width="4.5" stroke-linejoin="round" fill="none" />
                                <path d="M48 18V42L32 54L22 46V22L32 14L48 18Z" stroke="#37474f" stroke-width="4.5" stroke-linejoin="round" fill="none" />
                                <!-- Inner Connected Nodes / House & Arrow -->
                                <path d="M24 30L30 25L36 30V37H24V30Z" fill="#00bcd4" />
                                <path d="M30 18V25" stroke="#00bcd4" stroke-width="3" stroke-linecap="round" />
                                <circle cx="30" cy="16" r="2.5" fill="#00bcd4" />
                            </svg>
                        </td>
                        <!-- Logo Typography -->
                        <td style="vertical-align: middle; text-align: left;">
                            <div style="font-size: 13pt; font-weight: 800; color: #0097a7; line-height: 1.05; letter-spacing: -0.2px;">
                                Media Solusi
                            </div>
                            <div style="font-size: 12.5pt; font-weight: 800; color: #37474f; line-height: 1.05; letter-spacing: -0.2px;">
                                Network
                            </div>
                            <div style="font-size: 5.8pt; font-weight: bold; color: #78909c; letter-spacing: 0.8px; margin-top: 1px;">
                                INTERNET SERVICE PROVIDER
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ── 2. INVOICE TITLE ── -->
    <div class="invoice-title-container">
        <div class="invoice-title-text">INVOICE</div>
        <div class="invoice-subtitle-text">TAGIHAN</div>
    </div>

    <!-- ── 3. CUSTOMER & INVOICE DETAILS ── -->
    <table class="info-container-table">
        <tr>
            <!-- Left: Customer Information -->
            <td class="info-customer-col">
                <div class="customer-name-heading">{{ $custName }}</div>
                <div class="customer-divider-line"></div>
                <div class="customer-address-text">
                    {{ $custAddress }}
                </div>
            </td>

            <!-- Right: Company & Invoice Info -->
            <td class="info-company-col">
                <div class="company-name-heading">PT MEDIA SOLUSI NETWORK</div>
                <table class="meta-kv-table">
                    <tr>
                        <td class="meta-kv-label">No tagihan</td>
                        <td class="meta-kv-sep">:</td>
                        <td class="meta-kv-value">{{ $invoice->invoice_number }}</td>
                    </tr>
                    <tr>
                        <td class="meta-kv-label">Nomor Pelanggan</td>
                        <td class="meta-kv-sep">:</td>
                        <td class="meta-kv-value">{{ $invoice->internet_number }}</td>
                    </tr>
                    <tr>
                        <td class="meta-kv-label">Periode Pemakaian</td>
                        <td class="meta-kv-sep">:</td>
                        <td class="meta-kv-value">{{ $periode }}</td>
                    </tr>
                    <tr>
                        <td class="meta-kv-label">Jatuh Tempo</td>
                        <td class="meta-kv-sep">:</td>
                        <td class="meta-kv-value">{{ $jatuhTempo }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ── 4. ITEM & AMOUNT TABLE ── -->
    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 59%; text-align: left;">Layanan</th>
                <th style="width: 12%; text-align: center;">Qty</th>
                <th style="width: 24%; text-align: right;">Tagihan</th>
            </tr>
        </thead>
        <tbody>
            <!-- Row 1: Item Detail -->
            <tr>
                <td style="text-align: center; height: 20px;">1</td>
                <td style="text-transform: uppercase;">
                    {{ $displayPackageName }}
                </td>
                <td style="text-align: center;">1</td>
                <td style="text-align: right;">
                    Rp {{ number_format($subtotal, 2, ',', '.') }}
                </td>
            </tr>

            <!-- Row 2: Potongan -->
            <tr>
                <td colspan="2" rowspan="2" style="vertical-align: top; padding: 5px;">
                    <div style="font-size: 8.5pt;">
                        <strong>Terbilang :</strong> {{ !empty($terbilang) ? $terbilang : '' }} Rupiah
                    </div>
                </td>
                <td style="text-align: right; font-size: 8pt; padding: 3px 6px;">POTONGAN</td>
                <td style="text-align: right; font-size: 8.5pt; padding: 3px 6px;">
                    {{ $discount > 0 ? 'Rp ' . number_format($discount, 2, ',', '.') : '0' }}
                </td>
            </tr>

            <!-- Row 3: PPN -->
            <tr>
                <td style="text-align: right; font-size: 8pt; padding: 3px 6px;">PPN</td>
                <td style="text-align: right; font-size: 8.5pt; padding: 3px 6px;">
                    Rp {{ number_format($ppn, 2, ',', '.') }}<br>
                    <span style="font-size: 7.5pt;">(include)</span>
                </td>
            </tr>

            <!-- Row 4: Tagihan Bulan Ini (Cyan Highlight) -->
            <tr>
                <td colspan="2" class="cell-cyan-tagihan" style="text-align: center; font-size: 8.5pt; text-transform: uppercase; letter-spacing: 0.5px; height: 20px;">
                    TAGIHAN BULAN INI
                </td>
                <td colspan="2" class="cell-cyan-tagihan" style="text-align: right; font-size: 9pt;">
                    Rp {{ number_format($total, 2, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- ── 5. SIGNATURES & PAYMENT SECTION ── -->
    <table class="sig-table">
        <thead>
            <tr>
                <th style="width: 34%;">Pembayaran</th>
                <th style="width: 33%;">Mengetahui</th>
                <th style="width: 33%;">Pelanggan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <!-- Col 1: Pembayaran Info -->
                <td style="text-align: center; vertical-align: middle; padding: 8px 12px;">
                    <div style="font-size: 8pt; line-height: 1.35;">
                        PEMBAYARAN : Bank BCA KCP Riau Bandung 086-0796023 an/ PT MEDIA SOLUSI NETWOR
                    </div>
                    <div style="font-size: 8pt; line-height: 1.35; margin-top: 4px;">
                        konfirmasi pembayaran kirim bukti TF ke nomor <strong>089508416636</strong>
                    </div>
                </td>

                <!-- Col 2: Mengetahui (Finance) -->
                <td style="text-align: center; vertical-align: bottom; padding: 8px 10px;">
                    <div style="font-size: 8.5pt; font-weight: normal; margin-bottom: 2px;">
                        {{ $adminName }}
                    </div>
                    <div style="border-top: 1px solid #000000; width: 140px; margin: 0 auto 3px auto;"></div>
                    <div style="font-size: 8.5pt; color: #000000;">Keuangan</div>
                </td>

                <!-- Col 3: Pelanggan -->
                <td style="text-align: center; vertical-align: bottom; padding: 8px 10px;">
                    <div style="font-size: 8.5pt; font-weight: normal; text-transform: uppercase; margin-bottom: 12px;">
                        {{ $custName }}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- ── 6. PERFORATED CUT DIVIDER ── -->
    <hr class="perforated-cut-line">

    <!-- ── 7. SLIP PEMBAYARAN ── -->
    <table class="slip-header-table">
        <tr>
            <td class="slip-company-name">PT. MEDIA SOLUSI NETWORK</td>
            <td class="slip-title">SLIP PEMBAYARAN</td>
        </tr>
    </table>

    <table class="slip-table">
        <tr>
            <td style="width: 50%;"><strong>Nomor Tagihan :</strong> {{ $invoice->invoice_number }}</td>
            <td style="width: 50%;"><strong>Periode Tagihan :</strong>{{ $periode }}</td>
        </tr>
        <tr>
            <td><strong>Nomor Pelanggan :</strong> {{ $invoice->internet_number }}</td>
            <td><strong>Jatuh Tempo :</strong> {{ $jatuhTempo }}</td>
        </tr>
        <tr>
            <td><strong>Nama Pelanggan :</strong> {{ strtoupper($custName) }}</td>
            <td><strong>Jumlah Tagihan :</strong> Rp {{ number_format($total, 2, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Slip Signatures -->
    <table class="slip-sig-table">
        <tr>
            <td>
                <div>Petugas</div>
                <div style="margin-top: 24px; font-weight: normal;">TTD / Nama</div>
            </td>
            <td>
                <div>Pelanggan</div>
                <div style="margin-top: 24px; font-weight: normal; text-transform: uppercase;">{{ $custName }}</div>
            </td>
        </tr>
    </table>

    <!-- Catatan -->
    <div class="slip-notes-heading">catatan :</div>
    <ul class="slip-notes-list">
        <li>Apabila pelanggan belum melakukan pembayaran sampai dengan jatuh tempo (Maksimal {{ $jatuhTempo }}), maka akan dilakukan pemutusan koneksi sementara terhitung mulai pukul 24.00 pada tanggal akhir periode sebelumnya.</li>
        <li>Untuk pelanggan yang melakukan pembayaran melalui <strong>Transfer Bank</strong>, mohon memberikan konfirmasi via Whatsapp ke nomor <strong>089508416636</strong> dengan mencantumkan bukti pembayaran.</li>
    </ul>

    <!-- ── 8. BOTTOM FOOTER BANNER ── -->
    <table class="footer-banner">
        <tr>
            <!-- Office -->
            <td style="width: 28%;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 16px; vertical-align: top; padding: 0;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="11" fill="#ffffff" />
                                <path d="M12 6C9.79 6 8 7.79 8 10C8 13 12 18 12 18C12 18 16 13 16 10C16 7.79 14.21 6 12 6ZM12 11.5C11.17 11.5 10.5 10.83 10.5 10C10.5 9.17 11.17 8.5 12 8.5C12.83 8.5 13.5 9.17 13.5 10C13.5 10.83 12.83 11.5 12 11.5Z" fill="#00a8b5" />
                            </svg>
                        </td>
                        <td style="vertical-align: top; padding-left: 3px;">
                            <span class="footer-label">OFFICE</span><br>
                            Jl Raya Leuwigajah No. 223 Kel. Utama, Kec. Cimahi Selatan, Kota Cimahi, 40533
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Operational -->
            <td style="width: 32%;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 16px; vertical-align: top; padding: 0;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="11" fill="#ffffff" />
                                <path d="M12 6C9.79 6 8 7.79 8 10C8 13 12 18 12 18C12 18 16 13 16 10C16 7.79 14.21 6 12 6ZM12 11.5C11.17 11.5 10.5 10.83 10.5 10C10.5 9.17 11.17 8.5 12 8.5C12.83 8.5 13.5 9.17 13.5 10C13.5 10.83 12.83 11.5 12 11.5Z" fill="#00a8b5" />
                            </svg>
                        </td>
                        <td style="vertical-align: top; padding-left: 3px;">
                            <span class="footer-label">OPERATIONAL</span><br>
                            Jl Kayu Agung II No 9, Kel. Turangga, Kec. Lengkong, Kota Bandung, 40264
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Telepon -->
            <td style="width: 21%;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 16px; vertical-align: top; padding: 0;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="11" fill="#ffffff" />
                                <path d="M6.62 10.79C8.06 13.62 10.38 15.94 13.21 17.38L15.41 15.18C15.69 14.9 16.08 14.82 16.43 14.93C17.55 15.3 18.75 15.5 20 15.5C20.55 15.5 21 15.95 21 16.5V20C21 20.55 20.55 21 20 21C10.61 21 3 13.39 3 4C3 3.45 3.45 3 4 3H7.5C8.05 3 8.5 3.45 8.5 4C8.5 5.25 8.7 6.45 9.07 7.57C9.18 7.92 9.1 8.31 8.82 8.59L6.62 10.79Z" fill="#00a8b5" />
                            </svg>
                        </td>
                        <td style="vertical-align: top; padding-left: 3px;">
                            022-3050-0111<br>
                            0852-2013-7627
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Web & Email -->
            <td style="width: 19%; text-align: left;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 16px; vertical-align: top; padding: 0;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="11" fill="#ffffff" />
                                <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM11 19.93C7.05 19.44 4 16.08 4 12C4 11.38 4.08 10.79 4.21 10.21L9 15V16C9 17.1 9.9 18 11 18V19.93ZM17.9 17.39C17.64 16.58 16.9 16 16 16H15V13C15 12.45 14.55 12 14 12H8V10H10C10.55 10 11 9.55 11 9V7H13C14.1 7 15 6.1 15 5V4.59C17.93 5.78 20 8.65 20 12C20 14.08 19.2 15.97 17.9 17.39Z" fill="#00a8b5" />
                            </svg>
                        </td>
                        <td style="vertical-align: top; padding-left: 3px;">
                            ptmsn.co.id<br>
                            info@ptmsn.co.id
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
