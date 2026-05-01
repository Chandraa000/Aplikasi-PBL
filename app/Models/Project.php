<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_project', 'deskripsi', 'dospem_id', 'status', 'semester_id'
    ];

    public function dospem()
    {
        return $this->belongsTo(User::class, 'dospem_id');
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members');
    }

    public function anggota()
    {
        return $this->hasMany(GroupAnggota::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}