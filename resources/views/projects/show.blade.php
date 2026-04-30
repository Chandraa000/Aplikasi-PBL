<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->nama_project }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f6fa; color: #0f1624; }

        .topbar {
            background: #0f1624; color: white;
            padding: 16px 32px;
        }
        .topbar a {
            color: white; text-decoration: none; font-size: 0.9rem;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .topbar a:hover { opacity: 0.8; }

        .content { max-width: 720px; margin: 36px auto; padding: 0 20px 60px; }

        .alert-success { background: #e8f5e9; color: #2e7d32; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }
        .alert-error { background: #fce4ec; color: #c62828; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }

        /* Header */
        .badges { display: flex; gap: 8px; margin-bottom: 12px; }
        .badge { padding: 4px 14px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .badge-gray { background: #f0f2f5; color: #6b7a8d; }
        .badge-menengah { background: #fff3e0; color: #e65100; }
        .badge-mudah { background: #e8f5e9; color: #2e7d32; }
        .badge-sulit { background: #0f1624; color: white; }
        .badge-aktif { background: #e8f5e9; color: #2e7d32; }
        .badge-selesai { background: #e3f2fd; color: #1565c0; }

        h1 { font-size: 1.9rem; font-weight: 800; margin-bottom: 10px; line-height: 1.3; }
        .subtitle { font-size: 0.9rem; color: #6b7a8d; margin-bottom: 28px; line-height: 1.6; }

        /* Card */
        .card {
            background: white; border-radius: 14px;
            border: 1.5px solid #ebebeb; padding: 22px;
            margin-bottom: 18px;
        }

        /* Estimasi */
        .estimasi-row { display: flex; align-items: center; gap: 14px; }
        .estimasi-icon {
            width: 38px; height: 38px; background: #f0f2f5;
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            font-size: 1rem; flex-shrink: 0;
        }
        .estimasi-label { font-size: 0.8rem; color: #6b7a8d; margin-bottom: 2px; }
        .estimasi-value { font-size: 1rem; font-weight: 700; }

        /* Two col */
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px; }

        .card-label {
            font-size: 0.8rem; color: #6b7a8d; font-weight: 600;
            margin-bottom: 14px; display: flex; align-items: center; gap: 6px;
        }

        /* Tech tags */
        .tag-list { display: flex; flex-wrap: wrap; gap: 8px; }
        .tag {
            background: #f0f2f5; color: #0f1624;
            padding: 5px 12px; border-radius: 8px;
            font-size: 0.82rem; font-weight: 500;
            transition: all 0.15s;
        }
        .tag:hover { background: #0f1624; color: white; }

        /* Info rows */
        .info-row {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px; border: 1.5px solid #f0f2f5;
            border-radius: 10px; margin-bottom: 8px;
            transition: border-color 0.2s; cursor: default;
        }
        .info-row:hover { border-color: #c0c0c0; }
        .info-row:last-child { margin-bottom: 0; }
        .info-icon {
            width: 30px; height: 30px; background: #f0f2f5;
            border-radius: 8px; display: flex; align-items: center;
            justify-content: center; font-size: 0.85rem; flex-shrink: 0;
        }
        .info-lbl { font-size: 0.75rem; color: #6b7a8d; }
        .info-val { font-size: 0.88rem; font-weight: 600; }

        /* Learning outcomes */
        .outcomes-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .outcome-item {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 14px; border: 1.5px solid #f0f2f5; border-radius: 10px;
            transition: border-color 0.2s;
        }
        .outcome-item:hover { border-color: #0f1624; }
        .outcome-num {
            width: 26px; height: 26px; min-width: 26px;
            background: #0f1624; color: white;
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-size: 0.75rem; font-weight: 700;
        }
        .outcome-text { font-size: 0.84rem; font-weight: 500; }

        /* Deskripsi detail */
        .desc-text { font-size: 0.88rem; color: #6b7a8d; line-height: 1.7; }

        /* Anggota */
        .anggota-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 14px; border: 1.5px solid #f0f2f5;
            border-radius: 10px; margin-bottom: 8px;
        }
        .anggota-left { display: flex; align-items: center; gap: 10px; }
        .avatar {
            width: 34px; height: 34px; background: #0f1624; color: white;
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-size: 0.82rem; font-weight: 700;
        }
        .anggota-name { font-size: 0.88rem; font-weight: 600; }
        .anggota-email { font-size: 0.78rem; color: #6b7a8d; }
        .btn-hapus {
            padding: 5px 12px; background: #fce4ec; color: #c62828;
            border: none; border-radius: 8px; font-size: 0.78rem;
            font-weight: 600; cursor: pointer;
        }
        .form-add-row { display: flex; gap: 10px; margin-bottom: 14px; }
        .form-add-row select {
            flex: 1; padding: 10px 14px; border: 1.5px solid #e0e0e0;
            border-radius: 10px; font-size: 0.9rem; outline: none; background: white;
        }
        .btn-add-sm {
            padding: 10px 18px; background: #0f1624; color: white;
            border: none; border-radius: 10px; font-size: 0.88rem;
            font-weight: 600; cursor: pointer; white-space: nowrap;
        }

        /* Kelompok */
        .group-item {
            border: 1.5px solid #ebebeb; border-radius: 12px;
            padding: 16px 18px; margin-bottom: 10px;
            transition: border-color 0.2s;
        }
        .group-item:hover { border-color: #0f1624; }
        .group-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .group-name { font-size: 0.95rem; font-weight: 700; }
        .group-btns { display: flex; gap: 8px; }
        .btn-kanban {
            padding: 6px 14px; background: #f0f2f5; color: #0f1624;
            border-radius: 8px; font-size: 0.8rem; font-weight: 600;
            text-decoration: none; transition: all 0.15s;
        }
        .btn-kanban:hover { background: #0f1624; color: white; }
        .btn-del {
            padding: 6px 12px; background: #fce4ec; color: #c62828;
            border: none; border-radius: 8px; font-size: 0.8rem;
            font-weight: 600; cursor: pointer;
        }
        .progress-wrap { background: #f0f2f5; border-radius: 20px; height: 6px; margin: 8px 0 4px; }
        .progress-bar { background: #0f1624; border-radius: 20px; height: 6px; transition: width 0.3s; }
        .progress-info { font-size: 0.78rem; color: #6b7a8d; }
        .form-add-group { display: flex; gap: 10px; margin-bottom: 14px; }
        .form-add-group input {
            flex: 1; padding: 10px 14px; border: 1.5px solid #e0e0e0;
            border-radius: 10px; font-size: 0.9rem; outline: none;
        }

        /* Bottom */
        .bottom-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 28px; }
        .btn-back {
            padding: 14px; background: white; border: 1.5px solid #e0e0e0;
            border-radius: 12px; font-size: 0.95rem; font-weight: 600;
            color: #0f1624; text-align: center; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-back:hover { background: #f5f6fa; }
        .btn-primary {
            padding: 14px; background: #0f1624; border: none;
            border-radius: 12px; font-size: 0.95rem; font-weight: 600;
            color: white; text-align: center; text-decoration: none;
            display: block; transition: background 0.2s;
        }
        .btn-primary:hover { background: #1a2a3a; color: white; }
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
    <div class="badges">
        <span class="badge badge-gray">Project</span>
        <span class="badge badge-{{ $project->status == 'aktif' ? 'aktif' : 'selesai' }}">
            {{ ucfirst($project->status) }}
        </span>
    </div>
    <h1>{{ $project->nama_project }}</h1>
    <p class="subtitle">{{ $project->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

    {{-- Estimasi / Dospem --}}
    <div class="card">
        <div class="estimasi-row">
            <div class="estimasi-icon">🕐</div>
            <div>
                <div class="estimasi-label">Dosen Pembimbing</div>
                <div class="estimasi-value">{{ $project->dospem->name ?? '-' }}</div>
            </div>
        </div>
    </div>

    {{-- Anggota + Info Cepat --}}
<div class="two-col">
    <div class="card">
        @php $semuaAnggota = $project->anggota ?? collect([]); @endphp
        <div class="card-label">‹› Anggota Terdaftar ({{ $semuaAnggota->count() }} orang)</div>
        @forelse($semuaAnggota as $anggota)
        <div style="display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #f5f5f5;">
            <div style="width:36px; height:36px; min-width:36px; background:#0f1624; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.82rem; font-weight:700;">
                {{ strtoupper(substr($anggota->nama,0,1)) }}
            </div>
            <div style="flex:1; min-width:0;">
                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <span style="font-size:0.88rem; font-weight:600; color:#0f1624;">{{ $anggota->nama }}</span>
                    @if($anggota->is_ketua)
                    <span style="background:#0f1624; color:white; padding:2px 8px; border-radius:20px; font-size:0.7rem; font-weight:600; white-space:nowrap;">Ketua</span>
                    @endif
                </div>
                <div style="font-size:0.78rem; color:#6b7a8d; margin-top:2px;">
                    NIM: {{ $anggota->nim }} &nbsp;·&nbsp; Semester {{ $anggota->semester }}
                </div>
            </div>
        </div>
        @empty
        <p style="color:#b0bec5; font-size:0.85rem; text-align:center; padding:20px 0;">Belum ada anggota</p>
        @endforelse
    </div>
    <div class="card">
        <div class="card-label">⚡ Info Cepat</div>
        <div class="info-row">
            <div class="info-icon">👥</div>
            <div>
                <div class="info-lbl">Total Anggota</div>
                <div class="info-val">{{ $semuaAnggota->count() }} orang</div>
            </div>
        </div>
        <div class="info-row">
            <div class="info-icon">✅</div>
            <div>
                <div class="info-lbl">Status Proyek</div>
                <div class="info-val">{{ ucfirst($project->status) }}</div>
            </div>
        </div>
    </div>
</div>
    {{-- Learning Outcomes / Kelompok --}}
    <div class="card">
        <div class="card-label">📋 Daftar Kelompok</div>

        @if(auth()->user()->isDospem())
        <form action="{{ route('projects.groups.store', $project->id) }}" method="POST" class="form-add-group">
            @csrf
            <input type="text" name="nama_group" placeholder="Nama kelompok baru...">
            <button type="submit" class="btn-add-sm">+ Tambah</button>
        </form>
        @endif

        @forelse($project->groups as $group)
        @php
            $total = $group->tasks->count();
            $done = $group->tasks->where('status','done')->count();
            $persen = $total > 0 ? round(($done/$total)*100) : 0;
        @endphp
        <div class="group-item">
            <div class="group-row">
                <div class="group-name">{{ $group->nama_group }}</div>
                <div class="group-btns">
                    <a href="{{ route('projects.groups.show', [$project->id, $group->id]) }}" class="btn-kanban">Buka Kanban</a>
                    @if(auth()->user()->isDospem())
                    <form action="{{ route('projects.groups.destroy', [$project->id, $group->id]) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-del" onclick="return confirm('Hapus kelompok?')">Hapus</button>
                    </form>
                    @endif
                </div>
            </div>
            <div style="font-size:0.8rem; color:#6b7a8d;">👥 {{ $group->members->count() }} anggota · ✅ {{ $done }}/{{ $total }} tugas selesai</div>
            <div class="progress-wrap"><div class="progress-bar" style="width:{{ $persen }}%"></div></div>
            <div class="progress-info">Progress: {{ $persen }}%</div>
        </div>
        @empty
        <p style="text-align:center; color:#b0bec5; padding:16px;">Belum ada kelompok.</p>
        @endforelse
    </div>

    {{-- Deskripsi Detail --}}
    <div class="card">
        <div class="card-label">📝 Deskripsi Detail</div>
        <p class="desc-text">{{ $project->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
    </div>

    {{-- Kelola Anggota (Dospem only) --}}
    @if(auth()->user()->isDospem())
    <div class="card">
        <div class="card-label">👥 Kelola Anggota</div>
        @php
            $anggotaIds = $project->members->pluck('id');
            $mahasiswaList = App\Models\User::where('role','mahasiswa')->whereNotIn('id', $anggotaIds)->get();
        @endphp
        @if($mahasiswaList->count() > 0)
        <form action="{{ route('projects.join', $project->id) }}" method="POST" class="form-add-row">
            @csrf
            <input type="hidden" name="dari_dospem" value="1">
            <select name="user_id">
                <option value="">-- Pilih Mahasiswa --</option>
                @foreach($mahasiswaList as $mhs)
                <option value="{{ $mhs->id }}">{{ $mhs->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-add-sm">Tambah</button>
        </form>
        @endif
        @forelse($project->members as $member)
        <div class="anggota-item">
            <div class="anggota-left">
                <div class="avatar">{{ strtoupper(substr($member->name,0,1)) }}</div>
                <div>
                    <div class="anggota-name">{{ $member->name }}</div>
                    <div class="anggota-email">{{ $member->email }}</div>
                </div>
            </div>
            <form action="{{ route('projects.removeMember', [$project->id, $member->id]) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-hapus" onclick="return confirm('Hapus anggota?')">Hapus</button>
            </form>
        </div>
        @empty
        <p style="text-align:center; color:#b0bec5;">Belum ada anggota.</p>
        @endforelse
    </div>
    @endif

    {{-- Bottom Actions --}}
    <div class="bottom-actions">
        <a href="{{ route('dashboard') }}" class="btn-back">Kembali</a>
        @if(auth()->user()->isMahasiswa())
        <a href="{{ route('projects.joinForm', $project->id) }}" class="btn-primary">Pilih Proyek Ini</a>
        @else
        <a href="{{ route('projects.edit', $project->id) }}" class="btn-primary">Edit Proyek</a>
        @endif
    </div>

</div>
</body>
</html>