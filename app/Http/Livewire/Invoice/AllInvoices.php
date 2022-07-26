<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Invoice;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class AllInvoices extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public  $search_invoice_no_tractor_trailer, $data;
    public function render()
    {
        $query = Invoice::whereHas('myTractor', function($query){
            $query->where('label','LIKE',strtoupper("%$this->search_invoice_no_tractor_trailer%") );
        })
            ->orWhere(function($query) {
                $query->where('invoice_no','LIKE',"%$this->search_invoice_no_tractor_trailer%");

            });

        return view('livewire.invoice.all-invoices',[
            'invoices' => $query->orderBy('created_at','DESC')->paginate(10),
        ]);
    }

    public function mount($name , $value){

        if ($name === 'search_invoice_no_tractor_trailer')
            $this->resetPage();

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
