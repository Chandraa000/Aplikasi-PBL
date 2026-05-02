<?php

namespace App\Http\Controllers;

use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
{
    $semesterAktif = \App\Models\Semester::where('is_aktif', true)->first();

    if (auth()->user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->role == 'dospem') {
        $projects = \App\Models\Project::with(['dospem', 'groups.tasks', 'members'])
            ->when($semesterAktif, fn($q) => $q->where('semester_id', $semesterAktif->id))
            ->latest()->get();
        return view('dashboard_dospem', compact('projects', 'semesterAktif'));
    }

    // Mahasiswa
    $projects = \App\Models\Project::with(['dospem', 'groups.tasks', 'members'])
        ->when($semesterAktif, fn($q) => $q->where('semester_id', $semesterAktif->id))
        ->latest()->get();
    return view('home', compact('projects', 'semesterAktif'));
}
}