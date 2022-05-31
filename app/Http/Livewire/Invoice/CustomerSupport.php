<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Customer;
use App\Models\ModePayment;
use App\Models\Tractor;
use App\Models\Trailer;
use Livewire\Component;

class CustomerSupport extends Component
{
    public $newTractor =  null, $newTrailer = null, $newCustomer = null ;
    public function render()
    {

        return view('livewire.invoice.customer-support',[
            'modePayments' => ModePayment::all()->reject(function($mode){
                return $mode->label == "Virement Bancaire";
            }),
        ]);
    }

    public function storeTractor(){

        if ($this->newTractor == "")
            return 0;

        Tractor::create(['label' => strtoupper($this->newTractor)]);

        $this->newTractor = "";

        session()->flash('new-tractor', 'Tracteur enregistré avec succès.');
    }


    public function storeTrailer(){

        if ($this->newTrailer == "")
            return 0;

        Trailer::create(['label'=> strtoupper($this->newTrailer)]);
        $this->newTrailer = "";
        session()->flash('new-trailer', 'remorque enregistré avec succès.');
    }

    public function storeCustomer(){

        if ($this->newCustomer == "")
            return 0;

        Customer::create(['label'=> strtoupper($this->newCustomer)]);
        $this->newCustomer = "";
        session()->flash('new-customer', 'client enregistré avec succès.');
    }

    public function cancel(){
        $this->newTractor = "";
        $this->newTrailer = "";
        $this->newCustomer = "";


    }
}
