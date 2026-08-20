<div class="ims-sidebar-footer" style="padding: 12px 14px; margin-top: auto; flex-shrink: 0; background: #030d1c; border-top: 1px solid rgba(255, 255, 255, 0.06);">
    {{-- Open State --}}
    <div
        x-show="$store.sidebar.isOpen"
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        style="display: flex; flex-direction: column; gap: 10px;"
    >
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; border-radius: 12px; background: #07172c; border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);">
            <div style="display: flex; align-items: center; gap: 9px;">
                <span style="position: relative; display: flex; width: 9px; height: 9px;">
                    <span style="position: absolute; display: inline-flex; width: 100%; height: 100%; border-radius: 50%; background: #10b981; opacity: 0.75; animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;"></span>
                    <span style="position: relative; display: inline-flex; width: 9px; height: 9px; border-radius: 50%; background: #10b981; box-shadow: 0 0 8px #10b981;"></span>
                </span>
                <span style="font-size: 12px; font-weight: 600; color: #ffffff; letter-spacing: 0.01em;">Sistem Online</span>
            </div>
            <span style="font-size: 11px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-weight: 700; color: #38bdf8; background: #08294f; padding: 3px 10px; border-radius: 7px; border: 1px solid #0c4d87;">v2.4.0</span>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 2px; padding: 0 4px;">
            <span style="font-size: 11px; font-weight: 600; color: #8899ac;">&copy; {{ date('Y') }} IMS ONE</span>
            <span style="font-size: 10px; font-weight: 400; color: #556677;">All Rights Reserved</span>
        </div>
    </div>

    {{-- Collapsed State --}}
    <div x-show="! $store.sidebar.isOpen" style="display: flex; align-items: center; justify-content: center; padding: 4px 0;">
        <div style="display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 9px; background: #07172c; border: 1px solid rgba(255, 255, 255, 0.08);" title="IMS ONE Online - v2.4.0">
            <span style="position: relative; display: flex; width: 9px; height: 9px;">
                <span style="position: absolute; display: inline-flex; width: 100%; height: 100%; border-radius: 50%; background: #10b981; opacity: 0.75; animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;"></span>
                <span style="position: relative; display: inline-flex; width: 9px; height: 9px; border-radius: 50%; background: #10b981; box-shadow: 0 0 8px #10b981;"></span>
            </span>
        </div>
    </div>
</div>



