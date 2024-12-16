<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_code',
        'discount',
        'expiry_date',
        'type',
        'menu_id',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class)->withDefault();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}

