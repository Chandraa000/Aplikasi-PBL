<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'jenis', 'tahun_ajaran', 'is_aktif',
        'tanggal_mulai', 'tanggal_selesai'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    
}