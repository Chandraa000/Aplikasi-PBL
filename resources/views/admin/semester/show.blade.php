<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $semester->nama }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f6fa; }
        .topbar { background: #0f1624; color: white; padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; }
        .topbar a { color: white; text-decoration: none; font-size: 0.9rem; }
        .content { padding: 32px; }
        .header { margin-bottom: 28px; }
        .header h1 { font-size: 1.8rem; font-weight: 700; color: #0f1624; margin-bottom: 6px; }
        .header p { color: #6b7a8d; font-size: 0.9rem; }
        .badge-aktif { background: #2e7d32; color: white; padding: 4px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 600; display: inline-block; margin-bottom: 12px; }
        .badge-nonaktif { background: #f0f2f5; color: #6b7a8d; padding: 4px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 600; display: inline-block; margin-bottom: 12px; }
        .stat-cards { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; margin-bottom: 28px; }
        .stat-card { background: white; border-radius: 14px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; justify-content: space-between; align-items: flex-start; }
        .stat-card .label { font-size: 0.88rem; color: #6b7a8d; margin-bottom: 8px; }
        .stat-card .value { font-size: 1.8rem; font-weight: 700; color: #0f1624; }
        .stat-card .icon { font-size: 1.4rem; }
        .proj-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
        .proj-card { background: white; border-radius: 14px; border: 1.5px solid #e8e8e8; padding: 22px; transition: all 0.2s; }
        .proj-card:hover { border-color: #0f1624; box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
        .proj-card-top { display: flex; justify-content: space-between; margin-bottom: 12px; }
        .badge-gray { background: #f0f2f5; color: #6b7a8d; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .badge-green { background: #e8f5e9; color: #2e7d32; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-blue { background: #e3f2fd; color: #1565c0; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .proj-name { font-size: 1rem; font-weight: 700; color: #0f1624; margin-bottom: 6px; }
        .proj-desc { font-size: 0.82rem; color: #6b7a8d; margin-bottom: 14px; line-height: 1.5; }
        .proj-meta { font-size: 0.82rem; color: #6b7a8d; margin-bottom: 6px; }
        .progress-wrap { background: #f0f2f5; border-radius: 20px; height: 6px; margin: 10px 0 4px; }
        .progress-fill { background: #0f1624; border-radius: 20px; height: 6px; }
        .progress-pct { font-size: 0.78rem; color: #6b7a8d; margin-bottom: 14px; }
        .btn-detail { display: block; padding: 10px; background: #f0f2f5; color: #0f1624; text-align: center; border-radius: 10px; font-size: 0.88rem; font-weight: 600; text-decoration: none; }
        .btn-detail:hover { background: #0f1624; color: white; }
        .empty-state { text-align: center; padding: 60px; color: #b0bec5; background: white; border-radius: 14px; }
    </style>
</head>
<body>

<div class="topbar">
    <a href="{{ route('admin.semester.index') }}">← Kembali ke Semester</a>
    <span style="font-size:0.85rem; color:#8a9bb0;">Admin</span>
</div>

<div class="content">

    <div class="header">
        <span class="{{ $semester->is_aktif ? 'badge-aktif' : 'badge-nonaktif' }}">
            {{ $semester->is_aktif ? '✅ Semester Aktif' : 'Non-aktif' }}
        </span>
        <h1>{{ $semester->nama }}</h1>
        <p>
            @if($semester->tanggal_mulai)
            📅 {{ \Carbon\Carbon::parse($semester->tanggal_mulai)->format('d M Y') }}
            @if($semester->tanggal_selesai)
            → {{ \Carbon\Carbon::parse($semester->tanggal_selesai)->format('d M Y') }}
            @endif
            @endif
        </p>
    </div>

    {{-- Stat Cards --}}
    <div class="stat-cards">
        <div class="stat-card">
            <div><div class="label">Total Proyek</div><div class="value">{{ $semester->projects->count() }}</div></div>
            <div class="icon">📁</div>
        </div>
        <div class="stat-card">
            <div><div class="label">Total Kelompok</div><div class="value">{{ $semester->projects->sum(fn($p) => $p->groups->count()) }}</div></div>
            <div class="icon">👥</div>
        </div>
        <div class="stat-card">
            <div><div class="label">Tugas Selesai</div><div class="value">{{ $semester->projects->sum(fn($p) => $p->groups->sum(fn($g) => $g->tasks->where('status','done')->count())) }}</div></div>
            <div class="icon">✅</div>
        </div>
    </div>

    {{-- Daftar Proyek --}}
    @if($semester->projects->count() > 0)
    <div class="proj-grid">
        @foreach($semester->projects as $project)
        @php
            $totalT = $project->groups->sum(fn($g) => $g->tasks->count());
            $doneT = $project->groups->sum(fn($g) => $g->tasks->where('status','done')->count());
            $persen = $totalT > 0 ? round(($doneT/$totalT)*100) : 0;
        @endphp
        <div class="proj-card">
            <div class="proj-card-top">
                <span class="badge-gray">Project</span>
                <span class="{{ $project->status == 'aktif' ? 'badge-green' : 'badge-blue' }}">{{ ucfirst($project->status) }}</span>
            </div>
            <div class="proj-name">{{ $project->nama_project }}</div>
            <div class="proj-desc">{{ Str::limit($project->deskripsi, 80) ?? '-' }}</div>
            <div class="proj-meta">🕐 Dospem: <strong>{{ $project->dospem->name ?? '-' }}</strong></div>
            <div class="proj-meta">👥 {{ $project->members->count() }} anggota · 📁 {{ $project->groups->count() }} kelompok</div>
            <div class="progress-wrap">
                <div class="progress-fill" style="width:{{ $persen }}%"></div>
            </div>
            <div class="progress-pct">Progress: {{ $persen }}%</div>
            <a href="{{ route('projects.show', $project->id) }}" class="btn-detail">Lihat Detail</a>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <p style="font-size:1.1rem; font-weight:600; margin-bottom:8px;">Belum ada proyek di semester ini</p>
        <p>Proyek akan muncul di sini setelah ditambahkan ke semester ini</p>
    </div>
    @endif

</div>
</body>
</html>