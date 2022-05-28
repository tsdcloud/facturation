<?php

namespace App\Http\Livewire\Invoice;

use Livewire\Component;
use App\Models\ModePayment;
use App\Models\Weighbridge;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\invoice as ModelsInvoice;
use App\Http\Controllers\InvoiceController;
use SebastianBergmann\Type\NullType;

class Invoice extends Component
{
    public ?string $name = null, $tractor = null, $trailer = null, $searchTrailerandTractorNumFac = null;
    public bool $isDisabled = false;
    public ?int $modePaymentId = null, $weighbridgeId = null;
    public $amountPaid = null ,$remains = 0, $weighedTest = false, $url= null, $newTractor;
    public function render()
    {
       
        return view('livewire.invoice.invoice',[
            'modePayments' => ModePayment::all(),
            'weighbridges' => Weighbridge::all(),
            'invoices' => ModelsInvoice::all(),
            'dailyInvoices' => ModelsInvoice::whereDay('created_at',date('d'))
                                              ->where('user_id',Auth::user()->id)
                                           ->where(function($query){
                                               $query->where('tractor','LIKE',"%{$this->searchTrailerandTractorNumFac}%");
                                               $query->orWhere('trailer','LIKE',"%{$this->searchTrailerandTractorNumFac}%");
                                               $query->orWhere('invoice_no','LIKE',"%{$this->searchTrailerandTractorNumFac}%");
                                           })
                                           ->orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }

    public function updated(){
        if ($this->amountPaid != "" && $this->weighedTest == false)
           $this->remains = 11925 - $this->amountPaid;

        if ($this->amountPaid != "" && $this->weighedTest == true)
           $this->remains = 5962.5 - $this->amountPaid;

        if ($this->amountPaid =="")
           $this->remains = 0;
        
    }
    protected $rules = [
        'name' => 'required',
        'tractor' => 'required',
       // 'trailer' => 'required',
        'modePaymentId' => 'required',
        'weighbridgeId' => 'required',
        'amountPaid' => 'required',
    ];
    protected $messages =[
        'name.require' => 'le nom est obligatoire',
        'tractor.require' => 'le tracteur est obligatoire',
        // 'trailer.require' => 'la remorque est obligatoire',
        'modePaymentId.require' => 'choisissez le mode de paiement',
        'weighbridgeId.require' => 'choisissez le pont bascule',
        'amountPaid.require' => 'veuillez entrer le montant',
    ];

    public function store() {

        $this->validate();
       $lastId = ModelsInvoice::latest('id')->first();
       if (is_null($lastId)){
       $data = ModelsInvoice::create([
           'name'=> $this->name,
           'invoice_no' => str_pad(1,10,0,STR_PAD_LEFT),
           'tractor'=> $this->tractor,
           'trailer'=> $this->trailer ,
           'mode_payment_id'=> $this->modePaymentId,
           'weighbridge_id'=> $this->weighbridgeId,
           'amount_paid'=> $this->amountPaid,
           'remains'=> !is_null($this->remains) ? $this->remains: 1,
           'user_id'=> auth()->id(),
       ]);
   }

       if (!is_null($lastId)){
           $data = ModelsInvoice::create([
               'name'=> $this->name,
               'invoice_no' => str_pad($lastId->id + 1,7,0,STR_PAD_LEFT),
               'tractor'=> $this->tractor,
               'trailer'=> $this->trailer ,
               'mode_payment_id'=> $this->modePaymentId,
               'weighbridge_id'=> $this->weighbridgeId,
               'amount_paid'=> $this->amountPaid,
               'remains'=> $this->remains ? $this->remains: 0 ,
               'user_id'=> auth()->id(),
           ]);
       }

    $this->url = $data->id;

        $this->reset(['name','tractor','trailer','modePaymentId','weighbridgeId','amountPaid','weighbridgeId','remains']);
        session()->flash('message', 'Transaction enregistreé avec succès.');
        $this->dispatchBrowserEvent('closeAlert');
       // $this->dispatchBrowserEvent('show-modal');

     //  $this->url = action([InvoiceController::class, 'pdf'], ['id' => $data->id]);

      // redirect()->route('show-pdf', ['id' => $data->id]);
       // dd($this->url);

    }

    public function disabledBouton(): bool {
        if ($this->amountPaid && $this->weighbridgeId
           && $this->modePaymentId && $this->tractor &&
           $this->trailer) {
            return true;
        }
            return false;
    }

    public function downloadPDF($id){

        $data = ModelsInvoice::where('id',$id)->first();
        InvoiceService::invoiceBuilder($data,'preview');
    }
    public function previewPDF($id){

        $data = ModelsInvoice::where('id',$id)->first();
        InvoiceService::invoiceBuilder($data, 'preview');
    }

    public function cancel(){
        $this->newTractor = "";
    }

    public function storeTractor(){
        
    }
}
