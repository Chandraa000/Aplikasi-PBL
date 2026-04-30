<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupAnggota extends Model
{
    use HasFactory;

    protected $table = 'group_anggota';

    protected $fillable = [
        'group_id', 'project_id', 'nama', 'nim', 'semester', 'is_ketua'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    public function anggota()
    {
    return $this->hasMany(GroupAnggota::class);
    }
}