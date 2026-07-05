<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AIB Trazabilidad') — Agroindustrias AIB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        aib: {
                            bg: '#0f1a0e',
                            bg2: '#162013',
                            card: '#1c2a18',
                            card2: '#243521',
                            border: '#2e4a28',
                            fg: '#e8f0e6',
                            fg2: '#a3b89e',
                            muted: '#6b8264',
                            accent: '#d4a017',
                            accent2: '#f0c040',
                        }
                    },
                    fontFamily: {
                        display: ['Playfair Display', 'serif'],
                        body: ['DM Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@200;400;500;700;900&family=Playfair+Display:wght@700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #0f1a0e;
            color: #e8f0e6;
        }

        h1,
        h2,
        h3,
        .font-display {
            font-family: 'Playfair Display', serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #162013;
        }

        ::-webkit-scrollbar-thumb {
            background: #2e4a28;
            border-radius: 3px;
        }

        .bg-pattern {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(ellipse 80% 60% at 20% 10%, rgba(212, 160, 23, 0.06) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 90%, rgba(74, 222, 128, 0.04) 0%, transparent 60%),
                repeating-linear-gradient(0deg, transparent, transparent 40px, rgba(46, 74, 40, 0.08) 40px, rgba(46, 74, 40, 0.08) 41px),
                repeating-linear-gradient(90deg, transparent, transparent 40px, rgba(46, 74, 40, 0.08) 40px, rgba(46, 74, 40, 0.08) 41px);
        }

        .floating-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
            animation: orbFloat 12s ease-in-out infinite alternate;
        }

        @keyframes orbFloat {
            0% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(30px, -40px) scale(1.1);
            }

            100% {
                transform: translate(-20px, 30px) scale(0.95);
            }
        }

        .sidebar {
            width: 270px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            color: #a3b89e;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 2px;
            text-decoration: none;
        }

        .nav-item:hover {
            background: #1c2a18;
            color: #e8f0e6;
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(212, 160, 23, 0.15), rgba(212, 160, 23, 0.05));
            color: #f0c040;
            border: 1px solid rgba(212, 160, 23, 0.2);
        }

        .input-aib {
            width: 100%;
            padding: 10px 14px;
            background: #162013;
            border: 1px solid #2e4a28;
            border-radius: 10px;
            color: #e8f0e6;
            font-size: 14px;
            transition: all 0.3s;
            font-family: 'DM Sans', sans-serif;
        }

        .input-aib:focus {
            outline: none;
            border-color: #d4a017;
            box-shadow: 0 0 0 3px rgba(212, 160, 23, 0.15);
        }

        .input-aib::placeholder {
            color: #6b8264;
        }

        select.input-aib {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236b8264' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }

        .btn-gold {
            background: linear-gradient(135deg, #d4a017, #b8880f);
            color: #0f1a0e;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'DM Sans', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 160, 23, 0.3);
        }

        .btn-outline {
            background: #243521;
            color: #e8f0e6;
            border: 1px solid #2e4a28;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'DM Sans', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-outline:hover {
            background: #2e4a28;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 13px;
            border-radius: 8px;
        }

        .btn-danger-aib {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-danger-aib:hover {
            background: rgba(239, 68, 68, 0.25);
        }

        .btn-success-aib {
            background: rgba(74, 222, 128, 0.12);
            color: #4ade80;
            border: 1px solid rgba(74, 222, 128, 0.3);
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-success-aib:hover {
            background: rgba(74, 222, 128, 0.25);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            text-align: left;
            padding: 12px 16px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b8264;
            font-weight: 700;
            border-bottom: 1px solid #2e4a28;
        }

        tbody td {
            padding: 14px 16px;
            font-size: 14px;
            border-bottom: 1px solid rgba(46, 74, 40, 0.3);
            color: #a3b89e;
        }

        tbody tr {
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: rgba(46, 74, 40, 0.15);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(74, 222, 128, 0.12);
            color: #4ade80;
        }

        .badge-warning {
            background: rgba(251, 191, 36, 0.12);
            color: #fbbf24;
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .badge-info {
            background: rgba(56, 189, 248, 0.12);
            color: #38bdf8;
        }

        .stat-card {
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
            border-color: #6b8264;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4ade80;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.5);
            }
        }

        .toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 200;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .toast {
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 300px;
            animation: toastIn 0.4s ease-out;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateX(40px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .toast-success {
            background: rgba(22, 40, 20, 0.95);
            border: 1px solid rgba(74, 222, 128, 0.3);
            color: #4ade80;
        }

        .toast-error {
            background: rgba(40, 20, 20, 0.95);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        .toast-info {
            background: rgba(20, 30, 40, 0.95);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: #38bdf8;
        }

        .fade-up {
            animation: fadeUp 0.5s ease-out both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .delay-1 {
            animation-delay: .1s;
        }

        .delay-2 {
            animation-delay: .2s;
        }

        .delay-3 {
            animation-delay: .3s;
        }

        .delay-4 {
            animation-delay: .4s;
        }

        @media(max-width:768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body class="min-h-screen overflow-x-hidden">
    <div class="bg-pattern"></div>
    <div class="floating-orb" style="width:300px;height:300px;background:rgba(212,160,23,0.04);top:10%;left:5%;"></div>
    <div class="floating-orb"
        style="width:400px;height:400px;background:rgba(74,222,128,0.03);bottom:10%;right:5%;animation-delay:-6s;">
    </div>

    <div class="toast-container" id="toastContainer">
        @if (session('success'))
            <div class="toast toast-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="toast toast-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if (session('info'))
            <div class="toast toast-info"><i class="fas fa-info-circle"></i> {{ session('info') }}</div>
        @endif
    </div>

    <div class="flex min-h-screen relative z-10">
        <aside class="sidebar fixed top-0 left-0 bottom-0 bg-aib-bg2 border-r border-aib-border flex flex-col"
            id="sidebar">
            <div class="p-6 border-b border-aib-border flex items-center gap-3">
                <div
                    class="w-11 h-11 bg-gradient-to-br from-aib-accent to-yellow-700 rounded-xl flex items-center justify-center text-lg font-black text-aib-bg">
                    AIB</div>
                <div>
                    <div class="font-display font-bold text-sm">AIB Trazabilidad</div>
                    <div class="text-[11px] text-aib-muted">Sede Ica</div>
                </div>
            </div>
            <nav class="flex-1 p-4 overflow-y-auto">
                <div class="mb-2">
                    <div class="text-[10px] uppercase tracking-widest text-aib-muted px-3 py-2 font-bold">Principal
                    </div>
                    <a href="/dashboard" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie w-5 text-center text-[15px]"></i> Dashboard
                    </a>
                </div>
                <div class="mb-2">
                    <div class="text-[10px] uppercase tracking-widest text-aib-muted px-3 py-2 font-bold">Gestion</div>
                    <a href="/lotes" class="nav-item {{ request()->is('lotes*') ? 'active' : '' }}">
                        <i class="fas fa-boxes-stacked w-5 text-center text-[15px]"></i> Lotes
                        <span
                            class="ml-auto bg-aib-accent text-aib-bg text-[11px] font-bold px-2 py-0.5 rounded-full">{{ \App\Models\Lote::count() }}</span>
                    </a>
                    <a href="/trazabilidad" class="nav-item {{ request()->is('trazabilidad*') ? 'active' : '' }}">
                        <i class="fas fa-route w-5 text-center text-[15px]"></i> Trazabilidad
                    </a>
                    <a href="/qr" class="nav-item {{ request()->is('qr*') ? 'active' : '' }}">
                        <i class="fas fa-qrcode w-5 text-center text-[15px]"></i> Generador QR
                    </a>
                </div>
                @if (in_array(session('usuario_rol'), ['Administrador', 'Supervisor', 'Transporte']))
                    <div class="mb-2">
                        <div class="text-[10px] uppercase tracking-widest text-aib-muted px-3 py-2 font-bold">Reportes
                        </div>
                        <a href="/reportes" class="nav-item {{ request()->is('reportes*') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar w-5 text-center text-[15px]"></i> Reportes
                        </a>
                    </div>
                @endif
                @if (session('usuario_rol') === 'Administrador')
                    <div class="mb-2">
                        <div class="text-[10px] uppercase tracking-widest text-aib-muted px-3 py-2 font-bold">
                            Administracion</div>
                        <a href="/usuarios" class="nav-item {{ request()->is('usuarios*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog w-5 text-center text-[15px]"></i> Usuarios
                        </a>
                    </div>
                @endif
            </nav>
            <div class="p-5 border-t border-aib-border flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center font-bold text-sm text-aib-bg">
                    {{ substr(session('usuario_nombre', 'US'), 0, 1) }}{{ substr(session('usuario_nombre', ''), strpos(session('usuario_nombre', '') . ' ', ' ') + 1, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-[13px] truncate">{{ session('usuario_nombre', 'Usuario') }}</div>
                    <div class="text-[11px] px-2 py-0.5 rounded-full inline-block mt-0.5"
                        style="background:rgba(212,160,23,0.12);color:#d4a017;font-weight:600;">
                        {{ session('usuario_rol', '') }}
                    </div>
                </div>
                <a href="/logout" class="text-aib-muted hover:text-red-400 transition-colors text-lg"
                    title="Cerrar sesion"><i class="fas fa-right-from-bracket"></i></a>
            </div>
        </aside>

        <div class="main-content flex-1 min-h-screen" style="margin-left:270px;">
            <header class="sticky top-0 z-40 px-8 py-4 border-b border-aib-border"
                style="background:rgba(15,26,14,0.85);backdrop-filter:blur(16px);">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button onclick="document.getElementById('sidebar').classList.toggle('open')"
                            class="hidden max-[768px]:block bg-none border-none text-aib-fg text-xl cursor-pointer"><i
                                class="fas fa-bars"></i></button>
                        <div>
                            <h2 class="text-xl font-bold font-display">@yield('pageTitle', 'Dashboard')</h2>
                            <p class="text-xs text-aib-muted">@yield('pageSubtitle', 'Sistema de Trazabilidad Digital')</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-[13px] text-aib-fg2"><i class="fas fa-clock text-aib-accent mr-1"></i><span
                                id="currentTime"></span></div>
                    </div>
                </div>
            </header>
            <main class="p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function updateClock() {
            const n = new Date(),
                e = document.getElementById('currentTime');
            if (e) e.textContent = n.toLocaleString('es-PE', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }
        updateClock();
        setInterval(updateClock, 1000);
        setTimeout(() => {
            document.querySelectorAll('.toast').forEach(t => {
                t.style.opacity = '0';
                t.style.transform = 'translateX(40px)';
                t.style.transition = 'all 0.3s';
                setTimeout(() => t.remove(), 300);
            });
        }, 4000);

        function checkResponsive() {
            const b = document.getElementById('menuBtn');
            if (b) b.style.display = window.innerWidth <= 768 ? 'block' : 'none';
        }
        checkResponsive();
        window.addEventListener('resize', checkResponsive);
    </script>
    @stack('scripts')
</body>

</html>
