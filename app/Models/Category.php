<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_name']; // Tambahkan jika Anda ingin nama kategori bisa diisi

    public function menus()
    {
        return $this->hasMany(Menu::class); // Pastikan relasi hasMany
    }
}

