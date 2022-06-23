<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'status_invoice',
        'trailer_id',
        'customer_id',
        'type_weighing_id',
        'path_qrcode',
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

    public function myTrailer(){

        return $this->belongsTo(Trailer::class, 'trailer_id');
    }

    public function customer(){

        return $this->belongsTo(Customer::class);
    }

    public function typeWeighing(){

        return $this->belongsTo(TypeWeighing::class,'type_weighing_id');
    }
}
