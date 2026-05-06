<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Proyek</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f6fa; }
        .topbar { background: #0f1624; color: white; padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; }
        .topbar a { color: white; text-decoration: none; font-size: 0.9rem; }
        .content { max-width: 1000px; margin: 36px auto; padding: 0 20px 60px; }
        h1 { font-size: 1.6rem; font-weight: 800; color: #0f1624; margin-bottom: 6px; }
        .subtitle { color: #6b7a8d; font-size: 0.9rem; margin-bottom: 28px; }

        .semester-section { margin-bottom: 36px; }
        .semester-header { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid #e8e8e8; }
        .semester-name { font-size: 1.1rem; font-weight: 700; color: #0f1624; }
        .badge-aktif { background: #e8f5e9; color: #2e7d32; padding: 3px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .badge-nonaktif { background: #f0f2f5; color: #6b7a8d; padding: 3px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .proj-count { background: #f0f2f5; color: #0f1624; padding: 3px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }

        .proj-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; }
        .proj-card { background: white; border-radius: 14px; border: 1.5px solid #e8e8e8; padding: 20px; transition: all 0.2s; }
        .proj-card:hover { border-color: #0f1624; box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
        .proj-card-top { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .badge-gray { background: #f0f2f5; color: #6b7a8d; padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; }
        .badge-green { background: #e8f5e9; color: #2e7d32; padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600; }
        .badge-blue { background: #e3f2fd; color: #1565c0; padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600; }
        .proj-name { font-size: 0.95rem; font-weight: 700; color: #0f1624; margin-bottom: 6px; }
        .proj-meta { font-size: 0.8rem; color: #6b7a8d; margin-bottom: 4px; }
        .progress-wrap { background: #f0f2f5; border-radius: 20px; height: 5px; margin: 10px 0 4px; }
        .progress-fill { background: #0f1624; border-radius: 20px; height: 5px; }
        .progress-pct { font-size: 0.75rem; color: #6b7a8d; margin-bottom: 12px; }
        .btn-detail { display: block; padding: 9px; background: #f0f2f5; color: #0f1624; text-align: center; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; }
        .btn-detail:hover { background: #0f1624; color: white; }

        .empty-sem { background: white; border-radius: 12px; padding: 24px; text-align: center; color: #b0bec5; font-size: 0.85rem; }
        .empty-all { text-align: center; padding: 60px; color: #b0bec5; }
    </style>
</head>
<body>

<div class="topbar">
    <a href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
    <span style="font-size:0.85rem; color:#8a9bb0;">Riwayat Proyek</span>
</div>

<div class="content">
    <h1>📚 Riwayat Proyek Saya</h1>
    <p class="subtitle">Semua proyek yang Anda ampu per semester</p>

    @forelse($semesters as $semester)
    @if($semester->projects->count() > 0)
    <div class="semester-section">
        <div class="semester-header">
            <div class="semester-name">{{ $semester->nama }}</div>
            <span class="{{ $semester->is_aktif ? 'badge-aktif' : 'badge-nonaktif' }}">
                {{ $semester->is_aktif ? '✅ Aktif' : 'Selesai' }}
            </span>
            <span class="proj-count">{{ $semester->projects->count() }} proyek</span>
        </div>

        <div class="proj-grid">
            @foreach($semester->projects as $project)
            @php
                $total = $project->groups->sum(fn($g) => $g->tasks->count());
                $done = $project->groups->sum(fn($g) => $g->tasks->where('status','done')->count());
                $persen = $total > 0 ? round(($done/$total)*100) : 0;
            @endphp
            <div class="proj-card">
                <div class="proj-card-top">
                    <span class="badge-gray">Project</span>
                    <span class="{{ $project->status == 'aktif' ? 'badge-green' : 'badge-blue' }}">{{ ucfirst($project->status) }}</span>
                </div>
                <div class="proj-name">{{ $project->nama_project }}</div>
                <div class="proj-meta">👥 {{ $project->anggota->count() }} anggota</div>
                <div class="proj-meta">📁 {{ $project->groups->count() }} kelompok</div>
                <div class="proj-meta">✅ {{ $done }}/{{ $total }} tugas selesai</div>
                <div class="progress-wrap">
                    <div class="progress-fill" style="width:{{ $persen }}%"></div>
                </div>
                <div class="progress-pct">Progress: {{ $persen }}%</div>
                <a href="{{ route('projects.show', $project->id) }}" class="btn-detail">Lihat Detail</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @empty
    <div class="empty-all">
        <p style="font-size:1rem; font-weight:600; margin-bottom:6px;">Belum ada riwayat proyek</p>
        <p>Proyek yang Anda ampu akan muncul di sini</p>
    </div>
    @endforelse
</div>

</body>
</html>