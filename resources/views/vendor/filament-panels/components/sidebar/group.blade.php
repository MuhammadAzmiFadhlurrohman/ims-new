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
@endphp

@if (blank($label))
    {{-- ── 1. STANDALONE ITEM (DASHBOARD) ── --}}
    <li class="fi-sidebar-group flex flex-col gap-y-1 relative my-1">
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
                'fi-active' => $active,
            ])
        }}
        style="overflow: visible !important;"
    >
        {{-- HEADER GRUP STATIS (DENGAN IKON BIRU MENYALA & GARIS PEMBATAS KANAN) --}}
        <div
            x-show="$store.sidebar.isOpen"
            x-transition:enter="delay-100 lg:transition"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="ims-group-header flex items-center gap-2.5 px-3 py-1.5 mt-0.5 mb-0.5 select-none"
        >
            <!-- Left Short Line -->
            <div class="w-2.5 h-px bg-white/20 shrink-0"></div>

            <!-- Glowing Electric Blue Icon (Biru Menyala) -->
            @if ($icon)
                <div class="ims-group-icon-glow flex items-center justify-center shrink-0">
                    <x-filament::icon
                        :icon="$icon"
                        style="color: #00d4ff !important; width: 1.2rem; height: 1.2rem; filter: drop-shadow(0 0 6px rgba(0, 212, 255, 0.85)) !important;"
                        class="w-5 h-5 text-sky-400"
                    />
                </div>
            @endif

            <!-- Group Title Left Aligned -->
            <span
                style="color: #94a3b8 !important; font-size: 11px !important; font-weight: 800 !important; letter-spacing: 0.08em !important; text-transform: uppercase !important; margin-left: 2px; white-space: nowrap !important;"
            >
                {{ $label }}
            </span>

            <!-- Right Divider Line Extending to the Edge -->
            <div class="h-px bg-white/10 flex-1 ml-2"></div>
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
                class="relative w-full flex justify-center py-1"
                style="overflow: visible !important;"
            >
                <!-- Tombol Ikon Grup (Biru Menyala) -->
                <button
                    type="button"
                    class="w-11 h-11 flex items-center justify-center rounded-xl transition-all duration-150 cursor-pointer hover:bg-sky-500/20 {{ $active ? 'bg-sky-600/40 text-white border border-sky-400/50 shadow-lg shadow-sky-500/30' : 'bg-transparent text-sky-400' }}"
                >
                    <x-filament::icon
                        :icon="$icon"
                        style="color: #00d4ff !important; width: 1.4rem; height: 1.4rem; filter: drop-shadow(0 0 7px rgba(0, 212, 255, 0.85)) !important;"
                        class="w-6 h-6 text-sky-400 hover:text-white transition-colors"
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
                                        <span class="ims-flyout-bullet"></span>
                                        <span class="ims-flyout-link-text">{{ $child->getLabel() }}</span>
                                    </a>
                                @endforeach
                            @else
                                <a
                                    href="{{ $item->getUrl() }}"
                                    @if ($item->shouldOpenUrlInNewTab()) target="_blank" @endif
                                    class="ims-flyout-link {{ $itemIsActive ? 'active' : '' }}"
                                >
                                    @if ($itemIcon)
                                        <x-filament::icon
                                            :icon="$itemIcon"
                                            class="ims-flyout-icon"
                                        />
                                    @else
                                        <span class="ims-flyout-bullet"></span>
                                    @endif
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
