<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'reviewer',
        'review',
        'rating'
    ];

    public function user()
    {
        return $this->belongsTo(registeration::class, 'user_id');
    }
}
