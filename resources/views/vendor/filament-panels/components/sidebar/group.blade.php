@props([
    'active' => false,
    'collapsible' => true,
    'icon' => null,
    'items' => [],
    'label' => null,
    'sidebarCollapsible' => true,
    'subNavigation' => false,
])

@php
    $sidebarCollapsible = $sidebarCollapsible && filament()->isSidebarCollapsibleOnDesktop();
    $hasDropdown = filled($label) && filled($icon) && $sidebarCollapsible;

    $groupLower = strtolower($label ?? '');
    $groupThemeClass = match (true) {
        str_contains($groupLower, 'olt') => 'ims-group-theme-olt',
        str_contains($groupLower, 'manajemen') || str_contains($groupLower, 'system') => 'ims-group-theme-manajemen',
        str_contains($groupLower, 'pelanggan') || str_contains($groupLower, 'layanan') => 'ims-group-theme-pelanggan',
        str_contains($groupLower, 'keuangan') || str_contains($groupLower, 'billing') => 'ims-group-theme-keuangan',
        str_contains($groupLower, 'operasional') || str_contains($groupLower, 'helpdesk') => 'ims-group-theme-operasional',
        str_contains($groupLower, 'jaringan') || str_contains($groupLower, 'inventaris') => 'ims-group-theme-jaringan',
        default => 'ims-group-theme-default',
    };
@endphp

@if (blank($label))
    {{-- ── 1. STANDALONE ITEM (DASHBOARD) ── --}}
    <li class="fi-sidebar-group flex flex-col gap-y-1 relative my-1 ims-group-dashboard">
        @foreach ($items as $item)
            @php
                $itemIcon = $item->getIcon();
                $itemActiveIcon = $item->getActiveIcon();
            @endphp

            <x-filament-panels::sidebar.item
                :active="$item->isActive()"
                :active-child-items="$item->isChildItemsActive()"
                :active-icon="$itemActiveIcon"
                :badge="$item->getBadge()"
                :badge-color="$item->getBadgeColor()"
                :badge-tooltip="$item->getBadgeTooltip()"
                :child-items="$item->getChildItems()"
                :first="$loop->first"
                :grouped="false"
                :icon="$itemIcon"
                :last="$loop->last"
                :should-open-url-in-new-tab="$item->shouldOpenUrlInNewTab()"
                :sidebar-collapsible="$sidebarCollapsible"
                :url="$item->getUrl()"
            >
                {{ $item->getLabel() }}

                @if ($itemIcon instanceof \Illuminate\Contracts\Support\Htmlable)
                    <x-slot name="icon">
                        {{ $itemIcon }}
                    </x-slot>
                @endif

                @if ($itemActiveIcon instanceof \Illuminate\Contracts\Support\Htmlable)
                    <x-slot name="activeIcon">
                        {{ $itemActiveIcon }}
                    </x-slot>
                @endif
            </x-filament-panels::sidebar.item>
        @endforeach
    </li>
@else
    {{-- ── 2. GROUPED CATEGORY (STATIC HEADER DIVIDER TANPA DROPDOWN) ── --}}
    <li
        {{
            $attributes->class([
                'fi-sidebar-group flex flex-col gap-y-1 relative my-1',
                $groupThemeClass,
                'fi-active' => $active,
            ])
        }}
        style="overflow: visible !important;"
    >

        {{-- HEADER GRUP STATIS (DENGAN IKON MENYALA & GARIS PEMBATAS KANAN) --}}
        <div
            x-show="$store.sidebar.isOpen"
            x-transition:enter="delay-100 lg:transition"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="ims-group-header flex items-center select-none"
        >
            <!-- Glowing Accent Icon -->
            @if ($icon)
                <div class="ims-group-icon-glow flex items-center justify-center shrink-0">
                    <x-filament::icon
                        :icon="$icon"
                        class="ims-group-icon"
                    />
                </div>
            @endif

            <!-- Group Title Left Aligned -->
            <span class="ims-group-title">
                {{ $label }}
            </span>

            <!-- Right Divider Line Extending to the Edge -->
            <div class="ims-group-divider"></div>
        </div>

        {{-- TAMPILAN SAAT SIDEBAR TERTUTUP (MINIMIZE / HOVER FLYOUT) --}}
        @if ($hasDropdown)
            <div
                x-data="{
                    isHovered: false,
                    timer: null,
                    showMenu() {
                        clearTimeout(this.timer);
                        this.isHovered = true;
                    },
                    hideMenu() {
                        this.timer = setTimeout(() => {
                            this.isHovered = false;
                        }, 150);
                    }
                }"
                x-show="! $store.sidebar.isOpen"
                x-on:mouseenter="showMenu()"
                x-on:mouseleave="hideMenu()"
                class="relative w-full flex justify-center py-1 ims-flyout-trigger-wrap"
            >
                <!-- Tombol Ikon Grup -->
                <button
                    type="button"
                    class="ims-collapsed-group-btn {{ $active ? 'active' : '' }}"
                >
                    <x-filament::icon
                        :icon="$icon"
                        class="ims-collapsed-group-icon"
                    />
                </button>


                <!-- Menu Popout Submenu -->
                <div
                    x-show="isHovered"
                    x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-2"
                    class="ims-flyout-menu"
                    style="position: absolute !important; left: calc(100% + 14px) !important; top: -6px !important; display: none;"
                >
                    <div class="absolute -left-5 top-0 bottom-0 w-6 bg-transparent"></div>

                    <div class="ims-flyout-header">
                        <span class="ims-flyout-title">{{ $label }}</span>
                        <span class="ims-flyout-badge">{{ count($items) }} Menu</span>
                    </div>

                    <div class="ims-flyout-list">
                        @foreach ($items as $item)
                            @php
                                $itemIsActive = $item->isActive();
                                $itemIcon = $item->getIcon();
                                $childItems = $item->getChildItems();
                            @endphp

                            @if ($childItems && count($childItems) > 0)
                                <div class="ims-flyout-subgroup-title">
                                    {{ $item->getLabel() }}
                                </div>
                                @foreach ($childItems as $child)
                                    <a
                                        href="{{ $child->getUrl() }}"
                                        @if ($child->shouldOpenUrlInNewTab()) target="_blank" @endif
                                        class="ims-flyout-link {{ $child->isActive() ? 'active' : '' }}"
                                    >
                                        <div class="ims-flyout-icon-box">
                                            <span class="ims-flyout-bullet"></span>
                                        </div>
                                        <span class="ims-flyout-link-text">{{ $child->getLabel() }}</span>
                                    </a>
                                @endforeach
                            @else
                                <a
                                    href="{{ $item->getUrl() }}"
                                    @if ($item->shouldOpenUrlInNewTab()) target="_blank" @endif
                                    class="ims-flyout-link {{ $itemIsActive ? 'active' : '' }}"
                                >
                                    <div class="ims-flyout-icon-box">
                                        @if ($itemIcon)
                                            <x-filament::icon
                                                :icon="$itemIcon"
                                                class="ims-flyout-icon"
                                            />
                                        @else
                                            <span class="ims-flyout-bullet"></span>
                                        @endif
                                    </div>
                                    <span class="ims-flyout-link-text">{{ $item->getLabel() }}</span>
                                    @if ($badge = $item->getBadge())
                                        <span class="ims-flyout-item-badge">{{ $badge }}</span>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
        @endif

        {{-- LIST ITEM SAAT SIDEBAR TERBUKA (SELALU TAMPIL DENGAN CYAN TREE LINE) --}}
        <ul
            x-show="$store.sidebar.isOpen"
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 -translate-x-2"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 -translate-x-2"
            class="fi-sidebar-group-items ims-tree-line relative flex flex-col gap-y-1 my-1"
        >
            @foreach ($items as $item)
                @php
                    $itemIcon = $item->getIcon();
                    $itemActiveIcon = $item->getActiveIcon();
                @endphp

                <x-filament-panels::sidebar.item
                    :active="$item->isActive()"
                    :active-child-items="$item->isChildItemsActive()"
                    :active-icon="$itemActiveIcon"
                    :badge="$item->getBadge()"
                    :badge-color="$item->getBadgeColor()"
                    :badge-tooltip="$item->getBadgeTooltip()"
                    :child-items="$item->getChildItems()"
                    :first="$loop->first"
                    :grouped="true"
                    :icon="$itemIcon"
                    :last="$loop->last"
                    :should-open-url-in-new-tab="$item->shouldOpenUrlInNewTab()"
                    :sidebar-collapsible="$sidebarCollapsible"
                    :url="$item->getUrl()"
                >
                    {{ $item->getLabel() }}

                    @if ($itemIcon instanceof \Illuminate\Contracts\Support\Htmlable)
                        <x-slot name="icon">
                            {{ $itemIcon }}
                        </x-slot>
                    @endif

                    @if ($itemActiveIcon instanceof \Illuminate\Contracts\Support\Htmlable)
                        <x-slot name="activeIcon">
                            {{ $itemActiveIcon }}
                        </x-slot>
                    @endif
                </x-filament-panels::sidebar.item>
            @endforeach
        </ul>
    </li>
@endif
