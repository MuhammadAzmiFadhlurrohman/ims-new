<div class="ims-sidebar-footer" style="padding: 12px 14px !important; margin-top: auto !important; flex-shrink: 0 !important; background: #030d1a !important; border-top: 1px solid rgba(255, 255, 255, 0.1) !important;">
    {{-- Open State --}}
    <div x-show="$store.sidebar.isOpen" style="display: flex; flex-direction: column; gap: 8px;">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 7px 10px; border-radius: 10px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500 shadow-sm shadow-emerald-400"></span>
                </span>
                <span style="font-size: 11px !important; font-weight: 700 !important; color: #ffffff !important; letter-spacing: 0.02em;">Sistem Online</span>
            </div>
            <span style="font-size: 10px !important; font-family: monospace !important; font-weight: 800 !important; color: #38bdf8 !important; background: rgba(56, 189, 248, 0.15) !important; padding: 2px 7px !important; border-radius: 6px !important; border: 1px solid rgba(56, 189, 248, 0.35) !important;">v2.4.0</span>
        </div>
        
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0 4px; font-size: 10.5px !important; font-weight: 600 !important;">
            <span style="color: #cbd5e1 !important;">&copy; {{ date('Y') }} IMS ONE</span>
            <span style="color: #64748b !important;">All Rights Reserved</span>
        </div>
    </div>

    {{-- Collapsed State --}}
    <div x-show="! $store.sidebar.isOpen" style="display: flex; align-items: center; justify-content: center; padding: 6px 0;">
        <span class="relative flex h-3 w-3" title="IMS ONE Online - v2.4.0">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 shadow-md shadow-emerald-400"></span>
        </span>
    </div>
</div>
