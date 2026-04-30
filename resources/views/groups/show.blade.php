<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $group->nama_group }} - Kanban</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f6fa; }
        .topbar { background: #0f1624; color: white; padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; }
        .topbar a { color: white; text-decoration: none; font-size: 0.9rem; }
        .topbar a:hover { opacity: 0.8; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .group-title { font-size: 1rem; font-weight: 700; }
        .group-sub { font-size: 0.8rem; color: #8a9bb0; }
        .content { padding: 28px 32px; }
        .progress-section { background: white; border-radius: 14px; padding: 20px 24px; margin-bottom: 24px; display: flex; align-items: center; gap: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .progress-info { flex: 1; }
        .progress-info h3 { font-size: 1rem; font-weight: 700; margin-bottom: 4px; }
        .progress-info p { font-size: 0.82rem; color: #6b7a8d; }
        .progress-wrap { flex: 2; }
        .progress-bar-bg { background: #f0f2f5; border-radius: 20px; height: 10px; margin-bottom: 6px; }
        .progress-bar-fill { background: #0f1624; border-radius: 20px; height: 10px; transition: width 0.5s; }
        .progress-pct { font-size: 0.82rem; color: #6b7a8d; text-align: right; }
        .stat-pills { display: flex; gap: 10px; }
        .stat-pill { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .pill-todo { background: #f0f2f5; color: #6b7a8d; }
        .pill-progress { background: #fff3e0; color: #e65100; }
        .pill-done { background: #e8f5e9; color: #2e7d32; }
        .main-layout { display: grid; grid-template-columns: 260px 1fr; gap: 24px; }
        .sidebar-card { background: white; border-radius: 14px; padding: 20px; margin-bottom: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .sidebar-title { font-size: 0.85rem; font-weight: 700; color: #0f1624; margin-bottom: 14px; display: flex; align-items: center; gap: 6px; }
        .member-item { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f5f5f5; }
        .member-item:last-child { border-bottom: none; }
        .avatar { width: 32px; height: 32px; background: #0f1624; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.78rem; font-weight: 700; flex-shrink: 0; }
        .member-name { font-size: 0.85rem; font-weight: 600; }
        .member-tasks { font-size: 0.75rem; color: #6b7a8d; }
        .form-add-member { margin-top: 12px; }
        .form-add-member select { width: 100%; padding: 8px 12px; border: 1.5px solid #e0e0e0; border-radius: 8px; font-size: 0.85rem; outline: none; margin-bottom: 8px; background: white; }
        .btn-add-member { width: 100%; padding: 9px; background: #0f1624; color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; }
        .btn-remove { margin-left: auto; padding: 3px 8px; background: #fce4ec; color: #c62828; border: none; border-radius: 6px; font-size: 0.72rem; font-weight: 600; cursor: pointer; flex-shrink: 0; }
        .kanban-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .kanban-header h2 { font-size: 1.1rem; font-weight: 700; }
        .btn-tambah-tugas { padding: 9px 18px; background: #0f1624; color: white; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 600; cursor: pointer; }
        .kanban-cols { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .kanban-col { background: white; border-radius: 14px; padding: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); min-height: 400px; }
        .col-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 2px solid #f0f2f5; }
        .col-title { font-size: 0.9rem; font-weight: 700; display: flex; align-items: center; gap: 8px; }
        .col-dot { width: 8px; height: 8px; border-radius: 50%; }
        .dot-todo { background: #9e9e9e; }
        .dot-progress { background: #ff9800; }
        .dot-done { background: #4caf50; }
        .col-count { background: #f0f2f5; color: #6b7a8d; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; }
        .task-card { background: #f8f9fb; border-radius: 10px; padding: 14px; margin-bottom: 10px; border: 1.5px solid #ebebeb; transition: all 0.2s; }
        .task-card:hover { border-color: #0f1624; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .task-title { font-size: 0.9rem; font-weight: 700; margin-bottom: 6px; }
        .task-desc { font-size: 0.8rem; color: #6b7a8d; margin-bottom: 10px; line-height: 1.5; }
        .task-meta { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
        .badge-prioritas { padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .badge-tinggi { background: #fce4ec; color: #c62828; }
        .badge-sedang { background: #fff3e0; color: #e65100; }
        .badge-rendah { background: #e8f5e9; color: #2e7d32; }
        .task-assign { font-size: 0.78rem; color: #6b7a8d; }
        .task-actions { display: flex; gap: 6px; }
        .btn-move { flex: 1; padding: 6px; background: #f0f2f5; color: #0f1624; border: none; border-radius: 8px; font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: all 0.15s; }
        .btn-move:hover { background: #0f1624; color: white; }
        .btn-del-task { padding: 6px 10px; background: #fce4ec; color: #c62828; border: none; border-radius: 8px; font-size: 0.75rem; cursor: pointer; }
        .empty-col { text-align: center; color: #c0c8d0; font-size: 0.82rem; padding: 30px 0; }
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center; }
        .modal-overlay.active { display: flex; }
        .modal { background: white; border-radius: 16px; padding: 28px; width: 100%; max-width: 480px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
        .modal h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px 14px; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 0.9rem; outline: none; font-family: 'Segoe UI', sans-serif; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { border-color: #0f1624; }
        .modal-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 20px; }
        .btn-cancel { padding: 11px; background: white; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; color: #0f1624; }
        .btn-submit { padding: 11px; background: #0f1624; border: none; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; color: white; }
        .alert-success { background: #e8f5e9; color: #2e7d32; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="topbar">
    <a href="{{ route('projects.show', $project->id) }}">← Kembali ke Proyek</a>
    <div style="text-align:center;">
        <div class="group-title">{{ $group->nama_group }}</div>
        <div class="group-sub">{{ $project->nama_project }}</div>
    </div>
    <div class="topbar-right">
        <span style="font-size:0.85rem; color:#8a9bb0;">{{ auth()->user()->name }}</span>
    </div>
</div>

<div class="content">

    @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    @php
        $totalTasks = $group->tasks->count();
        $doneTasks = $group->tasks->where('status','done')->count();
        $progressTasks = $group->tasks->where('status','on_progress')->count();
        $todoTasks = $group->tasks->where('status','todo')->count();
        $persen = $totalTasks > 0 ? round(($doneTasks/$totalTasks)*100) : 0;
    @endphp

    <div class="progress-section">
        <div class="progress-info">
            <h3>Progress Kelompok</h3>
            <p>{{ $doneTasks }} dari {{ $totalTasks }} tugas selesai</p>
        </div>
        <div class="progress-wrap">
            <div class="progress-bar-bg">
                <div class="progress-bar-fill" style="width:{{ $persen }}%"></div>
            </div>
            <div class="progress-pct">{{ $persen }}% selesai</div>
        </div>
        <div class="stat-pills">
            <span class="stat-pill pill-todo">Todo: {{ $todoTasks }}</span>
            <span class="stat-pill pill-progress">Progress: {{ $progressTasks }}</span>
            <span class="stat-pill pill-done">Done: {{ $doneTasks }}</span>
        </div>
    </div>

    <div class="main-layout">

        <div class="sidebar">
            <div class="sidebar-card">
                <div class="sidebar-title">👥 Anggota Kelompok</div>

                @if(auth()->user()->isDospem() && $mahasiswa->count() > 0)
                <form action="{{ route('groups.addMember', [$project->id, $group->id]) }}" method="POST" class="form-add-member">
                    @csrf
                    <select name="user_id">
                        <option value="">-- Tambah anggota --</option>
                        @foreach($mahasiswa as $mhs)
                        <option value="{{ $mhs->id }}">{{ $mhs->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-add-member">+ Tambah Anggota</button>
                </form>
                @endif

                @php $groupAnggota = $group->anggota ?? collect([]); @endphp
                @forelse($groupAnggota as $anggota)
                <div class="member-item">
                    <div class="avatar">{{ strtoupper(substr($anggota->nama, 0, 1)) }}</div>
                    <div style ="flex:1;"> >
                        <div class="member-name">
                            {{ $anggota->nama }}
                            @if($anggota->is_ketua)
                            <span style="background:#0f1624; color:white; padding:1px 6px; border-radius:10px; font-size:0.68rem; margin-left:4px;">Ketua</span>
                            @endif
                        </div>    
                        <div class="member-tasks">NIM: {{ $anggota->nim }}</div>
                        <div class="member-tasks">Semester {{ $anggota->semester }}</div>
                    </div>
                </div>
                @empty
                <p style="text-align:center; color:#b0bec5; font-size:0.82rem; padding:10px 0;">Belum ada anggota</p>
                @endforelse
            </div>
        </div>

        <div class="kanban-section">
            <div class="kanban-header">
                <h2>🗂 Kanban Board</h2>
                @if(auth()->user()->isDospem())
                <button class="btn-tambah-tugas" onclick="document.getElementById('modalTambah').classList.add('active')">
                    + Tambah Tugas
                </button>
                @endif
            </div>

            <div class="kanban-cols">
                @foreach([
                    'todo' => ['label'=>'To Do', 'dot'=>'dot-todo'],
                    'on_progress' => ['label'=>'In Progress', 'dot'=>'dot-progress'],
                    'done' => ['label'=>'Done', 'dot'=>'dot-done'],
                ] as $status => $cfg)
                <div class="kanban-col">
                    <div class="col-header">
                        <div class="col-title">
                            <span class="col-dot {{ $cfg['dot'] }}"></span>
                            {{ $cfg['label'] }}
                        </div>
                        <span class="col-count">{{ $group->tasks->where('status',$status)->count() }}</span>
                    </div>

                    @forelse($group->tasks->where('status',$status) as $task)
                    <div class="task-card">
                        <div class="task-title">{{ $task->judul }}</div>
                        @if($task->deskripsi)
                        <div class="task-desc">{{ Str::limit($task->deskripsi, 80) }}</div>
                        @endif
                        <div class="task-meta">
                            <span class="badge-prioritas badge-{{ $task->prioritas }}">
                                {{ ucfirst($task->prioritas) }}
                            </span>
                            <span class="task-assign">👤 {{ $task->assignedTo->name ?? 'Unassigned' }}</span>
                        </div>

                        {{-- Aksi hanya untuk Dospem --}}
                        @if(auth()->user()->isDospem())
                        <div class="task-actions">
                            @if($status != 'todo')
                            <button class="btn-move btn-status"
                                data-id="{{ $task->id }}"
                                data-status="{{ $status == 'done' ? 'on_progress' : 'todo' }}">
                                ← {{ $status == 'done' ? 'Progress' : 'Todo' }}
                            </button>
                            @endif
                            @if($status != 'done')
                            <button class="btn-move btn-status"
                                data-id="{{ $task->id }}"
                                data-status="{{ $status == 'todo' ? 'on_progress' : 'done' }}">
                                {{ $status == 'todo' ? 'Progress' : 'Done' }} →
                            </button>
                            @endif
                            <form action="{{ route('groups.tasks.destroy', [$group->id, $task->id]) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del-task" onclick="return confirm('Hapus tugas?')">🗑</button>
                            </form>
                        </div>
                        @endif

                    </div>
                    @empty
                    <div class="empty-col">Tidak ada tugas</div>
                    @endforelse
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Tugas (Dospem only) --}}
@if(auth()->user()->isDospem())
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <h3>➕ Tambah Tugas Baru</h3>
        <form action="{{ route('groups.tasks.store', $group->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Judul Tugas *</label>
                <input type="text" name="judul" placeholder="Masukkan judul tugas" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3" placeholder="Deskripsi tugas..."></textarea>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div class="form-group">
                    <label>Prioritas *</label>
                    <select name="prioritas">
                        <option value="tinggi">🔴 Tinggi</option>
                        <option value="sedang" selected>🟡 Sedang</option>
                        <option value="rendah">🟢 Rendah</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Assign ke</label>
                    <select name="assigned_to">
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($group->members as $member)
                        <option value="{{ $member->user_id }}">{{ $member->user->name ?? '-' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="document.getElementById('modalTambah').classList.remove('active')">Batal</button>
                <button type="submit" class="btn-submit">Tambah Tugas</button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
document.querySelectorAll('.btn-status').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var taskId = this.getAttribute('data-id');
        var status = this.getAttribute('data-status');
        fetch('/tasks/' + taskId + '/status', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: status })
        }).then(function() { location.reload(); });
    });
});

@if(auth()->user()->isDospem())
document.getElementById('modalTambah').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('active');
});
@endif
</script>

</body>
</html>