<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'menu_id',
        'quantity',
        'price',
        'voucher_id',
    ];

    /**
     * Relasi ke model Transaction.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Relasi ke model Menu.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
