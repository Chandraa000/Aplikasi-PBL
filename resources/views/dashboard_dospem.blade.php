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
        .btn-logout { background: transparent; border: 2px solid white; color: white; padding: 8px 18px; border-radius: 8px; font-size: 0.9rem; text-decoration: none; }
        .btn-logout:hover { background: white; color: #0f1624; }
        .content { padding: 32px; max-width: 1200px; margin: 0 auto; }

        /* Semester */
        .semester-bar { background: #e8f5e9; border-radius: 12px; padding: 14px 20px; margin-bottom: 28px; display: flex; align-items: center; gap: 10px; }
        .semester-bar .sem-name { font-size: 0.9rem; font-weight: 700; color: #2e7d32; }
        .semester-bar .sem-sub { font-size: 0.78rem; color: #4caf50; }

        /* Stat Cards */
        .stat-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px; }
        .stat-card { background: white; border-radius: 16px; padding: 24px; display: flex; justify-content: space-between; align-items: flex-start; box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card .label { font-size: 0.85rem; color: #6b7a8d; margin-bottom: 10px; }
        .stat-card .value { font-size: 2rem; font-weight: 800; color: #0f1624; }
        .stat-icon { width: 44px; height: 44px; background: #f0f2f5; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }

        /* Search */
        .toolbar { display: flex; gap: 12px; margin-bottom: 24px; }
        .toolbar input { flex: 1; padding: 11px 16px; border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 0.9rem; outline: none; }
        .toolbar input:focus { border-color: #0f1624; }
        .toolbar select { padding: 11px 16px; border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 0.9rem; outline: none; background: white; min-width: 160px; }

        /* Section */
        .section-title { font-size: 1rem; font-weight: 700; color: #0f1624; margin-bottom: 16px; }

        /* Project Cards */
        .proj-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .proj-card { background: white; border-radius: 16px; border: 1.5px solid #e8e8e8; padding: 22px; display: flex; flex-direction: column; transition: all 0.2s; }
        .proj-card:hover { border-color: #0f1624; box-shadow: 0 8px 24px rgba(0,0,0,0.08); transform: translateY(-2px); }
        .proj-card-top { display: flex; justify-content: space-between; margin-bottom: 12px; }
        .badge-gray { background: #f0f2f5; color: #6b7a8d; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .badge-aktif { background: #e8f5e9; color: #2e7d32; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-selesai { background: #e3f2fd; color: #1565c0; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .proj-name { font-size: 1rem; font-weight: 700; color: #0f1624; margin-bottom: 6px; }
        .proj-desc { font-size: 0.82rem; color: #6b7a8d; margin-bottom: 14px; line-height: 1.5; }
        .proj-meta { font-size: 0.82rem; color: #6b7a8d; margin-bottom: 6px; display: flex; align-items: center; gap: 6px; }
        .progress-wrap { background: #f0f2f5; border-radius: 20px; height: 6px; margin: 10px 0 4px; }
        .progress-fill { background: #0f1624; border-radius: 20px; height: 6px; }
        .progress-pct { font-size: 0.78rem; color: #6b7a8d; margin-bottom: 14px; }
        .kelompok-label { font-size: 0.8rem; font-weight: 600; color: #6b7a8d; margin-bottom: 6px; }
        .kelompok-item { font-size: 0.82rem; color: #4a5568; padding: 2px 0; }
        .kelompok-more { font-size: 0.78rem; color: #b0bec5; }
        .proj-actions { margin-top: auto; padding-top: 16px; }
        .btn-detail { display: block; padding: 11px; background: #0f1624; color: white; text-align: center; border-radius: 10px; font-size: 0.9rem; font-weight: 600; text-decoration: none; transition: background 0.2s; }
        .btn-detail:hover { background: #1e2d40; color: white; }

        .empty-state { grid-column: span 3; text-align: center; padding: 60px; background: white; border-radius: 16px; color: #b0bec5; }
        .alert-success { background: #e8f5e9; color: #2e7d32; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-left">
        <div style="font-size:1.5rem;">👨‍🏫</div>
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

    @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Semester Info --}}
    @if(isset($semesterAktif) && $semesterAktif)
    <div class="semester-bar">
        <span style="font-size:1.2rem;">📅</span>
        <div>
            <div class="sem-name">Semester Aktif: {{ $semesterAktif->nama }}</div>
            <div class="sem-sub">Menampilkan proyek yang Anda ampu di semester ini</div>
        </div>
    </div>
    @else
    <div style="background:#fce4ec; border-radius:12px; padding:14px 20px; margin-bottom:28px;">
        <span style="font-size:0.9rem; color:#c62828; font-weight:600;">⚠️ Belum ada semester aktif. Hubungi admin.</span>
    </div>
    @endif

    {{-- Stat Cards --}}
    <div class="stat-cards">
        <div class="stat-card">
            <div>
                <div class="label">Total Proyek Saya</div>
                <div class="value">{{ $projects->count() }}</div>
            </div>
            <div class="stat-icon">📁</div>
        </div>
        <div class="stat-card">
            <div>
                <div class="label">Proyek Aktif</div>
                <div class="value">{{ $projects->where('status','aktif')->count() }}</div>
            </div>
            <div class="stat-icon">🟢</div>
        </div>
        <div class="stat-card">
            <div>
                <div class="label">Tugas Selesai</div>
                <div class="value">{{ $projects->sum(fn($p) => $p->groups->sum(fn($g) => $g->tasks->where('status','done')->count())) }}</div>
            </div>
            <div class="stat-icon">✅</div>
        </div>
    </div>

    {{-- Search --}}
    <div class="toolbar">
        <input type="text" id="searchInput" placeholder="🔍 Cari proyek..." onkeyup="filterProjects()">
        <select id="filterStatus" onchange="filterProjects()">
            <option value="">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="selesai">Selesai</option>
        </select>
    </div>

    <div class="section-title">📋 Proyek Saya</div>

    {{-- Project Grid --}}
    <div class="proj-grid" id="projectGrid">
        @forelse($projects as $project)
        @php
            $totalT = $project->groups->sum(fn($g) => $g->tasks->count());
            $doneT = $project->groups->sum(fn($g) => $g->tasks->where('status','done')->count());
            $persen = $totalT > 0 ? round(($doneT/$totalT)*100) : 0;
        @endphp
        <div class="proj-card" data-name="{{ strtolower($project->nama_project) }}" data-status="{{ $project->status }}">
            <div>
                <div class="proj-card-top">
                    <span class="badge-gray">Project</span>
                    <span class="{{ $project->status == 'aktif' ? 'badge-aktif' : 'badge-selesai' }}">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>
                <div class="proj-name">{{ $project->nama_project }}</div>
                <div class="proj-desc">{{ Str::limit($project->deskripsi, 80) ?? '-' }}</div>
                <div class="proj-meta">👥 <span>{{ $project->members->count() }} anggota</span></div>
                <div class="proj-meta">📁 <span>{{ $project->groups->count() }} kelompok</span></div>
                <div class="proj-meta">✅ <span>{{ $doneT }}/{{ $totalT }} tugas selesai</span></div>
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
                <a href="{{ route('projects.show', $project->id) }}" class="btn-detail">Lihat Detail →</a>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <p style="font-size:1rem; font-weight:600; margin-bottom:6px;">Belum ada proyek</p>
            <p>Proyek yang Anda ampu akan muncul di sini</p>
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