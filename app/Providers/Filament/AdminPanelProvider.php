<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\View\PanelsRenderHook;
use Filament\Tables\View\TablesRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('IMS ONE')
            ->brandLogo(fn () => view('filament.components.brand-logo'))
            ->darkMode(false)
            ->colors([
                'primary' => Color::Blue,
                'gray'    => Color::Slate,
            ])
            ->font('Inter')
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('22vw')
            ->collapsedSidebarWidth('4.5rem')
            ->maxContentWidth(MaxWidth::Full)
            ->globalSearch(false)
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn () => Blade::render('
                    <script>
                        (function() {
                            try {
                                var theme = localStorage.getItem("ims_theme") || localStorage.getItem("theme");
                                if (theme === "dark" || (!theme && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
                                    document.documentElement.classList.add("dark");
                                } else {
                                    document.documentElement.classList.remove("dark");
                                }
                            } catch (e) {}
                        })();
                    </script>
                ')
            )
            ->renderHook(
                PanelsRenderHook::USER_MENU_BEFORE,
                fn () => view('filament.components.header-datetime')
            )
            ->renderHook(
                PanelsRenderHook::SIDEBAR_FOOTER,
                fn () => view('filament.components.sidebar-footer')
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => Blade::render('<style>{!! file_get_contents(resource_path("css/filament/admin/theme.css")) !!}</style>')
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => Blade::render('<style>{!! file_get_contents(resource_path("css/filament/admin/sidebar-glass.css")) !!}</style>')
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => Blade::render('<style>{!! file_get_contents(resource_path("css/filament/admin/dashboard.css")) !!}</style>')
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => Blade::render('<style>{!! file_get_contents(resource_path("css/filament/admin/pendaftaran.css")) !!}</style>')
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => Blade::render('<style>{!! file_get_contents(resource_path("css/filament/admin/header.css")) !!}</style>')
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => file_exists(resource_path("css/filament/admin/olt-theme.css"))
                    ? Blade::render('<style>{!! file_get_contents(resource_path("css/filament/admin/olt-theme.css")) !!}</style>')
                    : ''
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => Blade::render('
                    <script>
                        (function() {
                            var isThemeToggling = false;

                            window.applyImsTheme = function() {
                                try {
                                    var theme = localStorage.getItem("ims_theme") || localStorage.getItem("theme");
                                    if (theme === "dark") {
                                        document.documentElement.classList.add("dark");
                                    } else if (theme === "light") {
                                        document.documentElement.classList.remove("dark");
                                    }
                                    if (typeof window.syncImsThemeIcons === "function") {
                                        window.syncImsThemeIcons();
                                    }
                                } catch(e) {}
                            };

                            window.toggleImsTheme = function(event) {
                                if (isThemeToggling) return;
                                isThemeToggling = true;

                                var isDark = document.documentElement.classList.contains("dark");
                                var targetTheme = isDark ? "light" : "dark";

                                var toggleBtn = document.getElementById("ims-theme-toggle");
                                var btnRect = toggleBtn ? toggleBtn.getBoundingClientRect() : null;

                                var x = (event && typeof event.clientX === "number" && event.clientX > 0) 
                                    ? event.clientX 
                                    : (btnRect ? (btnRect.left + btnRect.width / 2) : (window.innerWidth - 60));
                                var y = (event && typeof event.clientY === "number" && event.clientY > 0) 
                                    ? event.clientY 
                                    : (btnRect ? (btnRect.top + btnRect.height / 2) : 35);

                                document.documentElement.style.setProperty("--ims-toggle-x", x + "px");
                                document.documentElement.style.setProperty("--ims-toggle-y", y + "px");

                                function applyDOMToggle() {
                                    if (targetTheme === "dark") {
                                        document.documentElement.classList.add("dark");
                                    } else {
                                        document.documentElement.classList.remove("dark");
                                    }
                                    localStorage.setItem("ims_theme", targetTheme);
                                    localStorage.setItem("theme", targetTheme);
                                    if (typeof window.syncImsThemeIcons === "function") {
                                        window.syncImsThemeIcons();
                                    }
                                }

                                if (document.startViewTransition) {
                                    var maxDistX = Math.max(x, window.innerWidth - x);
                                    var maxDistY = Math.max(y, window.innerHeight - y);
                                    var endRadius = Math.ceil(Math.hypot(maxDistX, maxDistY) * 1.1);

                                    var transition = document.startViewTransition(function() {
                                        applyDOMToggle();
                                    });

                                    transition.ready.then(function() {
                                        var clipPath = [
                                            "circle(0px at " + x + "px " + y + "px)",
                                            "circle(" + endRadius + "px at " + x + "px " + y + "px)"
                                        ];
                                        try {
                                            var anim = document.documentElement.animate(
                                                { clipPath: clipPath },
                                                {
                                                    duration: 1500,
                                                    easing: "cubic-bezier(0.35, 0, 0.25, 1)",
                                                    pseudoElement: "::view-transition-new(root)"
                                                }
                                            );
                                            anim.onfinish = function() {
                                                isThemeToggling = false;
                                            };
                                        } catch(err) {
                                            transition.finished.then(function() {
                                                isThemeToggling = false;
                                            }).catch(function() {
                                                isThemeToggling = false;
                                            });
                                        }
                                    }).catch(function() {
                                        isThemeToggling = false;
                                    });
                                } else {
                                    applyDOMToggle();
                                    setTimeout(function() {
                                        isThemeToggling = false;
                                    }, 300);
                                }
                            };

                            window.applyImsTheme();
                            document.addEventListener("DOMContentLoaded", window.applyImsTheme);
                            document.addEventListener("livewire:navigated", window.applyImsTheme);
                            document.addEventListener("livewire:init", window.applyImsTheme);

                            // Enforce dark class preservation against livewire re-renders safely
                            try {
                                var observer = new MutationObserver(function() {
                                    if (isThemeToggling) return;
                                    var theme = localStorage.getItem("ims_theme");
                                    if (theme === "dark" && !document.documentElement.classList.contains("dark")) {
                                        document.documentElement.classList.add("dark");
                                    } else if (theme === "light" && document.documentElement.classList.contains("dark")) {
                                        document.documentElement.classList.remove("dark");
                                    }
                                });
                                observer.observe(document.documentElement, { attributes: true, attributeFilter: ["class"] });
                            } catch(e) {}
                        })();

                        window.currentImsRecordKey = "";

                        window.openImsStatusModal = function(key, status) {
                            window.currentImsRecordKey = key;
                            var radios = document.querySelectorAll("input[name=\'ims_status_radio\']");
                            for (var i = 0; i < radios.length; i++) {
                                if (radios[i].value.toLowerCase() === (status || "").toLowerCase()) {
                                    radios[i].checked = true;
                                }
                            }
                            var modal = document.getElementById("ims-status-modal");
                            if (modal) {
                                modal.style.setProperty("display", "flex", "important");
                            } else {
                                console.error("Modal ims-status-modal not found");
                            }
                        };

                        window.closeImsStatusModal = function() {
                            var modal = document.getElementById("ims-status-modal");
                            if (modal) {
                                modal.style.setProperty("display", "none", "important");
                            }
                        };

                        window.submitImsStatusChange = function() {
                            var selectedRadio = document.querySelector("input[name=\'ims_status_radio\']:checked");
                            var statusValue = selectedRadio ? selectedRadio.value : "Temporary Delete";
                            var saveText = document.getElementById("ims-btn-save-text");
                            if (saveText) saveText.textContent = "Menyimpan...";

                            var csrfMeta = document.querySelector("meta[name=\'csrf-token\']");
                            var csrfToken = csrfMeta ? csrfMeta.content : "";

                            fetch("/admin/update-status-type", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": csrfToken,
                                    "Accept": "application/json"
                                },
                                body: JSON.stringify({
                                    key: window.currentImsRecordKey,
                                    status_type: statusValue
                                })
                            }).then(function(res) { return res.json(); }).then(function(data) {
                                if (saveText) saveText.textContent = "Ubah";
                                window.closeImsStatusModal();
                                window.location.reload();
                            }).catch(function(err) {
                                alert("Gagal update status: " + err.message);
                                if (saveText) saveText.textContent = "Ubah";
                            });
                        };

                        // Hover-to-Open Submenu on Minimized Sidebar
                        document.addEventListener("mouseover", function(e) {
                            var sidebar = document.querySelector(".fi-sidebar");
                            if (!sidebar || sidebar.classList.contains("fi-sidebar-open")) return;

                            var target = e.target.closest(".fi-sidebar-group");
                            if (target) {
                                var trigger = target.querySelector(".fi-dropdown-trigger") || target.querySelector("button");
                                if (trigger && !trigger.getAttribute("data-hover-opened")) {
                                    trigger.setAttribute("data-hover-opened", "true");
                                    trigger.click();
                                    setTimeout(function() {
                                        trigger.removeAttribute("data-hover-opened");
                                    }, 400);
                                }
                            }
                        });
                    </script>
                ')
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn () => view('filament.components.status-type-modal')
            )
            ->renderHook(
                TablesRenderHook::TOOLBAR_BEFORE,
                fn () => (request()->routeIs('*monthly-invoices*') || str_contains(request()->url(), 'monthly-invoices'))
                    ? view('filament.widgets.billing-summary-widget')
                    : ''
            )
            ->renderHook(
                PanelsRenderHook::BODY_START,
                fn () => Blade::render('
                    <style>
                        html.fi body.fi-body,
                        body.fi-body {
                            background: linear-gradient(145deg, #dff5f0 0%, #e8eeff 30%, #ede9ff 60%, #e0f2fe 100%) fixed !important;
                        }
                        html.dark body.fi-body,
                        html.dark.fi body.fi-body,
                        html.dark {
                            background: #030a14 !important;
                            background-color: #030a14 !important;
                        }
                        .fi-main-ctn, .fi-main, .fi-page {
                            background: transparent !important;
                            background-color: transparent !important;
                        }
                    </style>
                ')
            )
            ->navigationGroups([
                NavigationGroup::make('Pelanggan & Layanan')
                    ->icon('heroicon-o-users')
                    ->collapsed(false),
                NavigationGroup::make('Keuangan & Billing')
                    ->icon('heroicon-o-banknotes')
                    ->collapsed(false),
                NavigationGroup::make('Operasional & Helpdesk')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->collapsed(false),
                NavigationGroup::make('Jaringan & Inventaris')
                    ->icon('heroicon-o-server-stack')
                    ->collapsed(false),
                NavigationGroup::make('OLT')
                    ->icon('heroicon-o-share')
                    ->collapsed(false),
                NavigationGroup::make('Manajemen Internal & System')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(true),
                NavigationGroup::make('Keamanan & Audit Sistem')
                    ->icon('heroicon-o-shield-check')
                    ->collapsed(false),
            ])
            ->navigationItems((function () {
                $items = [];
                try {
                    if (\Illuminate\Support\Facades\Schema::hasTable('olts')) {
                        $olts = \App\Models\Olt::all();
                        $sort = 10;
                        foreach ($olts as $olt) {
                            $items[] = \Filament\Navigation\NavigationItem::make($olt->name)
                                ->group('OLT')
                                ->icon('heroicon-o-server-stack')
                                ->sort($sort++)
                                ->isActiveWhen(fn () => request()->get('olt') === $olt->code && request()->routeIs('filament.admin.pages.olt-management-page'))
                                ->url(fn () => \App\Filament\Pages\OltManagementPage::getUrl(['olt' => $olt->code]));
                        }
                    }
                } catch (\Throwable $e) {
                    // fail silently
                }
                return $items;
            })())
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 4,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
            ])
            ->resources([
                \App\Filament\Resources\ActivityLogResource::class,
                \App\Filament\Resources\BandwidthPackageResource::class,
                \App\Filament\Resources\CustomerResource::class,
                \App\Filament\Resources\CustomerSubscriptionResource::class,
                \App\Filament\Resources\DepartmentResource::class,
                \App\Filament\Resources\EmployeeResource::class,
                \App\Filament\Resources\InstallationPipelineResource::class,
                \App\Filament\Resources\ItemCategoryResource::class,
                \App\Filament\Resources\ItemResource::class,
                \App\Filament\Resources\MonthlyInvoiceResource::class,
                \App\Filament\Resources\OdpResource::class,
                \App\Filament\Resources\OltResource::class,
                \App\Filament\Resources\PackageMutationResource::class,
                \App\Filament\Resources\PositionResource::class,
                \App\Filament\Resources\RegistrationInvoiceResource::class,
                \App\Filament\Resources\RouterHistoryResource::class,
                \App\Filament\Resources\RouterResource::class,
                \App\Filament\Resources\ServiceSuspensionResource::class,
                \App\Filament\Resources\ServiceTerminationResource::class,
                \App\Filament\Resources\TicketResource::class,
                \App\Filament\Resources\UserResource::class,
            ])
            ->pages([
                Pages\Dashboard::class,
                \App\Filament\Pages\DataPelangganMatrixPage::class,
                \App\Filament\Pages\OltCoveragePage::class,
                \App\Filament\Pages\OltManagementPage::class,
                \App\Filament\Pages\OltUserSearchPage::class,
            ])
            ->widgets([
                \App\Filament\Widgets\StatsOverviewWidget::class,
                \App\Filament\Widgets\BillingChartWidget::class,
                \App\Filament\Widgets\CustomerStatusChartWidget::class,
                \App\Filament\Widgets\CustomerStatusMatrixWidget::class,
                \App\Filament\Widgets\OverdueInvoicesWidget::class,
                \App\Filament\Widgets\TicketOverviewCardsWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
