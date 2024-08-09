<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'from_id',
        'to_id',
        'chat_id',
        'is_readed'
    ];
    public function from(){
        return $this->belongsTo(User::class,'from_id');
    }
    public function to(){
        return $this->belongsTo(User::class,'to_id');
    }
    public function chat(){
        return $this->belongsTo(Chat::class,'chat_id');
    }
}
