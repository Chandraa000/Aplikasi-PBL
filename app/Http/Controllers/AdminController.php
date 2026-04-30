<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Group;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUser = User::count();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalDospem = User::where('role', 'dospem')->count();
        $totalProject = Project::count();
        $totalKelompok = Group::count();
        $totalTugas = Task::count();
        $tugasSelesai = Task::where('status', 'done')->count();
        $projects = Project::with(['dospem', 'groups.tasks', 'members'])->latest()->get();

        return view('admin.dashboard', compact(
            'totalUser', 'totalMahasiswa', 'totalDospem',
            'totalProject', 'totalKelompok', 'totalTugas',
            'tugasSelesai', 'projects'
        ));
    }

    public function users()
    {
        $users = User::whereIn('role', ['mahasiswa', 'dospem'])->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|in:mahasiswa,dospem',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:mahasiswa,dospem',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->back()->with('success', 'User berhasil diupdate!');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }

    public function destroyProject(Project $project)
    {
        $project->delete();
        return redirect()->back()->with('success', 'Project berhasil dihapus!');
    }
}