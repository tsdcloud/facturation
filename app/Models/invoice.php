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
        'subtotal',
        'tax_amount',
        'total_amount',
        'amount_paid',
        'remains',
        'mode_payment_id',
        'weighbridge_id',
        'user_id',
        'tractor_id',
        'approved',
    ];

    public function weighbridge(){
        return $this->belongsTo(Weighbridge::class);
    }

    public function modePayment()  {
        return $this->belongsTo(ModePayment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function myTractor(){
        return $this->belongsTo(Tractor::class,'tractor_id');
    }
}
