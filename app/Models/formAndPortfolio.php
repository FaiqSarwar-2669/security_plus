<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formAndPortfolio extends Model
{
    use HasFactory;

    protected $table = 'forms_and_portfolio';

    protected $fillable = [
        'user_id',
        'form_content',
        'logo',
        'Banner_image',
        'portfolio',
    ];

    public function user()
    {
        return $this->belongsTo(registeration::class, 'user_id');
    }
}
