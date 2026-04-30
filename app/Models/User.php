<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $fillable = [
    'name', 'nim', 'email', 'password', 'role'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'dospem_id');
    }

    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function isDospem()
    {
        return $this->role === 'dospem';
    }

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }
    public function joinedProjects()
    {
       return $this->belongsToMany(Project::class, 'project_members');
    }
}