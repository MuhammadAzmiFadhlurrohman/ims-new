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

<div style="display: flex !important; flex-direction: row !important; align-items: stretch !important; gap: 12px !important; width: 100% !important; margin: 8px 0 14px 0 !important; padding: 0 1.5rem !important; box-sizing: border-box !important;">
    {{-- Card 1: Generating... Auto Publish (Yellow/Gold) --}}
    <div style="flex: 1 1 0 !important; min-width: 0 !important; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; border-radius: 8px !important; padding: 12px 14px !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25) !important;">
        <div style="font-size: 12px !important; font-weight: 700 !important; opacity: 0.95 !important; letter-spacing: 0.02em !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;">
            Generating... Auto Publish
        </div>
        <div style="font-size: 13px !important; font-weight: 800 !important; margin-top: 3px !important; letter-spacing: 0.01em !important; white-space: nowrap !important;">
            {{ $generatingCount }} User / Rp {{ number_format($generatingAmount, 2, ',', '.') }}
        </div>
    </div>

    {{-- Card 2: Publish Billing (Blue) --}}
    <div style="flex: 1 1 0 !important; min-width: 0 !important; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important; border-radius: 8px !important; padding: 12px 14px !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25) !important;">
        <div style="font-size: 12px !important; font-weight: 700 !important; opacity: 0.95 !important; letter-spacing: 0.02em !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;">
            Publish Billing
        </div>
        <div style="font-size: 13px !important; font-weight: 800 !important; margin-top: 3px !important; letter-spacing: 0.01em !important; white-space: nowrap !important;">
            {{ $publishCount }} User / Rp {{ number_format($publishAmount, 2, ',', '.') }}
        </div>
    </div>

    {{-- Card 3: Waiting Payment (Teal/Emerald) --}}
    <div style="flex: 1 1 0 !important; min-width: 0 !important; background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border-radius: 8px !important; padding: 12px 14px !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25) !important;">
        <div style="font-size: 12px !important; font-weight: 700 !important; opacity: 0.95 !important; letter-spacing: 0.02em !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;">
            Waiting Payment
        </div>
        <div style="font-size: 13px !important; font-weight: 800 !important; margin-top: 3px !important; letter-spacing: 0.01em !important; white-space: nowrap !important;">
            {{ $waitingCount }} User / Rp {{ number_format($waitingAmount, 2, ',', '.') }}
        </div>
    </div>

    {{-- Card 4: Paid (Rose/Red) --}}
    <div style="flex: 1 1 0 !important; min-width: 0 !important; background: linear-gradient(135deg, #f87171 0%, #ef4444 100%) !important; border-radius: 8px !important; padding: 12px 14px !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(248, 113, 113, 0.25) !important;">
        <div style="font-size: 12px !important; font-weight: 700 !important; opacity: 0.95 !important; letter-spacing: 0.02em !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;">
            Paid
        </div>
        <div style="font-size: 13px !important; font-weight: 800 !important; margin-top: 3px !important; letter-spacing: 0.01em !important; white-space: nowrap !important;">
            {{ $paidCount }} User / Rp {{ number_format($paidAmount, 2, ',', '.') }}
        </div>
    </div>
</div>
