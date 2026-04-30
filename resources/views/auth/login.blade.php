<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem PBL - Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #0f1624; font-family: 'Segoe UI', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .container { width: 100%; max-width: 440px; padding: 20px; text-align: center; }
        .logo { width: 64px; height: 64px; background: white; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px; }
        h1 { color: white; font-size: 2rem; font-weight: 700; margin-bottom: 8px; }
        .subtitle { color: #6dd5fa; font-size: 0.95rem; margin-bottom: 30px; }
        .card { background: #f0f2f5; border-radius: 16px; padding: 32px; text-align: left; }
        .card h2 { font-size: 1.4rem; font-weight: 700; color: #0f1624; margin-bottom: 6px; }
        .card p { color: #6b7a8d; font-size: 0.9rem; margin-bottom: 24px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-weight: 600; color: #0f1624; margin-bottom: 8px; font-size: 0.95rem; }
        .form-group input { width: 100%; padding: 12px 16px; border: none; border-radius: 10px; background: white; font-size: 0.95rem; color: #0f1624; outline: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .form-group input:focus { box-shadow: 0 0 0 2px #4a9eff; }
        .btn-submit { width: 100%; padding: 14px; background: #0f1624; color: white; border: none; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; margin-top: 8px; transition: background 0.2s; }
        .btn-submit:hover { background: #1a2a3a; }
        .alert-danger { background: #fde8e8; color: #c0392b; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 0.9rem; }
        .register-link { margin-top: 16px; text-align: center; font-size: 0.88rem; color: #6b7a8d; }
        .register-link a { color: #0f1624; font-weight: 600; text-decoration: none; }
        .help-btn { position: fixed; bottom: 20px; right: 20px; width: 40px; height: 40px; background: #1a2332; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; cursor: pointer; border: 2px solid #2a3a4a; }
        .is-invalid { box-shadow: 0 0 0 2px #e74c3c !important; }
        .invalid-feedback { color: #e74c3c; font-size: 0.85rem; margin-top: 4px; display: block; }
    </style>
</head>
<body>

<div class="container">
    <div class="logo">✦</div>
    <h1>Sistem PBL</h1>
    <p class="subtitle">Manajemen Proyek Problem Based Learning</p>

    <div class="card">
        <h2>Masuk ke Sistem</h2>
        <p>Masukkan email dan password Anda</p>

        @if($errors->any())
        <div class="alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan email"
                    value="{{ old('email') }}"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password"
                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn-submit">→ Masuk</button>
        </form>
        <div class="register-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </div>
    </div>
</div>

<div class="help-btn">?</div>

</body>
</html>