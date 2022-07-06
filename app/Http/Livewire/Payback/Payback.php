<?php

namespace App\Http\Livewire\Payback;

use App\Models\Invoice;
use Livewire\Component;

class Payback extends Component
{
    public $invoice, $id_invoice;
    public function render()
    {
        return view('livewire.payback.payback',[
            'refunds' => Invoice::where('isRefunded',false)->paginate(10),
        ]);
    }

    public function getId($id){

        $this->invoice = Invoice::where('id',$id)->first();
     //  dd($this->invoice);
    }

    public function payback(){

        $data =  tap($this->invoice)->update([
            'isRefunded' => true,
            'who_paid_back' => auth()->user()->name,
            'who_paid_back_id' => auth()->user()->id,
            'date_payback' => now(),
        ]);
        $this->id_invoice = $data->id;
        session()->flash('succès', 'facture remboursée : Opération reussite.');
       
        $this->dispatchBrowserEvent('closeAlert');
    }
    public function cancel(){

    }
}
