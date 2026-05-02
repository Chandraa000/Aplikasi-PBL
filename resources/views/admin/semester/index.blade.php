@extends('admin.layout')

@section('title', 'Kelola Semester')
@section('page_title', 'Kelola Semester')
@section('page_sub', 'Atur semester aktif dan lihat proyek per semester')

@section('content')
<style>
    .two-col { display: grid; grid-template-columns: 340px 1fr; gap: 24px; }
    .card { background: white; border-radius: 14px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .card h3 { font-size: 1rem; font-weight: 700; color: #0f1624; margin-bottom: 20px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #0f1624; margin-bottom: 6px; }
    .form-group input, .form-group select { width: 100%; padding: 10px 14px; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 0.9rem; outline: none; background: white; }
    .form-group input:focus, .form-group select:focus { border-color: #0f1624; }
    .btn-submit { width: 100%; padding: 12px; background: #0f1624; color: white; border: none; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; }
    .btn-submit:hover { background: #1a2a3a; }
    .semester-card { border: 1.5px solid #e8e8e8; border-radius: 14px; padding: 20px; margin-bottom: 14px; transition: all 0.2s; }
    .semester-card:hover { border-color: #0f1624; box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
    .semester-card.aktif { border-color: #2e7d32; background: #f1f8e9; }
    .semester-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
    .semester-name { font-size: 1rem; font-weight: 700; color: #0f1624; margin-bottom: 4px; }
    .semester-meta { font-size: 0.82rem; color: #6b7a8d; }
    .badge-aktif { background: #2e7d32; color: white; padding: 3px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .badge-nonaktif { background: #f0f2f5; color: #6b7a8d; padding: 3px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .proj-count { background: #f0f2f5; color: #0f1624; padding: 3px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
    .semester-actions { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; }
    .btn-lihat { padding: 7px 14px; background: #f0f2f5; color: #0f1624; border-radius: 8px; font-size: 0.82rem; font-weight: 600; text-decoration: none; transition: all 0.15s; }
    .btn-lihat:hover { background: #0f1624; color: white; }
    .btn-aktifkan { padding: 7px 14px; background: #e8f5e9; color: #2e7d32; border: none; border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer; }
    .btn-hapus { padding: 7px 14px; background: #fce4ec; color: #c62828; border: none; border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer; }
    .empty-state { text-align: center; padding: 40px; color: #b0bec5; }
</style>

<div class="two-col">
    {{-- Form Tambah --}}
    <div>
        <div class="card">
            <h3>➕ Tambah Semester</h3>
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
                            @else
                            Tanggal belum diatur
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
            <div class="empty-state">
                <p style="font-size:1rem; font-weight:600; margin-bottom:6px;">Belum ada semester</p>
                <p>Tambahkan semester menggunakan form di sebelah kiri</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection