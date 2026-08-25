<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F4FAFF]">
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
                            deep: '#062B5C',
                            navy: '#0B1F33',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    boxShadow: {
                        'brand-soft': '0 8px 30px rgba(8, 120, 229, 0.08)',
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
            background-color: #F4FAFF !important;
            color: #0B1F33;
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
            0%, 100% { box-shadow: 0 0 0 0 rgba(8, 120, 229, 0.4); }
            50% { box-shadow: 0 0 0 8px rgba(8, 120, 229, 0); }
        }
        .pulse-beacon-blue {
            animation: pulseBlue 2s infinite;
        }
    </style>
</head>
<body class="flex flex-col justify-between min-h-screen text-slate-800 bg-[#F4FAFF] relative overflow-x-hidden">

    <!-- Top Navigation Header -->
    <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-5 flex items-center justify-between relative z-10 shrink-0">
        
        <!-- Logo: IMS ONE (Landing Theme) -->
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
            <div class="w-7 h-7 rounded-lg bg-brand text-white flex items-center justify-center font-bold text-xs shadow-sm group-hover:scale-105 transition-transform">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                </svg>
            </div>
            <div>
                <span class="font-heading text-base font-black text-brand-navy tracking-tight leading-none block">
                    IMS<span class="text-brand">ONE</span>
                </span>
                <span class="text-[8px] font-extrabold tracking-widest text-brand uppercase block">
                    Customer Portal
                </span>
            </div>
        </a>

        <!-- Back to Home Button -->
        <a href="{{ url('/') }}" class="h-9 px-4 rounded-full bg-white hover:bg-brand-soft border border-blue-200 text-brand-navy text-xs font-bold transition-all shadow-sm flex items-center gap-2">
            <span class="text-brand font-black">&larr;</span>
            <span class="hidden sm:inline">Kembali ke Beranda</span>
            <span class="sm:hidden">Beranda</span>
        </a>
    </header>

    <!-- Main Card Container -->
    <main class="w-full flex-1 flex items-center justify-center px-4 py-6 relative z-10">
        
        <div class="bg-white border border-blue-100 rounded-2xl p-5 sm:p-6 max-w-[390px] w-full shadow-brand-soft relative overflow-hidden">
            
            <!-- Top Security Beacon -->
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <span class="inline-flex items-center gap-2 text-[10.5px] font-black text-brand tracking-wider uppercase font-mono">
                    <span class="w-2 h-2 rounded-full bg-brand pulse-beacon-blue"></span>
                    <span>SECURE ACCESS PORTAL</span>
                </span>
                <span class="text-[10px] text-slate-400 font-mono font-bold">256-BIT SSL</span>
            </div>

            <div class="text-center mb-4">
                <h1 class="font-heading text-xl sm:text-2xl font-black text-brand-navy mb-1 tracking-tight">
                    Layanan Pelanggan
                </h1>
                <p class="text-[11px] text-slate-500 leading-relaxed font-medium">
                    Masukkan nomor WhatsApp atau CID terdaftar untuk memantau status jaringan, tagihan, dan tiket.
                </p>
            </div>

            <!-- Flash Error / Info Alerts -->
            @if(session('error'))
                <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium mb-4 leading-snug flex items-start gap-2.5">
                    <span class="text-rose-500 text-sm shrink-0">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="p-3.5 rounded-2xl bg-brand-soft border border-blue-200 text-brand text-xs font-medium mb-4 leading-snug flex items-start gap-2.5">
                    <span class="text-brand text-sm shrink-0">ℹ️</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('customer.login') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block font-bold text-xs text-brand-navy mb-2">
                        Nomor WhatsApp / CID Pelanggan *
                    </label>
                    <div class="flex items-center h-10 px-3 rounded-xl bg-brand-pale border border-slate-200 focus-within:border-brand focus-within:bg-white focus-within:ring-2 focus-within:ring-brand/20 transition-all shadow-inner">
                        
                        <!-- Country Prefix Badge -->
                        <div class="flex items-center gap-1.5 pr-3 mr-3 border-r border-slate-200 select-none shrink-0">
                            <span class="text-xs">🇮🇩</span>
                            <span class="text-brand-navy text-xs font-black tracking-wide">+62</span>
                        </div>

                        <!-- Numeric Dialpad Input -->
                        <input 
                            type="tel" 
                            inputmode="numeric" 
                            name="phone_or_cid" 
                            placeholder="081298765432 atau CID" 
                            required 
                            autofocus
                            class="w-full bg-transparent text-brand-navy placeholder-slate-400 text-xs sm:text-sm font-bold outline-none tracking-wide"
                        />
                    </div>
                    
                    <span class="text-[11px] text-slate-500 mt-2 flex items-center gap-1.5">
                        <span class="text-brand">💡</span>
                        <span>Bisa juga memasukkan ID Pelanggan (CID).</span>
                    </span>
                </div>

                <button type="submit" class="w-full h-10 rounded-xl btn-brand-primary text-white font-black text-xs shadow-sm transition-all flex items-center justify-center gap-2 hover:shadow-md">
                    <span>Masuk ke Portal Layanan</span>
                    <span class="text-white font-black">&rarr;</span>
                </button>
            </form>

            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500 mb-1.5">Belum terdaftar atau nomor HP berubah?</p>
                <a href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20membutuhkan%20bantuan%20login%20portal%20pelanggan" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand hover:text-brand-dark hover:underline transition-colors">
                    <span>💬 Hubungi Customer Service 24/7</span>
                </a>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full max-w-7xl mx-auto px-4 py-3 sm:py-4 text-center text-xs text-slate-400 relative z-10 shrink-0 border-t border-slate-200">
        &copy; {{ date('Y') }} IMS ONE Fiber Network. Portal Layanan Mandiri Pelanggan.
    </footer>

</body>
</html>
