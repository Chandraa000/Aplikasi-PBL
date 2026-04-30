@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="card">
    <div class="card-header">
        @if(auth()->user()->isDospem())
        <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Buat Project
        </a>
        @endif
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Project</th>
                    <th>Dospem</th>
                    <th>Anggota</th>
                    <th>Grup</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $i => $project)
                <tr>
                    <td>{{ $projects->firstItem() + $i }}</td>
                    <td>{{ $project->nama_project }}</td>
                    <td>{{ $project->dospem->name ?? '-' }}</td>
                    <td>{{ $project->members->count() }} anggota</td>
                    <td>{{ $project->groups->count() }} grup</td>
                    <td>
                        <span class="badge badge-{{ $project->status == 'aktif' ? 'success' : 'secondary' }}">
                            {{ $project->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if(auth()->user()->isMahasiswa())
                        <form action="{{ route('projects.join', $project->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm"
                                onclick="return confirm('Bergabung ke project ini?')">
                                <i class="fas fa-sign-in-alt"></i> Join
                            </button>
                        </form>
                        @endif
                        @if(auth()->user()->isDospem() && $project->dospem_id == auth()->id())
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                       <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin hapus project ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">Belum ada project</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $projects->links() }}
    </div>
</div>
@endsection