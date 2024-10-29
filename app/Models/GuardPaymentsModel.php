<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardPaymentsModel extends Model
{
    use HasFactory;
    protected $table = 'guard_payment';

    protected $fillable = [
        'guard_id',
        'company_id',
        'payablbe',
        'deduction',
        'total',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(Guards::class, 'guard_id');
    }
}
