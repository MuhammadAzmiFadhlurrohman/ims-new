@php
    $user = filament()->auth()->user();
    $logoutUrl = filament()->getLogoutUrl();
    $userName = filament()->getUserName($user);
    $userEmail = $user?->email ?? 'Administrator';
@endphp

{{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_BEFORE) }}

<div x-data="{ open: false }" class="relative inline-block text-left" @click.outside="open = false" @close.stop="open = false">
    {{-- Trigger Button --}}
    <button
        type="button"
        @click="open = ! open"
        aria-label="User Menu"
        class="ims-user-menu-trigger-btn flex items-center gap-2.5 px-2.5 py-1.5 rounded-full hover:bg-slate-100 transition-all cursor-pointer select-none focus:outline-none"
    >
        <x-filament-panels::avatar.user :user="$user" class="shrink-0 pointer-events-none" />
        
        <span class="ims-header-user-name font-bold text-blue-600 text-xs uppercase flex items-center gap-1.5 tracking-wide pointer-events-none">
            <span>{{ strtoupper($userName) }}</span>
            <svg class="w-3.5 h-3.5 text-blue-500 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"/>
            </svg>
        </span>
    </button>

    {{-- Dropdown Menu Panel (Direct Alpine.js with zero teleport issues) --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="transform opacity-0 scale-95 -translate-y-1"
        x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="transform opacity-0 scale-95 -translate-y-1"
        x-cloak
        style="position: absolute; right: 0; top: calc(100% + 8px); width: 14.5rem; z-index: 9999999; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 14px 40px rgba(15, 23, 42, 0.16); padding: 6px;"
    >
        {{-- User Header --}}
        <div style="padding: 10px 12px 8px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 8px;">
            <div style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 18px; height: 18px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div style="overflow: hidden; line-height: 1.25;">
                <div style="font-size: 12.5px; font-weight: 800; color: #0f172a; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">{{ $userName }}</div>
                <div style="font-size: 11px; color: #64748b; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; margin-top: 2px;">{{ $userEmail }}</div>
            </div>
        </div>

        {{-- Sign Out Button --}}
        <div style="padding: 4px 0 0;">
            <form action="{{ $logoutUrl }}" method="post" style="margin: 0;">
                @csrf
                <button
                    type="submit"
                    style="width: 100%; display: flex; align-items: center; gap: 8px; padding: 8px 12px; font-size: 12.5px; font-weight: 700; color: #ef4444; border-radius: 8px; border: none; background: transparent; cursor: pointer; text-align: left; transition: all 0.15s ease;"
                    onmouseover="this.style.background='#fef2f2'; this.style.color='#b91c1c';"
                    onmouseout="this.style.background='transparent'; this.style.color='#ef4444';"
                >
                    <svg style="width: 16px; height: 16px; color: inherit;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </div>
</div>

{{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_AFTER) }}
