<?php

namespace App\Http\Livewire\Invoice;

use Livewire\Component;
use App\Models\ModePayment;
use App\Models\Weighbridge;
use Illuminate\Support\Facades\App;
use App\Models\invoice as ModelsInvoice;
use App\Http\Controllers\InvoiceController;

class Invoice extends Component
{
    public ?string $name = null, $tractor = null, $trailer = null, $searchTrailerandTractorNumFac = null;
    public bool $isDisabled = false;
    public ?int $modePaymentId = null, $weighbridgeId = null, $amountPaid = null, $remains =null;
    // public ?int $remains = null;
    public function render()
    {
        return view('livewire.invoice.invoice',[
            'modePayments' => ModePayment::all(),
            'weighbridges' => Weighbridge::all(),
            'invoices' => ModelsInvoice::all(),
            'dailyInvoices' => ModelsInvoice::whereDay('created_at',date('d'))
                                           ->where(function($query){
                                               $query->where('tractor','LIKE',"%{$this->searchTrailerandTractorNumFac}%");
                                               $query->orWhere('trailer','LIKE',"%{$this->searchTrailerandTractorNumFac}%");
                                               $query->orWhere('invoice_no','LIKE',"%{$this->searchTrailerandTractorNumFac}%");
                                           })
                                           ->orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }

    protected $rules = [
        'name' => 'required',
        'tractor' => 'required',
        'trailer' => 'required',
        'modePaymentId' => 'required',
        'weighbridgeId' => 'required',
        'amountPaid' => 'required',
    ];
    protected $messages =[
        'name.require' => 'le nom est obligatoire',
        'tractor.require' => 'le tracteur est obligatoire',
        'trailer.require' => 'la remorque est obligatoire',
        'modePaymentId.require' => 'choisissez le mode de paiement',
        'weighbridgeId.require' => 'choisissez le pont bascule',
        'amountPaid.require' => 'veuillez entrer le montant',
    ];

    public function store() {
      
        $this->validate();
        
        $data = ModelsInvoice::create([
            'name'=> $this->name,
            'invoice_no' => '001',
            'tractor'=> $this->tractor,
            'trailer'=> $this->trailer,
            'mode_payment_id'=> $this->modePaymentId,
            'weighbridge_id'=> $this->weighbridgeId,
            'amount_paid'=> $this->amountPaid,
            'remains'=> $this->remains ?? 0 ,
            'user_id'=> auth()->id(),
        ]);
        $this->reset(['name','tractor','trailer','modePaymentId','weighbridgeId','amountPaid','weighbridgeId','remains']);
        session()->flash('message', 'Transaction enregistreé avec succès.');
        $this->dispatchBrowserEvent('closeAlert');
        // return redirect()->action([InvoiceController::class, 'pdf']);
      
    }

    public function disabledBouton(): bool {
        if ($this->amountPaid && $this->weighbridgeId 
           && $this->modePaymentId && $this->tractor && 
           $this->trailer) {
            return true;
        }
            return false;
    }
}
