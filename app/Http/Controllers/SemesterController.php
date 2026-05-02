<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Project;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::withCount('projects')->latest()->get();
        return view('admin.semester.index', compact('semesters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis'           => 'required|in:ganjil,genap',
            'tahun_ajaran'    => 'required',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
        ]);

        $nama = 'Semester ' . ucfirst($request->jenis) . ' ' . $request->tahun_ajaran;

        Semester::create([
            'nama'            => $nama,
            'jenis'           => $request->jenis,
            'tahun_ajaran'    => $request->tahun_ajaran,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'is_aktif'        => false,
        ]);

        return redirect()->back()->with('success', 'Semester berhasil ditambahkan!');
    }

    public function show(Semester $semester)
    {
    $semester->load([
        'projects.dospem',
        'projects.groups.tasks',
        'projects.members'
    ]);
    return view('admin.semester.show', compact('semester'));
    }     

    public function setAktif(Semester $semester)
    {
        // Nonaktifkan semua semester
        Semester::query()->update(['is_aktif' => false]);
        // Aktifkan semester yang dipilih
        $semester->update(['is_aktif' => true]);
        return redirect()->back()->with('success', $semester->nama . ' dijadikan semester aktif!');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect()->back()->with('success', 'Semester berhasil dihapus!');
    }
}