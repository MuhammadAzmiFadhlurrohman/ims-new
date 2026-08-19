@props([
    'active' => false,
    'activeChildItems' => false,
    'activeIcon' => null,
    'badge' => null,
    'badgeColor' => null,
    'badgeTooltip' => null,
    'childItems' => [],
    'first' => false,
    'grouped' => false,
    'icon' => null,
    'last' => false,
    'shouldOpenUrlInNewTab' => false,
    'sidebarCollapsible' => true,
    'subGrouped' => false,
    'url',
])

@php
    $sidebarCollapsible = $sidebarCollapsible && filament()->isSidebarCollapsibleOnDesktop();
@endphp

<li
    {{
        $attributes->class([
            'fi-sidebar-item relative',
            'fi-active fi-sidebar-item-active' => $active,
            'flex flex-col gap-y-1' => $active || $activeChildItems,
        ])
    }}
>
    <!-- Cyan Connector Dot on the Left Tree-Line (for grouped items) -->
    @if ($grouped)
        <span class="ims-tree-dot {{ $active ? 'active' : '' }}"></span>
    @endif

    <a
        {{ \Filament\Support\generate_href_html($url, $shouldOpenUrlInNewTab) }}
        x-on:click="window.matchMedia(`(max-width: 1024px)`).matches && $store.sidebar.close()"
        @class([
            'fi-sidebar-item-button relative flex items-center gap-x-3 rounded-xl px-3 py-2.5 outline-none transition-all duration-150',
            'fi-active' => $active,
            'is-standalone' => ! $grouped,
        ])
    >
        @if (filled($icon))
            <x-filament::icon
                :icon="($active && $activeIcon) ? $activeIcon : $icon"
                @class([
                    'fi-sidebar-item-icon w-5 h-5 shrink-0 transition-colors',
                    'text-white' => $active,
                    'text-sky-400' => ! $active,
                ])
                style="{{ $active ? 'color: #ffffff !important;' : 'color: #38bdf8 !important;' }}"
            />
        @endif

        <span
            @if ($sidebarCollapsible)
                x-show="$store.sidebar.isOpen"
                x-transition:enter="lg:transition lg:delay-100"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
            @endif
            @class([
                'fi-sidebar-item-label flex-1 truncate text-[13px] font-semibold tracking-wide',
                'text-white font-bold' => $active,
                'text-slate-200 hover:text-white' => ! $active,
            ])
            style="{{ $active ? 'color: #ffffff !important; font-weight: 700 !important;' : 'color: #e2e8f0 !important;' }}"
        >
            {{ $slot }}
        </span>

        @if (filled($badge))
            <span
                @if ($sidebarCollapsible)
                x-show="$store.sidebar.isOpen"
                @endif
                class="fi-badge px-2 py-0.5 text-[10px] font-extrabold rounded-full bg-sky-500/25 text-sky-200 border border-sky-400/30"
            >
                {{ $badge }}
            </span>
        @endif
    </a>
</li>
