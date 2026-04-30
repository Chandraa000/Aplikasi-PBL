<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Project;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'nama_group' => 'required',
            'deskripsi'  => 'nullable',
        ]);

        $jumlahGroup = $project->groups()->count();
        if ($jumlahGroup >= 5) {
            return redirect()->back()->with('error', 'Maksimal 5 kelompok per project!');
        }

        $project->groups()->create([
            'nama_group' => $request->nama_group,
            'deskripsi'  => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Kelompok berhasil ditambahkan!');
    }

    public function show(Project $project, Group $group)
{
    $group->load(['members.user', 'tasks', 'anggota']);
    $anggotaIds = $group->members->pluck('user_id');
    $mahasiswa = User::where('role', 'mahasiswa')
        ->whereNotIn('id', $anggotaIds)
        ->get();
    return view('groups.show', compact('project', 'group', 'mahasiswa'));
}

    public function addMember(Request $request, Project $project, Group $group)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        GroupMember::firstOrCreate([
            'group_id' => $group->id,
            'user_id'  => $request->user_id,
        ]);

        return redirect()->back()->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function removeMember(Project $project, Group $group, GroupMember $member)
    {
        $member->delete();
        return redirect()->back()->with('success', 'Anggota berhasil dihapus!');
    }

    public function destroy(Project $project, Group $group)
    {
        $group->delete();
        return redirect()->back()->with('success', 'Kelompok berhasil dihapus!');
    }
}