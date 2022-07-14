<?php

namespace App\Http\Livewire\Invoice;


use App\Models\Invoice;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MyInvoices extends Component
{
    public $search_invoice_no_tractor_trailer, $data;

    protected $listeners = ['destroy'];


    public function render()
    {
        $query = Invoice::where('user_id',auth()->user()->id);
        $query->whereHas('myTractor', function($query){
            $query->where('label','LIKE',strtoupper("%$this->search_invoice_no_tractor_trailer%") );
        })
        ->orWhere(function($query) {
            $query->where('invoice_no','LIKE',"%$this->search_invoice_no_tractor_trailer%");
            $query->where('user_id',auth()->user()->id);
        });


        return view('livewire.invoice.my-invoices',[

            'invoices' => $query->orderBy('created_at','DESC')->paginate(10),
        ]);
    }

    public function mount(){

        $this->data = '';
    }
    public function getInvoice($id){

        $this->data = Invoice::where('id',$id)->first();

    }

    public function cancelInvoice(){

        try{
            tap($this->data)->update(['status_invoice' => 'cancelling']);
            $this->dispatchBrowserEvent('closeAlert');
            session()->flash('message', 'facture annulée.');
        }catch(\Exception $e){
            Log::error(sprintf('%d'.$e->getMessage(), __METHOD__));
            session()->flash('error', 'Une erreur c\'est produite lors de l\'annulation de la facture veuillez essayer à nouveau.');
        }
    }

    public function cancel(){

       $this->reset('data');
    }
}
