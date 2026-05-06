@extends('admin.layout')

@section('title', $semester->nama)
@section('page_title', $semester->nama)
@section('page_sub', 'Daftar proyek di semester ini')

@section('content')
<style>
    .back-btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: #f0f2f5; color: #0f1624; border-radius: 10px; text-decoration: none; font-size: 0.88rem; font-weight: 600; transition: all 0.2s; }
    .back-btn:hover { background: #0f1624; color: white; }
    .btn-tambah { padding: 10px 20px; background: #0f1624; color: white; border: none; border-radius: 10px; font-size: 0.88rem; font-weight: 600; cursor: pointer; transition: background 0.2s; }
    .btn-tambah:hover { background: #1e2d40; }
    .header-card { background: white; border-radius: 14px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between; }
    .header-info h2 { font-size: 1.3rem; font-weight: 700; color: #0f1624; margin-bottom: 6px; }
    .header-info p { font-size: 0.85rem; color: #6b7a8d; }
    .badge-aktif { background: #2e7d32; color: white; padding: 4px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 600; }
    .badge-nonaktif { background: #f0f2f5; color: #6b7a8d; padding: 4px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 600; }
    .stat-cards { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; margin-bottom: 28px; }
    .stat-card { background: white; border-radius: 14px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: flex-start; }
    .stat-card .label { font-size: 0.85rem; color: #6b7a8d; margin-bottom: 8px; }
    .stat-card .value { font-size: 1.8rem; font-weight: 700; color: #0f1624; }
    .stat-card .icon { font-size: 1.3rem; }
    .proj-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
    .proj-card { background: white; border-radius: 14px; border: 1.5px solid #e8e8e8; padding: 22px; transition: all 0.2s; display: flex; flex-direction: column; }
    .proj-card:hover { border-color: #0f1624; box-shadow: 0 4px 16px rgba(0,0,0,0.08); transform: translateY(-2px); }
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
    .btn-detail { display: block; padding: 10px; background: #f0f2f5; color: #0f1624; text-align: center; border-radius: 10px; font-size: 0.88rem; font-weight: 600; text-decoration: none; margin-top: auto; }
    .btn-detail:hover { background: #0f1624; color: white; }
    .empty-state { text-align: center; padding: 60px; color: #b0bec5; background: white; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }

    /* Modal */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; align-items: center; justify-content: center; }
    .modal-overlay.show { display: flex; }
    .modal-box { background: white; border-radius: 20px; padding: 32px; width: 100%; max-width: 520px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
    .modal-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 24px; color: #0f1624; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 0.82rem; font-weight: 600; color: #6b7a8d; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 11px 14px; border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 0.9rem; outline: none; font-family: 'Segoe UI', sans-serif; background: white; transition: border-color 0.2s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #0f1624; }
    .modal-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 24px; }
    .btn-cancel { padding: 12px; background: #f5f6fa; border: none; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; color: #6b7a8d; }
    .btn-save { padding: 12px; background: #0f1624; border: none; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; color: white; }
    .btn-save:hover { background: #1e2d40; }
</style>

{{-- Top Actions --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <a href="{{ route('admin.semester.index') }}" class="back-btn">← Kembali ke Semester</a>
    @if($semester->is_aktif)
    <button class="btn-tambah" id="btnTambahProject">+ Tambah Project</button>
    @endif
</div>

{{-- Header --}}
<div class="header-card">
    <div class="header-info">
        <h2>{{ $semester->nama }}</h2>
        <p>
            @if($semester->tanggal_mulai)
            📅 {{ \Carbon\Carbon::parse($semester->tanggal_mulai)->format('d M Y') }}
            @if($semester->tanggal_selesai)
            → {{ \Carbon\Carbon::parse($semester->tanggal_selesai)->format('d M Y') }}
            @endif
            @else
            Tanggal belum diatur
            @endif
        </p>
    </div>
    <span class="{{ $semester->is_aktif ? 'badge-aktif' : 'badge-nonaktif' }}">
        {{ $semester->is_aktif ? '✅ Semester Aktif' : 'Non-aktif' }}
    </span>
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

{{-- Daftar Project --}}
@if($semester->projects->count() > 0)
<div class="proj-grid">
    @foreach($semester->projects as $project)
    @php
        $totalT = $project->groups->sum(fn($g) => $g->tasks->count());
        $doneT = $project->groups->sum(fn($g) => $g->tasks->where('status','done')->count());
        $persen = $totalT > 0 ? round(($doneT/$totalT)*100) : 0;
    @endphp
    <div class="proj-card">
        <div>
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
        </div>
        <div style="display:flex; gap:8px; margin-top:auto;">
            <a href="{{ route('projects.show', $project->id) }}" class="btn-detail" style="flex:1;">Lihat Detail</a>
            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit"
                    style="padding:10px 14px; background:#fce4ec; color:#c62828; border:none; border-radius:10px; font-size:0.82rem; font-weight:600; cursor:pointer;"
                    onclick="return confirm('Hapus project ini?')">🗑</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <p style="font-size:1.1rem; font-weight:600; margin-bottom:8px;">Belum ada proyek di semester ini</p>
    <p>Klik tombol <strong>"+ Tambah Project"</strong> untuk menambahkan proyek</p>
</div>
@endif

{{-- Modal Tambah Project --}}
<div class="modal-overlay" id="modalTambahProject">
    <div class="modal-box">
        <div class="modal-title">➕ Tambah Project ke {{ $semester->nama }}</div>
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <input type="hidden" name="semester_id" value="{{ $semester->id }}">
            <div class="form-group">
                <label>Nama Project *</label>
                <input type="text" name="nama_project" placeholder="Masukkan nama project" required>
            </div>
            <div class="form-group">
                <label>Dosen Pembimbing *</label>
                <select name="dospem_id" required>
                    <option value="">-- Pilih Dosen Pembimbing --</option>
                    @foreach($dospems as $dospem)
                    <option value="{{ $dospem->id }}">{{ $dospem->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3" placeholder="Deskripsi project..."></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="btnBatalProject">Batal</button>
                <button type="submit" class="btn-save">✓ Simpan Project</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('btnTambahProject').addEventListener('click', function() {
        document.getElementById('modalTambahProject').classList.add('show');
    });
    document.getElementById('btnBatalProject').addEventListener('click', function() {
        document.getElementById('modalTambahProject').classList.remove('show');
    });
    document.getElementById('modalTambahProject').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('show');
    });
</script>
@endsection