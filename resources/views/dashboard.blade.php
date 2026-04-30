@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Project</h3>
                <div class="card-tools">
                    <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Buat Project
                    </a>
                </div>
            </div>
            <div class="card-body">
                @forelse($projects as $project)
                <div class="card card-outline card-primary mb-3">
                    <div class="card-header">
                        <h5 class="card-title">{{ $project->nama_project }}</h5>
                        <div class="card-tools">
                            <span class="badge badge-{{ $project->status == 'aktif' ? 'success' : 'secondary' }}">
                                {{ $project->status }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>{{ $project->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        <p><i class="fas fa-chalkboard-teacher"></i> Dospem: {{ $project->dospem->name ?? '-' }}</p>
                        <p><i class="fas fa-users"></i> {{ $project->groups->count() }} Grup</p>
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-center">Belum ada project. <a href="{{ route('projects.create') }}">Buat sekarang!</a></p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection