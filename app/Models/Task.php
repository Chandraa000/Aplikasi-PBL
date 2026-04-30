<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id', 'assigned_to', 'judul',
        'deskripsi', 'status', 'prioritas'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}