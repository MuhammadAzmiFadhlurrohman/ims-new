<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Perintah Kerja - {{ $pipeline->code }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 15px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #ccc; padding: 6px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $company_name }}</h2>
        <h3>Surat Perintah Kerja (SPK) Survei &amp; Pemasangan FTTH</h3>
    </div>

    <p><strong>No. SPK:</strong> {{ $pipeline->code }}</p>
    <p><strong>No. Internet:</strong> {{ $pipeline->internet_number }}</p>
    <p><strong>Nama Pelanggan:</strong> {{ $pipeline->subscription->customer_name ?? '-' }}</p>
    <p><strong>Alamat Pemasangan:</strong> {{ $pipeline->subscription->installation_address ?? '-' }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Tahapan Pipeline</th>
                <th>Jadwal / Tim</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Survei Lokasi</td>
                <td>{{ $pipeline->survey_scheduled_at }} / {{ $pipeline->survey_team }}</td>
                <td>{{ $pipeline->survey_note ?? '-' }}</td>
            </tr>
            <tr>
                <td>Instalasi Dropcore</td>
                <td>{{ $pipeline->installation_scheduled_at }} / {{ $pipeline->installation_team }}</td>
                <td>{{ $pipeline->installation_note ?? '-' }}</td>
            </tr>
            <tr>
                <td>Aktivasi ONT</td>
                <td>{{ $pipeline->activation_scheduled_at }} / {{ $pipeline->activation_team }}</td>
                <td>{{ $pipeline->activation_note ?? '-' }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
