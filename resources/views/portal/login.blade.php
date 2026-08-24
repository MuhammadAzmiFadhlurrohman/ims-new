<!DOCTYPE html>
<html lang="id" class="dark h-full bg-[#08111e]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Layanan Pelanggan — IMS ONE</title>
    <meta name="description" content="Portal mandiri pelanggan IMS ONE. Lapor gangguan, ajukan upgrade paket, dan pantau tiket teknisi.">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                        },
                        darknavy: {
                            950: '#040810',
                            900: '#08111e',
                            800: '#0d1d33',
                            700: '#132845',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }
        html, body {
            background-color: #08111e !important;
            color: #f1f5f9;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100%;
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Outfit', sans-serif;
        }
        .cyber-glow {
            background: radial-gradient(circle at 50% 25%, rgba(14, 165, 233, 0.18) 0%, rgba(8, 17, 30, 0) 70%);
        }
        .glass-card {
            background: rgba(13, 29, 51, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-[#08111e] flex flex-col justify-between min-h-screen text-slate-100 cyber-glow">

    <!-- Top Navigation Header -->
    <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 sm:gap-3 group">
            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-2xl bg-gradient-to-tr from-brand-600 to-cyan-400 p-0.5 shadow-lg shadow-brand-500/25 flex items-center justify-center transform group-hover:scale-105 transition-transform">
                <div class="w-full h-full bg-[#08111e] rounded-[14px] flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                    </svg>
                </div>
            </div>
            <div>
                <span class="font-heading text-lg sm:text-xl font-black text-white flex items-center gap-1 leading-none">
                    IMS<span class="text-brand-400">ONE</span>
                </span>
                <span class="text-[8.5px] sm:text-[9px] font-extrabold tracking-widest text-slate-400 uppercase block mt-0.5">
                    Customer Care
                </span>
            </div>
        </a>

        <a href="{{ url('/') }}" class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-xs font-bold text-slate-300 hover:text-white transition-all">
            <svg class="w-3.5 h-3.5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="hidden sm:inline">Kembali ke Beranda</span>
            <span class="sm:hidden">Beranda</span>
        </a>
    </header>

    <!-- Main Card Container -->
    <main class="w-full max-w-md mx-auto px-4 py-4 sm:py-8 my-auto">
        
        <div class="glass-card rounded-3xl p-6 sm:p-10 shadow-2xl border border-brand-500/25 relative overflow-hidden">
            
            <!-- Glow Accent -->
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-brand-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="text-center mb-6 sm:mb-8 relative z-10">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-tr from-brand-600/30 to-cyan-400/20 border border-brand-400/30 flex items-center justify-center mx-auto mb-3.5 text-2xl shadow-inner">
                    📱
                </div>
                <h1 class="font-heading text-2xl sm:text-3xl font-black text-white mb-2 tracking-tight">
                    Layanan Pelanggan
                </h1>
                <p class="text-xs text-slate-300 leading-relaxed font-medium">
                    Masukkan nomor WhatsApp yang terdaftar untuk mengakses info langganan, lapor gangguan, dan tiket layanan Anda.
                </p>
            </div>

            <!-- Flash Error / Info Alerts -->
            @if(session('error'))
                <div class="p-3.5 sm:p-4 rounded-2xl bg-rose-500/15 border border-rose-500/30 text-rose-300 text-xs font-medium mb-5 leading-relaxed flex items-start gap-2.5">
                    <span class="text-rose-400 text-base shrink-0">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="p-3.5 sm:p-4 rounded-2xl bg-sky-500/15 border border-sky-500/30 text-sky-300 text-xs font-medium mb-5 leading-relaxed flex items-start gap-2.5">
                    <span class="text-sky-400 text-base shrink-0">ℹ️</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('customer.login') }}" method="POST" class="space-y-4 sm:space-y-5 relative z-10">
                @csrf
                
                <div>
                    <label class="block font-bold text-xs text-slate-300 mb-2">
                        Nomor Telepon / WhatsApp Terdaftar *
                    </label>
                    <div class="flex items-center h-14 px-3 sm:px-4 rounded-2xl bg-white/5 border border-white/15 focus-within:border-cyan-400 focus-within:ring-2 focus-within:ring-cyan-400/20 focus-within:bg-[#0c1b30] transition-all shadow-inner">
                        
                        <!-- Country / Prefix Badge -->
                        <div class="flex items-center gap-1.5 pr-3 mr-3 border-r border-white/15 select-none shrink-0">
                            <span class="text-sm">🇮🇩</span>
                            <span class="text-slate-300 text-xs sm:text-sm font-black tracking-wide">+62</span>
                        </div>

                        <!-- Numeric Dialpad Input -->
                        <input 
                            type="tel" 
                            inputmode="numeric" 
                            pattern="[0-9]*"
                            name="phone_or_cid" 
                            placeholder="081298765432" 
                            required 
                            autofocus
                            class="w-full bg-transparent text-white placeholder-slate-500 text-sm sm:text-base font-bold outline-none tracking-wide"
                        />
                    </div>
                    
                    <span class="text-[11px] text-slate-400 mt-1.5 block leading-relaxed">
                        💡 Masukkan nomor WhatsApp tanpa spasi atau strip. Bisa juga menggunakan ID Pelanggan (CID).
                    </span>
                </div>

                <button type="submit" class="w-full h-14 rounded-2xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white font-black text-sm shadow-xl shadow-cyan-500/25 transition-all transform active:scale-[0.99] flex items-center justify-center gap-2">
                    <span>Masuk ke Portal Layanan &rarr;</span>
                </button>

                <!-- Session Policy Notice -->
                <div class="p-3 rounded-xl bg-white/5 border border-white/5 text-[10.5px] text-slate-400 text-center flex items-center justify-center gap-1.5">
                    <span>⏱️</span>
                    <span>Sesi akses berlaku <strong>1 Jam</strong> untuk menghemat beban server.</span>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-white/10 text-center relative z-10">
                <p class="text-xs text-slate-400 mb-1.5">Belum terdaftar atau nomor HP berubah?</p>
                <a href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20membutuhkan%20bantuan%20login%20portal%20pelanggan" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-cyan-400 hover:text-cyan-300 hover:underline">
                    <span>💬 Hubungi Customer Service 24/7</span>
                </a>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full max-w-7xl mx-auto px-4 py-4 sm:py-6 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} IMS ONE (Media Sarana Network). Portal Layanan Mandiri Pelanggan.
    </footer>

</body>
</html>
