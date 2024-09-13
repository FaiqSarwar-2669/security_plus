<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chatUsers extends Model
{
    use HasFactory;
    
    protected $table = 'chatUser';

    protected $fillable = ['current', 'members'];

    public function current()
    {
        return $this->belongsTo(registeration::class, 'current');
    }
}
