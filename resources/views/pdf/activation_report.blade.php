<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Berita Acara Aktivasi - {{ $subscription->internet_number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { border-bottom: 2px solid #0284c7; padding-bottom: 10px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $company_name }}</h2>
        <h3>Berita Acara Aktivasi &amp; Penyerahan Perangkat FTTH</h3>
    </div>

    <p><strong>Nomor Internet:</strong> {{ $subscription->internet_number }}</p>
    <p><strong>Nama Pelanggan:</strong> {{ $subscription->customer_name }}</p>
    <p><strong>Paket Bandwidth:</strong> {{ $subscription->package_code }}</p>
    <p><strong>ODP &amp; Port:</strong> {{ $subscription->odp_code ?? '-' }} (Port: {{ $subscription->odp_port ?? '-' }})</p>
    <p><strong>PPPoE Profile:</strong> {{ $subscription->pppoe_profile ?? '-' }}</p>

    <p>Dengan ini menyatakan bahwa layanan internet telah aktif dan perangkat dalam kondisi baik.</p>
</body>
</html>
