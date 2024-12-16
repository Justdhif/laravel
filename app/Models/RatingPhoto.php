<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating_id',
        'path',
    ];

    public function rating()
    {
        return $this->belongsTo(Ratings::class);
    }
}
