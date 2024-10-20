<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Guards extends Model
{
    use HasFactory,HasApiTokens;
    protected $table = 'Guards';

    protected $fillable = [
        'user_id',
        'First_Name',
        'Last_Name',
        'Father_Name',
        'DOB',
        'Gender',
        'Email',
        'Mobile_Number',
        'Emergency_Contact',
        'Address',
        'City',
        'Qualification',
        'Hobbies',
        'Postal_Code',
        'Religion',
        'Salary',
        'Identity',
        'Password',
        'Status',
        'profile_image'
    ];

    public function user()
    {
        return $this->belongsTo(registeration::class, 'user_id');
    }
}
