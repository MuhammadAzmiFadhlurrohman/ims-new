<x-filament-panels::page>
    <style>
        /* ════════════════════════════════════════════════════════════
           DATA PELANGGAN IMS – Premium Matrix Design System
           ════════════════════════════════════════════════════════════ */
        .matrix-page-wrapper {
            display: flex;
            flex-direction: column;
            gap: 28px;
            padding-bottom: 40px;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        /* ── Section Card Container ── */
        .matrix-section {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }

        .matrix-section:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.07);
        }

        /* ── Section Header ── */
        .matrix-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        .matrix-section-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .matrix-section-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .matrix-section-icon svg {
            width: 18px;
            height: 18px;
            color: #ffffff;
        }

        .matrix-section-icon-aktif { background: linear-gradient(135deg, #00bcd4, #0097a7); }
        .matrix-section-icon-terminasi { background: linear-gradient(135deg, #f43f5e, #e11d48); }
        .matrix-section-icon-suspend { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .matrix-section-icon-gagal { background: linear-gradient(135deg, #64748b, #475569); }

        .matrix-section-title {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .matrix-section-subtitle {
            font-size: 11px;
            font-weight: 500;
            color: #94a3b8;
            margin-top: 1px;
        }

        .matrix-section-total-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .matrix-section-total-pill:hover {
            transform: translateY(-1px);
            filter: brightness(1.1);
        }

        .matrix-section-total-pill-aktif { background: linear-gradient(135deg, #00bcd4, #0097a7); box-shadow: 0 3px 10px rgba(0, 188, 212, 0.3); }
        .matrix-section-total-pill-terminasi { background: linear-gradient(135deg, #f43f5e, #e11d48); box-shadow: 0 3px 10px rgba(244, 63, 94, 0.3); }
        .matrix-section-total-pill-suspend { background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 3px 10px rgba(245, 158, 11, 0.3); }
        .matrix-section-total-pill-gagal { background: linear-gradient(135deg, #64748b, #475569); box-shadow: 0 3px 10px rgba(100, 116, 139, 0.3); }

        .matrix-section-total-pill .total-number {
            font-size: 14px;
            font-weight: 900;
        }

        /* ── Cards Grid (Desktop) ── */
        .matrix-section-body {
            padding: 16px 20px 20px;
        }

        .matrix-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            width: 100%;
            box-sizing: border-box;
        }

        /* ── Individual Card ── */
        .matrix-item-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 14px 16px;
            min-height: 88px;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .matrix-item-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 12px 12px 0 0;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .matrix-item-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        .matrix-item-card:hover::before {
            opacity: 1;
        }

        .matrix-item-card.card-aktif::before { background: linear-gradient(90deg, #00bcd4, #0097a7); }
        .matrix-item-card.card-terminasi::before { background: linear-gradient(90deg, #f43f5e, #e11d48); }
        .matrix-item-card.card-suspend::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
        .matrix-item-card.card-gagal::before { background: linear-gradient(90deg, #64748b, #475569); }

        /* ── Card Badge ── */
        .matrix-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #ffffff !important;
            line-height: 1.3;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .matrix-badge-aktif { background: linear-gradient(135deg, #00bcd4, #0097a7); }
        .matrix-badge-terminasi { background: linear-gradient(135deg, #f43f5e, #e11d48); }
        .matrix-badge-suspend { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .matrix-badge-gagal { background: linear-gradient(135deg, #64748b, #475569); }

        /* ── Count Row ── */
        .matrix-count-row {
            margin-top: 12px;
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .matrix-count-number {
            font-size: 22px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .matrix-count-unit {
            font-size: 12px;
            font-weight: 500;
            color: #64748b;
        }

        /* ── Responsive Grid ── */
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

        /* ════════════════════════════════════════════════════════════
           MOBILE CARD SLIDER (< 1024px)
           ════════════════════════════════════════════════════════════ */
        @media (max-width: 1023px) {
            .matrix-page-wrapper {
                gap: 16px;
            }

            .matrix-section {
                border-radius: 14px;
            }

            .matrix-section-header {
                padding: 12px 14px;
                flex-wrap: wrap;
                gap: 8px;
            }

            .matrix-section-icon {
                width: 32px;
                height: 32px;
                border-radius: 8px;
            }

            .matrix-section-icon svg {
                width: 15px;
                height: 15px;
            }

            .matrix-section-title {
                font-size: 13px;
            }

            .matrix-section-subtitle {
                font-size: 10px;
            }

            .matrix-section-total-pill {
                padding: 4px 12px;
                font-size: 11px;
            }

            .matrix-section-total-pill .total-number {
                font-size: 12px;
            }

            .matrix-section-body {
                padding: 12px 14px 16px;
            }

            /* Hide grid, show slider */
            .matrix-cards-grid {
                display: none !important;
            }

            .matrix-mobile-slider {
                display: block !important;
            }

            /* ── Slider Container ── */
            .matrix-mobile-slider {
                position: relative;
                overflow: hidden;
            }

            .matrix-slider-track {
                display: flex;
                transition: transform 0.35s cubic-bezier(0.25, 0.8, 0.25, 1);
                touch-action: pan-y;
            }

            .matrix-slider-slide {
                flex: 0 0 100%;
                min-width: 0;
                padding: 0 4px;
                box-sizing: border-box;
            }

            .matrix-slider-slide .matrix-item-card {
                min-height: 105px;
                border-radius: 14px;
                padding: 16px 42px;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                box-sizing: border-box !important;
            }

            .matrix-slider-slide .matrix-badge {
                font-size: 11px;
                padding: 5px 14px;
                border-radius: 8px;
                margin: 0 auto !important;
                display: inline-flex !important;
                justify-content: center !important;
                text-align: center !important;
            }

            .matrix-slider-slide .matrix-count-row {
                margin-top: 10px;
                display: flex !important;
                align-items: baseline !important;
                justify-content: center !important;
                text-align: center !important;
                gap: 6px;
                width: 100%;
            }

            .matrix-slider-slide .matrix-count-number {
                font-size: 30px;
                line-height: 1;
            }

            .matrix-slider-slide .matrix-count-unit {
                font-size: 13px;
            }

            /* ── Slider Dots ── */
            .matrix-slider-dots {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 6px;
                padding: 10px 0 4px;
            }

            .matrix-slider-dot {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: #cbd5e1;
                border: none;
                padding: 0;
                cursor: pointer;
                transition: all 0.25s ease;
            }

            .matrix-slider-dot.active {
                width: 20px;
                border-radius: 10px;
            }

            .matrix-slider-dot.dot-aktif.active { background: #00bcd4; }
            .matrix-slider-dot.dot-terminasi.active { background: #f43f5e; }
            .matrix-slider-dot.dot-suspend.active { background: #f59e0b; }
            .matrix-slider-dot.dot-gagal.active { background: #64748b; }

            /* ── Slider Nav Arrows ── */
            .matrix-slider-nav {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 28px;
                height: 28px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.95);
                border: 1px solid #e2e8f0;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 5;
                transition: all 0.2s ease;
                padding: 0;
            }

            .matrix-slider-nav:hover {
                background: #ffffff;
                box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            }

            .matrix-slider-nav svg {
                width: 14px;
                height: 14px;
                color: #475569;
            }

            .matrix-slider-prev { left: 6px; }
            .matrix-slider-next { right: 6px; }

            .matrix-slider-nav:disabled {
                opacity: 0.3;
                cursor: default;
            }
        }

        /* Desktop: hide mobile slider */
        @media (min-width: 1024px) {
            .matrix-mobile-slider {
                display: none !important;
            }
        }

        /* ════════════════════════════════════════════════════════════
           DARK MODE OVERRIDES
           ════════════════════════════════════════════════════════════ */
        html.dark .matrix-section {
            background: #08192e !important;
            border-color: #14355a !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4) !important;
        }

        html.dark .matrix-section-header {
            border-bottom-color: #0d2748 !important;
        }

        html.dark .matrix-section-title {
            color: #ffffff !important;
        }

        html.dark .matrix-section-subtitle {
            color: #64748b !important;
        }

        html.dark .matrix-item-card {
            background: linear-gradient(135deg, #0b2240 0%, #081d36 100%) !important;
            border-color: #1a3d6a !important;
        }

        html.dark .matrix-item-card:hover {
            background: linear-gradient(135deg, #0e2d52 0%, #0c2442 100%) !important;
            border-color: #00d4ff !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4) !important;
        }

        html.dark .matrix-count-number {
            color: #ffffff !important;
        }

        html.dark .matrix-count-unit {
            color: #94a3b8 !important;
        }

        html.dark .matrix-slider-dot {
            background: #1e3a5f !important;
        }

        html.dark .matrix-slider-nav {
            background: rgba(8, 25, 46, 0.95) !important;
            border-color: #1a3d6a !important;
        }

        html.dark .matrix-slider-nav svg {
            color: #94a3b8 !important;
        }
    </style>

    <div class="matrix-page-wrapper">

        @php
            $sections = [
                [
                    'key' => 'aktif',
                    'title' => 'Aktif',
                    'subtitle' => 'Pelanggan dengan layanan aktif',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
                    'counts' => $aktifCounts,
                    'total' => $totalAktif,
                    'filterStatus' => 'aktif',
                ],
                [
                    'key' => 'terminasi',
                    'title' => 'Terminasi',
                    'subtitle' => 'Pelanggan layanan dihentikan',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />',
                    'counts' => $terminasiCounts,
                    'total' => $totalTerminasi,
                    'filterStatus' => 'terminasi',
                ],
                [
                    'key' => 'suspend',
                    'title' => 'Suspend',
                    'subtitle' => 'Pelanggan layanan ditangguhkan',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />',
                    'counts' => $suspendCounts,
                    'total' => $totalSuspend,
                    'filterStatus' => 'suspend',
                ],
                [
                    'key' => 'gagal',
                    'title' => 'Gagal Pasang',
                    'subtitle' => 'Pelanggan batal / tidak tercover',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />',
                    'counts' => $gagalCounts,
                    'total' => $totalGagal,
                    'filterStatus' => 'gagal',
                ],
            ];
        @endphp

        @foreach($sections as $sIdx => $section)
            <div class="matrix-section">
                {{-- Section Header --}}
                <div class="matrix-section-header">
                    <div class="matrix-section-header-left">
                        <div class="matrix-section-icon matrix-section-icon-{{ $section['key'] }}">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $section['icon'] !!}</svg>
                        </div>
                        <div>
                            <div class="matrix-section-title">{{ $section['title'] }}</div>
                            <div class="matrix-section-subtitle">{{ $section['subtitle'] }}</div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=' . $section['filterStatus']) }}"
                       class="matrix-section-total-pill matrix-section-total-pill-{{ $section['key'] }}">
                        Total: <span class="total-number">{{ $section['total'] }}</span> User
                    </a>
                </div>

                {{-- Section Body --}}
                <div class="matrix-section-body">
                    {{-- Desktop Grid --}}
                    <div class="matrix-cards-grid">
                        @foreach($categories as $cat)
                            <a href="{{ url('/admin/customer-subscriptions?filter_status=' . $section['filterStatus'] . '&filter_category=' . $cat->code) }}"
                               class="matrix-item-card card-{{ $section['key'] }}">
                                <span class="matrix-badge matrix-badge-{{ $section['key'] }}">
                                    {{ $cat->name }}
                                </span>
                                <div class="matrix-count-row">
                                    <span class="matrix-count-number">{{ $section['counts'][$cat->code] ?? 0 }}</span>
                                    <span class="matrix-count-unit">User</span>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Mobile Slider --}}
                    <div class="matrix-mobile-slider" data-slider-id="slider-{{ $sIdx }}">
                        <div class="matrix-slider-track" id="slider-track-{{ $sIdx }}">
                            @foreach($categories as $cIdx => $cat)
                                <div class="matrix-slider-slide">
                                    <a href="{{ url('/admin/customer-subscriptions?filter_status=' . $section['filterStatus'] . '&filter_category=' . $cat->code) }}"
                                       class="matrix-item-card card-{{ $section['key'] }}">
                                        <span class="matrix-badge matrix-badge-{{ $section['key'] }}">
                                            {{ $cat->name }}
                                        </span>
                                        <div class="matrix-count-row">
                                            <span class="matrix-count-number">{{ $section['counts'][$cat->code] ?? 0 }}</span>
                                            <span class="matrix-count-unit">User</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        {{-- Nav Arrows --}}
                        <button class="matrix-slider-nav matrix-slider-prev" data-slider="{{ $sIdx }}" data-dir="prev" aria-label="Previous">
                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                        </button>
                        <button class="matrix-slider-nav matrix-slider-next" data-slider="{{ $sIdx }}" data-dir="next" aria-label="Next">
                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                        </button>

                        {{-- Dots --}}
                        <div class="matrix-slider-dots" id="slider-dots-{{ $sIdx }}">
                            @foreach($categories as $cIdx => $cat)
                                <button class="matrix-slider-dot dot-{{ $section['key'] }} {{ $cIdx === 0 ? 'active' : '' }}"
                                        data-slider="{{ $sIdx }}"
                                        data-index="{{ $cIdx }}"
                                        aria-label="Slide {{ $cIdx + 1 }}">
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <script>
    (function() {
        const sliders = {};

        document.querySelectorAll('.matrix-mobile-slider').forEach(function(container) {
            const id = container.dataset.sliderId;
            const idx = id.replace('slider-', '');
            const track = document.getElementById('slider-track-' + idx);
            const dots = container.querySelectorAll('.matrix-slider-dot');
            const slides = track ? track.querySelectorAll('.matrix-slider-slide') : [];
            const total = slides.length;

            sliders[idx] = { current: 0, total: total, track: track, dots: dots };

            function goTo(index) {
                if (index < 0) index = 0;
                if (index >= total) index = total - 1;
                sliders[idx].current = index;
                track.style.transform = 'translateX(-' + (index * 100) + '%)';
                dots.forEach(function(d, i) {
                    d.classList.toggle('active', i === index);
                });
            }

            // Dot click
            dots.forEach(function(dot) {
                dot.addEventListener('click', function() {
                    goTo(parseInt(dot.dataset.index));
                });
            });

            // Touch swipe
            let startX = 0, startY = 0, isDragging = false;
            if (track) {
                track.addEventListener('touchstart', function(e) {
                    startX = e.touches[0].clientX;
                    startY = e.touches[0].clientY;
                    isDragging = true;
                }, { passive: true });

                track.addEventListener('touchend', function(e) {
                    if (!isDragging) return;
                    isDragging = false;
                    const diffX = startX - e.changedTouches[0].clientX;
                    const diffY = startY - e.changedTouches[0].clientY;
                    if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 40) {
                        if (diffX > 0) {
                            goTo(sliders[idx].current + 1);
                        } else {
                            goTo(sliders[idx].current - 1);
                        }
                    }
                }, { passive: true });
            }
        });

        // Arrow buttons
        document.querySelectorAll('.matrix-slider-nav').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const idx = btn.dataset.slider;
                const dir = btn.dataset.dir;
                const s = sliders[idx];
                if (!s) return;
                if (dir === 'next') {
                    if (s.current < s.total - 1) {
                        s.current++;
                        s.track.style.transform = 'translateX(-' + (s.current * 100) + '%)';
                        s.dots.forEach(function(d, i) { d.classList.toggle('active', i === s.current); });
                    }
                } else {
                    if (s.current > 0) {
                        s.current--;
                        s.track.style.transform = 'translateX(-' + (s.current * 100) + '%)';
                        s.dots.forEach(function(d, i) { d.classList.toggle('active', i === s.current); });
                    }
                }
            });
        });
    })();
    </script>
</x-filament-panels::page>
