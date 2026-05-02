@extends('admin.layout')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Admin')
@section('page_sub', 'Ringkasan data sistem PBL')

@section('content')
<style>
    .stat-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px; }
    .stat-card { background: white; border-radius: 14px; padding: 22px; display: flex; justify-content: space-between; align-items: flex-start; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .stat-card .label { font-size: 0.85rem; color: #6b7a8d; margin-bottom: 10px; }
    .stat-card .value { font-size: 2rem; font-weight: 700; color: #0f1624; }
    .stat-card .stat-icon { width: 42px; height: 42px; background: #f0f2f5; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .mini-cards { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; margin-bottom: 28px; }
    .mini-card { background: white; border-radius: 14px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-align: center; }
    .mini-card .num { font-size: 2.2rem; font-weight: 800; color: #0f1624; }
    .mini-card .lbl { font-size: 0.85rem; color: #6b7a8d; margin-top: 4px; }
    .mini-card .icon { font-size: 1.4rem; margin-bottom: 8px; }
    .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
    .section-title { font-size: 1rem; font-weight: 700; color: #0f1624; }
    .btn-add { padding: 9px 18px; background: #0f1624; color: white; border-radius: 10px; font-size: 0.85rem; font-weight: 600; text-decoration: none; }
    .proj-table { background: white; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f8f9fb; padding: 13px 16px; text-align: left; font-size: 0.8rem; font-weight: 700; color: #6b7a8d; border-bottom: 1.5px solid #f0f2f5; }
    td { padding: 13px 16px; font-size: 0.86rem; color: #0f1624; border-bottom: 1px solid #f5f6fa; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f8f9fb; }
    .badge { padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .badge-aktif { background: #e8f5e9; color: #2e7d32; }
    .badge-selesai { background: #e3f2fd; color: #1565c0; }
    .progress-wrap { background: #f0f2f5; border-radius: 20px; height: 6px; min-width: 80px; }
    .progress-fill { background: #0f1624; border-radius: 20px; height: 6px; }
    .btn-del { padding: 5px 10px; background: #fce4ec; color: #c62828; border: none; border-radius: 7px; font-size: 0.75rem; font-weight: 600; cursor: pointer; }
    .btn-edit-sm { padding: 5px 10px; background: #fff3e0; color: #e65100; border-radius: 7px; font-size: 0.75rem; font-weight: 600; text-decoration: none; margin-right: 4px; }
    .btn-detail-sm { padding: 5px 10px; background: #f0f2f5; color: #0f1624; border-radius: 7px; font-size: 0.75rem; font-weight: 600; text-decoration: none; margin-right: 4px; }
</style>

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

<div class="mini-cards">
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

<div class="section-header">
    <div class="section-title">📁 Semua Project</div>
    <a href="{{ route('projects.create') }}" class="btn-add">+ Buat Project</a>
</div>
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
                <td><span class="badge badge-{{ $project->status == 'aktif' ? 'aktif' : 'selesai' }}">{{ ucfirst($project->status) }}</span></td>
                <td>
                    <a href="{{ route('projects.show', $project->id) }}" class="btn-detail-sm">Detail</a>
                    <a href="{{ route('projects.edit', $project->id) }}" class="btn-edit-sm">Edit</a>
                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-del" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; color:#b0bec5; padding:30px;">Belum ada project</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection