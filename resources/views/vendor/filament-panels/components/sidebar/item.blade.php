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
    <!-- Connector Dot on the Left Tree-Line (for grouped items) -->
    @if ($grouped)
        <span class="ims-tree-dot {{ $active ? 'active' : '' }}"></span>
    @endif

    <a
        {{ \Filament\Support\generate_href_html($url, $shouldOpenUrlInNewTab) }}
        x-on:click="window.matchMedia(`(max-width: 1024px)`).matches && $store.sidebar.close()"
        @class([
            'fi-sidebar-item-button relative flex items-center outline-none',
            'fi-active' => $active,
            'is-standalone' => ! $grouped,
        ])
    >
        @if (filled($icon))
            <div class="fi-sidebar-item-icon-box">
                <x-filament::icon
                    :icon="($active && $activeIcon) ? $activeIcon : $icon"
                    class="fi-sidebar-item-icon"
                />
            </div>
        @endif

        <span
            @if ($sidebarCollapsible)
                x-show="$store.sidebar.isOpen || (window.matchMedia('(max-width: 1023px)').matches)"
                x-transition:enter="lg:transition lg:delay-100"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
            @endif
            class="fi-sidebar-item-label"
        >
            {{ $slot }}
        </span>

        @if (filled($badge))
            <span
                @if ($sidebarCollapsible)
                    x-show="$store.sidebar.isOpen || (window.matchMedia('(max-width: 1023px)').matches)"
                @endif
                class="fi-badge"
            >
                {{ $badge }}
            </span>
        @endif
    </a>
</li>


