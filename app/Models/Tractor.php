<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tractor extends Model
{
    use HasFactory;

    protected $fillable = ['label'];

    public function invoices(){

        return $this->hasMany(invoice::class);
    }
}
