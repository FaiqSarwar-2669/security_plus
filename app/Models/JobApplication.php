<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;
    protected $table = 'job_applications';

    protected $fillable = [
        'user_id',
        'Form',
        'Status',
    ];

    public function user()
    {
        return $this->belongsTo(registeration::class, 'user_id');
    }
}
