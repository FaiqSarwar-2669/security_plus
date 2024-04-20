<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class login extends Model
{
    use HasFactory,HasApiTokens;

    protected $table = 'registrations';

    protected $fillable = [
        'email',
        'password'
    ];
    // public function tokens()
    // {
    //     return $this->hasMany(\Laravel\Sanctum\PersonalAccessToken::class, 'tokenable_id');
    // }
}
