<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Project</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f6fa; }
        .topbar { background: #0f1624; color: white; padding: 16px 32px; }
        .topbar a { color: white; text-decoration: none; font-size: 0.9rem; }
        .topbar a:hover { opacity: 0.8; }
        .content { max-width: 680px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 16px; padding: 36px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .card h2 { font-size: 1.5rem; font-weight: 700; color: #0f1624; margin-bottom: 6px; }
        .card .subtitle { color: #6b7a8d; font-size: 0.9rem; margin-bottom: 28px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; color: #0f1624; margin-bottom: 8px; font-size: 0.9rem; }
        .form-group input, .form-group textarea {
            width: 100%; padding: 12px 16px;
            border: 1.5px solid #e0e0e0; border-radius: 10px;
            font-size: 0.95rem; color: #0f1624; outline: none;
            font-family: 'Segoe UI', sans-serif;
            transition: border-color 0.2s;
        }
        .form-group input:focus, .form-group textarea:focus { border-color: #0f1624; }
        .form-group .hint { font-size: 0.8rem; color: #b0bec5; margin-top: 6px; }
        .is-invalid { border-color: #e74c3c !important; }
        .invalid-feedback { color: #e74c3c; font-size: 0.82rem; margin-top: 4px; display: block; }
        .alert-success { background: #e8f5e9; color: #2e7d32; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }
        .form-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 28px; }
        .btn-batal {
            padding: 13px; background: white; border: 1.5px solid #e0e0e0;
            border-radius: 10px; font-size: 0.95rem; font-weight: 600;
            color: #0f1624; text-align: center; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-batal:hover { background: #f5f6fa; }
        .btn-simpan {
            padding: 13px; background: #0f1624; border: none;
            border-radius: 10px; font-size: 0.95rem; font-weight: 600;
            color: white; cursor: pointer; transition: background 0.2s;
        }
        .btn-simpan:hover { background: #1a2a3a; }
    </style>
</head>
<body>

<div class="topbar">
    <a href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
</div>

<div class="content">
    <div class="card">
        <h2>Buat Project Baru</h2>
        <p class="subtitle">Lengkapi informasi project yang akan dibuat</p>

        @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Project *</label>
                <input type="text" name="nama_project"
                    placeholder="Masukkan nama project"
                    value="{{ old('nama_project') }}"
                    class="{{ $errors->has('nama_project') ? 'is-invalid' : '' }}">
                @error('nama_project')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Nama Dosen Pembimbing *</label>
                <input type="text" name="nama_dospem"
                    placeholder="Masukkan nama dosen pembimbing"
                    value="{{ old('nama_dospem') }}"
                    class="{{ $errors->has('nama_dospem') ? 'is-invalid' : '' }}">
                <span class="hint">Nama dosen akan otomatis terdaftar di sistem</span>
                @error('nama_dospem')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Deskripsi Project</label>
                <textarea name="deskripsi" rows="4"
                    placeholder="Jelaskan tujuan dan deskripsi project...">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('dashboard') }}" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">✓ Simpan Project</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>