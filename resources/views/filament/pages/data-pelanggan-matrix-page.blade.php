<x-filament-panels::page>
    <style>
        .matrix-page-wrapper {
            display: flex;
            flex-direction: column;
            gap: 24px;
            padding-bottom: 40px;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        .matrix-section-title {
            font-size: 13.5px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
            padding-left: 2px;
        }

        .matrix-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        @media (max-width: 1100px) {
            .matrix-cards-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .matrix-cards-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 480px) {
            .matrix-cards-grid {
                grid-template-columns: 1fr;
            }
        }

        .matrix-item-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06), 0 2px 8px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(226, 232, 240, 0.8);
            padding: 14px 16px;
            min-height: 96px;
            text-decoration: none;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .matrix-item-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        /* Pill Badges */
        .matrix-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            color: #ffffff !important;
            line-height: 1.3;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .matrix-badge-aktif {
            background-color: #00bcd4 !important; /* Bright Cyan */
        }

        .matrix-badge-terminasi {
            background-color: #f43f5e !important; /* Bright Rose Pink */
        }

        .matrix-badge-suspend {
            background-color: #f59e0b !important; /* Bright Amber Orange */
        }

        .matrix-badge-gagal {
            background-color: #64748b !important; /* Slate */
        }

        .matrix-count-row {
            margin-top: 14px;
            font-size: 19px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .matrix-count-unit {
            font-size: 13.5px;
            font-weight: 500;
            color: #475569;
            margin-left: 2px;
        }

        /* Dark Mode Overrides */
        html.dark .matrix-section-title {
            color: #ffffff !important;
        }

        html.dark .matrix-item-card {
            background: #08192e !important;
            border-color: #14355a !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3) !important;
        }

        html.dark .matrix-item-card:hover {
            background: #0c2442 !important;
            border-color: #00d4ff !important;
        }

        html.dark .matrix-count-row {
            color: #ffffff !important;
        }

        html.dark .matrix-count-unit {
            color: #94a3b8 !important;
        }
    </style>

    <div class="matrix-page-wrapper">

        {{-- ── 1. SECTION: AKTIF ───────────────────────────────────── --}}
        <div>
            <div class="matrix-section-title">Aktif</div>
            
            <div class="matrix-cards-grid">
                @foreach($categories as $cat)
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=aktif&filter_category=' . $cat->code) }}" 
                       class="matrix-item-card">
                        <span class="matrix-badge matrix-badge-aktif">
                            {{ $cat->name }}
                        </span>
                        <div class="matrix-count-row">
                            {{ $aktifCounts[$cat->code] ?? 0 }} <span class="matrix-count-unit">User</span>
                        </div>
                    </a>
                @endforeach

                {{-- Total Aktif --}}
                <a href="{{ url('/admin/customer-subscriptions?filter_status=aktif') }}" 
                   class="matrix-item-card">
                    <span class="matrix-badge matrix-badge-aktif">
                        Total
                    </span>
                    <div class="matrix-count-row">
                        {{ $totalAktif }} <span class="matrix-count-unit">User</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- ── 2. SECTION: TERMINASI ───────────────────────────────── --}}
        <div>
            <div class="matrix-section-title">Terminasi</div>
            
            <div class="matrix-cards-grid">
                @foreach($categories as $cat)
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=terminasi&filter_category=' . $cat->code) }}" 
                       class="matrix-item-card">
                        <span class="matrix-badge matrix-badge-terminasi">
                            {{ $cat->name }}
                        </span>
                        <div class="matrix-count-row">
                            {{ $terminasiCounts[$cat->code] ?? 0 }} <span class="matrix-count-unit">User</span>
                        </div>
                    </a>
                @endforeach

                {{-- Total Terminasi --}}
                <a href="{{ url('/admin/customer-subscriptions?filter_status=terminasi') }}" 
                   class="matrix-item-card">
                    <span class="matrix-badge matrix-badge-terminasi">
                        Total
                    </span>
                    <div class="matrix-count-row">
                        {{ $totalTerminasi }} <span class="matrix-count-unit">User</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- ── 3. SECTION: SUSPEND ─────────────────────────────────── --}}
        <div>
            <div class="matrix-section-title">Suspend</div>
            
            <div class="matrix-cards-grid">
                @foreach($categories as $cat)
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=suspend&filter_category=' . $cat->code) }}" 
                       class="matrix-item-card">
                        <span class="matrix-badge matrix-badge-suspend">
                            {{ $cat->name }}
                        </span>
                        <div class="matrix-count-row">
                            {{ $suspendCounts[$cat->code] ?? 0 }} <span class="matrix-count-unit">User</span>
                        </div>
                    </a>
                @endforeach

                {{-- Total Suspend --}}
                <a href="{{ url('/admin/customer-subscriptions?filter_status=suspend') }}" 
                   class="matrix-item-card">
                    <span class="matrix-badge matrix-badge-suspend">
                        Total
                    </span>
                    <div class="matrix-count-row">
                        {{ $totalSuspend }} <span class="matrix-count-unit">User</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- ── 4. SECTION: GAGAL PASANG ───────────────────────────── --}}
        <div>
            <div class="matrix-section-title">Gagal Pasang</div>
            
            <div class="matrix-cards-grid">
                @foreach($categories as $cat)
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=gagal&filter_category=' . $cat->code) }}" 
                       class="matrix-item-card">
                        <span class="matrix-badge matrix-badge-gagal">
                            {{ $cat->name }}
                        </span>
                        <div class="matrix-count-row">
                            {{ $gagalCounts[$cat->code] ?? 0 }} <span class="matrix-count-unit">User</span>
                        </div>
                    </a>
                @endforeach

                {{-- Total Gagal --}}
                <a href="{{ url('/admin/customer-subscriptions?filter_status=gagal') }}" 
                   class="matrix-item-card">
                    <span class="matrix-badge matrix-badge-gagal">
                        Total
                    </span>
                    <div class="matrix-count-row">
                        {{ $totalGagal }} <span class="matrix-count-unit">User</span>
                    </div>
                </a>
            </div>
        </div>

    </div>
</x-filament-panels::page>


