<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'trailer',
        'tractor',
        'invoice_no',
        'amount_ht',
        'vat',
        'amount_paid',
        'remains',
        'mode_payment_id',
        'weighbridge_id',
        'user_id'
    ];

    public function weighbridge(){
        return $this->belongsTo(Weighbridge::class);
    }

    public function modePayement(){
        return $this->belongsTo(ModePayment::class);
    }
}
