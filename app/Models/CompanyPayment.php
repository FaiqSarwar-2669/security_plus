<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPayment extends Model
{
    use HasFactory;

    protected $table = 'company_payment';

    protected $fillable = [
        'user_id',
        'organization_id',
        'name',
        'price',
        'slip',
    ];

    public function user()
    {
        return $this->belongsTo(registeration::class, 'user_id');
    }
}
