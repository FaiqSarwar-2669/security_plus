<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messagemodel extends Model
{
    use HasFactory;
    protected $table = 'chats';

    protected $fillable = ['sender_id', 'receiver_id', 'message'];

    public function sender()
    {
        return $this->belongsTo(registeration::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(registeration::class, 'receiver_id');
    }
}
