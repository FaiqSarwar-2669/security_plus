<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractModel extends Model
{
    use HasFactory;
    protected $table = 'guardContract';
    protected $fillable = [
        'Guards_id',
        'CompanyId',
        'CompanyName',
        'OrganizationId',
        'OrganizationName',
        'Name',
        'Email',
        'Mobile_Number',
        'Address',
        'City',
    ];

    public function user()
    {
        return $this->belongsTo(Guards::class, 'Guards_id');
    }

}
