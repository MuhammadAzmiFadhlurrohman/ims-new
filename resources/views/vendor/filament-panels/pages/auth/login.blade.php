<x-filament-panels::page.simple>

<style>
    /* =========================================================
       IMS ONE – ULTRA-LUXURY EXECUTIVE CYBER GLASS LOGIN SYSTEM
       File: resources/views/vendor/filament-panels/pages/auth/login.blade.php
    ========================================================= */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap');

    html, body {
        background: #060c18 !important;
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    /* Outer Viewport Layout with Ambient Radial Glows */
    .fi-simple-layout {
        background: #060c18 !important;
        background-image: 
            radial-gradient(circle at 10% 20%, rgba(14, 165, 233, 0.22) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(37, 99, 235, 0.25) 0%, transparent 45%),
            radial-gradient(circle at 50% 50%, rgba(15, 23, 42, 0.95) 0%, #040812 100%) !important;
        min-height: 100vh !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 24px !important;
        box-sizing: border-box !important;
        position: relative !important;
    }

    /* Ambient Decorative Floating Orbs */
    .fi-simple-layout::before {
        content: '';
        position: fixed;
        top: 15%;
        left: 10%;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(14, 165, 233, 0.25) 0%, transparent 70%);
        filter: blur(50px);
        pointer-events: none;
        z-index: 0;
    }

    .fi-simple-layout::after {
        content: '';
        position: fixed;
        bottom: 15%;
        right: 10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.22) 0%, transparent 70%);
        filter: blur(60px);
        pointer-events: none;
        z-index: 0;
    }

    .fi-simple-main-ctn {
        max-width: 1060px !important;
        width: 100% !important;
        padding: 0 !important;
        margin: auto !important;
        position: relative !important;
        z-index: 1 !important;
    }

    .fi-simple-main {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
        animation: imsGlassFadeIn 0.65s cubic-bezier(0.16, 1, 0.3, 1) both !important;
    }

    @keyframes imsGlassFadeIn {
        from { opacity: 0; transform: translateY(20px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .fi-simple-header,
    .fi-logo,
    .fi-simple-page-heading,
    .fi-simple-page-subheading {
        display: none !important;
    }

    /* ── MASTER SPLIT GLASS CARD ── */
    .ims-login-card {
        display: flex;
        flex-direction: row;
        background: rgba(11, 22, 44, 0.82) !important;
        backdrop-filter: blur(28px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(28px) saturate(180%) !important;
        border: 1px solid rgba(56, 189, 248, 0.22) !important;
        border-radius: 28px !important;
        box-shadow: 
            0 30px 80px -15px rgba(0, 0, 0, 0.8),
            0 0 50px -10px rgba(14, 165, 233, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.12) !important;
        overflow: hidden;
        min-height: 620px;
        width: 100%;
    }

    /* ── LEFT HERO PANEL (ROYAL SAPPHIRE GLOW) ── */
    .ims-left-hero {
        flex: 1.15;
        background: linear-gradient(145deg, rgba(2, 132, 199, 0.75) 0%, rgba(30, 64, 175, 0.85) 45%, rgba(10, 18, 36, 0.95) 100%);
        padding: 46px 42px 38px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        color: #ffffff;
        border-right: 1px solid rgba(255, 255, 255, 0.08);
    }

    .ims-left-hero::before {
        content: '';
        position: absolute;
        top: -40%;
        left: -30%;
        width: 160%;
        height: 160%;
        background: 
            radial-gradient(circle at 25% 25%, rgba(56, 189, 248, 0.4) 0%, transparent 45%),
            radial-gradient(circle at 80% 80%, rgba(37, 99, 235, 0.45) 0%, transparent 50%);
        pointer-events: none;
    }

    .ims-brand-badge {
        display: flex;
        align-items: center;
        gap: 15px;
        z-index: 2;
    }

    .ims-cube-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.12);
        border: 1.5px solid rgba(255, 255, 255, 0.28);
        backdrop-filter: blur(12px);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.25);
    }

    .ims-hero-content {
        margin: 28px 0;
        z-index: 2;
    }

    .ims-hero-title {
        font-size: 34px;
        font-weight: 900;
        line-height: 1.15;
        letter-spacing: -0.03em;
        color: #ffffff;
        margin-bottom: 6px;
    }

    .ims-hero-cyan {
        color: #38bdf8;
        display: inline-block;
        text-shadow: 0 0 24px rgba(56, 189, 248, 0.6);
    }

    .ims-hero-desc {
        font-size: 13.5px;
        line-height: 1.65;
        color: rgba(241, 245, 249, 0.88);
        max-width: 390px;
        margin-top: 12px;
    }

    /* 3 Feature Glass Cards */
    .ims-glass-pills {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        z-index: 2;
    }

    .ims-glass-pill {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 16px;
        padding: 14px 10px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25), inset 0 1px 0 rgba(255, 255, 255, 0.12);
        transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
    }

    .ims-glass-pill:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(56, 189, 248, 0.4);
        transform: translateY(-3px);
    }

    .ims-pill-icon {
        width: 34px;
        height: 34px;
        border-radius: 11px;
        background: linear-gradient(135deg, #38bdf8 0%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(56, 189, 248, 0.45);
    }

    .ims-pill-title {
        font-size: 12px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.01em;
    }

    .ims-pill-desc {
        font-size: 9.5px;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.25;
    }

    /* ── RIGHT LOGIN FORM PANEL (EXECUTIVE DARK CYBER) ── */
    .ims-right-form {
        flex: 1;
        padding: 46px 44px 34px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: rgba(8, 17, 34, 0.88) !important;
        box-sizing: border-box;
    }

    .ims-form-header {
        text-align: center;
        margin-bottom: 26px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .ims-lock-badge {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        background: rgba(14, 165, 233, 0.12);
        border: 1.5px solid rgba(56, 189, 248, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #38bdf8;
        margin-bottom: 14px;
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.25), inset 0 1px 0 rgba(255, 255, 255, 0.15);
    }

    .ims-form-title {
        font-size: 24px;
        font-weight: 900;
        color: #ffffff !important;
        letter-spacing: -0.03em;
        margin: 0 0 6px;
    }

    .ims-form-subtitle {
        font-size: 13.5px;
        color: #94a3b8 !important;
        margin: 0;
        font-weight: 500;
    }

    /* ── ULTRA-CLEAN FORM INPUTS (SCOPED TO LOGIN) ── */
    .ims-right-form .fi-fo-field-wrp {
        margin-bottom: 18px !important;
    }

    .ims-right-form .fi-fo-field-wrp-label label,
    .ims-right-form .fi-fo-field-wrp label {
        font-size: 12.5px !important;
        font-weight: 800 !important;
        color: #e2e8f0 !important;
        letter-spacing: -0.01em !important;
        margin-bottom: 6px !important;
        display: flex !important;
        align-items: center !important;
    }

    .ims-right-form .fi-fo-field-wrp-label sup,
    .ims-right-form label sup {
        color: #f87171 !important;
        font-weight: 900 !important;
        margin-left: 3px !important;
    }

    /* Input Container with Cyan Glass Border */
    .ims-right-form .fi-input-wrp,
    .ims-right-form [class*="fi-input-wrp"] {
        background: rgba(14, 26, 50, 0.9) !important;
        background-color: rgba(14, 26, 50, 0.9) !important;
        border: 1.5px solid rgba(56, 189, 248, 0.28) !important;
        border-radius: 14px !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.05) !important;
        padding: 0 !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .ims-right-form .fi-input-wrp:focus-within,
    .ims-right-form [class*="fi-input-wrp"]:focus-within {
        background: rgba(16, 32, 62, 1) !important;
        background-color: rgba(16, 32, 62, 1) !important;
        border-color: #38bdf8 !important;
        box-shadow: 
            0 0 0 4px rgba(56, 189, 248, 0.25),
            0 0 20px rgba(56, 189, 248, 0.3) !important;
    }

    .ims-right-form .fi-input-wrp input,
    .ims-right-form [class*="fi-input-wrp"] input {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #ffffff !important;
        -webkit-text-fill-color: #ffffff !important;
        padding: 12px 16px !important;
        background: transparent !important;
        border: none !important;
        outline: none !important;
    }

    .ims-right-form .fi-input-wrp input::placeholder,
    .ims-right-form [class*="fi-input-wrp"] input::placeholder {
        color: #64748b !important;
        -webkit-text-fill-color: #64748b !important;
        font-weight: 500 !important;
    }

    .ims-right-form .fi-input-wrp-suffix button,
    .ims-right-form .fi-input-wrp-suffix svg {
        color: #94a3b8 !important;
    }

    .ims-right-form .fi-input-wrp-suffix button:hover svg {
        color: #38bdf8 !important;
    }

    /* Checkbox (Remember Me) */
    .ims-right-form .fi-fo-checkbox {
        margin-top: 4px !important;
    }

    .ims-right-form .fi-checkbox-label {
        font-size: 12.5px !important;
        font-weight: 600 !important;
        color: #94a3b8 !important;
        cursor: pointer !important;
    }

    /* Submit Button (Vibrant Sapphire Neon) */
    .ims-submit-button {
        width: 100% !important;
        background: linear-gradient(135deg, #0284c7 0%, #2563eb 50%, #1d4ed8 100%) !important;
        background-color: #1d4ed8 !important;
        color: #ffffff !important;
        font-weight: 800 !important;
        font-size: 15px !important;
        padding: 13px 22px !important;
        border-radius: 14px !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 12px !important;
        box-shadow: 
            0 8px 24px rgba(37, 99, 235, 0.45),
            0 0 25px rgba(56, 189, 248, 0.25) !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
        margin-top: 16px !important;
        box-sizing: border-box !important;
    }

    .ims-submit-button:hover {
        transform: translateY(-2px) !important;
        box-shadow: 
            0 12px 32px rgba(37, 99, 235, 0.6),
            0 0 35px rgba(56, 189, 248, 0.45) !important;
        filter: brightness(1.08) !important;
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
        color: #64748b;
        margin-top: 22px;
    }

    .ims-copyright-footer strong {
        color: #38bdf8;
        font-weight: 800;
    }

    /* ── MOBILE RESPONSIVENESS (< 960px) ── */
    @media (max-width: 959px) {
        .fi-simple-layout {
            padding: 16px !important;
        }

        .ims-login-card {
            flex-direction: column;
            border-radius: 22px;
            min-height: auto;
            max-width: 440px;
            margin: 0 auto;
        }

        .ims-left-hero {
            display: none !important;
        }

        .ims-right-form {
            padding: 34px 26px 26px;
        }
    }
</style>

<div class="ims-login-card">
    {{-- ════════════════════════════════════════════════════════════
         ── LEFT HERO PANEL (ROYAL SAPPHIRE GLOW) ──
         ════════════════════════════════════════════════════════════ --}}
    <div class="ims-left-hero">
        <!-- Logo & Enterprise Brand -->
        <div class="ims-brand-badge">
            <div class="ims-cube-icon">
                <img src="{{ asset('images/favicon.svg') }}" alt="IMS Logo" style="width: 28px; height: 28px;" onerror="this.onerror=null; this.src='{{ asset('images/favicon.png') }}';">
            </div>
            <div>
                <div style="font-size: 19px; font-weight: 900; letter-spacing: -0.02em; color: #ffffff;">IMS ONE</div>
                <div style="font-size: 10.5px; font-weight: 700; color: #7dd3fc; letter-spacing: 0.05em; text-transform: uppercase;">ISP & Enterprise Management</div>
            </div>
        </div>

        <!-- Headline Content -->
        <div class="ims-hero-content">
            <div class="ims-hero-title">
                Selamat Datang<br>
                <span class="ims-hero-cyan">Kembali!</span>
            </div>
            <div style="display: flex; align-items: center; gap: 4px; margin: 12px 0 16px;">
                <span style="width: 24px; height: 3.5px; background: #38bdf8; border-radius: 2px; box-shadow: 0 0 10px rgba(56, 189, 248, 0.6);"></span>
                <span style="width: 8px; height: 3.5px; background: rgba(255,255,255,0.4); border-radius: 2px;"></span>
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
                    <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="ims-pill-title">Real-Time</div>
                <div class="ims-pill-desc">Live OLT & RouterOS</div>
            </div>

            <!-- 2. Aman -->
            <div class="ims-glass-pill">
                <div class="ims-pill-icon">
                    <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                </div>
                <div class="ims-pill-title">Aman</div>
                <div class="ims-pill-desc">Role Shield Proteksi</div>
            </div>

            <!-- 3. Otomatis -->
            <div class="ims-glass-pill">
                <div class="ims-pill-icon">
                    <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="ims-pill-title">Otomatis</div>
                <div class="ims-pill-desc">Billing & Isolir Auto</div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════
         ── RIGHT LOGIN FORM PANEL (EXECUTIVE DARK CYBER) ──
         ════════════════════════════════════════════════════════════ --}}
    <div class="ims-right-form">
        <div>
            <!-- Top Lock Badge -->
            <div class="ims-form-header">
                <div class="ims-lock-badge">
                    <svg style="width: 26px; height: 26px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
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
                    <span style="width: 24px; height: 24px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: inline-flex; align-items: center; justify-content: center;">
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
            &copy; {{ date('Y') }} <strong>IMS ONE</strong> &nbsp;•&nbsp; Enterprise ISP System
        </div>
    </div>
</div>

</x-filament-panels::page.simple>
