<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>INVOICE REGISTRASI - {{ $invoice->invoice_number }}</title>
    <style>
        @page {
            margin: 20px 25px;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9pt;
            color: #1e293b;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .invoice-title {
            font-size: 16pt;
            font-weight: 900;
            color: #0284c7;
            text-align: right;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .meta-box {
            border: 1px solid #cbd5e1;
            padding: 10px;
            border-radius: 4px;
        }
        .main-table {
            width: 100%;
            border: 1px solid #cbd5e1;
            margin-bottom: 15px;
        }
        .main-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: bold;
            padding: 6px 8px;
            font-size: 9pt;
        }
        .main-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 9pt;
        }
        .total-row td {
            background-color: #f1f5f9;
            font-weight: bold;
        }
        .footer-note {
            font-size: 8pt;
            color: #64748b;
            margin-top: 20px;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    @php
        $custName = $subscription->customer_name ?? ($customer->name ?? 'PELANGGAN');
        $custAddress = $subscription->installation_address ?? ($customer->address ?? '-');
        $packageName = $subscription->package->name ?? 'INTERNET BROADBAND';
    @endphp

    <table class="header-table">
        <tr>
            <td style="width: 50%; vertical-align: middle;">
                <div style="font-size: 14pt; font-weight: 900; color: #0284c7;">PT MEDIA SOLUSI NETWORK</div>
                <div style="font-size: 8pt; color: #64748b;">Integrated Internet Service Provider</div>
            </td>
            <td style="width: 50%; vertical-align: middle; text-align: right;">
                <div class="invoice-title">INVOICE REGISTRASI</div>
                <div style="font-size: 9pt; font-weight: bold; color: #334155;">{{ $invoice->invoice_number }}</div>
            </td>
        </tr>
    </table>

    <table class="meta-table">
        <tr>
            <td style="width: 48%; vertical-align: top;">
                <div class="meta-box">
                    <strong style="color: #0f172a;">DITAGIHKAN KEPADA:</strong><br>
                    <div style="font-size: 10pt; font-weight: bold; margin-top: 3px;">{{ strtoupper($custName) }}</div>
                    <div style="font-size: 8.5pt; color: #475569; margin-top: 2px;">{{ $custAddress }}</div>
                    <div style="font-size: 8.5pt; color: #475569;">No. Layanan: <strong>{{ $invoice->internet_number }}</strong></div>
                </div>
            </td>
            <td style="width: 4%;"></td>
            <td style="width: 48%; vertical-align: top;">
                <div class="meta-box">
                    <strong style="color: #0f172a;">INFORMASI INVOICE:</strong><br>
                    <table style="width: 100%; font-size: 8.5pt; margin-top: 3px;">
                        <tr>
                            <td style="width: 45%;">Tanggal Terbit</td>
                            <td style="width: 5%;">:</td>
                            <td>{{ $invoice->created_at ? $invoice->created_at->format('d M Y') : date('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td>Status Pembayaran</td>
                            <td>:</td>
                            <td><strong style="color: {{ $invoice->payment_status === 'PAID' ? '#16a34a' : '#ea580c' }}">{{ $invoice->payment_status ?? 'UNPAID' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Metode Pembayaran</td>
                            <td>:</td>
                            <td>{{ $invoice->payment_method ?? 'Midtrans' }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">No</th>
                <th style="text-align: left;">Deskripsi Layanan</th>
                <th style="width: 12%; text-align: center;">Qty</th>
                <th style="width: 25%; text-align: right;">Biaya</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">1</td>
                <td>
                    <strong>Biaya Registrasi &amp; Pemasangan Awal</strong><br>
                    <span style="font-size: 8pt; color: #64748b;">Paket Berlangganan: {{ $packageName }}</span>
                </td>
                <td style="text-align: center;">1</td>
                <td style="text-align: right;">Rp {{ number_format($subtotal, 2, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" style="text-align: right;">TOTAL TAGIHAN REGISTRASI</td>
                <td style="text-align: right; color: #0284c7; font-size: 10pt;">Rp {{ number_format($total, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="font-size: 8.5pt; margin-top: 10px;">
        <strong>Terbilang:</strong> {{ $terbilang }} Rupiah
    </div>

    <div class="footer-note">
        <strong>PT MEDIA SOLUSI NETWORK</strong> &bull; Jl Raya Leuwigajah No. 223 Kel. Utama, Kec. Cimahi Selatan, Kota Cimahi &bull; Telp: 022-3050-0111
    </div>

</body>
</html>
