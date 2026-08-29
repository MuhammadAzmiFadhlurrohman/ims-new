<x-filament-panels::page>
    @if(!request()->has('category'))
        @php
            $counts = $this->getCounts();
            $totalActive = array_sum($counts);
        @endphp

        <style>
            /* ── HIDE DEFAULT FILAMENT HEADER ON PORTAL ── */
            .fi-header {
                display: none !important;
            }

            /* ── TICKET PORTAL EXECUTIVE STYLES ── */
            .ims-ticket-container {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
                animation: imsTicketFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
            }

            @keyframes imsTicketFadeIn {
                from { opacity: 0; transform: translateY(12px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes imsPulseGreen {
                0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
                70% { transform: scale(1.05); box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
                100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
            }

            /* ── HERO BANNER ── */
            .ims-ticket-hero {
                position: relative;
                overflow: hidden;
                border-radius: 20px;
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f172a 100%);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.25);
                padding: 1.75rem 2rem;
                color: #ffffff;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 1.5rem;
            }

            .ims-ticket-hero::after {
                content: '';
                position: absolute;
                top: -50%;
                right: -10%;
                width: 380px;
                height: 380px;
                background: radial-gradient(circle, rgba(56, 189, 248, 0.15) 0%, rgba(56, 189, 248, 0) 70%);
                pointer-events: none;
            }

            .ims-ticket-hero-left {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
                z-index: 1;
                max-width: 620px;
            }

            .ims-ticket-live-pill {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background: rgba(34, 197, 94, 0.15);
                border: 1px solid rgba(34, 197, 94, 0.35);
                color: #4ade80;
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                width: fit-content;
            }

            .ims-live-dot {
                width: 8px;
                height: 8px;
                background-color: #22c55e;
                border-radius: 50%;
                display: inline-block;
                animation: imsPulseGreen 2s infinite;
            }

            .ims-ticket-hero-title {
                font-size: 1.45rem;
                font-weight: 900;
                letter-spacing: -0.02em;
                color: #ffffff;
                margin: 0;
                line-height: 1.25;
            }

            .ims-ticket-hero-desc {
                font-size: 0.84rem;
                color: #94a3b8;
                line-height: 1.5;
                margin: 0;
            }

            .ims-ticket-hero-right {
                display: flex;
                align-items: center;
                gap: 0.85rem;
                z-index: 1;
                flex-wrap: wrap;
            }

            .ims-ticket-stat-box {
                background: rgba(255, 255, 255, 0.06);
                border: 1px solid rgba(255, 255, 255, 0.12);
                backdrop-filter: blur(8px);
                border-radius: 14px;
                padding: 0.75rem 1.25rem;
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                min-width: 130px;
            }

            .ims-ticket-stat-val {
                font-size: 1.75rem;
                font-weight: 900;
                color: #38bdf8;
                line-height: 1;
            }

            .ims-ticket-stat-lbl {
                font-size: 0.68rem;
                font-weight: 700;
                color: #cbd5e1;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-top: 0.2rem;
            }

            .ims-btn-action-all {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background: linear-gradient(135deg, #0284c7 0%, #0050d8 100%);
                color: #ffffff !important;
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 12px;
                padding: 0.75rem 1.25rem;
                font-size: 0.82rem;
                font-weight: 800;
                text-decoration: none !important;
                box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .ims-btn-action-all:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(2, 132, 199, 0.5);
                background: linear-gradient(135deg, #0369a1 0%, #003db3 100%);
            }

            /* ── GRID SYSTEM ── */
            .ims-ticket-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
                gap: 1.25rem;
            }

            /* ── LUXURY EXECUTIVE TICKET CARDS ── */
            .ims-ticket-card {
                position: relative;
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 18px;
                padding: 1.4rem 1.5rem;
                text-decoration: none !important;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                gap: 1.15rem;
                box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.05);
                transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
                overflow: hidden;
                cursor: pointer;
            }

            .ims-ticket-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                transition: height 0.25s ease;
            }

            .ims-ticket-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 16px 32px -4px rgba(15, 23, 42, 0.12);
                border-color: #cbd5e1;
            }

            .ims-ticket-card:hover::before {
                height: 6px;
            }

            /* Card Accents & Stat Box Focus */
            .ims-card-count-focus {
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                justify-content: center;
                padding: 0.35rem 0.85rem;
                border-radius: 12px;
                min-width: 80px;
                text-align: right;
                transition: all 0.2s ease;
            }

            .ims-count-number {
                font-size: 1.75rem;
                font-weight: 900;
                line-height: 1;
                font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;
                letter-spacing: -0.03em;
            }

            .ims-count-unit {
                font-size: 0.62rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-top: 3px;
                opacity: 0.9;
            }

            .ims-card-gangguan::before { background: linear-gradient(90deg, #e11d48, #f43f5e); }
            .ims-card-gangguan:hover { border-color: #fca5a5; }
            .ims-card-gangguan .ims-card-icon-wrap { background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6; }
            .ims-card-gangguan .ims-card-count-focus { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
            .ims-card-gangguan:hover .ims-card-arrow { color: #e11d48; }

            .ims-card-password::before { background: linear-gradient(90deg, #4f46e5, #6366f1); }
            .ims-card-password:hover { border-color: #c7d2fe; }
            .ims-card-password .ims-card-icon-wrap { background: #eef2ff; color: #4f46e5; border: 1px solid #e0e7ff; }
            .ims-card-password .ims-card-count-focus { background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; }
            .ims-card-password:hover .ims-card-arrow { color: #4f46e5; }

            .ims-card-coverage::before { background: linear-gradient(90deg, #059669, #10b981); }
            .ims-card-coverage:hover { border-color: #a7f3d0; }
            .ims-card-coverage .ims-card-icon-wrap { background: #ecfdf5; color: #059669; border: 1px solid #d1fae5; }
            .ims-card-coverage .ims-card-count-focus { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
            .ims-card-coverage:hover .ims-card-arrow { color: #059669; }

            .ims-card-terminasi::before { background: linear-gradient(90deg, #475569, #64748b); }
            .ims-card-terminasi:hover { border-color: #cbd5e1; }
            .ims-card-terminasi .ims-card-icon-wrap { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }
            .ims-card-terminasi .ims-card-count-focus { background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }
            .ims-card-terminasi:hover .ims-card-arrow { color: #475569; }

            .ims-card-suspend::before { background: linear-gradient(90deg, #d97706, #f59e0b); }
            .ims-card-suspend:hover { border-color: #fde68a; }
            .ims-card-suspend .ims-card-icon-wrap { background: #fffbeb; color: #d97706; border: 1px solid #fef3c7; }
            .ims-card-suspend .ims-card-count-focus { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
            .ims-card-suspend:hover .ims-card-arrow { color: #d97706; }

            .ims-card-psb::before { background: linear-gradient(90deg, #0284c7, #38bdf8); }
            .ims-card-psb:hover { border-color: #bae6fd; }
            .ims-card-psb .ims-card-icon-wrap { background: #f0f9ff; color: #0284c7; border: 1px solid #e0f2fe; }
            .ims-card-psb .ims-card-count-focus { background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; }
            .ims-card-psb:hover .ims-card-arrow { color: #0284c7; }

            .ims-card-mutasi::before { background: linear-gradient(90deg, #7c3aed, #8b5cf6); }
            .ims-card-mutasi:hover { border-color: #ddd6fe; }
            .ims-card-mutasi .ims-card-icon-wrap { background: #f5f3ff; color: #7c3aed; border: 1px solid #ede9fe; }
            .ims-card-mutasi .ims-card-count-focus { background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }
            .ims-card-mutasi:hover .ims-card-arrow { color: #7c3aed; }

            /* Card Content Layout */
            .ims-card-top {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 0.75rem;
            }

            .ims-card-icon-wrap {
                width: 46px;
                height: 46px;
                border-radius: 13px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                transition: transform 0.2s ease;
            }

            .ims-ticket-card:hover .ims-card-icon-wrap {
                transform: scale(1.06);
            }

            .ims-card-middle {
                display: flex;
                flex-direction: column;
                gap: 0.35rem;
            }

            .ims-card-title {
                font-size: 1.12rem;
                font-weight: 900;
                color: #0f172a;
                letter-spacing: -0.02em;
                margin: 0;
                line-height: 1.25;
            }

            .ims-card-desc {
                font-size: 0.78rem;
                color: #64748b;
                line-height: 1.45;
                font-weight: 500;
                margin: 0;
            }

            .ims-card-bottom {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding-top: 0.85rem;
                border-top: 1px solid #f1f5f9;
                font-size: 0.78rem;
                font-weight: 700;
                color: #64748b;
            }

            .ims-card-arrow {
                display: inline-flex;
                align-items: center;
                gap: 0.35rem;
                font-weight: 800;
                transition: transform 0.2s ease, color 0.2s ease;
            }

            .ims-ticket-card:hover .ims-card-arrow {
                transform: translateX(4px);
            }

            /* ── DARK MODE OVERRIDES FOR TICKET PORTAL ── */
            html.dark .ims-ticket-card {
                background: #08192e !important;
                border-color: #14355a !important;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4) !important;
            }

            html.dark .ims-ticket-card:hover {
                background: #0c2442 !important;
                border-color: #00d4ff !important;
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6) !important;
            }

            html.dark .ims-card-title {
                color: #ffffff !important;
            }

            html.dark .ims-card-desc {
                color: #94a3b8 !important;
            }

            html.dark .ims-card-bottom {
                border-top-color: #14355a !important;
                color: #cbd5e1 !important;
            }

            html.dark .ims-card-gangguan .ims-card-icon-wrap { background: rgba(225, 29, 72, 0.15) !important; color: #fb7185 !important; border-color: rgba(225, 29, 72, 0.3) !important; }
            html.dark .ims-card-gangguan .ims-card-count-focus { background: rgba(225, 29, 72, 0.2) !important; color: #fda4af !important; border-color: rgba(225, 29, 72, 0.35) !important; }

            html.dark .ims-card-password .ims-card-icon-wrap { background: rgba(99, 102, 241, 0.15) !important; color: #a5b4fc !important; border-color: rgba(99, 102, 241, 0.3) !important; }
            html.dark .ims-card-password .ims-card-count-focus { background: rgba(99, 102, 241, 0.2) !important; color: #c7d2fe !important; border-color: rgba(99, 102, 241, 0.35) !important; }

            html.dark .ims-card-coverage .ims-card-icon-wrap { background: rgba(16, 185, 129, 0.15) !important; color: #6ee7b7 !important; border-color: rgba(16, 185, 129, 0.3) !important; }
            html.dark .ims-card-coverage .ims-card-count-focus { background: rgba(16, 185, 129, 0.2) !important; color: #a7f3d0 !important; border-color: rgba(16, 185, 129, 0.35) !important; }

            html.dark .ims-card-psb .ims-card-icon-wrap { background: rgba(14, 165, 233, 0.15) !important; color: #7dd3fc !important; border-color: rgba(14, 165, 233, 0.3) !important; }
            html.dark .ims-card-psb .ims-card-count-focus { background: rgba(14, 165, 233, 0.2) !important; color: #bae6fd !important; border-color: rgba(14, 165, 233, 0.35) !important; }

            html.dark .ims-card-mutasi .ims-card-icon-wrap { background: rgba(168, 85, 247, 0.15) !important; color: #d8b4fe !important; border-color: rgba(168, 85, 247, 0.3) !important; }
            html.dark .ims-card-mutasi .ims-card-count-focus { background: rgba(168, 85, 247, 0.2) !important; color: #e9d5ff !important; border-color: rgba(168, 85, 247, 0.35) !important; }

            html.dark .ims-card-suspend .ims-card-icon-wrap { background: rgba(245, 158, 11, 0.15) !important; color: #fcd34d !important; border-color: rgba(245, 158, 11, 0.3) !important; }
            html.dark .ims-card-suspend .ims-card-count-focus { background: rgba(245, 158, 11, 0.2) !important; color: #fde68a !important; border-color: rgba(245, 158, 11, 0.35) !important; }

            html.dark .ims-card-terminasi .ims-card-icon-wrap { background: rgba(148, 163, 184, 0.15) !important; color: #cbd5e1 !important; border-color: rgba(148, 163, 184, 0.3) !important; }
            html.dark .ims-card-terminasi .ims-card-count-focus { background: rgba(148, 163, 184, 0.2) !important; color: #e2e8f0 !important; border-color: rgba(148, 163, 184, 0.35) !important; }

            /* ── MOBILE & TABLET 2-COLUMN RESPONSIVE LAYOUT (< 1024px) ── */
            @media (max-width: 1023px) {
                .ims-ticket-hero {
                    padding: 1.25rem 1.35rem;
                    border-radius: 16px;
                    gap: 1rem;
                }

                .ims-ticket-hero-title {
                    font-size: 1.2rem;
                }

                .ims-ticket-hero-desc {
                    font-size: 0.78rem;
                }

                .ims-ticket-hero-right {
                    width: 100%;
                    display: grid;
                    grid-template-columns: 1fr 1.4fr;
                    gap: 0.75rem;
                }

                .ims-ticket-stat-box {
                    min-width: unset;
                    padding: 0.55rem 0.85rem;
                    align-items: center;
                    text-align: center;
                }

                .ims-ticket-stat-val {
                    font-size: 1.45rem;
                }

                .ims-ticket-stat-lbl {
                    font-size: 0.62rem;
                }

                .ims-btn-action-all {
                    padding: 0.55rem 0.85rem;
                    font-size: 0.76rem;
                    justify-content: center;
                    text-align: center;
                }

                /* 2-COLUMN GRID SYSTEM */
                .ims-ticket-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                    gap: 0.75rem !important;
                }

                .ims-ticket-card {
                    padding: 0.95rem 0.9rem !important;
                    border-radius: 15px !important;
                    gap: 0.75rem !important;
                    height: 100% !important;
                    box-sizing: border-box !important;
                }

                .ims-card-top {
                    gap: 0.4rem !important;
                }

                .ims-card-icon-wrap {
                    width: 36px !important;
                    height: 36px !important;
                    border-radius: 10px !important;
                }

                .ims-card-icon-wrap svg {
                    width: 18px !important;
                    height: 18px !important;
                }

                .ims-card-count-focus {
                    padding: 0.25rem 0.55rem !important;
                    min-width: 60px !important;
                    border-radius: 9px !important;
                }

                .ims-count-number {
                    font-size: 1.35rem !important;
                }

                .ims-count-unit {
                    font-size: 0.55rem !important;
                }

                .ims-card-middle {
                    gap: 0.25rem !important;
                    flex: 1 1 auto !important;
                }

                .ims-card-title {
                    font-size: 0.88rem !important;
                    line-height: 1.22 !important;
                    font-weight: 900 !important;
                }

                .ims-card-desc {
                    font-size: 0.7rem !important;
                    line-height: 1.35 !important;
                    display: -webkit-box !important;
                    -webkit-line-clamp: 2 !important;
                    -webkit-box-orient: vertical !important;
                    overflow: hidden !important;
                }

                .ims-card-bottom {
                    padding-top: 0.65rem !important;
                    font-size: 0.72rem !important;
                    gap: 4px !important;
                }

                .ims-card-bottom span:first-child {
                    white-space: nowrap !important;
                    overflow: hidden !important;
                    text-overflow: ellipsis !important;
                    max-width: calc(100% - 16px) !important;
                }
            }

            @media (max-width: 639px) {
                .ims-ticket-hero-right {
                    grid-template-columns: 1fr;
                }

                .ims-ticket-grid {
                    gap: 0.6rem !important;
                    grid-template-columns: 1fr !important;
                }

                .ims-ticket-card {
                    padding: 0.8rem 0.75rem !important;
                    border-radius: 13px !important;
                    gap: 0.6rem !important;
                }

                .ims-card-icon-wrap {
                    width: 32px !important;
                    height: 32px !important;
                    border-radius: 8px !important;
                }

                .ims-card-icon-wrap svg {
                    width: 16px !important;
                    height: 16px !important;
                }

                .ims-card-count-focus {
                    padding: 0.2rem 0.45rem !important;
                    min-width: 50px !important;
                }

                .ims-count-number {
                    font-size: 1.2rem !important;
                }

                .ims-count-unit {
                    font-size: 0.52rem !important;
                }

                .ims-card-title {
                    font-size: 0.78rem !important;
                }

                .ims-card-desc {
                    font-size: 0.64rem !important;
                    -webkit-line-clamp: 2 !important;
                }

                .ims-card-bottom {
                    font-size: 0.64rem !important;
                }
            }
        </style>

        <div class="ims-ticket-container">

            {{-- ── HERO / DISPATCH HEADER ── --}}
            <div class="ims-ticket-hero">
                <div class="ims-ticket-hero-left">
                    <div class="ims-ticket-live-pill">
                        <span class="ims-live-dot"></span>
                        NOC &amp; Helpdesk Dispatch Portal
                    </div>
                    <h1 class="ims-ticket-hero-title">Portal Manajemen Tiket &amp; Layanan</h1>
                    <p class="ims-ticket-hero-desc">
                        Monitoring antrian keluhan teknis, gangguan jaringan fiber optik, permohonan pelanggan, dan alur operasional lapangan secara terpusat.
                    </p>
                </div>

                <div class="ims-ticket-hero-right">
                    <div class="ims-ticket-stat-box">
                        <span class="ims-ticket-stat-val">{{ $totalActive }}</span>
                        <span class="ims-ticket-stat-lbl">Total Antrian</span>
                    </div>

                    <a href="{{ url('/admin/tickets?category=all') }}" class="ims-btn-action-all">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        <span>Lihat Semua Tiket</span>
                    </a>
                </div>
            </div>

            {{-- ── GRID PORTAL KARTU TIKET ── --}}
            <div class="ims-ticket-grid">

                {{-- 1. Gangguan Layanan --}}
                <a href="{{ url('/admin/tickets?category=gangguan') }}" class="ims-ticket-card ims-card-gangguan">
                    <div class="ims-card-top">
                        <div class="ims-card-icon-wrap">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="ims-card-count-focus">
                            <span class="ims-count-number">{{ $counts['gangguan'] }}</span>
                            <span class="ims-count-unit">Tiket Masuk</span>
                        </div>
                    </div>
                    <div class="ims-card-middle">
                        <h2 class="ims-card-title">Gangguan Layanan</h2>
                        <p class="ims-card-desc">Laporan LOS (Red/Bending), kabel putus, redaman tinggi, koneksi lambat &amp; penanganan helpdesk.</p>
                    </div>
                    <div class="ims-card-bottom">
                        <span>Buka Helpdesk NOC</span>
                        <span class="ims-card-arrow">&rarr;</span>
                    </div>
                </a>

                {{-- 2. Ubah Password --}}
                <a href="{{ url('/admin/tickets?category=ubah_password') }}" class="ims-ticket-card ims-card-password">
                    <div class="ims-card-top">
                        <div class="ims-card-icon-wrap">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </div>
                        <div class="ims-card-count-focus">
                            <span class="ims-count-number">{{ $counts['ubah_password'] }}</span>
                            <span class="ims-count-unit">Tiket Masuk</span>
                        </div>
                    </div>
                    <div class="ims-card-middle">
                        <h2 class="ims-card-title">Ubah Password</h2>
                        <p class="ims-card-desc">Permintaan reset kata sandi WiFi / SSID, verifikasi data pelanggan, &amp; konfigurasi ONT.</p>
                    </div>
                    <div class="ims-card-bottom">
                        <span>Buka Permintaan</span>
                        <span class="ims-card-arrow">&rarr;</span>
                    </div>
                </a>

                {{-- 3. Cek Coverage Area --}}
                <a href="{{ url('/admin/tickets?category=coverage') }}" class="ims-ticket-card ims-card-coverage">
                    <div class="ims-card-top">
                        <div class="ims-card-icon-wrap">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="ims-card-count-focus">
                            <span class="ims-count-number">{{ $counts['coverage'] }}</span>
                            <span class="ims-count-unit">Tiket Masuk</span>
                        </div>
                    </div>
                    <div class="ims-card-middle">
                        <h2 class="ims-card-title">Cek Coverage Area</h2>
                        <p class="ims-card-desc">Survey jangkauan fiber optik, pengecekan ketersediaan port ODP &amp; kelayakan pasang baru.</p>
                    </div>
                    <div class="ims-card-bottom">
                        <span>Buka Survey Area</span>
                        <span class="ims-card-arrow">&rarr;</span>
                    </div>
                </a>

                {{-- 4. Pemasangan Baru (PSB) --}}
                <a href="{{ url('/admin/installation-pipelines') }}" class="ims-ticket-card ims-card-psb">
                    <div class="ims-card-top">
                        <div class="ims-card-icon-wrap">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div class="ims-card-count-focus">
                            <span class="ims-count-number">{{ $counts['psb'] }}</span>
                            <span class="ims-count-unit">Antrian Aktif</span>
                        </div>
                    </div>
                    <div class="ims-card-middle">
                        <h2 class="ims-card-title">Pemasangan Baru (PSB)</h2>
                        <p class="ims-card-desc">Pipeline instalasi teknisi, penarikan kabel dropcore, aktivasi ONU/ONT &amp; validasi billing.</p>
                    </div>
                    <div class="ims-card-bottom">
                        <span>Pipeline Instalasi</span>
                        <span class="ims-card-arrow">&rarr;</span>
                    </div>
                </a>

                {{-- 5. Ubah Layanan --}}
                <a href="{{ url('/admin/package-mutations') }}" class="ims-ticket-card ims-card-mutasi">
                    <div class="ims-card-top">
                        <div class="ims-card-icon-wrap">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                        <div class="ims-card-count-focus">
                            <span class="ims-count-number">{{ $counts['ubah_layanan'] }}</span>
                            <span class="ims-count-unit">Tiket Masuk</span>
                        </div>
                    </div>
                    <div class="ims-card-middle">
                        <h2 class="ims-card-title">Ubah Layanan</h2>
                        <p class="ims-card-desc">Permohonan upgrade/downgrade bandwidth paket, mutasi profil speed, &amp; penyesuaian tagihan.</p>
                    </div>
                    <div class="ims-card-bottom">
                        <span>Buka Mutasi Paket</span>
                        <span class="ims-card-arrow">&rarr;</span>
                    </div>
                </a>

                {{-- 6. Suspend Layanan --}}
                <a href="{{ url('/admin/service-suspensions') }}" class="ims-ticket-card ims-card-suspend">
                    <div class="ims-card-top">
                        <div class="ims-card-icon-wrap">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ims-card-count-focus">
                            <span class="ims-count-number">{{ $counts['suspend'] }}</span>
                            <span class="ims-count-unit">Tiket Masuk</span>
                        </div>
                    </div>
                    <div class="ims-card-middle">
                        <h2 class="ims-card-title">Suspend Layanan</h2>
                        <p class="ims-card-desc">Daftar isolir sementara pelanggan akibat keterlambatan pembayaran atau cuti berlangganan.</p>
                    </div>
                    <div class="ims-card-bottom">
                        <span>Daftar Isolir</span>
                        <span class="ims-card-arrow">&rarr;</span>
                    </div>
                </a>

                {{-- 7. Terminasi Layanan --}}
                <a href="{{ url('/admin/service-terminations') }}" class="ims-ticket-card ims-card-terminasi">
                    <div class="ims-card-top">
                        <div class="ims-card-icon-wrap">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                        </div>
                        <div class="ims-card-count-focus">
                            <span class="ims-count-number">{{ $counts['terminasi'] }}</span>
                            <span class="ims-count-unit">Tiket Masuk</span>
                        </div>
                    </div>
                    <div class="ims-card-middle">
                        <h2 class="ims-card-title">Terminasi Layanan</h2>
                        <p class="ims-card-desc">Pemutusan layanan permanen, penyelesaian administrasi akhir, &amp; penarikan perangkat ONT.</p>
                    </div>
                    <div class="ims-card-bottom">
                        <span>Daftar Pencabutan</span>
                        <span class="ims-card-arrow">&rarr;</span>
                    </div>
                </a>

            </div>

        </div>
    @else
        {{-- ── TABEL TIKET SESUAI KATEGORI (Saat salah satu kategori dipilih) ── --}}
        {{ $this->table }}
    @endif
</x-filament-panels::page>

