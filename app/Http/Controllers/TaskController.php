<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Group;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, Group $group)
    {
        $request->validate([
            'judul'       => 'required',
            'deskripsi'   => 'nullable',
            'prioritas'   => 'required|in:tinggi,sedang,rendah',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $group->tasks()->create([
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'prioritas'   => $request->prioritas,
            'assigned_to' => $request->assigned_to,
            'status'      => 'todo',
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:todo,on_progress,done',
        ]);

        $task->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function destroy(Group $group, Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Tugas berhasil dihapus!');
    }
}