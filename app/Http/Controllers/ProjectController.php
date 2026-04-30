<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectMember;
use App\Models\GroupMember;
use App\Models\GroupAnggota;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['dospem', 'groups', 'members'])->latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_project' => 'required',
            'deskripsi'    => 'nullable',
            'nama_dospem'  => 'required',
        ]);

        $dospem = User::firstOrCreate(
            ['email' => str()->slug($request->nama_dospem) . '@dospem.com'],
            [
                'name'     => $request->nama_dospem,
                'password' => bcrypt('password123'),
                'role'     => 'dospem',
            ]
        );

        Project::create([
            'nama_project' => $request->nama_project,
            'deskripsi'    => $request->deskripsi,
            'dospem_id'    => $dospem->id,
            'status'       => 'aktif',
        ]);

        return redirect()->route('projects.index')->with('success', 'Project berhasil dibuat!');
    }

    public function show(Project $project)
    {
        $project->load(['dospem', 'groups.members.user', 'groups.tasks', 'members', 'anggota']);
        $isMember = $project->members->contains(auth()->id());
        return view('projects.show', compact('project', 'isMember'));
    }

    public function joinForm(Project $project)
    {
        $project->load(['dospem', 'groups', 'members']);
        return view('projects.join', compact('project'));
    }

    public function join(Request $request, Project $project)
    {
        $request->validate([
            'anggota'            => 'required|array|min:1',
            'anggota.*.nama'     => 'required',
            'anggota.*.nim'      => 'required',
            'anggota.*.semester' => 'required',
        ]);

        $alreadyMember = ProjectMember::where('project_id', $project->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyMember) {
            return redirect()->back()->with('error', 'Kamu sudah bergabung di project ini!');
        }

        $ketua = $request->anggota[0];
        $namaKelompok = 'Kelompok ' . $ketua['nama'];

        auth()->user()->update(['nim' => $ketua['nim']]);

        $group = $project->groups()->create([
            'nama_group' => $namaKelompok,
            'deskripsi'  => 'Semester ' . $ketua['semester'],
        ]);

        ProjectMember::create([
            'project_id' => $project->id,
            'user_id'    => auth()->id(),
        ]);

        GroupMember::create([
            'group_id' => $group->id,
            'user_id'  => auth()->id(),
        ]);

        foreach ($request->anggota as $i => $anggota) {
            GroupAnggota::create([
                'group_id'   => $group->id,
                'project_id' => $project->id,
                'nama'       => $anggota['nama'],
                'nim'        => $anggota['nim'],
                'semester'   => $anggota['semester'],
                'is_ketua'   => $i === 0,
            ]);
        }

        return redirect()->route('projects.groups.show', [$project->id, $group->id])
            ->with('success', 'Berhasil bergabung! ' . count($request->anggota) . ' anggota terdaftar.');
    }

    public function removeMember(Project $project, User $user)
    {
        $project->members()->detach($user->id);
        return redirect()->back()->with('success', 'Anggota berhasil dihapus!');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        if ($project->dospem_id != auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengedit project ini!');
        }
        $request->validate(['nama_project' => 'required']);
        $project->update($request->only('nama_project', 'deskripsi', 'status'));
        return redirect()->route('projects.index')->with('success', 'Project berhasil diupdate!');
    }

    public function destroy(Project $project)
    {
        if ($project->dospem_id != auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus project ini!');
        }
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus!');
    }
}