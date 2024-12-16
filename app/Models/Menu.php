<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'description', 'price', 'stock', 'category_id', 'image',
    ];

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class); // Pastikan relasi belongsTo
    }

    public function ratings()
    {
        return $this->hasMany(Ratings::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

