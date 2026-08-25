{{-- IMS ONE - Universal SweetAlert2 Blade Component --}}
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/ims-sweetalert.css') }}">
<script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert2/ims-sweetalert.js') }}"></script>

{{-- Flash Data for Automatic SweetAlert Trigger --}}
@php
    $flashData = [];
    if (session('success')) $flashData['success'] = session('success');
    if (session('error')) $flashData['error'] = session('error');
    if (session('info')) $flashData['info'] = session('info');
    if (session('warning')) $flashData['warning'] = session('warning');
    if (session('session_expired')) $flashData['session_expired'] = session('session_expired');
    if (session('ticket_created')) $flashData['ticket_created'] = session('ticket_created');
    if (session('status')) $flashData['info'] = session('status');
@endphp

@if(!empty($flashData))
    <script id="ims-flash-data" type="application/json">
        {!! json_encode($flashData) !!}
    </script>
@endif
