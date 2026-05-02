@extends('admin.layout')

@section('title', 'Kelola User')
@section('page_title', 'Kelola User')
@section('page_sub', 'Tambah, edit, dan hapus user sistem')

@section('content')
<style>
    .main-grid { display: grid; grid-template-columns: 320px 1fr; gap: 24px; align-items: start; }
    .card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
    .card-title { font-size: 0.95rem; font-weight: 700; color: #0f1624; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 0.82rem; font-weight: 600; color: #6b7a8d; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-group input, .form-group select { width: 100%; padding: 11px 14px; border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 0.9rem; outline: none; background: white; transition: border-color 0.2s; font-family: 'Segoe UI', sans-serif; }
    .form-group input:focus, .form-group select:focus { border-color: #0f1624; }
    .btn-submit { width: 100%; padding: 12px; background: #0f1624; color: white; border: none; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: background 0.2s; }
    .btn-submit:hover { background: #1e2d40; }

    /* Tabs */
    .tab-header { display: flex; gap: 8px; margin-bottom: 20px; background: #f5f6fa; padding: 6px; border-radius: 12px; }
    .tab-btn { flex: 1; padding: 10px; border: none; border-radius: 8px; font-size: 0.88rem; font-weight: 600; cursor: pointer; transition: all 0.2s; background: transparent; color: #6b7a8d; }
    .tab-btn.active { background: white; color: #0f1624; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }

    /* Search */
    .search-wrap { position: relative; margin-bottom: 16px; }
    .search-wrap input { width: 100%; padding: 10px 14px 10px 38px; border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 0.88rem; outline: none; }
    .search-wrap input:focus { border-color: #0f1624; }
    .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #b0bec5; font-size: 0.9rem; }

    /* Stats row */
    .stats-row { display: flex; gap: 12px; margin-bottom: 16px; }
    .stat-pill { background: #f5f6fa; border-radius: 10px; padding: 10px 16px; flex: 1; text-align: center; }
    .stat-pill .num { font-size: 1.4rem; font-weight: 800; color: #0f1624; }
    .stat-pill .lbl { font-size: 0.75rem; color: #6b7a8d; margin-top: 2px; }

    /* Table */
    .table-wrap { border-radius: 12px; overflow: hidden; border: 1.5px solid #f0f2f5; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f8f9fb; padding: 12px 16px; text-align: left; font-size: 0.78rem; font-weight: 700; color: #6b7a8d; text-transform: uppercase; letter-spacing: 0.5px; }
    td { padding: 12px 16px; font-size: 0.86rem; color: #0f1624; border-top: 1px solid #f5f6fa; }
    tr:hover td { background: #fafbfc; }
    .user-cell { display: flex; align-items: center; gap: 10px; }
    .avatar { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.82rem; font-weight: 700; color: white; flex-shrink: 0; }
    .avatar-blue { background: linear-gradient(135deg, #1565c0, #42a5f5); }
    .avatar-orange { background: linear-gradient(135deg, #e65100, #ff9800); }
    .user-name { font-weight: 600; font-size: 0.88rem; }
    .user-email { font-size: 0.78rem; color: #6b7a8d; }
    .badge-mhs { background: #e3f2fd; color: #1565c0; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .badge-dsp { background: #fff3e0; color: #e65100; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .nim-text { font-size: 0.82rem; color: #6b7a8d; font-family: monospace; }
    .action-btns { display: flex; gap: 6px; }
    .btn-edit { padding: 6px 12px; background: #fff3e0; color: #e65100; border: none; border-radius: 8px; font-size: 0.78rem; font-weight: 600; cursor: pointer; transition: all 0.15s; }
    .btn-edit:hover { background: #e65100; color: white; }
    .btn-del { padding: 6px 12px; background: #fce4ec; color: #c62828; border: none; border-radius: 8px; font-size: 0.78rem; font-weight: 600; cursor: pointer; transition: all 0.15s; }
    .btn-del:hover { background: #c62828; color: white; }
    .empty-row td { text-align: center; padding: 40px; color: #b0bec5; }

    /* Modal */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 200; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
    .modal-overlay.active { display: flex; }
    .modal { background: white; border-radius: 20px; padding: 32px; width: 100%; max-width: 440px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
    .modal-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 24px; display: flex; align-items: center; gap: 8px; }
    .modal-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 20px; }
    .btn-cancel { padding: 11px; background: #f5f6fa; border: none; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; color: #6b7a8d; }
    .btn-cancel:hover { background: #e8e8e8; }
</style>

<div class="main-grid">
    {{-- Form Tambah --}}
    <div class="card">
        <div class="card-title">➕ Tambah User Baru</div>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="name" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label>NIM / NIP</label>
                <input type="text" name="nim" placeholder="Khusus mahasiswa" value="{{ old('nim') }}">
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
                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>🎓 Mahasiswa</option>
                    <option value="dospem" {{ old('role') == 'dospem' ? 'selected' : '' }}>👨‍🏫 Dosen Pembimbing</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">+ Tambah User</button>
        </form>
    </div>

    {{-- Tabel User --}}
    <div class="card">
        {{-- Tab --}}
        <div class="tab-header">
            <button class="tab-btn active" id="tab-mhs" onclick="switchTab('mahasiswa')">
                🎓 Mahasiswa ({{ $users->where('role','mahasiswa')->count() }})
            </button>
            <button class="tab-btn" id="tab-dsp" onclick="switchTab('dospem')">
                👨‍🏫 Dospem ({{ $users->where('role','dospem')->count() }})
            </button>
        </div>

        {{-- Search --}}
        <div class="search-wrap">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchUser" placeholder="Cari nama atau email..." onkeyup="filterUser()">
        </div>

        {{-- Tabel Mahasiswa --}}
        <div id="tabel-mahasiswa">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>NIM</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableMahasiswa">
                        @php $mahasiswaList = $users->where('role','mahasiswa')->values(); @endphp
                        @forelse($mahasiswaList as $i => $user)
                        <tr data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}">
                            <td style="color:#6b7a8d; width:40px;">{{ $i + 1 }}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar avatar-blue">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                    <div>
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="user-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="nim-text">{{ $user->nim ?? '-' }}</span></td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-edit" onclick="openEdit({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->nim }}')">✏️ Edit</button>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-del" onclick="return confirm('Hapus {{ $user->name }}?')">🗑 Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="empty-row"><td colspan="4">Belum ada mahasiswa terdaftar</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tabel Dospem --}}
        <div id="tabel-dospem" style="display:none;">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Dosen Pembimbing</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableDospem">
                        @php $dospemList = $users->where('role','dospem')->values(); @endphp
                        @forelse($dospemList as $i => $user)
                        <tr data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}">
                            <td style="color:#6b7a8d; width:40px;">{{ $i + 1 }}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar avatar-orange">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                    <div>
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="user-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-edit" onclick="openEdit({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->nim }}')">✏️ Edit</button>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-del" onclick="return confirm('Hapus {{ $user->name }}?')">🗑 Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="empty-row"><td colspan="3">Belum ada dosen pembimbing terdaftar</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-title">✏️ Edit User</div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" id="editName" name="name" required>
            </div>
            <div class="form-group">
                <label>NIM / NIP</label>
                <input type="text" id="editNim" name="nim" placeholder="Khusus mahasiswa">
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" id="editEmail" name="email" required>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
            </div>
            <div class="form-group">
                <label>Role *</label>
                <select id="editRole" name="role" required>
                    <option value="mahasiswa">🎓 Mahasiswa</option>
                    <option value="dospem">👨‍🏫 Dosen Pembimbing</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="document.getElementById('modalEdit').classList.remove('active')">Batal</button>
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
var activeTab = 'mahasiswa';

function switchTab(tab) {
    activeTab = tab;
    document.getElementById('tabel-mahasiswa').style.display = tab == 'mahasiswa' ? 'block' : 'none';
    document.getElementById('tabel-dospem').style.display = tab == 'dospem' ? 'block' : 'none';
    document.getElementById('tab-mhs').classList.toggle('active', tab == 'mahasiswa');
    document.getElementById('tab-dsp').classList.toggle('active', tab == 'dospem');
    document.getElementById('searchUser').value = '';
}

function filterUser() {
    var search = document.getElementById('searchUser').value.toLowerCase();
    var tableId = activeTab == 'mahasiswa' ? 'tableMahasiswa' : 'tableDospem';
    document.querySelectorAll('#' + tableId + ' tr').forEach(function(row) {
        var name = row.getAttribute('data-name') || '';
        var email = row.getAttribute('data-email') || '';
        row.style.display = (name.includes(search) || email.includes(search)) ? '' : 'none';
    });
}

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
</script>
@endsection