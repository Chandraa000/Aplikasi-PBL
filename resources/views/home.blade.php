<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
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
        .mhs-header { margin-bottom: 28px; }
        .mhs-header h2 { font-size: 1.8rem; font-weight: 700; color: #0f1624; margin-bottom: 6px; }
        .mhs-header p { color: #6b7a8d; font-size: 0.95rem; }
        .search-bar { background: white; border-radius: 14px; padding: 16px 20px; margin-bottom: 28px; display: flex; gap: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .search-bar input { flex: 1; padding: 10px 16px; border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 0.95rem; outline: none; }
        .search-bar input:focus { border-color: #0f1624; }
        .search-bar select { padding: 10px 16px; border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 0.95rem; outline: none; min-width: 160px; cursor: pointer; background: white; }
        .proj-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .proj-card { background: white; border-radius: 16px; border: 1.5px solid #e8e8e8; padding: 24px; display: flex; flex-direction: column; transition: all 0.2s; }
        .proj-card:hover { border-color: #0f1624; box-shadow: 0 8px 32px rgba(0,0,0,0.1); transform: translateY(-2px); }
        .proj-card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
        .badge-kategori { background: #f0f2f5; color: #6b7a8d; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 500; }
        .badge-aktif-green { background: #e8f5e9; color: #2e7d32; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; }
        .badge-selesai-blue { background: #e3f2fd; color: #1565c0; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; }
        .proj-card h3 { font-size: 1.1rem; font-weight: 700; color: #0f1624; margin-bottom: 10px; line-height: 1.4; }
        .proj-card .desc { font-size: 0.85rem; color: #6b7a8d; line-height: 1.6; margin-bottom: 18px; }
        .proj-meta { margin-bottom: 16px; }
        .proj-meta-row { display: flex; align-items: center; gap: 8px; font-size: 0.83rem; color: #6b7a8d; margin-bottom: 8px; }
        .proj-meta-row span { font-weight: 500; }
        .outcomes-section { margin-bottom: 20px; }
        .outcomes-label { font-size: 0.8rem; color: #6b7a8d; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; font-weight: 600; }
        .outcomes-list { list-style: none; }
        .outcomes-list li { font-size: 0.82rem; color: #4a5568; padding: 2px 0; display: flex; align-items: center; gap: 6px; }
        .outcomes-list li::before { content: '•'; color: #0f1624; font-weight: 700; }
        .outcomes-more { font-size: 0.8rem; color: #b0bec5; margin-top: 4px; }
        .proj-actions { display: flex; flex-direction: column; gap: 8px; margin-top: auto; }
        .btn-lihat { padding: 11px; background: white; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 0.9rem; font-weight: 600; color: #0f1624; text-align: center; text-decoration: none; transition: all 0.2s; }
        .btn-lihat:hover { background: #f5f6fa; border-color: #0f1624; }
        .btn-pilih { padding: 11px; background: #0f1624; border: none; border-radius: 10px; font-size: 0.9rem; font-weight: 600; color: white; text-align: center; text-decoration: none; transition: background 0.2s; display: block; }
        .btn-pilih:hover { background: #1a2a3a; color: white; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-left">
        <div style="font-size:1.5rem;">🎓</div>
        <div>
            <h1>Dashboard Mahasiswa</h1>
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
    <div class="mhs-header">
        <h2>Pilih Proyek PBL</h2>
        <p>Pilih template proyek yang ingin Anda kerjakan</p>
    </div>

    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="🔍 Cari proyek..." onkeyup="filterProjects()">
        <select id="filterStatus" onchange="filterProjects()">
            <option value="">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="selesai">Selesai</option>
        </select>
    </div>

    <div class="proj-grid" id="projectGrid">
        @forelse($projects as $project)
        <div class="proj-card" data-name="{{ strtolower($project->nama_project) }}" data-status="{{ $project->status }}">
            <div>
                <div class="proj-card-top">
                    <span class="badge-kategori">Project</span>
                    <span class="{{ $project->status == 'aktif' ? 'badge-aktif-green' : 'badge-selesai-blue' }}">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>
                <h3>{{ $project->nama_project }}</h3>
                <p class="desc">{{ Str::limit($project->deskripsi, 100) ?? '-' }}</p>
                <div class="proj-meta">
                    <div class="proj-meta-row">🕐 <span>Dospem: {{ $project->dospem->name ?? '-' }}</span></div>
                    <div class="proj-meta-row">👥 <span>{{ $project->members->count() }} anggota terdaftar</span></div>
                </div>
                <div class="outcomes-section">
                    <div class="outcomes-label">📋 Info Kelompok:</div>
                    <ul class="outcomes-list">
                        @forelse($project->groups->take(2) as $group)
                        <li>{{ $group->nama_group }}</li>
                        @empty
                        <li>Belum ada kelompok</li>
                        @endforelse
                    </ul>
                    @if($project->groups->count() > 2)
                    <p class="outcomes-more">+{{ $project->groups->count() - 2 }} lainnya</p>
                    @endif
                </div>
            </div>
            <div class="proj-actions">
                <a href="{{ route('projects.show', $project->id) }}" class="btn-lihat">Lihat Detail</a>
                <a href="{{ route('projects.joinForm', $project->id) }}" class="btn-pilih">Pilih Proyek Ini</a>
            </div>
        </div>
        @empty
        <div style="grid-column:span 3; text-align:center; padding:60px; color:#b0bec5;">Belum ada proyek tersedia.</div>
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