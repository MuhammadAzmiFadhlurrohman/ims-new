@php
    $data = \App\Filament\Widgets\BillingSummaryHeaderWidget::getViewDataStatic();
    $generatingCount = $generatingCount ?? $data['generatingCount'];
    $generatingAmount = $generatingAmount ?? $data['generatingAmount'];
    $publishCount = $publishCount ?? $data['publishCount'];
    $publishAmount = $publishAmount ?? $data['publishAmount'];
    $waitingCount = $waitingCount ?? $data['waitingCount'];
    $waitingAmount = $waitingAmount ?? $data['waitingAmount'];
    $paidCount = $paidCount ?? $data['paidCount'];
    $paidAmount = $paidAmount ?? $data['paidAmount'];
@endphp

<style>
.ims-billing-summary-container {
    display: grid !important;
    grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
    gap: 12px !important;
    width: 100% !important;
    margin: 8px 0 14px 0 !important;
    padding: 0 1.5rem !important;
    box-sizing: border-box !important;
}
.ims-billing-card {
    min-width: 0 !important;
    border-radius: 12px !important;
    padding: 12px 14px !important;
    color: #ffffff !important;
    box-sizing: border-box !important;
    transition: transform 0.15s ease, box-shadow 0.15s ease !important;
}
.ims-billing-card:hover {
    transform: translateY(-2px) !important;
}
.ims-billing-card-title {
    font-size: 12px !important;
    font-weight: 700 !important;
    opacity: 0.95 !important;
    letter-spacing: 0.02em !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}
.ims-billing-card-value {
    font-size: 13px !important;
    font-weight: 800 !important;
    margin-top: 3px !important;
    letter-spacing: 0.01em !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}

@media (max-width: 1023px) {
    .ims-billing-summary-container {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 8px !important;
        padding: 0 0.5rem !important;
        margin: 6px 0 12px 0 !important;
    }
    .ims-billing-card {
        padding: 10px 12px !important;
        border-radius: 10px !important;
    }
    .ims-billing-card-title {
        font-size: 11.5px !important;
    }
    .ims-billing-card-value {
        font-size: 12px !important;
    }
}
@media (max-width: 479px) {
    .ims-billing-summary-container {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 6px !important;
        padding: 0 !important;
    }
    .ims-billing-card {
        padding: 8px 10px !important;
    }
    .ims-billing-card-title {
        font-size: 10.5px !important;
    }
    .ims-billing-card-value {
        font-size: 11px !important;
    }
}
</style>

<div class="ims-billing-summary-container">
    {{-- Card 1: Generating... Auto Publish (Yellow/Gold) --}}
    <div class="ims-billing-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25) !important;">
        <div class="ims-billing-card-title">
            Generating... Auto Publish
        </div>
        <div class="ims-billing-card-value">
            {{ $generatingCount }} User / Rp {{ number_format($generatingAmount, 2, ',', '.') }}
        </div>
    </div>

    {{-- Card 2: Publish Billing (Blue) --}}
    <div class="ims-billing-card" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25) !important;">
        <div class="ims-billing-card-title">
            Publish Billing
        </div>
        <div class="ims-billing-card-value">
            {{ $publishCount }} User / Rp {{ number_format($publishAmount, 2, ',', '.') }}
        </div>
    </div>

    {{-- Card 3: Waiting Payment (Teal/Emerald) --}}
    <div class="ims-billing-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25) !important;">
        <div class="ims-billing-card-title">
            Waiting Payment
        </div>
        <div class="ims-billing-card-value">
            {{ $waitingCount }} User / Rp {{ number_format($waitingAmount, 2, ',', '.') }}
        </div>
    </div>

    {{-- Card 4: Paid (Rose/Red) --}}
    <div class="ims-billing-card" style="background: linear-gradient(135deg, #f87171 0%, #ef4444 100%) !important; box-shadow: 0 4px 12px rgba(248, 113, 113, 0.25) !important;">
        <div class="ims-billing-card-title">
            Paid
        </div>
        <div class="ims-billing-card-value">
            {{ $paidCount }} User / Rp {{ number_format($paidAmount, 2, ',', '.') }}
        </div>
    </div>
</div>
