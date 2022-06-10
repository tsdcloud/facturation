<?php

namespace App\Http\Livewire;

use App\Models\invoice;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class ListInvoices extends Component
{
    public $search_invoice_no_tractor_trailer;
    public array $data = [];
    protected $listeners = ['destroy'];
    
    public function render()
    {
        return view('livewire.list-invoices',[
            'invoices' => invoice::where(function($query){
                $query->where('invoice_no','LIKE',"%{$this->search_invoice_no_tractor_trailer}%");
                $query->where('user_id', auth()->user()->id);
                $query->where('status_invoice','validated');
            })->orderBy('created_at','DESC')->paginate(10),
        ]);
    }

    public function getInvoice($id){
   
        $ok = invoice::where('id',$id)->first();    
        $this->data[] = $ok;
    //    dd($this->data)        ;
    }

    public function cancelInvoice(){
        try{
            tap($this->data)->update(['status_invoice' => 'cancelling']);
           $this->dispatchBrowserEvent('closeAlert');
           session()->flash('message', 'facture enregistreé avec succès.');
        }catch(\Exception $e){
            Log::error(sprintf('%d'.$e->getMessage(), __METHOD__));
            session()->flash('error', 'Une erreur c\'est produite lors de l\'annulation de la facture veuillez essayer à nouveau.');
        }
    }
}
