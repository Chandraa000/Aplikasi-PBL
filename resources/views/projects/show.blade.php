<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->nama_project }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f6fa; }
        .topbar { background: #0f1624; color: white; padding: 16px 32px; }
        .topbar a { color: white; text-decoration: none; font-size: 0.9rem; }
        .topbar a:hover { opacity: 0.8; }
        .content { max-width: 900px; margin: 36px auto; padding: 0 20px 60px; }
        .alert-success { background: #e8f5e9; color: #2e7d32; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }
        .alert-error { background: #fce4ec; color: #c62828; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }

        /* Header */
        .proj-header { background: white; border-radius: 16px; padding: 28px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .badges { display: flex; gap: 8px; margin-bottom: 12px; }
        .badge { padding: 4px 14px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .badge-gray { background: #f0f2f5; color: #6b7a8d; }
        .badge-aktif { background: #e8f5e9; color: #2e7d32; }
        .badge-selesai { background: #e3f2fd; color: #1565c0; }
        h1 { font-size: 1.8rem; font-weight: 800; color: #0f1624; margin-bottom: 8px; }
        .subtitle { font-size: 0.9rem; color: #6b7a8d; margin-bottom: 16px; }
        .meta-row { display: flex; gap: 20px; flex-wrap: wrap; }
        .meta-item { display: flex; align-items: center; gap: 6px; font-size: 0.85rem; color: #6b7a8d; }
        .meta-item strong { color: #0f1624; }

        /* Stat Cards */
        .stat-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: white; border-radius: 14px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-align: center; }
        .stat-card .num { font-size: 2rem; font-weight: 800; color: #0f1624; }
        .stat-card .lbl { font-size: 0.82rem; color: #6b7a8d; margin-top: 4px; }
        .stat-card .icon { font-size: 1.3rem; margin-bottom: 8px; }

        /* Anggota */
        .card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .card-title { font-size: 0.9rem; font-weight: 700; color: #0f1624; margin-bottom: 16px; display: flex; align-items: center; gap: 6px; }
        .anggota-item { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f5f5f5; }
        .anggota-item:last-child { border-bottom: none; }
        .avatar { width: 36px; height: 36px; min-width: 36px; background: #0f1624; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.82rem; font-weight: 700; }
        .anggota-name { font-size: 0.88rem; font-weight: 600; color: #0f1624; }
        .anggota-detail { font-size: 0.78rem; color: #6b7a8d; margin-top: 2px; }
        .badge-ketua { background: #0f1624; color: white; padding: 2px 8px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; margin-left: 6px; }

        /* Kelompok / Kanban Cards */
        .kelompok-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; }
        .kelompok-card { background: white; border-radius: 16px; border: 1.5px solid #e8e8e8; padding: 22px; transition: all 0.2s; }
        .kelompok-card:hover { border-color: #0f1624; box-shadow: 0 4px 16px rgba(0,0,0,0.08); transform: translateY(-2px); }
        .kel-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
        .kel-name { font-size: 1rem; font-weight: 700; color: #0f1624; }
        .kel-meta { font-size: 0.82rem; color: #6b7a8d; margin-bottom: 10px; }
        .progress-wrap { background: #f0f2f5; border-radius: 20px; height: 8px; margin: 8px 0 4px; }
        .progress-fill { background: #0f1624; border-radius: 20px; height: 8px; }
        .progress-pct { font-size: 0.78rem; color: #6b7a8d; margin-bottom: 14px; }
        .btn-kanban { display: block; padding: 12px; background: #0f1624; color: white; text-align: center; border-radius: 10px; font-size: 0.9rem; font-weight: 600; text-decoration: none; transition: background 0.2s; }
        .btn-kanban:hover { background: #1e2d40; color: white; }

        /* Task pills */
        .task-pills { display: flex; gap: 8px; margin-bottom: 12px; }
        .pill { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .pill-todo { background: #f0f2f5; color: #6b7a8d; }
        .pill-progress { background: #fff3e0; color: #e65100; }
        .pill-done { background: #e8f5e9; color: #2e7d32; }

        .btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 11px 22px; background: #f0f2f5; color: #0f1624; border-radius: 10px; text-decoration: none; font-size: 0.9rem; font-weight: 600; margin-top: 8px; transition: all 0.2s; }
        .btn-back:hover { background: #0f1624; color: white; }

        .empty-state { text-align: center; padding: 40px; color: #b0bec5; }
    </style>
</head>
<body>

<div class="topbar">
    <a href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
</div>

<div class="content">

    @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert-error">❌ {{ session('error') }}</div>
    @endif

    {{-- Header --}}
    <div class="proj-header">
        <div class="badges">
            <span class="badge badge-gray">Project</span>
            <span class="badge badge-{{ $project->status == 'aktif' ? 'aktif' : 'selesai' }}">{{ ucfirst($project->status) }}</span>
        </div>
        <h1>{{ $project->nama_project }}</h1>
        <p class="subtitle">{{ $project->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
        <div class="meta-row">
            <div class="meta-item">👨‍🏫 Dospem: <strong>{{ $project->dospem->name ?? '-' }}</strong></div>
            <div class="meta-item">👥 <strong>{{ $project->anggota->count() }}</strong> anggota</div>
            <div class="meta-item">📁 <strong>{{ $project->groups->count() }}</strong> kelompok</div>
        </div>
    </div>

    {{-- Daftar Anggota --}}
@php $semuaAnggota = $project->anggota ?? collect([]); @endphp
@if($semuaAnggota->count() > 0)
<div class="card">
    <div class="card-title">👥 Daftar Anggota ({{ $semuaAnggota->count() }} orang)</div>
    @foreach($semuaAnggota as $anggota)
    <div class="anggota-item">
        <div class="avatar">{{ strtoupper(substr($anggota->nama,0,1)) }}</div>
        <div style="flex:1;">
            <div class="anggota-name">
                {{ $anggota->nama }}
                @if($anggota->is_ketua)
                <span class="badge-ketua">Ketua</span>
                @endif
            </div>
            <div class="anggota-detail">NIM: {{ $anggota->nim }} &nbsp;·&nbsp; Semester {{ $anggota->semester }}</div>
        </div>
        @if(auth()->user()->isDospem())
        <form action="{{ route('projects.removeAnggota', [$project->id, $anggota->id]) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit"
                style="padding:5px 12px; background:#fce4ec; color:#c62828; border:none; border-radius:8px; font-size:0.78rem; font-weight:600; cursor:pointer;"
                onclick="return confirm('Hapus anggota {{ $anggota->nama }} dari proyek ini?')">
                Hapus
            </button>
        </form>
        @endif
    </div>
    @endforeach
</div>
@endif

    {{-- Kelompok & Kanban --}}
    <div class="card-title" style="margin-bottom:16px;">🗂 Kelompok & Kanban Board</div>
    @if($project->groups->count() > 0)
    <div class="kelompok-grid">
        @foreach($project->groups as $group)
        @php
            $total = $group->tasks->count();
            $done = $group->tasks->where('status','done')->count();
            $progress = $group->tasks->where('status','on_progress')->count();
            $todo = $group->tasks->where('status','todo')->count();
            $persen = $total > 0 ? round(($done/$total)*100) : 0;
        @endphp
        <div class="kelompok-card">
            <div class="kel-header">
                <div class="kel-name">{{ $group->nama_group }}</div>
                <span style="font-size:0.8rem; color:#6b7a8d;">{{ $group->members->count() }} anggota</span>
            </div>
            <div class="task-pills">
                <span class="pill pill-todo">Todo: {{ $todo }}</span>
                <span class="pill pill-progress">Progress: {{ $progress }}</span>
                <span class="pill pill-done">Done: {{ $done }}</span>
            </div>
            <div class="progress-wrap">
                <div class="progress-fill" style="width:{{ $persen }}%"></div>
            </div>
            <div class="progress-pct">Progress: {{ $persen }}% ({{ $done }}/{{ $total }} tugas)</div>
            <a href="{{ route('projects.groups.show', [$project->id, $group->id]) }}" class="btn-kanban">
                🗂 Buka Kanban Board
            </a>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <p style="font-size:1rem; font-weight:600; margin-bottom:6px;">Belum ada kelompok</p>
        <p>Kelompok akan muncul setelah mahasiswa bergabung ke proyek ini</p>
    </div>
    @endif

    <a href="{{ route('dashboard') }}" class="btn-back">← Kembali ke Dashboard</a>

</div>
</body>
</html>