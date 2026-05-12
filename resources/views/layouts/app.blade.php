<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QAMS &mdash; @yield('title', 'Quiz & Assignment Management')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; }

        :root {
            --sidebar-w: 268px;
            --navy:      #0f172a;
            --navy2:     #1e293b;
            --accent:    #6366f1;
            --accent2:   #818cf8;
            --bg:        #f0f4f8;
            --card-bg:   #ffffff;
            --text-main: #0f172a;
            --text-muted:#64748b;
            --border:    #e2e8f0;
            --radius-lg: 16px;
            --radius-md: 12px;
            --radius-sm: 8px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md: 0 4px 16px rgba(0,0,0,.07);
            --shadow-lg: 0 10px 40px rgba(0,0,0,.1);
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            overflow-x: hidden;
            font-size: 0.935rem;
        }

        /* ─── Custom Scrollbar ─── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* ═══════════════════════════════
           SIDEBAR
        ═══════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1a2540 60%, #1e2d50 100%);
            position: fixed;
            top: 0; left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            padding: 0;
            box-shadow: 4px 0 24px rgba(0,0,0,0.18);
            transition: transform 0.32s cubic-bezier(0.4,0,0.2,1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Brand */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 24px 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
            text-decoration: none;
        }
        .sidebar-brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--accent), #a78bfa);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(99,102,241,0.4);
        }
        .sidebar-brand-text { line-height: 1.2; }
        .sidebar-brand-text span:first-child {
            display: block;
            font-size: 1.15rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.5px;
        }
        .sidebar-brand-text span:last-child {
            display: block;
            font-size: 0.68rem;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0.8px;
            text-transform: uppercase;
            font-weight: 500;
        }

        /* Nav section label */
        .sidebar-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 20px 22px 6px;
        }

        /* Nav links */
        .sidebar-nav { padding: 8px 12px; flex: 1; }
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.885rem;
            transition: all 0.22s ease;
            margin-bottom: 2px;
            position: relative;
            white-space: nowrap;
            overflow: hidden;
        }
        .sidebar a i {
            font-size: 1.05rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
            transition: color 0.22s;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.92);
        }
        .sidebar a:hover i { color: var(--accent2); }
        .sidebar a.active {
            background: linear-gradient(90deg, rgba(99,102,241,0.25), rgba(99,102,241,0.08));
            color: #fff;
            font-weight: 600;
        }
        .sidebar a.active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 60%;
            background: var(--accent2);
            border-radius: 0 3px 3px 0;
        }
        .sidebar a.active i { color: var(--accent2); }

        /* Sidebar footer / logout */
        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 11px;
            width: 100%;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            border: none;
            background: transparent;
            color: rgba(248,113,113,0.75);
            font-weight: 500;
            font-size: 0.885rem;
            cursor: pointer;
            transition: all 0.2s;
            text-align: left;
        }
        .logout-btn i { font-size: 1.05rem; width: 20px; text-align: center; flex-shrink: 0; }
        .logout-btn:hover { background: rgba(248,113,113,0.12); color: #f87171; }

        /* Mobile overlay */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 1039;
            backdrop-filter: blur(3px);
        }
        .sidebar-overlay.show { display: block; }

        /* ═══════════════════════════════
           MAIN CONTENT
        ═══════════════════════════════ */
        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            padding: 20px 24px 40px;
            transition: margin-left 0.32s cubic-bezier(0.4,0,0.2,1);
        }

        /* ─── Top Bar ─── */
        .top-bar {
            background: #fff;
            padding: 10px 18px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 22px;
            border: 1px solid var(--border);
        }
        .top-bar-left { display: flex; align-items: center; gap: 10px; }
        .page-title-text {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-main);
        }
        .breadcrumb-mini {
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Hamburger */
        .sidebar-toggle {
            display: none;
            align-items: center; justify-content: center;
            width: 36px; height: 36px;
            border-radius: var(--radius-sm);
            background: #f8fafc;
            border: 1px solid var(--border);
            cursor: pointer;
            color: var(--text-main);
            font-size: 1.15rem;
            transition: background 0.15s;
            flex-shrink: 0;
        }
        .sidebar-toggle:hover { background: #e2e8f0; }

        /* User pill */
        .user-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 99px;
            padding: 4px 12px 4px 6px;
            cursor: default;
        }
        .user-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #a78bfa);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            overflow: hidden;
        }
        .user-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .user-pill .user-name { font-size: 0.835rem; font-weight: 600; color: var(--text-main); }
        .user-pill .user-role {
            font-size: 0.68rem;
            font-weight: 600;
            background: linear-gradient(90deg, var(--accent), #a78bfa);
            color: #fff;
            padding: 2px 8px;
            border-radius: 99px;
        }

        /* Change password btn */
        .btn-pwd {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: var(--radius-sm);
            background: #f8fafc;
            border: 1px solid var(--border);
            color: var(--text-muted);
            font-size: 0.82rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.18s;
            white-space: nowrap;
        }
        .btn-pwd:hover { background: #e8f0fe; color: var(--accent); border-color: #c7d2fe; }

        /* ─── Alerts ─── */
        .alert {
            border: none;
            border-radius: var(--radius-md);
            font-size: 0.9rem;
        }
        .alert-success { background: #f0fdf4; color: #166534; }
        .alert-danger  { background: #fef2f2; color: #991b1b; }
        .alert-info    { background: #eff6ff; color: #1e40af; }
        .alert-warning { background: #fffbeb; color: #92400e; }

        /* ─── Cards ─── */
        .card {
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            background: var(--card-bg);
            transition: box-shadow 0.22s ease, transform 0.22s ease;
        }
        .card:hover { box-shadow: var(--shadow-md); }
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 14px 18px;
            font-weight: 600;
        }

        /* ─── Stat Cards ─── */
        .stat-card {
            border-radius: var(--radius-lg) !important;
            overflow: hidden;
            border: 1px solid var(--border) !important;
            transition: transform 0.22s ease, box-shadow 0.22s ease !important;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg) !important; }
        .stat-card .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem;
            margin-bottom: 12px;
        }
        .stat-card h2 { font-size: 2rem; font-weight: 800; margin-bottom: 2px; }
        .stat-card p  { font-size: 0.78rem; font-weight: 500; color: var(--text-muted); margin: 0; }

        /* ─── Tables ─── */
        .table-responsive { border-radius: var(--radius-lg); overflow: hidden; }
        .table { font-size: 0.88rem; margin-bottom: 0; }
        .table thead th {
            font-size: 0.73rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
            padding: 11px 14px;
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
        }
        .table tbody td { padding: 12px 14px; vertical-align: middle; border-color: #f1f5f9; }
        .table tbody tr:last-child td { border-bottom: none; }
        .table-hover tbody tr:hover { background: #f8fafc; }

        /* ─── Buttons ─── */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #818cf8);
            border: none;
            font-weight: 600;
            letter-spacing: 0.2px;
            border-radius: var(--radius-sm);
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(99,102,241,0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            box-shadow: 0 4px 16px rgba(99,102,241,0.4);
            transform: translateY(-1px);
        }
        .btn-success {
            background: linear-gradient(135deg, #10b981, #34d399);
            border: none;
            font-weight: 600;
            border-radius: var(--radius-sm);
            box-shadow: 0 2px 8px rgba(16,185,129,0.25);
        }
        .btn-success:hover { background: linear-gradient(135deg, #059669, #10b981); transform: translateY(-1px); }
        .btn-outline-primary { border-radius: var(--radius-sm); font-weight: 500; }
        .btn-outline-warning  { border-radius: var(--radius-sm); font-weight: 500; }
        .btn-outline-danger   { border-radius: var(--radius-sm); font-weight: 500; }
        .btn-outline-info     { border-radius: var(--radius-sm); font-weight: 500; }
        .btn-secondary { border-radius: var(--radius-sm); font-weight: 500; }

        /* ─── Forms ─── */
        .form-control, .form-select {
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            color: var(--text-main);
            transition: border-color 0.18s, box-shadow 0.18s;
            background: #fff;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
            outline: none;
        }
        .form-label { font-weight: 600; font-size: 0.84rem; color: var(--text-main); margin-bottom: 6px; }

        /* ─── Badges ─── */
        .badge { border-radius: 6px; font-weight: 600; letter-spacing: 0.2px; }

        /* ─── Tooltip ─── */
        .tooltip .tooltip-inner {
            background: #0f172a;
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 8px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.3);
        }

        /* ─── List Groups ─── */
        .list-group-item {
            border-color: #f1f5f9;
            padding: 12px 16px;
            font-size: 0.88rem;
        }
        .list-group-item:first-child { border-top: none; }

        /* ─── Form Card Wrappers ─── */
        .form-card-wrap    { width: 100%; max-width: 700px; }
        .form-card-wrap-sm { width: 100%; max-width: 520px; }

        /* ═══════════════════════════════
           RESPONSIVE
        ═══════════════════════════════ */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0 !important; padding: 14px 16px 40px; }
            .sidebar-toggle { display: flex; }
        }
        @media (max-width: 767.98px) {
            .form-card-wrap, .form-card-wrap-sm { max-width: 100%; }
        }
        @media (max-width: 575.98px) {
            .main-content { padding: 10px 12px 40px; }
            .top-bar { padding: 8px 12px; }
            .user-pill .user-name { display: none; }
            .page-title-text { font-size: 0.95rem; }
        }
    </style>
</head>
<body>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- ═══ Sidebar ═══ -->
<aside class="sidebar" id="sidebar">
    <!-- Brand -->
    <a class="sidebar-brand" href="#">
        <div class="sidebar-brand-icon">
            <i class="bi bi-mortarboard-fill text-white"></i>
        </div>
        <div class="sidebar-brand-text">
            <span>QAMS</span>
            <span>Management System</span>
        </div>
    </a>

    <!-- Nav Links -->
    <div class="sidebar-nav">
        <div class="sidebar-label">Main Navigation</div>
        @yield('sidebar')
    </div>

    <!-- Logout -->
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i>
                <span>Sign Out</span>
            </button>
        </form>
    </div>
</aside>

<!-- ═══ Main Content ═══ -->
<main class="main-content" id="mainContent">

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-bar-left">
            <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()" aria-label="Menu">
                <i class="bi bi-list"></i>
            </button>
            <div>
                <div class="page-title-text">@yield('page-title')</div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('password.change') }}" class="btn-pwd"
               data-bs-toggle="tooltip" title="Change Password">
                <i class="bi bi-shield-lock"></i>
                <span class="d-none d-sm-inline">Password</span>
            </a>

            <div class="user-pill">
                <div class="user-avatar">
                    @if(auth()->user()->student && auth()->user()->student->picture)
                        <img src="{{ Storage::url(auth()->user()->student->picture) }}" alt="">
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </div>
                <span class="user-name">{{ explode(' ', auth()->user()->name)[0] }}</span>
                <span class="user-role">{{ ucfirst(auth()->user()->role) }}</span>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-check-circle-fill flex-shrink-0"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger d-flex align-items-start gap-2 mb-3">
            <i class="bi bi-x-circle-fill mt-1 flex-shrink-0"></i>
            <ul class="mb-0 ps-2">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
}
window.addEventListener('resize', function () {
    if (window.innerWidth >= 992) closeSidebar();
});
document.addEventListener('DOMContentLoaded', function () {
    [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).forEach(function (el) {
        new bootstrap.Tooltip(el, { trigger: 'hover', delay: { show: 200, hide: 80 } });
    });
});
</script>
@yield('scripts')
</body>
</html>
