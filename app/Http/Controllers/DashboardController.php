<?php

namespace App\Http\Controllers;

use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::with([
            'dospem',
            'groups.tasks',
            'members'
        ])->latest()->get();

        if (auth()->user()->role == 'dospem') {
            return view('dashboard_dospem', compact('projects'));
        }

        return view('home', compact('projects'));
    }
}