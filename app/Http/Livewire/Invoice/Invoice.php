<?php

namespace App\Http\Livewire\Invoice;

use App\Models\invoice as ModelsInvoice;
use App\Models\ModePayment;
use App\Models\Weighbridge;
use Livewire\Component;

class Invoice extends Component
{
    public ?string $name = null, $tractor = null, $trailer = null;

    public ?int $modePaymentId = null, $weighbridgeId = null,$userId = null, $amountPaid = null, $remains =null;
    // public ?int $remains = null;
    public function render()
    {
        return view('livewire.invoice.invoice',[
            'modePayments' => ModePayment::all(),
            'weighbridges' => Weighbridge::all(),
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

    public function store(): void {
        dd($this->remains);

        $this->validate();
        
        ModelsInvoice::create([
            'name'=> $this->name,
            'invoice_no' => '001',
            'tractor'=> $this->tractor,
            'trailer'=> $this->trailer,
            'mode_payment_id'=> $this->modePaymentId,
            'weighbridge_id'=> $this->weighbridgeId,
            'amount_paid'=> $this->amountPaid,
            'remains'=> $this->remains ?? 0 ,
        ]);
        //'user_id'=> "Alex GOBE",

        $this->reset(['name','tractor','trailer','modePaymentId','weighbridgeId','amountPaid','weighbridgeId','userId','remains']);
    }
}
