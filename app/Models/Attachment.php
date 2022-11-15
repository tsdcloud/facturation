<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['path','report_id'];

    public function report(){
        return $this->belongsTo(Report::class);
    }
}
