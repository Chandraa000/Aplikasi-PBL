<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* Semester badge */
        .semester-info { background: #e8f5e9; border-radius: 12px; padding: 12px 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; }
        .semester-info span { font-size: 0.88rem; font-weight: 600; color: #2e7d32; }

        /* Project Header */
        .project-header { background: white; border-radius: 16px; padding: 28px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; justify-content: space-between; align-items: flex-start; }
        .proj-title { font-size: 1.6rem; font-weight: 800; color: #0f1624; margin-bottom: 6px; }
        .proj-desc { font-size: 0.9rem; color: #6b7a8d; margin-bottom: 14px; }
        .proj-meta-row { display: flex; align-items: center; gap: 20px; flex-wrap: wrap; }
        .proj-meta-item { display: flex; align-items: center; gap: 6px; font-size: 0.85rem; color: #6b7a8d; }
        .badge-aktif { background: #e8f5e9; color: #2e7d32; padding: 4px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 600; }

        /* Stats */
        .stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: white; border-radius: 14px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center; }
        .stat-card .num { font-size: 2rem; font-weight: 800; color: #0f1624; }
        .stat-card .lbl { font-size: 0.82rem; color: #6b7a8d; margin-top: 4px; }
        .stat-card .icon { font-size: 1.3rem; margin-bottom: 8px; }

        /* Main Grid */
        .main-grid { display: grid; grid-template-columns: 280px 1fr; gap: 24px; }

        /* Anggota Sidebar */
        .sidebar-card { background: white; border-radius: 14px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 16px; }
        .card-title { font-size: 0.88rem; font-weight: 700; color: #0f1624; margin-bottom: 16px; display: flex; align-items: center; gap: 6px; }
        .anggota-item { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f5f5f5; }
        .anggota-item:last-child { border-bottom: none; }
        .avatar { width: 34px; height: 34px; background: #0f1624; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 700; flex-shrink: 0; }
        .anggota-name { font-size: 0.85rem; font-weight: 600; color: #0f1624; }
        .anggota-nim { font-size: 0.75rem; color: #6b7a8d; }
        .badge-ketua { background: #0f1624; color: white; padding: 2px 8px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; margin-left: 4px; }

        /* Progress */
        .progress-wrap { background: #f0f2f5; border-radius: 20px; height: 8px; margin: 8px 0 4px; }
        .progress-fill { background: #0f1624; border-radius: 20px; height: 8px; transition: width 0.5s; }
        .progress-pct { font-size: 0.8rem; color: #6b7a8d; }

        /* Kanban */
        .kanban-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .kanban-header h2 { font-size: 1.05rem; font-weight: 700; color: #0f1624; }
        .kanban-cols { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
        .kanban-col { background: white; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); min-height: 300px; }
        .col-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 2px solid #f0f2f5; }
        .col-title { font-size: 0.88rem; font-weight: 700; display: flex; align-items: center; gap: 6px; }
        .col-dot { width: 8px; height: 8px; border-radius: 50%; }
        .dot-todo { background: #9e9e9e; }
        .dot-progress { background: #ff9800; }
        .dot-done { background: #4caf50; }
        .col-count { background: #f0f2f5; color: #6b7a8d; padding: 2px 8px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .task-card { background: #f8f9fb; border-radius: 10px; padding: 12px; margin-bottom: 8px; border: 1.5px solid #ebebeb; }
        .task-title { font-size: 0.88rem; font-weight: 700; margin-bottom: 6px; color: #0f1624; }
        .task-desc { font-size: 0.78rem; color: #6b7a8d; margin-bottom: 8px; }
        .task-meta { display: flex; justify-content: space-between; align-items: center; }
        .badge-tinggi { background: #fce4ec; color: #c62828; padding: 2px 8px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; }
        .badge-sedang { background: #fff3e0; color: #e65100; padding: 2px 8px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; }
        .badge-rendah { background: #e8f5e9; color: #2e7d32; padding: 2px 8px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; }
        .task-assign { font-size: 0.75rem; color: #6b7a8d; }
        .empty-col { text-align: center; color: #c0c8d0; font-size: 0.82rem; padding: 24px 0; }
        .alert-success { background: #e8f5e9; color: #2e7d32; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }
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

    @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Semester Info --}}
    @if($semesterAktif)
    <div class="semester-info">
        <span>📅 {{ $semesterAktif->nama }}</span>
    </div>
    @endif

    {{-- Project Header --}}
    <div class="project-header">
        <div style="flex:1;">
            <div class="proj-title">{{ $myProject->nama_project }}</div>
            <div class="proj-desc">{{ $myProject->deskripsi ?? 'Tidak ada deskripsi.' }}</div>
            <div class="proj-meta-row">
                <div class="proj-meta-item">👨‍🏫 <span>{{ $myProject->dospem->name ?? '-' }}</span></div>
                <div class="proj-meta-item">👥 <span>{{ $myProject->anggota->count() }} anggota</span></div>
                @if($myGroup)
                <div class="proj-meta-item">📁 <span>{{ $myGroup->nama_group }}</span></div>
                @endif
            </div>
        </div>
        <span class="badge-aktif">{{ ucfirst($myProject->status) }}</span>
    </div>

    {{-- Stats --}}
    @if($myGroup)
    @php
        $totalT = $myGroup->tasks->count();
        $doneT = $myGroup->tasks->where('status','done')->count();
        $progressT = $myGroup->tasks->where('status','on_progress')->count();
        $todoT = $myGroup->tasks->where('status','todo')->count();
        $persen = $totalT > 0 ? round(($doneT/$totalT)*100) : 0;
    @endphp
    <div class="stat-row">
        <div class="stat-card">
            <div class="icon">📋</div>
            <div class="num">{{ $todoT }}</div>
            <div class="lbl">To Do</div>
        </div>
        <div class="stat-card">
            <div class="icon">⚡</div>
            <div class="num">{{ $progressT }}</div>
            <div class="lbl">In Progress</div>
        </div>
        <div class="stat-card">
            <div class="icon">✅</div>
            <div class="num">{{ $doneT }}</div>
            <div class="lbl">Done</div>
        </div>
    </div>
    @endif

    <div class="main-grid">

        {{-- Sidebar --}}
        <div>
            {{-- Progress --}}
            @if($myGroup)
            <div class="sidebar-card">
                <div class="card-title">📊 Progress Kelompok</div>
                <div style="font-size:0.85rem; color:#6b7a8d; margin-bottom:6px;">
                    {{ $doneT }} dari {{ $totalT }} tugas selesai
                </div>
                <div class="progress-wrap">
                    <div class="progress-fill" style="width:{{ $persen }}%"></div>
                </div>
                <div class="progress-pct">{{ $persen }}% selesai</div>
            </div>
            @endif

            {{-- Anggota --}}
            <div class="sidebar-card">
                <div class="card-title">👥 Anggota Kelompok</div>
                @if($myGroup && $myGroup->anggota->count() > 0)
                @foreach($myGroup->anggota as $anggota)
                <div class="anggota-item">
                    <div class="avatar">{{ strtoupper(substr($anggota->nama,0,1)) }}</div>
                    <div>
                        <div class="anggota-name">
                            {{ $anggota->nama }}
                            @if($anggota->is_ketua)
                            <span class="badge-ketua">Ketua</span>
                            @endif
                        </div>
                        <div class="anggota-nim">NIM: {{ $anggota->nim }} · Sem {{ $anggota->semester }}</div>
                    </div>
                </div>
                @endforeach
                @else
                <p style="color:#b0bec5; font-size:0.85rem; text-align:center; padding:16px 0;">Belum ada anggota</p>
                @endif
            </div>
        </div>

        {{-- Kanban Board --}}
        <div>
            <div class="kanban-header">
                <h2>🗂 Kanban Board - {{ $myGroup->nama_group ?? '-' }}</h2>
            </div>

            @if($myGroup)
            <div class="kanban-cols">
                @foreach(['todo' => ['label'=>'To Do','dot'=>'dot-todo'], 'on_progress' => ['label'=>'In Progress','dot'=>'dot-progress'], 'done' => ['label'=>'Done','dot'=>'dot-done']] as $status => $cfg)
                <div class="kanban-col">
                    <div class="col-header">
                        <div class="col-title">
                            <span class="col-dot {{ $cfg['dot'] }}"></span>
                            {{ $cfg['label'] }}
                        </div>
                        <span class="col-count">{{ $myGroup->tasks->where('status',$status)->count() }}</span>
                    </div>
                    @forelse($myGroup->tasks->where('status',$status) as $task)
                    <div class="task-card">
                        <div class="task-title">{{ $task->judul }}</div>
                        @if($task->deskripsi)
                        <div class="task-desc">{{ Str::limit($task->deskripsi, 70) }}</div>
                        @endif
                        <div class="task-meta">
                            <span class="badge-{{ $task->prioritas }}">{{ ucfirst($task->prioritas) }}</span>
                            <span class="task-assign">👤 {{ $task->assignedTo->name ?? '-' }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="empty-col">Tidak ada tugas</div>
                    @endforelse
                </div>
                @endforeach
            </div>
            @else
            <div style="background:white; border-radius:14px; padding:40px; text-align:center; color:#b0bec5; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                <p style="font-size:1rem; font-weight:600; margin-bottom:6px;">Belum masuk kelompok</p>
                <p>Tunggu dosen pembimbing menambahkan ke kelompok</p>
            </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>