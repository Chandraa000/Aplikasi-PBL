<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMember;

class DashboardController extends Controller
{
    public function index()
    {
        $semesterAktif = \App\Models\Semester::where('is_aktif', true)->first();

        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (auth()->user()->role == 'dospem') {
            $projects = Project::with(['dospem', 'groups.tasks', 'members'])
            ->where('dospem_id', auth()->id())
            ->when($semesterAktif, fn($q) => $q->where('semester_id', $semesterAktif->id))
            ->latest()->get();
            return view('dashboard_dospem', compact('projects', 'semesterAktif'));
    }

        // Cek apakah mahasiswa sudah join project di semester aktif
        $sudahJoin = ProjectMember::where('user_id', auth()->id())
            ->whereHas('project', function($q) use ($semesterAktif) {
                if ($semesterAktif) {
                    $q->where('semester_id', $semesterAktif->id);
                }
            })->first();

        if ($sudahJoin) {
            // Sudah join - tampilkan dashboard project sendiri
            $myProject = Project::with([
                'dospem',
                'groups.members.user',
                'groups.tasks',
                'members',
                'anggota'
            ])->find($sudahJoin->project_id);

            $myGroup = $myProject->groups()
                ->whereHas('members', fn($q) => $q->where('user_id', auth()->id()))
                ->with(['members.user', 'tasks', 'anggota'])
                ->first();

            return view('home_mahasiswa', compact('myProject', 'myGroup', 'semesterAktif'));
        }

        // Belum join - tampilkan semua project semester aktif
        $projects = Project::with(['dospem', 'groups', 'members'])
            ->when($semesterAktif, fn($q) => $q->where('semester_id', $semesterAktif->id))
            ->latest()->get();

        return view('home', compact('projects', 'semesterAktif'));
    }
}