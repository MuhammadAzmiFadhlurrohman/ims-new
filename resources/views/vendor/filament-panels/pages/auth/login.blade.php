<x-filament-panels::page.simple>

<style>
    /* =========================================================
       IMS ONE – ULTRA-LUXURY EXECUTIVE LOGIN DESIGN SYSTEM
       File: resources/views/vendor/filament-panels/pages/auth/login.blade.php
    ========================================================= */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap');

    html, body {
        background: #0b1329 !important;
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    /* Background Ambient Canvas */
    .fi-simple-layout {
        background: #091024 !important;
        background-image: 
            radial-gradient(circle at 15% 25%, rgba(14, 165, 233, 0.18) 0%, transparent 45%),
            radial-gradient(circle at 85% 75%, rgba(37, 99, 235, 0.2) 0%, transparent 50%),
            radial-gradient(circle at 50% 50%, rgba(15, 23, 42, 0.9) 0%, #060b18 100%) !important;
        min-height: 100vh !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 24px !important;
        box-sizing: border-box !important;
    }

    .fi-simple-main-ctn {
        max-width: 1040px !important;
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
        animation: imsLoginFadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) both !important;
    }

    @keyframes imsLoginFadeIn {
        from { opacity: 0; transform: translateY(16px) scale(0.99); }
        to { opacity: 1; transform: translateY(0) scale(1); }
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
            0 20px 60px -15px rgba(0, 0, 0, 0.45),
            0 0 0 1px rgba(255, 255, 255, 0.08);
        overflow: hidden;
        min-height: 600px;
        width: 100%;
    }

    /* ── LEFT HERO PANEL (BLUE/NAVY GRADIENT) ── */
    .ims-left-hero {
        flex: 1.15;
        background: linear-gradient(145deg, #0284c7 0%, #1e40af 45%, #0f172a 100%);
        padding: 44px 40px 36px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        color: #ffffff;
    }

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
        gap: 14px;
        z-index: 2;
    }

    .ims-cube-icon {
        width: 46px;
        height: 46px;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .ims-hero-content {
        margin: 24px 0;
        z-index: 2;
    }

    .ims-hero-title {
        font-size: 32px;
        font-weight: 900;
        line-height: 1.15;
        letter-spacing: -0.03em;
        color: #ffffff;
        margin-bottom: 6px;
    }

    .ims-hero-cyan {
        color: #38bdf8;
        display: inline-block;
        text-shadow: 0 0 20px rgba(56, 189, 248, 0.5);
    }

    .ims-hero-desc {
        font-size: 13.5px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.85);
        max-width: 380px;
        margin-top: 10px;
    }

    /* 3 Feature Glass Cards */
    .ims-glass-pills {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        z-index: 2;
    }

    .ims-glass-pill {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 12px 10px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transition: transform 0.2s ease, background 0.2s ease;
    }

    .ims-glass-pill:hover {
        background: rgba(255, 255, 255, 0.18);
        transform: translateY(-2px);
    }

    .ims-pill-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: linear-gradient(135deg, #38bdf8 0%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(56, 189, 248, 0.4);
    }

    .ims-pill-title {
        font-size: 11.5px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.01em;
    }

    .ims-pill-desc {
        font-size: 9.5px;
        color: rgba(255, 255, 255, 0.75);
        line-height: 1.2;
    }

    /* ── RIGHT LOGIN FORM PANEL ── */
    .ims-right-form {
        flex: 1;
        padding: 44px 42px 32px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: #ffffff;
        box-sizing: border-box;
    }

    .ims-form-header {
        text-align: center;
        margin-bottom: 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .ims-lock-badge {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: #f0f9ff;
        border: 1.5px solid #bae6fd;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0284c7;
        margin-bottom: 14px;
        box-shadow: 0 4px 16px rgba(2, 132, 199, 0.12);
    }

    .ims-form-title {
        font-size: 22px;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.02em;
        margin: 0 0 4px;
    }

    .ims-form-subtitle {
        font-size: 13px;
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }

    /* ── PURE STANDALONE FORM INPUTS (CLEAN LIGHT & DARK STYLING) ── */
    .ims-right-form .fi-fo-field-wrp {
        margin-bottom: 16px !important;
    }

    .ims-right-form .fi-fo-field-wrp-label label,
    .ims-right-form .fi-fo-field-wrp label {
        font-size: 12.5px !important;
        font-weight: 800 !important;
        color: #1e293b !important;
        letter-spacing: -0.01em !important;
        margin-bottom: 6px !important;
        display: flex !important;
        align-items: center !important;
    }

    .ims-right-form .fi-fo-field-wrp-label sup,
    .ims-right-form label sup {
        color: #ef4444 !important;
        font-weight: 900 !important;
        margin-left: 3px !important;
    }

    /* Crisp Input Container */
    .ims-right-form .fi-input-wrp {
        background: #f8fafc !important;
        background-color: #f8fafc !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 12px !important;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04) !important;
        padding: 0 !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .ims-right-form .fi-input-wrp:focus-within {
        background: #ffffff !important;
        background-color: #ffffff !important;
        border-color: #0284c7 !important;
        box-shadow: 0 0 0 3.5px rgba(2, 132, 199, 0.2) !important;
    }

    .ims-right-form .fi-input-wrp input {
        font-size: 13.5px !important;
        font-weight: 600 !important;
        color: #0f172a !important;
        -webkit-text-fill-color: #0f172a !important;
        padding: 10px 14px !important;
        background: transparent !important;
    }

    .ims-right-form .fi-input-wrp input::placeholder {
        color: #94a3b8 !important;
        -webkit-text-fill-color: #94a3b8 !important;
        font-weight: 500 !important;
    }

    .ims-right-form .fi-input-wrp-prefix,
    .ims-right-form .fi-input-wrp-suffix,
    .ims-right-form .fi-input-wrp-suffix button {
        color: #64748b !important;
    }

    /* Checkbox (Remember Me) */
    .ims-right-form .fi-fo-checkbox {
        margin-top: 4px !important;
    }

    .ims-right-form .fi-checkbox-label {
        font-size: 12.5px !important;
        font-weight: 600 !important;
        color: #475569 !important;
        cursor: pointer !important;
    }

    /* Submit Button (Royal Blue with Arrow) */
    .ims-submit-button {
        width: 100% !important;
        background: linear-gradient(135deg, #0284c7 0%, #2563eb 50%, #1d4ed8 100%) !important;
        background-color: #1d4ed8 !important;
        color: #ffffff !important;
        font-weight: 800 !important;
        font-size: 14.5px !important;
        padding: 12px 20px !important;
        border-radius: 12px !important;
        border: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 10px !important;
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35) !important;
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease !important;
        cursor: pointer !important;
        margin-top: 14px !important;
        box-sizing: border-box !important;
    }

    .ims-submit-button:hover {
        transform: translateY(-1.5px) !important;
        box-shadow: 0 10px 24px rgba(37, 99, 235, 0.45) !important;
        filter: brightness(1.06) !important;
    }

    .ims-submit-button:active {
        transform: translateY(0) !important;
    }

    /* Hide standard filament duplicate actions */
    .fi-form-actions,
    .fi-modal-actions {
        display: none !important;
    }

    .ims-copyright-footer {
        text-align: center;
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 20px;
    }

    .ims-copyright-footer strong {
        color: #0284c7;
        font-weight: 800;
    }

    /* ── MOBILE RESPONSIVENESS (< 960px) ── */
    @media (max-width: 959px) {
        .fi-simple-layout {
            padding: 14px !important;
        }

        .ims-login-card {
            flex-direction: column;
            border-radius: 20px;
            min-height: auto;
            max-width: 440px;
            margin: 0 auto;
        }

        .ims-left-hero {
            display: none !important;
        }

        .ims-right-form {
            padding: 32px 24px 24px;
        }
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
                <img src="{{ asset('images/favicon.svg') }}" alt="IMS Logo" style="width: 26px; height: 26px;" onerror="this.onerror=null; this.src='{{ asset('images/favicon.png') }}';">
            </div>
            <div>
                <div style="font-size: 18px; font-weight: 900; letter-spacing: -0.02em; color: #ffffff;">IMS ONE</div>
                <div style="font-size: 10.5px; font-weight: 700; color: #7dd3fc; letter-spacing: 0.04em; text-transform: uppercase;">ISP & Enterprise Management</div>
            </div>
        </div>

        <!-- Headline Content -->
        <div class="ims-hero-content">
            <div class="ims-hero-title">
                Selamat Datang<br>
                <span class="ims-hero-cyan">Kembali!</span>
            </div>
            <div style="display: flex; align-items: center; gap: 4px; margin: 10px 0 14px;">
                <span style="width: 22px; height: 3px; background: #38bdf8; border-radius: 2px;"></span>
                <span style="width: 8px; height: 3px; background: rgba(255,255,255,0.4); border-radius: 2px;"></span>
            </div>
            <p class="ims-hero-desc">
                Portal manajemen terpadu untuk monitoring jaringan OLT, MikroTik RouterOS, registrasi pelanggan, hingga otomasi billing invoice.
            </p>
        </div>

        <!-- 3 Feature Glass Cards -->
        <div class="ims-glass-pills">
            <!-- 1. Real-Time -->
            <div class="ims-glass-pill">
                <div class="ims-pill-icon">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="ims-pill-title">Real-Time</div>
                <div class="ims-pill-desc">Live OLT & RouterOS</div>
            </div>

            <!-- 2. Aman -->
            <div class="ims-glass-pill">
                <div class="ims-pill-icon">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                </div>
                <div class="ims-pill-title">Aman</div>
                <div class="ims-pill-desc">Role Shield Proteksi</div>
            </div>

            <!-- 3. Otomatis -->
            <div class="ims-glass-pill">
                <div class="ims-pill-icon">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="ims-pill-title">Otomatis</div>
                <div class="ims-pill-desc">Billing & Isolir Auto</div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════
         ── RIGHT LOGIN FORM PANEL (CLEAN WHITE CARD) ──
         ════════════════════════════════════════════════════════════ --}}
    <div class="ims-right-form">
        <div>
            <!-- Top Lock Badge -->
            <div class="ims-form-header">
                <div class="ims-lock-badge">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <h1 class="ims-form-title">Masuk ke Akun Anda</h1>
                <p class="ims-form-subtitle">Gunakan kredensial akun terdaftar Anda</p>
            </div>

            <!-- Login Form (Livewire Filament) -->
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

            <x-filament-panels::form id="form" wire:submit="authenticate">
                {{ $this->form }}

                <!-- Custom Styled Submit Button with Circular Arrow -->
                <button type="submit" class="ims-submit-button">
                    <span>Masuk ke Sistem</span>
                    <span style="width: 22px; height: 22px; border-radius: 50%; background: rgba(255, 255, 255, 0.22); display: inline-flex; align-items: center; justify-content: center;">
                        <svg style="width: 13px; height: 13px; color: #ffffff;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </button>
            </x-filament-panels::form>

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
        </div>

        <!-- Footer Copyright -->
        <div class="ims-copyright-footer">
            &copy; {{ date('Y') }} <strong>IMS ONE</strong> &nbsp;•&nbsp; Enterprise ISP System
        </div>
    </div>
</div>

</x-filament-panels::page.simple>
