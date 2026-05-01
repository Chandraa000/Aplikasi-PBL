<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Semester</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f6fa; }
        .topbar { background: #0f1624; color: white; padding: 18px 32px; display: flex; align-items: center; justify-content: space-between; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .topbar-left h1 { font-size: 1.3rem; font-weight: 700; }
        .topbar-left p { font-size: 0.85rem; color: #8a9bb0; }
        .topbar-nav { display: flex; gap: 8px; }
        .nav-btn { padding: 8px 16px; border-radius: 8px; font-size: 0.88rem; font-weight: 600; text-decoration: none; transition: all 0.2s; }
        .nav-active { background: white; color: #0f1624; }
        .nav-inactive { background: transparent; color: #8a9bb0; border: 1px solid #2a3a4a; }
        .nav-inactive:hover { background: #1a2a3a; color: white; }
        .btn-logout { background: transparent; border: 2px solid white; color: white; padding: 8px 18px; border-radius: 8px; font-size: 0.9rem; text-decoration: none; }
        .btn-logout:hover { background: white; color: #0f1624; }
        .content { padding: 32px; display: grid; grid-template-columns: 360px 1fr; gap: 24px; }
        .card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .card h3 { font-size: 1rem; font-weight: 700; color: #0f1624; margin-bottom: 20px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #0f1624; margin-bottom: 6px; }
        .form-group input, .form-group select { width: 100%; padding: 10px 14px; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 0.9rem; outline: none; background: white; }
        .form-group input:focus, .form-group select:focus { border-color: #0f1624; }
        .btn-submit { width: 100%; padding: 12px; background: #0f1624; color: white; border: none; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; }
        .btn-submit:hover { background: #1a2a3a; }
        .alert-success { background: #e8f5e9; color: #2e7d32; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 0.88rem; }
        .alert-error { background: #fce4ec; color: #c62828; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 0.88rem; }
        .semester-card { border: 1.5px solid #e8e8e8; border-radius: 14px; padding: 20px; margin-bottom: 16px; transition: all 0.2s; }
        .semester-card:hover { border-color: #0f1624; }
        .semester-card.aktif { border-color: #2e7d32; background: #f1f8e9; }
        .semester-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
        .semester-name { font-size: 1rem; font-weight: 700; color: #0f1624; }
        .badge-aktif { background: #2e7d32; color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-nonaktif { background: #f0f2f5; color: #6b7a8d; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .semester-meta { font-size: 0.82rem; color: #6b7a8d; margin-bottom: 14px; }
        .semester-actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn-lihat { padding: 7px 14px; background: #f0f2f5; color: #0f1624; border-radius: 8px; font-size: 0.82rem; font-weight: 600; text-decoration: none; }
        .btn-aktifkan { padding: 7px 14px; background: #e8f5e9; color: #2e7d32; border: none; border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer; }
        .btn-hapus { padding: 7px 14px; background: #fce4ec; color: #c62828; border: none; border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer; }
        .proj-count { display: inline-flex; align-items: center; gap: 6px; background: #f0f2f5; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; color: #0f1624; font-weight: 600; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-left">
        <div style="font-size:1.5rem;">⚙️</div>
        <div>
            <h1>Admin Dashboard</h1>
            <p>Kelola Semester</p>
        </div>
    </div>
    <div class="topbar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-btn nav-inactive">📊 Dashboard</a>
        <a href="{{ route('admin.users') }}" class="nav-btn nav-inactive">👥 Kelola User</a>
        <a href="{{ route('admin.semester.index') }}" class="nav-btn nav-active">📅 Semester</a>
    </div>
    <a href="{{ route('logout') }}" class="btn-logout"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">↪ Keluar</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
</div>

<div class="content">

    {{-- Form Tambah Semester --}}
    <div>
        <div class="card">
            <h3>➕ Tambah Semester</h3>

            @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert-error">❌ {{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.semester.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Jenis Semester *</label>
                    <select name="jenis" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="ganjil">Ganjil</option>
                        <option value="genap">Genap</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tahun Ajaran *</label>
                    <input type="text" name="tahun_ajaran" placeholder="Contoh: 2025/2026" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai">
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai">
                </div>
                <button type="submit" class="btn-submit">+ Tambah Semester</button>
            </form>
        </div>
    </div>

    {{-- Daftar Semester --}}
    <div>
        <div class="card">
            <h3>📅 Daftar Semester ({{ $semesters->count() }})</h3>

            @forelse($semesters as $semester)
            <div class="semester-card {{ $semester->is_aktif ? 'aktif' : '' }}">
                <div class="semester-header">
                    <div>
                        <div class="semester-name">{{ $semester->nama }}</div>
                        <div class="semester-meta">
                            @if($semester->tanggal_mulai)
                            📅 {{ \Carbon\Carbon::parse($semester->tanggal_mulai)->format('d M Y') }}
                            @if($semester->tanggal_selesai)
                            → {{ \Carbon\Carbon::parse($semester->tanggal_selesai)->format('d M Y') }}
                            @endif
                            @endif
                        </div>
                    </div>
                    <div style="display:flex; flex-direction:column; align-items:flex-end; gap:6px;">
                        <span class="{{ $semester->is_aktif ? 'badge-aktif' : 'badge-nonaktif' }}">
                            {{ $semester->is_aktif ? '✅ Aktif' : 'Non-aktif' }}
                        </span>
                        <span class="proj-count">📁 {{ $semester->projects_count }} proyek</span>
                    </div>
                </div>
                <div class="semester-actions">
                    <a href="{{ route('admin.semester.show', $semester->id) }}" class="btn-lihat">👁 Lihat Proyek</a>
                    @if(!$semester->is_aktif)
                    <form action="{{ route('admin.semester.aktif', $semester->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-aktifkan">✅ Jadikan Aktif</button>
                    </form>
                    @endif
                    <form action="{{ route('admin.semester.destroy', $semester->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-hapus" onclick="return confirm('Yakin hapus semester ini?')">🗑 Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <p style="text-align:center; color:#b0bec5; padding:30px;">Belum ada semester.</p>
            @endforelse
        </div>
    </div>
</div>

</body>
</html>