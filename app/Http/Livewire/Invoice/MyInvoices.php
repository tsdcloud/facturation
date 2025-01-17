<?php

namespace App\Http\Livewire\Invoice;


use App\Models\Invoice;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
class MyInvoices extends Component
{
    use WithPagination;

    public $search_invoice_no_tractor_trailer, $data, $test;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['destroy'];


    public function render()
    {
        $id = auth()->user()->id;
        $query = Invoice::where('user_id',$id);
        $query->whereHas('myTractor', function($query){
            $query->where('label','LIKE',strtoupper("%$this->search_invoice_no_tractor_trailer%") );
        })
        ->orWhere(function($query) use ($id) {
            $query->where('invoice_no','LIKE',"%$this->search_invoice_no_tractor_trailer%");
            $query->where('user_id',$id);
        });


        return view('livewire.invoice.my-invoices',[

            'invoices' => $query->orderBy('created_at','DESC')->paginate(10),
        ]);
    }

    public function updating($name , $value)
    {
        if ($name === 'search_invoice_no_tractor_trailer')
           $this->resetPage();
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
