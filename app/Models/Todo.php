<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['task_name', 'admin_id', 'status'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
