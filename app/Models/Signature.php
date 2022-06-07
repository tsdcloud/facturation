<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'user_id'
    ];


    public function user(){

        return $this->belongsTo(User::class,'user_id')
    }
}
