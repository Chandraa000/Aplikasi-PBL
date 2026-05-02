<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Sistem PBL</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f6fa; display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 260px; min-height: 100vh; background: #0f1624;
            display: flex; flex-direction: column;
            position: fixed; left: 0; top: 0; bottom: 0;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid #1e2d40;
        }
        .sidebar-brand .icon {
            width: 44px; height: 44px; background: white;
            border-radius: 12px; display: flex; align-items: center;
            justify-content: center; font-size: 1.3rem; margin-bottom: 12px;
        }
        .sidebar-brand h2 {
            color: white; font-size: 1rem; font-weight: 700; margin-bottom: 2px;
        }
        .sidebar-brand p { color: #8a9bb0; font-size: 0.78rem; }

        .sidebar-user {
            padding: 16px 24px;
            border-bottom: 1px solid #1e2d40;
            display: flex; align-items: center; gap: 12px;
        }
        .user-avatar {
            width: 36px; height: 36px; background: #2a3a4a;
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; color: white; font-weight: 700;
            font-size: 0.85rem; flex-shrink: 0;
        }
        .user-name { color: white; font-size: 0.88rem; font-weight: 600; }
        .user-role { color: #8a9bb0; font-size: 0.75rem; }

        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .nav-label {
            color: #4a5a6a; font-size: 0.7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1px;
            padding: 0 12px; margin-bottom: 8px; margin-top: 16px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px; border-radius: 10px;
            color: #8a9bb0; text-decoration: none;
            font-size: 0.9rem; font-weight: 500;
            transition: all 0.2s; margin-bottom: 4px;
        }
        .nav-item:hover { background: #1a2a3a; color: white; }
        .nav-item.active { background: white; color: #0f1624; font-weight: 700; }
        .nav-item .nav-icon { font-size: 1.1rem; width: 22px; text-align: center; }
        .nav-item .nav-badge {
            margin-left: auto; background: #2a3a4a; color: #8a9bb0;
            padding: 2px 8px; border-radius: 20px; font-size: 0.72rem;
            font-weight: 600;
        }
        .nav-item.active .nav-badge { background: #f0f2f5; color: #0f1624; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid #1e2d40;
        }
        .btn-logout-sidebar {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px; border-radius: 10px;
            color: #8a9bb0; text-decoration: none;
            font-size: 0.9rem; font-weight: 500;
            transition: all 0.2s; width: 100%;
            background: transparent; border: none; cursor: pointer;
        }
        .btn-logout-sidebar:hover { background: #fce4ec; color: #c62828; }

        /* Main Content */
        .main { margin-left: 260px; flex: 1; display: flex; flex-direction: column; }

        .topbar {
            background: white; padding: 16px 32px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid #f0f2f5;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 1.1rem; font-weight: 700; color: #0f1624; }
        .topbar-sub { font-size: 0.82rem; color: #6b7a8d; margin-top: 2px; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .topbar-date { font-size: 0.82rem; color: #6b7a8d; }

        .content { padding: 28px 32px; flex: 1; }

        /* Alerts */
        .alert-success { background: #e8f5e9; color: #2e7d32; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }
        .alert-error { background: #fce4ec; color: #c62828; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }
    </style>
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="icon">✦</div>
        <h2>Sistem PBL</h2>
        <p>Admin Panel</p>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div>
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-role">Administrator</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <div class="nav-label">Manajemen</div>
        <a href="{{ route('admin.users') }}"
            class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <span class="nav-icon">👥</span> Kelola User
        </a>
        <a href="{{ route('admin.semester.index') }}"
            class="nav-item {{ request()->routeIs('admin.semester.*') ? 'active' : '' }}">
            <span class="nav-icon">📅</span> Semester
        </a>
    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" id="logout-form-sidebar">@csrf</form>
        <button type="submit" form="logout-form-sidebar" class="btn-logout-sidebar">
            <span class="nav-icon">↪</span> Keluar
        </button>
    </div>
</div>

{{-- Main --}}
<div class="main">
    <div class="topbar">
        <div>
            <div class="topbar-title">@yield('page_title', 'Dashboard')</div>
            <div class="topbar-sub">@yield('page_sub', 'Admin Panel - Sistem PBL')</div>
        </div>
        <div class="topbar-right">
            <div class="topbar-date">{{ now()->format('d M Y') }}</div>
        </div>
    </div>

    <div class="content">
        @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert-error">❌ {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

</body>
</html>