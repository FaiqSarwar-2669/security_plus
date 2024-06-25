<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registeration extends Model
{
    use HasFactory;
    protected $table = 'registrations';

    protected $fillable = [
        'bussiness_fname',
        'bussiness_lname',
        'bussiness_owner',
        'area_code',
        'phone_number',
        'street_address',
        'city_name',
        'province',
        'bussiness_type',
        'password',
        'email',
        'profile',
    ];
}
