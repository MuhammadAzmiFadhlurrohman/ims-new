<!DOCTYPE html>
<html lang="id" class="dark h-full bg-[#08111e]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-brand-600 to-cyan-400 p-0.5 shadow-lg shadow-brand-500/25 flex items-center justify-center transform group-hover:scale-105 transition-transform">
                <div class="w-full h-full bg-[#08111e] rounded-[14px] flex items-center justify-center">
                    <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                    </svg>
                </div>
            </div>
            <div>
                <span class="font-heading text-xl font-black text-white flex items-center gap-1">
                    IMS<span class="text-brand-400">ONE</span>
                </span>
                <span class="text-[9px] font-extrabold tracking-widest text-slate-400 uppercase block -mt-1">
                    Customer Care Portal
                </span>
            </div>
        </a>

        <a href="{{ url('/') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-xs font-bold text-slate-300 hover:text-white transition-all">
            <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Beranda</span>
        </a>
    </header>

    <!-- Main Card Container -->
    <main class="w-full max-w-md mx-auto px-4 py-6">
        
        <div class="glass-card rounded-3xl p-8 sm:p-10 shadow-2xl border border-brand-500/25 relative overflow-hidden">
            
            <!-- Glow Accent -->
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-brand-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="text-center mb-8 relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-brand-600/30 to-cyan-400/20 border border-brand-400/30 flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
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
                <div class="p-4 rounded-2xl bg-rose-500/15 border border-rose-500/30 text-rose-300 text-xs font-medium mb-6 leading-relaxed flex items-start gap-2.5">
                    <span class="text-rose-400 text-base shrink-0">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="p-4 rounded-2xl bg-sky-500/15 border border-sky-500/30 text-sky-300 text-xs font-medium mb-6 leading-relaxed flex items-start gap-2.5">
                    <span class="text-sky-400 text-base shrink-0">ℹ️</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('customer.login') }}" method="POST" class="space-y-5 relative z-10">
                @csrf
                
                <div>
                    <label class="block font-bold text-xs text-slate-300 mb-2">
                        Nomor Telepon / WhatsApp Terdaftar *
                    </label>
                    <div class="flex items-center px-4 py-3.5 rounded-2xl bg-white/5 border border-white/15 focus-within:border-brand-400 focus-within:bg-white/10 transition-all shadow-inner">
                        <span class="text-slate-400 text-xs font-bold mr-2 select-none">🇮🇩 +62</span>
                        <input 
                            type="text" 
                            name="phone_or_cid" 
                            placeholder="Contoh: 081298765432" 
                            required 
                            autofocus
                            class="w-full bg-transparent text-white placeholder-slate-500 text-xs sm:text-sm font-semibold outline-none"
                        />
                    </div>
                    <span class="text-[11px] text-slate-400 mt-1.5 block">
                        💡 Bisa juga menggunakan Nomor Pelanggan (CID/Internet Number).
                    </span>
                </div>

                <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white font-black text-xs sm:text-sm shadow-xl shadow-cyan-500/25 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <span>Masuk ke Portal Layanan &rarr;</span>
                </button>

                <!-- Session Policy Notice -->
                <div class="p-3 rounded-xl bg-white/5 border border-white/5 text-[10.5px] text-slate-400 text-center flex items-center justify-center gap-1.5">
                    <span>⏱️</span>
                    <span>Sesi akses berlaku <strong>1 Jam</strong> untuk menghemat beban server.</span>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-white/10 text-center relative z-10">
                <p class="text-xs text-slate-400 mb-2">Belum terdaftar atau nomor HP berubah?</p>
                <a href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20membutuhkan%20bantuan%20login%20portal%20pelanggan" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-cyan-400 hover:text-cyan-300 hover:underline">
                    <span>💬 Hubungi Customer Service 24/7</span>
                </a>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full max-w-7xl mx-auto px-4 py-6 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} IMS ONE (Media Sarana Network). Portal Layanan Mandiri Pelanggan.
    </footer>

</body>
</html>
