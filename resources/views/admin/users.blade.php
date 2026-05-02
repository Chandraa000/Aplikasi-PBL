@extends('admin.layout')

@section('title', 'Kelola User')
@section('page_title', 'Kelola User')
@section('page_sub', 'Tambah, edit, dan hapus user sistem')

@section('content')
<style>
    .two-col { display: grid; grid-template-columns: 340px 1fr; gap: 24px; }
    .card { background: white; border-radius: 14px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .card h3 { font-size: 1rem; font-weight: 700; color: #0f1624; margin-bottom: 20px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #0f1624; margin-bottom: 6px; }
    .form-group input, .form-group select { width: 100%; padding: 10px 14px; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 0.9rem; outline: none; background: white; transition: border-color 0.2s; }
    .form-group input:focus, .form-group select:focus { border-color: #0f1624; }
    .form-group .hint { font-size: 0.78rem; color: #b0bec5; margin-top: 4px; }
    .btn-submit { width: 100%; padding: 12px; background: #0f1624; color: white; border: none; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; }
    .btn-submit:hover { background: #1a2a3a; }
    .search-bar { display: flex; gap: 12px; margin-bottom: 16px; }
    .search-bar input { flex: 1; padding: 10px 14px; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 0.9rem; outline: none; }
    .search-bar select { padding: 10px 14px; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 0.9rem; outline: none; background: white; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f8f9fb; padding: 12px 14px; text-align: left; font-size: 0.8rem; font-weight: 700; color: #6b7a8d; border-bottom: 1.5px solid #f0f2f5; }
    td { padding: 12px 14px; font-size: 0.85rem; color: #0f1624; border-bottom: 1px solid #f5f6fa; vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f8f9fb; }
    .badge-mahasiswa { background: #e3f2fd; color: #1565c0; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .badge-dospem { background: #fff3e0; color: #e65100; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .btn-edit { padding: 5px 10px; background: #fff3e0; color: #e65100; border: none; border-radius: 7px; font-size: 0.75rem; font-weight: 600; cursor: pointer; margin-right: 4px; }
    .btn-del { padding: 5px 10px; background: #fce4ec; color: #c62828; border: none; border-radius: 7px; font-size: 0.75rem; font-weight: 600; cursor: pointer; }
    .avatar { width: 32px; height: 32px; background: #0f1624; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.78rem; font-weight: 700; }
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 200; align-items: center; justify-content: center; }
    .modal-overlay.active { display: flex; }
    .modal { background: white; border-radius: 16px; padding: 28px; width: 100%; max-width: 440px; }
    .modal h3 { font-size: 1rem; font-weight: 700; margin-bottom: 20px; }
    .modal-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 16px; }
    .btn-cancel { padding: 11px; background: white; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; color: #0f1624; }
</style>

<div class="two-col">
    <div>
        <div class="card">
            <h3>➕ Tambah User Baru</h3>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="name" placeholder="Masukkan nama" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label>NIM / NIP</label>
                    <input type="text" name="nim" placeholder="NIM untuk mahasiswa" value="{{ old('nim') }}">
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" placeholder="Min. 6 karakter" required>
                </div>
                <div class="form-group">
                    <label>Role *</label>
                    <select name="role" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dospem">Dosen Pembimbing</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit">+ Tambah User</button>
            </form>
        </div>
    </div>

    <div>
        <div class="card">
            <h3>👥 Daftar User ({{ $users->count() }})</h3>
            <div class="search-bar">
                <input type="text" id="searchUser" placeholder="🔍 Cari nama atau email..." onkeyup="filterUser()">
                <select id="filterRole" onchange="filterUser()">
                    <option value="">Semua Role</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dospem">Dospem</option>
                </select>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>NIM</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    @forelse($users as $i => $user)
                    <tr data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}" data-role="{{ $user->role }}">
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="avatar">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td style="color:#6b7a8d;">{{ $user->email }}</td>
                        <td style="color:#6b7a8d;">{{ $user->nim ?? '-' }}</td>
                        <td><span class="badge-{{ $user->role }}">{{ $user->role == 'mahasiswa' ? 'Mahasiswa' : 'Dospem' }}</span></td>
                        <td>
                            <button class="btn-edit" onclick="openEdit({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->nim }}')">✏️ Edit</button>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del" onclick="return confirm('Yakin hapus user {{ $user->name }}?')">🗑 Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center; color:#b0bec5; padding:30px;">Belum ada user</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <h3>✏️ Edit User</h3>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" id="editName" name="name" required>
            </div>
            <div class="form-group">
                <label>NIM / NIP</label>
                <input type="text" id="editNim" name="nim" placeholder="NIM untuk mahasiswa">
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" id="editEmail" name="email" required>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
                <span class="hint">Kosongkan jika tidak ingin mengubah password</span>
            </div>
            <div class="form-group">
                <label>Role *</label>
                <select id="editRole" name="role" required>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dospem">Dosen Pembimbing</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="document.getElementById('modalEdit').classList.remove('active')">Batal</button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(id, name, email, role, nim) {
    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editRole').value = role;
    document.getElementById('editNim').value = nim || '';
    document.getElementById('editForm').action = '/admin/users/' + id;
    document.getElementById('modalEdit').classList.add('active');
}
document.getElementById('modalEdit').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('active');
});
function filterUser() {
    var search = document.getElementById('searchUser').value.toLowerCase();
    var role = document.getElementById('filterRole').value;
    document.querySelectorAll('#userTable tr').forEach(function(row) {
        var name = row.getAttribute('data-name') || '';
        var email = row.getAttribute('data-email') || '';
        var userRole = row.getAttribute('data-role') || '';
        var matchSearch = name.includes(search) || email.includes(search);
        var matchRole = role === '' || userRole === role;
        row.style.display = (matchSearch && matchRole) ? '' : 'none';
    });
}
</script>
@endsection