@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Project</label>
                <input type="text" name="nama_project" class="form-control" value="{{ $project->nama_project }}">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ $project->deskripsi }}</textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="aktif" {{ $project->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ $project->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection