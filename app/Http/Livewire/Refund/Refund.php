<?php

namespace App\Http\Livewire\Refund;

use App\Models\Invoice;
use Livewire\Component;

class Refund extends Component
{
    public function render()
    {
        return view('livewire.refund.refund',[

            'refunds' => Invoice::where('isRefunded',false)
                                  ->where('user_id',auth()->user()->id)
                                  ->paginate(10)
        ]);
    }
}
