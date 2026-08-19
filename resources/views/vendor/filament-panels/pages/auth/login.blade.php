<x-filament-panels::page.simple>

<style>
    /* =========================================================
       IMS ENTERPRISE SPLIT LOGIN DESIGN
       File: resources/views/vendor/filament-panels/pages/auth/login.blade.php
    ========================================================= */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap');

    html, body {
        background: #f1f5f9 !important;
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    /* Reset Filament wrapper constraints */
    .fi-simple-layout {
        background: #eef4fc !important;
        background-image: 
            radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.07) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(6, 182, 212, 0.08) 0%, transparent 40%) !important;
        min-height: 100vh !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 24px !important;
    }

    .fi-simple-main-ctn {
        max-width: 1060px !important;
        width: 100% !important;
        padding: 0 !important;
        margin: auto !important;
    }

    .fi-simple-main {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
        animation: imsFadeIn 0.5s ease-out both !important;
    }

    @keyframes imsFadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fi-simple-header,
    .fi-logo,
    .fi-simple-page-heading,
    .fi-simple-page-subheading {
        display: none !important;
    }

    /* ── SPLIT CARD CONTAINER ── */
    .ims-login-card {
        display: flex;
        flex-direction: row;
        background: #ffffff;
        border-radius: 28px;
        box-shadow: 
            0 10px 25px -5px rgba(15, 23, 42, 0.08),
            0 25px 50px -12px rgba(15, 23, 42, 0.18),
            0 0 0 1px rgba(226, 232, 240, 0.8);
        overflow: hidden;
        min-height: 600px;
        width: 100%;
    }

    @media (max-width: 960px) {
        .ims-login-card {
            flex-direction: column;
        }
        .ims-left-hero {
            display: none !important;
        }
    }

    /* ── LEFT HERO PANEL (BLUE GRADIENT) ── */
    .ims-left-hero {
        flex: 1.1;
        background: linear-gradient(150deg, #0284c7 0%, #1d4ed8 35%, #1e40af 70%, #0f172a 100%);
        padding: 42px 40px 36px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        color: #ffffff;
    }

    /* Background futuristic glow elements */
    .ims-left-hero::before {
        content: '';
        position: absolute;
        top: -30%;
        left: -20%;
        width: 140%;
        height: 140%;
        background: 
            radial-gradient(circle at 20% 20%, rgba(56, 189, 248, 0.35) 0%, transparent 45%),
            radial-gradient(circle at 80% 80%, rgba(37, 99, 235, 0.4) 0%, transparent 50%);
        pointer-events: none;
    }

    .ims-brand-badge {
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 2;
    }

    .ims-cube-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #00d4ff 0%, #2563eb 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 14px rgba(0, 212, 255, 0.45);
    }

    .ims-hero-content {
        margin: 28px 0;
        z-index: 2;
    }

    .ims-hero-title {
        font-size: 34px;
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -0.02em;
        color: #ffffff;
        margin-bottom: 6px;
    }

    .ims-hero-cyan {
        color: #00d4ff;
        display: inline-block;
        text-shadow: 0 0 16px rgba(0, 212, 255, 0.4);
    }

    .ims-hero-dash {
        display: flex;
        align-items: center;
        gap: 4px;
        margin: 12px 0 16px;
    }

    .ims-hero-dash span:nth-child(1) { width: 22px; height: 3px; background: #00d4ff; border-radius: 2px; }
    .ims-hero-dash span:nth-child(2) { width: 8px; height: 3px; background: rgba(255,255,255,0.4); border-radius: 2px; }

    .ims-hero-desc {
        font-size: 13.5px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.82);
        max-width: 380px;
    }

    /* Cityscape Building Silhouette Graphic */
    .ims-city-silhouette {
        position: relative;
        width: 100%;
        height: 160px;
        margin: 10px 0 16px;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        z-index: 2;
    }

    /* Bottom 3 Glassmorphism Badges */
    .ims-glass-pills {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        z-index: 2;
    }

    .ims-glass-pill {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 16px;
        padding: 14px 10px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        transition: transform 0.2s ease, background 0.2s ease;
    }

    .ims-glass-pill:hover {
        background: rgba(255, 255, 255, 0.18);
        transform: translateY(-2px);
    }

    .ims-pill-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #00d4ff 0%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 212, 255, 0.4);
    }

    .ims-pill-title {
        font-size: 12px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.01em;
    }

    .ims-pill-desc {
        font-size: 10px;
        color: rgba(255, 255, 255, 0.75);
        line-height: 1.2;
    }

    /* ── RIGHT LOGIN FORM PANEL ── */
    .ims-right-form {
        flex: 1;
        padding: 48px 46px 36px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: #ffffff;
    }

    .ims-form-header {
        text-align: center;
        margin-bottom: 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .ims-lock-badge {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #eff6ff;
        border: 2px solid #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        margin-bottom: 16px;
        box-shadow: 0 4px 18px rgba(37, 99, 235, 0.15);
    }

    .ims-form-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        margin: 0 0 6px;
    }

    .ims-form-subtitle {
        font-size: 13.5px;
        color: #64748b;
        margin: 0;
    }

    /* Form Fields Customization */
    .fi-fo-field-wrp label {
        font-size: 13px !important;
        font-weight: 700 !important;
        color: #1e293b !important;
        text-transform: none !important;
        letter-spacing: normal !important;
        margin-bottom: 6px !important;
    }

    .fi-input-wrp {
        background: #ffffff !important;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 12px !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
    }

    .fi-input-wrp:focus-within {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12) !important;
    }

    .fi-input-wrp input {
        font-size: 14px !important;
        font-weight: 500 !important;
        color: #0f172a !important;
        padding: 12px 14px !important;
    }

    /* Submit Button (Royal Blue with Arrow) */
    .ims-submit-button {
        width: 100%;
        background: linear-gradient(90deg, #1d4ed8 0%, #2563eb 100%) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        padding: 14px 24px !important;
        border-radius: 14px !important;
        border: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 12px !important;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.32) !important;
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease !important;
        cursor: pointer !important;
        margin-top: 18px !important;
    }

    .ims-submit-button:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 12px 28px rgba(37, 99, 235, 0.45) !important;
        filter: brightness(1.05) !important;
    }

    .ims-submit-button:active {
        transform: translateY(0) !important;
    }

    /* Hide standard filament form actions container to prevent duplicate button */
    .fi-form-actions,
    .fi-modal-actions {
        display: none !important;
    }

    .ims-copyright-footer {
        text-align: center;
        font-size: 12px;
        color: #94a3b8;
        margin-top: 24px;
    }

    .ims-copyright-footer strong {
        color: #2563eb;
    }
</style>

<div class="ims-login-card">
    {{-- ════════════════════════════════════════════════════════════
         ── LEFT HERO PANEL (BLUE MODERN ENTERPRISE) ──
         ════════════════════════════════════════════════════════════ --}}
    <div class="ims-left-hero">
        <!-- Logo & Enterprise Brand -->
        <div class="ims-brand-badge">
            <div class="ims-cube-icon">
                <svg style="width: 24px; height: 24px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>
            </div>
            <div>
                <div style="font-size: 17px; font-weight: 900; letter-spacing: -0.01em; color: #ffffff;">IMS</div>
                <div style="font-size: 11px; font-weight: 600; color: #7dd3fc; letter-spacing: 0.02em;">Sistem Manajemen Enterprise</div>
            </div>
        </div>

        <!-- Headline Content -->
        <div class="ims-hero-content">
            <div class="ims-hero-title">
                Selamat Datang<br>
                <span class="ims-hero-cyan">Kembali!</span>
            </div>
            <div class="ims-hero-dash">
                <span></span>
                <span></span>
            </div>
            <p class="ims-hero-desc">
                Masuk ke panel manajemen Anda untuk mengelola sistem dengan mudah, cepat, dan aman.
            </p>
        </div>

        <!-- Cityscape Futuristic Tech Illustration -->
        <div class="ims-city-silhouette">
            <svg viewBox="0 0 400 160" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%; max-height: 150px;">
                <!-- Glowing fiber waves -->
                <path d="M0 140 C100 110, 250 160, 400 120" stroke="url(#cyanGlow)" stroke-width="2.5" fill="none" opacity="0.85" />
                <path d="M0 150 C120 125, 280 165, 400 135" stroke="url(#blueGlow)" stroke-width="1.5" fill="none" opacity="0.5" />
                
                <!-- Buildings Background -->
                <rect x="50" y="70" width="45" height="90" rx="3" fill="#1e3a8a" opacity="0.5" />
                <rect x="110" y="45" width="55" height="115" rx="4" fill="#1e40af" opacity="0.6" />
                <rect x="180" y="20" width="70" height="140" rx="4" fill="#1d4ed8" opacity="0.8" />
                <rect x="265" y="55" width="50" height="105" rx="4" fill="#1e40af" opacity="0.6" />
                <rect x="330" y="80" width="40" height="80" rx="3" fill="#1e3a8a" opacity="0.5" />

                <!-- Illuminated Windows -->
                <g fill="#38bdf8" opacity="0.75">
                    <rect x="192" y="35" width="6" height="4" rx="1"/>
                    <rect x="204" y="35" width="6" height="4" rx="1"/>
                    <rect x="216" y="35" width="6" height="4" rx="1"/>
                    <rect x="228" y="35" width="6" height="4" rx="1"/>

                    <rect x="192" y="48" width="6" height="4" rx="1"/>
                    <rect x="204" y="48" width="6" height="4" rx="1"/>
                    <rect x="216" y="48" width="6" height="4" rx="1"/>
                    <rect x="228" y="48" width="6" height="4" rx="1"/>

                    <rect x="192" y="61" width="6" height="4" rx="1"/>
                    <rect x="204" y="61" width="6" height="4" rx="1"/>
                    <rect x="216" y="61" width="6" height="4" rx="1"/>
                    <rect x="228" y="61" width="6" height="4" rx="1"/>

                    <rect x="192" y="74" width="6" height="4" rx="1"/>
                    <rect x="204" y="74" width="6" height="4" rx="1"/>
                    <rect x="216" y="74" width="6" height="4" rx="1"/>
                    <rect x="228" y="74" width="6" height="4" rx="1"/>

                    <rect x="122" y="58" width="5" height="4" rx="1"/>
                    <rect x="134" y="58" width="5" height="4" rx="1"/>
                    <rect x="146" y="58" width="5" height="4" rx="1"/>
                    <rect x="122" y="70" width="5" height="4" rx="1"/>
                    <rect x="134" y="70" width="5" height="4" rx="1"/>
                    <rect x="146" y="70" width="5" height="4" rx="1"/>

                    <rect x="277" y="68" width="5" height="4" rx="1"/>
                    <rect x="289" y="68" width="5" height="4" rx="1"/>
                    <rect x="301" y="68" width="5" height="4" rx="1"/>
                </g>

                <!-- Glowing IMS Rooftop Sign -->
                <text x="215" y="14" font-family="'Plus Jakarta Sans', sans-serif" font-weight="900" font-size="11" fill="#00d4ff" text-anchor="middle" filter="url(#glowFilter)">iMS</text>

                <defs>
                    <linearGradient id="cyanGlow" x1="0" y1="0" x2="400" y2="0" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#00d4ff" />
                        <stop offset="0.5" stop-color="#38bdf8" />
                        <stop offset="1" stop-color="#2563eb" />
                    </linearGradient>
                    <linearGradient id="blueGlow" x1="0" y1="0" x2="400" y2="0" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#38bdf8" />
                        <stop offset="1" stop-color="#1d4ed8" />
                    </linearGradient>
                    <filter id="glowFilter" x="180" y="0" width="70" height="30" filterUnits="userSpaceOnUse">
                        <feDropShadow dx="0" dy="0" stdDeviation="3" flood-color="#00d4ff" flood-opacity="0.9"/>
                    </filter>
                </defs>
            </svg>
        </div>

        <!-- 3 Feature Glass Cards -->
        <div class="ims-glass-pills">
            <!-- 1. Aman -->
            <div class="ims-glass-pill">
                <div class="ims-pill-icon">
                    <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                </div>
                <div class="ims-pill-title">Aman</div>
                <div class="ims-pill-desc">Data terlindungi</div>
            </div>

            <!-- 2. Cepat -->
            <div class="ims-glass-pill">
                <div class="ims-pill-icon">
                    <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                </div>
                <div class="ims-pill-title">Cepat</div>
                <div class="ims-pill-desc">Akses instan</div>
            </div>

            <!-- 3. Terintegrasi -->
            <div class="ims-glass-pill">
                <div class="ims-pill-icon">
                    <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                </div>
                <div class="ims-pill-title">Terintegrasi</div>
                <div class="ims-pill-desc">Sistem terhubung</div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════
         ── RIGHT LOGIN FORM PANEL (WHITE CARD) ──
         ════════════════════════════════════════════════════════════ --}}
    <div class="ims-right-form">
        <div>
            <!-- Top Lock Badge -->
            <div class="ims-form-header">
                <div class="ims-lock-badge">
                    <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <h1 class="ims-form-title">Masuk ke Akun Anda</h1>
                <p class="ims-form-subtitle">Gunakan akun yang telah terdaftar</p>
            </div>

            <!-- Login Form (Livewire Filament) -->
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

            <x-filament-panels::form id="form" wire:submit="authenticate">
                {{ $this->form }}

                <!-- Custom Styled Submit Button with Circular Arrow -->
                <button type="submit" class="ims-submit-button">
                    <span>Masuk</span>
                    <span style="width: 24px; height: 24px; border-radius: 50%; background: rgba(255, 255, 255, 0.22); display: inline-flex; align-items: center; justify-content: center; margin-left: 2px;">
                        <svg style="width: 14px; height: 14px; color: #ffffff;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </button>
            </x-filament-panels::form>

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
        </div>

        <!-- Footer Copyright -->
        <div class="ims-copyright-footer">
            &copy; {{ date('Y') }} <strong>IMS</strong> &nbsp;•&nbsp; Sistem Manajemen Enterprise
        </div>
    </div>
</div>

</x-filament-panels::page.simple>
