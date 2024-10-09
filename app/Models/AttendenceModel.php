<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendenceModel extends Model
{
    use HasFactory;
    protected $table = 'attendence';
    protected $fillable = [
        'Guard_id',
        'Name',
        'Alert1',
        'Alert2',
        'Alert3',
        'Alert4',
        'Alert5',
        'Percentage'
    ];

    public function user()
    {
        return $this->belongsTo(Guards::class, 'Guard_id');
    }
}
