<div class="ims-sidebar-footer">
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
        <div class="ims-sidebar-footer-card">
            <div style="display: flex; align-items: center; gap: 9px;">
                <span style="position: relative; display: flex; width: 9px; height: 9px;">
                    <span style="position: absolute; display: inline-flex; width: 100%; height: 100%; border-radius: 50%; background: #10b981; opacity: 0.75; animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;"></span>
                    <span style="position: relative; display: inline-flex; width: 9px; height: 9px; border-radius: 50%; background: #10b981; box-shadow: 0 0 8px #10b981;"></span>
                </span>
                <span class="ims-sidebar-footer-status">Sistem Online</span>
            </div>
            <span class="ims-sidebar-footer-version">v2.4.0</span>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 2px; padding: 0 4px;">
            <span class="ims-sidebar-footer-copy">&copy; {{ date('Y') }} IMS ONE</span>
            <span class="ims-sidebar-footer-subcopy">All Rights Reserved</span>
        </div>
    </div>

    {{-- Collapsed State --}}
    <div x-show="! $store.sidebar.isOpen" style="display: flex; align-items: center; justify-content: center; padding: 4px 0;">
        <div class="ims-sidebar-footer-collapsed-dot" title="IMS ONE Online - v2.4.0">
            <span style="position: relative; display: flex; width: 9px; height: 9px;">
                <span style="position: absolute; display: inline-flex; width: 100%; height: 100%; border-radius: 50%; background: #10b981; opacity: 0.75; animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;"></span>
                <span style="position: relative; display: inline-flex; width: 9px; height: 9px; border-radius: 50%; background: #10b981; box-shadow: 0 0 8px #10b981;"></span>
            </span>
        </div>
    </div>
</div>



