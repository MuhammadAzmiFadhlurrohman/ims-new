<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0E2238]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Portal Pelanggan — IMS ONE Fiber Network</title>
    <meta name="description" content="Portal mandiri pelanggan IMS ONE. Lapor gangguan, kelola paket internet, pantau tiket teknisi, dan cek tagihan.">

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
            theme: {
                extend: {
                    colors: {
                        brand: {
                            DEFAULT: '#0878E5',
                            dark: '#0757B8',
                            light: '#55C7FF',
                            soft: '#EAF5FF',
                            pale: '#F4FAFF',
                            deep: '#0E2238',
                            card: '#16365C',
                            navy: '#0B1F33',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    boxShadow: {
                        'brand-soft': '0 8px 30px rgba(8, 120, 229, 0.15)',
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
            background-color: #0E2238 !important;
            color: #F8FAFC;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Outfit', sans-serif;
        }
        .btn-brand-primary {
            background-color: #0878E5 !important;
            color: #ffffff !important;
        }
        .btn-brand-primary:hover {
            background-color: #0757B8 !important;
        }
        @keyframes pulseBlue {
            0%, 100% { box-shadow: 0 0 0 0 rgba(85, 199, 255, 0.6); }
            50% { box-shadow: 0 0 0 10px rgba(85, 199, 255, 0); }
        }
        .pulse-beacon-blue {
            animation: pulseBlue 2s infinite;
        }
    </style>
</head>
<body class="flex flex-col justify-between min-h-screen text-slate-100 bg-[#0E2238] relative overflow-x-hidden">

    <!-- Ambient Subtle Glow Background -->
    <div class="fixed inset-0 pointer-events-none select-none overflow-hidden" aria-hidden="true">
        <div class="absolute -top-32 right-1/4 w-[500px] h-[500px] bg-[#0878E5]/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 left-1/4 w-[500px] h-[500px] bg-[#55C7FF]/15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-[#184271]/30 rounded-full blur-3xl"></div>
    </div>

    <!-- Top Navigation Header -->
    <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 sm:py-4 flex items-center justify-between relative z-10 shrink-0">
        
        <!-- Logo: IMS ONE (Brand Theme) -->
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
            <div class="w-7 h-7 rounded-lg bg-brand text-white flex items-center justify-center font-bold text-xs shadow-md shadow-brand/30 group-hover:scale-105 transition-transform">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                </svg>
            </div>
            <div>
                <span class="font-heading text-base font-black text-white tracking-tight leading-none block">
                    IMS<span class="text-brand-light">ONE</span>
                </span>
                <span class="text-[8px] font-extrabold tracking-widest text-brand-light uppercase block">
                    Customer Portal
                </span>
            </div>
        </a>

        <!-- Back to Home Button -->
        <a href="{{ url('/') }}" class="h-8 px-3.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold transition-all backdrop-blur-sm flex items-center gap-1.5 shadow-sm">
            <span class="text-brand-light font-black">&larr;</span>
            <span class="hidden sm:inline">Kembali ke Beranda</span>
            <span class="sm:hidden">Beranda</span>
        </a>
    </header>

    <!-- Main Card Container -->
    <main class="w-full flex-1 flex items-center justify-center px-4 py-5 relative z-10">
        
        <div class="bg-[#153256]/90 border border-white/20 backdrop-blur-2xl rounded-2xl p-5 sm:p-6 max-w-[390px] w-full shadow-2xl relative overflow-hidden">
            
            <!-- Glow Accent Inside Card -->
            <div class="absolute -top-16 -right-16 w-36 h-36 bg-[#0878E5]/30 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Top Security Beacon -->
            <div class="flex items-center justify-between mb-3 pb-2.5 border-b border-white/15">
                <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-brand-light tracking-wider uppercase font-mono">
                    <span class="w-2 h-2 rounded-full bg-brand-light pulse-beacon-blue"></span>
                    <span>SECURE ACCESS PORTAL</span>
                </span>
                <span class="text-[10px] text-slate-300 font-mono font-bold">256-BIT SSL</span>
            </div>

            <div class="text-center mb-4">
                <h1 class="font-heading text-xl sm:text-2xl font-black text-white mb-1 tracking-tight">
                    Layanan Pelanggan
                </h1>
                <p class="text-[11px] text-slate-300 leading-relaxed font-medium">
                    Masukkan nomor WhatsApp atau CID terdaftar untuk memantau status jaringan, tagihan, dan tiket.
                </p>
            </div>

            <!-- Flash Error / Info Alerts -->
            @if(session('error'))
                <div class="p-3 rounded-xl bg-rose-500/20 border border-rose-400/40 text-rose-200 text-xs font-medium mb-3 leading-snug flex items-start gap-2">
                    <span class="text-rose-300 text-sm shrink-0">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="p-3 rounded-xl bg-[#0878E5]/25 border border-[#55C7FF]/40 text-[#55C7FF] text-xs font-medium mb-3 leading-snug flex items-start gap-2">
                    <span class="text-brand-light text-sm shrink-0">ℹ️</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('customer.login') }}" method="POST" class="space-y-3.5">
                @csrf
                
                <div>
                    <label class="block font-bold text-xs text-slate-100 mb-1.5">
                        Nomor WhatsApp / CID Pelanggan *
                    </label>
                    <div class="flex items-center h-10 px-3 rounded-xl bg-[#0E2238]/90 border border-white/20 focus-within:border-brand-light focus-within:ring-2 focus-within:ring-brand/40 transition-all shadow-inner">
                        
                        <!-- Country Prefix Badge -->
                        <div class="flex items-center gap-1.5 pr-2.5 mr-2.5 border-r border-white/20 select-none shrink-0">
                            <span class="text-xs">🇮🇩</span>
                            <span class="text-brand-light text-xs font-black tracking-wide">+62</span>
                        </div>

                        <!-- Numeric Dialpad Input -->
                        <input 
                            type="tel" 
                            inputmode="numeric" 
                            name="phone_or_cid" 
                            placeholder="081298765432 atau CID" 
                            required 
                            autofocus
                            class="w-full bg-transparent text-white placeholder-slate-400 text-xs sm:text-sm font-bold outline-none tracking-wide"
                        />
                    </div>
                    
                    <span class="text-[10px] text-slate-300 mt-1.5 flex items-center gap-1">
                        <span class="text-brand-light">💡</span>
                        <span>Bisa juga memasukkan ID Pelanggan (CID).</span>
                    </span>
                </div>

                <button type="submit" class="w-full h-10 rounded-xl btn-brand-primary text-white font-black text-xs shadow-lg shadow-brand/30 transition-all flex items-center justify-center gap-1.5 hover:shadow-xl">
                    <span>Masuk ke Portal Layanan</span>
                    <span class="text-white font-black">&rarr;</span>
                </button>
            </form>

            <div class="mt-4 pt-3 border-t border-white/15 text-center">
                <p class="text-xs text-slate-300 mb-1">Belum terdaftar atau nomor HP berubah?</p>
                <a href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20membutuhkan%20bantuan%20login%20portal%20pelanggan" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-light hover:text-white hover:underline transition-colors">
                    <span>💬 Hubungi Customer Service 24/7</span>
                </a>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full max-w-7xl mx-auto px-4 py-3 sm:py-3.5 text-center text-xs text-slate-400 relative z-10 shrink-0 border-t border-white/10">
        &copy; {{ date('Y') }} IMS ONE Fiber Network. Portal Layanan Mandiri Pelanggan.
    </footer>

</body>
</html>
