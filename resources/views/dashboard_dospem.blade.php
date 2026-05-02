<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f6fa; }
        .topbar { background: #0f1624; color: white; padding: 18px 32px; display: flex; align-items: center; justify-content: space-between; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .topbar-left h1 { font-size: 1.3rem; font-weight: 700; }
        .topbar-left p { font-size: 0.85rem; color: #8a9bb0; }
        .btn-logout { background: transparent; border: 2px solid white; color: white; padding: 8px 18px; border-radius: 8px; font-size: 0.9rem; text-decoration: none; display: flex; align-items: center; gap: 6px; }
        .btn-logout:hover { background: white; color: #0f1624; }
        .content { padding: 32px; }
        .stat-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 36px; }
        .stat-card { background: white; border-radius: 16px; padding: 24px; display: flex; justify-content: space-between; align-items: flex-start; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .stat-card .label { font-size: 0.9rem; color: #6b7a8d; margin-bottom: 12px; }
        .stat-card .value { font-size: 2rem; font-weight: 700; color: #0f1624; }
        .stat-card .stat-icon { width: 40px; height: 40px; background: #f0f2f5; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; }
        .search-wrap { display: flex; gap: 12px; flex: 1; }
        .search-wrap input { flex: 1; padding: 10px 16px; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 0.9rem; outline: none; }
        .search-wrap select { padding: 10px 16px; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 0.9rem; outline: none; background: white; min-width: 150px; }
        .btn-add { background: #0f1624; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; }
        .btn-add:hover { background: #1a2a3a; color: white; }
        .proj-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .proj-card { background: white; border-radius: 16px; border: 1.5px solid #e8e8e8; padding: 24px; display: flex; flex-direction: column; transition: all 0.2s; }
        .proj-card:hover { border-color: #0f1624; box-shadow: 0 8px 32px rgba(0,0,0,0.1); transform: translateY(-2px); }
        .proj-card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
        .badge-kategori { background: #f0f2f5; color: #6b7a8d; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 500; }
        .badge-aktif { background: #e8f5e9; color: #2e7d32; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; }
        .badge-selesai { background: #e3f2fd; color: #1565c0; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; }
        .proj-card h3 { font-size: 1.05rem; font-weight: 700; color: #0f1624; margin-bottom: 8px; }
        .proj-card .desc { font-size: 0.83rem; color: #6b7a8d; line-height: 1.5; margin-bottom: 14px; }
        .meta-row { font-size: 0.82rem; color: #6b7a8d; margin-bottom: 6px; }
        .progress-wrap { background: #f0f2f5; border-radius: 20px; height: 6px; margin: 10px 0 4px; }
        .progress-fill { background: #0f1624; border-radius: 20px; height: 6px; }
        .progress-pct { font-size: 0.78rem; color: #6b7a8d; margin-bottom: 14px; }
        .kelompok-label { font-size: 0.8rem; font-weight: 600; color: #6b7a8d; margin-bottom: 6px; }
        .kelompok-item { font-size: 0.82rem; color: #4a5568; padding: 2px 0; }
        .kelompok-more { font-size: 0.78rem; color: #b0bec5; }
        .proj-actions { display: flex; flex-direction: column; gap: 8px; margin-top: auto; padding-top: 16px; }
        .btn-detail { background: #f0f2f5; color: #0f1624; text-align: center; padding: 10px; border-radius: 10px; font-size: 0.88rem; font-weight: 600; text-decoration: none; transition: all 0.15s; }
        .btn-detail:hover { background: #e0e0e0; }
        .btn-row { display: flex; gap: 8px; }
        .btn-edit { flex: 1; background: #fff3e0; color: #e65100; text-align: center; padding: 9px; border-radius: 10px; font-size: 0.85rem; font-weight: 600; text-decoration: none; }
        .btn-hapus { flex: 1; background: #fce4ec; color: #c62828; padding: 9px; border-radius: 10px; font-size: 0.85rem; font-weight: 600; border: none; cursor: pointer; width: 100%; }
        .empty-state { grid-column: span 3; text-align: center; padding: 60px; color: #b0bec5; }
        .empty-state a { color: #0f1624; font-weight: 600; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-left">
        <div style="font-size:1.5rem;">📊</div>
        <div>
            <h1>Dashboard Dosen Pembimbing</h1>
            <p>Selamat datang, {{ auth()->user()->name }}</p>
        </div>
    </div>
    <a href="{{ route('logout') }}" class="btn-logout"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        ↪ Keluar
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
</div>

<div class="content">

    {{-- Stat Cards --}}
    <div class="stat-cards" style="grid-template-columns: repeat(2, 1fr);">
        <div class="stat-card">
            <div><div class="label">Total Proyek</div><div class="value">{{ $projects->count() }}</div></div>
            <div class="stat-icon">📁</div>
        </div>
        <div class="stat-card">
            <div><div class="label">Proyek Aktif</div><div class="value">{{ $projects->where('status','aktif')->count() }}</div></div>
            <div class="stat-icon">🟢</div>
        </div>
        <div class="stat-card">
            <div><div class="label">Tugas Selesai</div><div class="value">{{ $projects->sum(fn($p) => $p->groups->sum(fn($g) => $g->tasks->where('status','done')->count())) }}</div></div>
            <div class="stat-icon">✅</div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="toolbar">
        @if(isset($semesterAktif) && $semesterAktif)
<div style="background:#e8f5e9; border-radius:12px; padding:14px 20px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
    <span style="font-size:1.2rem;">📅</span>
    <div>
        <div style="font-size:0.88rem; font-weight:700; color:#2e7d32;">Semester Aktif: {{ $semesterAktif->nama }}</div>
        <div style="font-size:0.78rem; color:#4caf50;">Menampilkan proyek semester ini saja</div>
    </div>
</div>
@else
<div style="background:#fce4ec; border-radius:12px; padding:14px 20px; margin-bottom:20px;">
    <span style="font-size:0.88rem; color:#c62828;">⚠️ Belum ada semester aktif. Silakan atur di admin panel.</span>
</div>
@endif
        <div class="search-wrap">
            <input type="text" id="searchInput" placeholder="🔍 Cari proyek..." onkeyup="filterProjects()">
            <select id="filterStatus" onchange="filterProjects()">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
        <a href="{{ route('projects.create') }}" class="btn-add">+ Buat Project</a>
    </div>

    {{-- Grid --}}
    <div class="proj-grid" id="projectGrid">
        @forelse($projects as $project)
        @php
            $totalTugas = $project->groups->sum(fn($g) => $g->tasks->count());
            $doneTugas = $project->groups->sum(fn($g) => $g->tasks->where('status','done')->count());
            $persen = $totalTugas > 0 ? round(($doneTugas/$totalTugas)*100) : 0;
        @endphp
        <div class="proj-card" data-name="{{ strtolower($project->nama_project) }}" data-status="{{ $project->status }}">
            <div>
                <div class="proj-card-top">
                    <span class="badge-kategori">Project</span>
                    <span class="{{ $project->status == 'aktif' ? 'badge-aktif' : 'badge-selesai' }}">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>
                <h3>{{ $project->nama_project }}</h3>
                <p class="desc">{{ Str::limit($project->deskripsi, 80) ?? '-' }}</p>
                <div class="meta-row">🕐 Dospem: <strong>{{ $project->dospem->name ?? '-' }}</strong></div>
                <div class="meta-row">👥 <strong>{{ $project->members->count() }}</strong> anggota · 📁 <strong>{{ $project->groups->count() }}</strong> kelompok</div>
                <div class="meta-row">✅ <strong>{{ $doneTugas }}/{{ $totalTugas }}</strong> tugas selesai</div>
                <div class="progress-wrap">
                    <div class="progress-fill" style="width:{{ $persen }}%"></div>
                </div>
                <div class="progress-pct">Progress: {{ $persen }}%</div>
                <div class="kelompok-label">📋 Kelompok:</div>
                @forelse($project->groups->take(2) as $group)
                <div class="kelompok-item">• {{ $group->nama_group }}</div>
                @empty
                <div class="kelompok-item" style="color:#b0bec5;">Belum ada kelompok</div>
                @endforelse
                @if($project->groups->count() > 2)
                <div class="kelompok-more">+{{ $project->groups->count() - 2 }} lainnya</div>
                @endif
            </div>
            <div class="proj-actions">
                <a href="{{ route('projects.show', $project->id) }}" class="btn-detail">Lihat Detail</a>
                @if($project->dospem_id == auth()->id())
                <div class="btn-row">
                    <a href="{{ route('projects.edit', $project->id) }}" class="btn-edit">✏️ Edit</a>
                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="flex:1;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-hapus" onclick="return confirm('Yakin hapus project ini?')">🗑 Hapus</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state">
            Belum ada proyek. <a href="{{ route('projects.create') }}">Buat sekarang!</a>
        </div>
        @endforelse
    </div>
</div>

<script>
function filterProjects() {
    var search = document.getElementById('searchInput').value.toLowerCase();
    var status = document.getElementById('filterStatus').value;
    document.querySelectorAll('.proj-card').forEach(function(card) {
        var name = card.getAttribute('data-name');
        var cardStatus = card.getAttribute('data-status');
        card.style.display = (name.includes(search) && (status === '' || cardStatus === status)) ? 'flex' : 'none';
    });
}
</script>

</body>
</html>