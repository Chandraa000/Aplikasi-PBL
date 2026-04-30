<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f6fa; }
        .topbar { background: #0f1624; color: white; padding: 18px 32px; display: flex; align-items: center; justify-content: space-between; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .topbar-left h1 { font-size: 1.3rem; font-weight: 700; }
        .topbar-left p { font-size: 0.85rem; color: #8a9bb0; }
        .topbar-nav { display: flex; gap: 8px; }
        .nav-btn { padding: 8px 16px; border-radius: 8px; font-size: 0.88rem; font-weight: 600; text-decoration: none; transition: all 0.2s; }
        .nav-btn-active { background: white; color: #0f1624; }
        .nav-btn-inactive { background: transparent; color: #8a9bb0; border: 1px solid #2a3a4a; }
        .nav-btn-inactive:hover { background: #1a2a3a; color: white; }
        .btn-logout { background: transparent; border: 2px solid white; color: white; padding: 8px 18px; border-radius: 8px; font-size: 0.9rem; text-decoration: none; }
        .btn-logout:hover { background: white; color: #0f1624; }
        .content { padding: 32px; }
        .stat-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px; }
        .stat-card { background: white; border-radius: 16px; padding: 24px; display: flex; justify-content: space-between; align-items: flex-start; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .stat-card .label { font-size: 0.88rem; color: #6b7a8d; margin-bottom: 10px; }
        .stat-card .value { font-size: 2rem; font-weight: 700; color: #0f1624; }
        .stat-card .stat-icon { width: 42px; height: 42px; background: #f0f2f5; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        .section-title { font-size: 1.1rem; font-weight: 700; color: #0f1624; margin-bottom: 16px; }
        .proj-table { background: white; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8f9fb; padding: 14px 16px; text-align: left; font-size: 0.82rem; font-weight: 700; color: #6b7a8d; border-bottom: 1.5px solid #f0f2f5; }
        td { padding: 14px 16px; font-size: 0.88rem; color: #0f1624; border-bottom: 1px solid #f5f6fa; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8f9fb; }
        .badge { padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-aktif { background: #e8f5e9; color: #2e7d32; }
        .badge-selesai { background: #e3f2fd; color: #1565c0; }
        .progress-wrap { background: #f0f2f5; border-radius: 20px; height: 6px; min-width: 80px; }
        .progress-fill { background: #0f1624; border-radius: 20px; height: 6px; }
        .btn-del { padding: 5px 12px; background: #fce4ec; color: #c62828; border: none; border-radius: 8px; font-size: 0.78rem; font-weight: 600; cursor: pointer; }
        .alert-success { background: #e8f5e9; color: #2e7d32; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }
        .alert-error { background: #fce4ec; color: #c62828; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }
        .two-stat { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; margin-bottom: 32px; }
        .mini-card { background: white; border-radius: 14px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center; }
        .mini-card .num { font-size: 2.5rem; font-weight: 800; color: #0f1624; }
        .mini-card .lbl { font-size: 0.85rem; color: #6b7a8d; margin-top: 4px; }
        .mini-card .icon { font-size: 1.5rem; margin-bottom: 8px; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-left">
        <div style="font-size:1.5rem;">⚙️</div>
        <div>
            <h1>Admin Dashboard</h1>
            <p>Selamat datang, {{ auth()->user()->name }}</p>
        </div>
    </div>
    <div class="topbar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-btn nav-btn-active">📊 Dashboard</a>
        <a href="{{ route('admin.users') }}" class="nav-btn nav-btn-inactive">👥 Kelola User</a>
    </div>
    <a href="{{ route('logout') }}" class="btn-logout"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        ↪ Keluar
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
</div>

<div class="content">

    @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert-error">❌ {{ session('error') }}</div>
    @endif

    {{-- Stat Cards --}}
    <div class="stat-cards">
        <div class="stat-card">
            <div><div class="label">Total User</div><div class="value">{{ $totalUser }}</div></div>
            <div class="stat-icon">👤</div>
        </div>
        <div class="stat-card">
            <div><div class="label">Total Mahasiswa</div><div class="value">{{ $totalMahasiswa }}</div></div>
            <div class="stat-icon">🎓</div>
        </div>
        <div class="stat-card">
            <div><div class="label">Total Dospem</div><div class="value">{{ $totalDospem }}</div></div>
            <div class="stat-icon">👨‍🏫</div>
        </div>
        <div class="stat-card">
            <div><div class="label">Total Project</div><div class="value">{{ $totalProject }}</div></div>
            <div class="stat-icon">📁</div>
        </div>
    </div>

    <div class="two-stat">
        <div class="mini-card">
            <div class="icon">👥</div>
            <div class="num">{{ $totalKelompok }}</div>
            <div class="lbl">Total Kelompok</div>
        </div>
        <div class="mini-card">
            <div class="icon">📋</div>
            <div class="num">{{ $totalTugas }}</div>
            <div class="lbl">Total Tugas</div>
        </div>
        <div class="mini-card">
            <div class="icon">✅</div>
            <div class="num">{{ $tugasSelesai }}</div>
            <div class="lbl">Tugas Selesai</div>
        </div>
    </div>

    {{-- Tabel Semua Project --}}
    <div class="section-title">📁 Semua Project</div>
    <div class="proj-table">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Project</th>
                    <th>Dospem</th>
                    <th>Anggota</th>
                    <th>Kelompok</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $i => $project)
                @php
                    $totalT = $project->groups->sum(fn($g) => $g->tasks->count());
                    $doneT = $project->groups->sum(fn($g) => $g->tasks->where('status','done')->count());
                    $persen = $totalT > 0 ? round(($doneT/$totalT)*100) : 0;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $project->nama_project }}</strong></td>
                    <td>{{ $project->dospem->name ?? '-' }}</td>
                    <td>{{ $project->members->count() }} orang</td>
                    <td>{{ $project->groups->count() }} kelompok</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div class="progress-wrap">
                                <div class="progress-fill" style="width:{{ $persen }}%"></div>
                            </div>
                            <span style="font-size:0.78rem; color:#6b7a8d;">{{ $persen }}%</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-{{ $project->status == 'aktif' ? 'aktif' : 'selesai' }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('projects.show', $project->id) }}"
                            style="padding:5px 12px; background:#f0f2f5; color:#0f1624; border-radius:8px; font-size:0.78rem; font-weight:600; text-decoration:none; margin-right:4px;">
                            Detail
                        </a>
                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-del" onclick="return confirm('Yakin hapus project ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center; color:#b0bec5; padding:30px;">Belum ada project</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>