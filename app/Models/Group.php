<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'nama_group', 'deskripsi'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function anggota()
    {
        return $this->hasMany(GroupAnggota::class);
    }
}