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
        return view('livewire.invoice.my-invoices',[
            'invoices' => Invoice::where(function($query){
                $query->where('invoice_no','LIKE',"%{$this->search_invoice_no_tractor_trailer}%");
                $query->where('user_id', auth()->user()->id);
//                $query->where('who_paid_back_id', auth()->user()->id);
            })->orderBy('created_at','DESC')->paginate(10),
            'numberInvoice' => Invoice::where('user_id',auth()->user()->id)
                                        ->whereDate('created_at',now())
                                        ->count(),
            'cashMoney' => Invoice::where('user_id', auth()->user()->id)
                                    ->where('mode_payment_id',2)
                                    ->whereDate('created_at',now())
                                    ->sum('total_amount'),
            'mobileMoney' => Invoice::where('user_id', auth()->user()->id)
                                     ->where('mode_payment_id',1)
                                     ->whereDate('created_at',now())
                                     ->sum('total_amount'),
            'cancelledInvoice' => Invoice::where('user_id',auth()->user()->id)
                                        ->where('status_invoice','cancelling')
                                        ->whereDate('created_at',now())
                                         ->count(),
            'totalAmount' => Invoice::where('user_id',auth()->user()->id)
                                    ->whereDate('created_at',now())
                                    ->sum('total_amount'),
//            'payback' => Invoice::where('who_paid_back',auth()->user()->name)
//                                  ->whereDate('date_payback',now())
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
