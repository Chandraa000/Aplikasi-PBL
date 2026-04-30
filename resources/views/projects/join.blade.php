<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bergabung ke Proyek</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f6fa; }

        .topbar { background: #0f1624; color: white; padding: 16px 32px; }
        .topbar a { color: white; text-decoration: none; font-size: 0.9rem; }

        .main { display: grid; grid-template-columns: 360px 1fr; min-height: calc(100vh - 56px); }

        /* Kiri */
        .left-panel { background: #0f1624; color: white; padding: 40px 32px; }
        .panel-header { font-size: 1rem; font-weight: 600; color: #8a9bb0; margin-bottom: 32px; }
        .template-card { background: white; color: #0f1624; border-radius: 16px; padding: 24px; }
        .template-card h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: 12px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; margin-bottom: 14px; }
        .badge-gray { background: #f0f2f5; color: #6b7a8d; }
        .badge-aktif { background: #e8f5e9; color: #2e7d32; }
        .template-card p { font-size: 0.85rem; color: #6b7a8d; line-height: 1.6; margin-bottom: 20px; }
        .info-row { margin-bottom: 12px; }
        .info-row label { font-size: 0.8rem; color: #6b7a8d; font-weight: 600; display: block; margin-bottom: 6px; }
        .tags { display: flex; flex-wrap: wrap; gap: 6px; }
        .tag { background: #f0f2f5; color: #0f1624; padding: 4px 10px; border-radius: 8px; font-size: 0.8rem; }

        /* Kanan */
        .right-panel { background: white; padding: 40px 48px; overflow-y: auto; }
        .right-panel h2 { font-size: 1.6rem; font-weight: 700; color: #0f1624; margin-bottom: 6px; }
        .right-panel .subtitle { color: #6b7a8d; font-size: 0.9rem; margin-bottom: 32px; }

        .section-title {
            font-size: 0.95rem; font-weight: 700; color: #0f1624;
            margin-bottom: 14px; padding-bottom: 10px;
            border-bottom: 2px solid #f0f2f5;
        }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-weight: 600; color: #0f1624; margin-bottom: 8px; font-size: 0.9rem; }
        .form-group input, .form-group select {
            width: 100%; padding: 12px 16px;
            border: 1.5px solid #e0e0e0; border-radius: 10px;
            font-size: 0.9rem; color: #0f1624; outline: none;
            transition: border-color 0.2s;
        }
        .form-group input:focus, .form-group select:focus { border-color: #0f1624; }
        .form-group input[readonly] { background: #f8f9fb; color: #6b7a8d; }

        /* Anggota */
        .anggota-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 14px; padding-bottom: 10px;
            border-bottom: 2px solid #f0f2f5;
        }
        .anggota-header span { font-size: 0.95rem; font-weight: 700; color: #0f1624; }
        .btn-tambah-anggota {
            padding: 7px 16px; background: #f0f2f5; color: #0f1624;
            border: none; border-radius: 8px; font-size: 0.85rem;
            font-weight: 600; cursor: pointer; transition: all 0.2s;
        }
        .btn-tambah-anggota:hover { background: #0f1624; color: white; }

        .anggota-item {
            background: #f8f9fb; border-radius: 12px; padding: 16px;
            margin-bottom: 12px; border: 1.5px solid #ebebeb;
        }
        .anggota-num {
            font-size: 0.8rem; font-weight: 700; color: #6b7a8d;
            margin-bottom: 10px; display: flex; justify-content: space-between;
            align-items: center;
        }
        .btn-hapus-anggota {
            padding: 3px 10px; background: #fce4ec; color: #c62828;
            border: none; border-radius: 6px; font-size: 0.78rem;
            font-weight: 600; cursor: pointer;
        }
        .three-col { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .ketua-badge {
            display: inline-block; background: #0f1624; color: white;
            padding: 3px 10px; border-radius: 20px; font-size: 0.75rem;
            font-weight: 600; margin-left: 8px;
        }

        /* Bottom */
        .form-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 28px; }
        .btn-batal {
            padding: 14px; background: white; border: 1.5px solid #e0e0e0;
            border-radius: 10px; font-size: 1rem; font-weight: 600;
            color: #0f1624; cursor: pointer; text-align: center; text-decoration: none;
        }
        .btn-buat {
            padding: 14px; background: #0f1624; border: none;
            border-radius: 10px; font-size: 1rem; font-weight: 600;
            color: white; cursor: pointer;
        }
        .btn-buat:hover { background: #1a2a3a; }

        .alert-error { background: #fce4ec; color: #c62828; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="topbar">
    <a href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
</div>

<div class="main">
    {{-- Panel Kiri --}}
    <div class="left-panel">
        <div class="panel-header">✦ Template Proyek</div>
        <div class="template-card">
            <span class="badge badge-gray">Project</span>
            <span class="badge badge-aktif">{{ ucfirst($project->status) }}</span>
            <h3>{{ $project->nama_project }}</h3>
            <p>{{ $project->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            <div class="info-row">
                <label>Dospem:</label>
                <div class="tags"><span class="tag">{{ $project->dospem->name ?? '-' }}</span></div>
            </div>
            <div class="info-row">
                <label>Anggota Terdaftar:</label>
                <div class="tags"><span class="tag">{{ $project->members->count() }} orang</span></div>
            </div>
            <div class="info-row">
                <label>Kelompok:</label>
                <div class="tags"><span class="tag">{{ $project->groups->count() }} kelompok</span></div>
            </div>
        </div>
    </div>

    {{-- Panel Kanan --}}
    <div class="right-panel">
        <h2>Daftar ke Proyek</h2>
        <p class="subtitle">Lengkapi data kelompok Anda untuk bergabung ke proyek ini</p>

        @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('projects.join', $project->id) }}">
            @csrf

            {{-- Info Proyek --}}
            <div class="section-title">📁 Info Proyek</div>
            <div class="two-col">
                <div class="form-group">
                    <label>Nama Proyek</label>
                    <input type="text" value="{{ $project->nama_project }}" readonly>
                </div>
                <div class="form-group">
                    <label>Dosen Pembimbing</label>
                    <input type="text" value="{{ $project->dospem->name ?? '-' }}" readonly>
                </div>
            </div>

            {{-- Daftar Anggota --}}
            <div class="anggota-header">
                <span>🧑‍🎓 Daftar Anggota <span id="jumlahAnggota" style="color:#6b7a8d; font-weight:400;">(1 orang)</span></span>
                <button type="button" class="btn-tambah-anggota" onclick="tambahAnggota()">+ Tambah Anggota</button>
            </div>

            <div id="listAnggota">
                {{-- Anggota 1 (Ketua - otomatis) --}}
                <div class="anggota-item">
                    <div class="anggota-num">
                        <span>Anggota 1 <span class="ketua-badge">Ketua</span></span>
                    </div>
                    <div class="three-col">
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Nama Lengkap *</label>
                            <input type="text" name="anggota[0][nama]" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label>NIM *</label>
                            <input type="text" name="anggota[0][nim]" placeholder="Contoh: H233600417" required>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Semester *</label>
                            <select name="anggota[0][semester]" required>
                                <option value="">-- Pilih --</option>
                                @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">Semester {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('dashboard') }}" class="btn-batal">Batal</a>
                <button type="submit" class="btn-buat">✓ Daftar ke Proyek</button>
            </div>
        </form>
    </div>
</div>

<script>
var jumlah = 1;

function tambahAnggota() {
    jumlah++;
    var div = document.createElement('div');
    div.className = 'anggota-item';
    div.id = 'anggota-' + jumlah;
    div.innerHTML = `
        <div class="anggota-num">
            <span>Anggota ${jumlah}</span>
            <button type="button" class="btn-hapus-anggota" onclick="hapusAnggota(${jumlah})">✕ Hapus</button>
        </div>
        <div class="three-col">
            <div class="form-group" style="margin-bottom:0;">
                <label>Nama Lengkap *</label>
                <input type="text" name="anggota[${jumlah-1}][nama]" placeholder="Nama lengkap" required>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>NIM *</label>
                <input type="text" name="anggota[${jumlah-1}][nim]" placeholder="Contoh: H233600417" required>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Semester *</label>
                <select name="anggota[${jumlah-1}][semester]" required>
                    <option value="">-- Pilih --</option>
                    ${[1,2,3,4,5,6,7,8].map(i => `<option value="${i}">Semester ${i}</option>`).join('')}
                </select>
            </div>
        </div>
    `;
    document.getElementById('listAnggota').appendChild(div);
    updateJumlah();
    document.getElementById('listAnggota').appendChild(div);
    updateJumlah();
}

function hapusAnggota(id) {
    document.getElementById('anggota-' + id).remove();
    updateJumlah();
}

function updateJumlah() {
    var items = document.querySelectorAll('.anggota-item');
    document.getElementById('jumlahAnggota').textContent = '(' + items.length + ' orang)';
}
</script>

</body>
</html>