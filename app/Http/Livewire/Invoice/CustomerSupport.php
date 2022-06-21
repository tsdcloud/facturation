<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Tractor;
use App\Models\Trailer;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Customer;
use App\Models\ModePayment;
use App\Models\Weighbridge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\invoice as ModelsInvoice;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CustomerSupport extends Component
{
    public $newTractor =  null, $newTrailer = null, $newCustomer = null ;
    public ?int $modePaymentId = null, $weighbridgeId = null, $tax_amount = 1925, $subtotal = 10000, $total_amount = 11925;
    public $amountPaid = null ,$remains = 0, $id_invoice= null, $weighedTransit = null;

    public $query= '';
    public $trailer = '';
    public $customer = '';
    public array $accounts = [];
    public array $trailers = [];
    public array $customers = [];
    public int $selectedAccount = 0;
    public int $selectedTrailer = 0;
    public int $selectedCustomer = 0;
    public int $highlightIndex = 0;
    public int $highlightIndexTrailer = 0;
    public int $highlightIndexCustomer = 0;
    public bool $showDropdown = true;
    public bool $showDropdown2 = true;
    public bool $showDropdown3 = true;


    public function hideDropdown()
    {
        $this->showDropdown = false;
    }
    public function hideDropdown2()
    {
        $this->showDropdown2 = false;
    }

    public function hideDropdown3()
    {
        $this->showDropdown3 = false;
    }


    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->accounts) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }
    public function incrementHighlightTrailer()
    {
        if ($this->highlightIndexTrailer === count($this->trailers) - 1) {
            $this->highlightIndexTrailer = 0;
            return;
        }
        $this->highlightIndexTrailer++;
    }

    public function incrementHighlightCustomer()
    {
        if ($this->highlightIndexCustomer === count($this->customers) - 1) {
            $this->highlightIndexCustomer = 0;
            return;
        }
        $this->highlightIndexCustomer++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->accounts) - 1;
            return;
        }

        $this->highlightIndex--;
    }

    public function decrementHighlightTrailer()
    {
        if ($this->highlightIndexTrailer === 0) {
            $this->highlightIndexTrailer = count($this->trailers) - 1;
            return;
        }

        $this->highlightIndexTrailer--;
    }


    public function decrementHighlightCustomer()
    {
        if ($this->highlightIndexCustomer === 0) {
            $this->highlightIndexCustomer = count($this->customers) - 1;
            return;
        }

        $this->highlightIndexCustomer--;
    }


    public function selectAccount($id = null)
    {
        $id = $id ?: $this->highlightIndex;

        $account = $this->accounts[$id] ?? null;

        if ($account) {
            $this->showDropdown = true;
            $this->query = $account['label'];
            $this->selectedAccount = $account['id'];
        }
    }
    public function selectTrailer($id = null)
    {
        $id = $id ?: $this->highlightIndexTrailer;

        $trailer = $this->trailers[$id] ?? null;

        if ($trailer) {
            $this->showDropdown2 = true;
            $this->trailer = $trailer['label'];
            $this->selectedTrailer = $trailer['id'];
        }
    }

    public function selectCustomer($id = null)
    {
        $id = $id ?: $this->highlightIndexCustomer;

        $customer = $this->customers[$id] ?? null;

        if ($customer) {
            $this->showDropdown3 = true;
            $this->customer = $customer['label'];
            $this->selectedCustomer = $customer['id'];
        }
    }

    public function updatedQuery()
    {
        $this->accounts = Tractor::where('label', 'like', '%' . strtoupper($this->query). '%')
            ->take(5)
            ->get()
            ->toArray();

    }

    public function updatedTrailer()
    {
        $this->trailers = Trailer::where('label', 'like', '%' . strtoupper($this->trailer). '%')
            ->take(5)
            ->get()
            ->toArray();

    }

    public function updatedCustomer()
    {
        $this->customers = Customer::where('label', 'like', '%' . strtoupper($this->customer). '%')
            ->take(5)
            ->get()
            ->toArray();

    }




    public function render()
    {

        return view('livewire.invoice.customer-support',[
            'modePayments' => ModePayment::all()->reject(function($mode){
                return $mode->label == "Virement Bancaire";
            }),

        ]);
    }



    public function updated(){
        if ($this->amountPaid != "" && $this->weighedTransit == false)
            $this->remains =  $this->amountPaid - 11925;

        if ($this->amountPaid != "" && $this->weighedTransit == true)
            $this->remains =  $this->amountPaid - 8945 ;

        if ($this->amountPaid == "")
            $this->remains = 0;

        if ($this->weighedTransit){

            $this->subtotal = 7501;
            $this->tax_amount = 1443;
            $this->total_amount = 8945;

        }

        if (!$this->weighedTransit){

            $this->subtotal = 10000;
            $this->tax_amount = 1925;
            $this->total_amount = 11925;
        }


    }

    protected $rules = [
        'customer' => 'required',
        'query' => 'required',
        'trailer' => 'required',
        'modePaymentId' => 'required',
        'amountPaid' => 'required',
    ];

    protected $messages = [
        'customer.required' => 'veuillez saisir le nom du client',
        'query.required' => 'veuillez saisir le numero du tracteur',
        'trailer.required' => 'veuillez saisir le numero de la remorque',
        'modePaymentId.required' => 'veuillez selectionner le mode de paiment',
        'amountPaid.required' => 'veuillez saisir le montant',
    ];



    public function store() {

         $this->validate();

         try{
             DB::beginTransaction();
                 $this->id_invoice =  InvoiceService::storeInvoice($this->subtotal,
                                                                  $this->tax_amount,
                                                                  $this->total_amount,
                                                                  $this->modePaymentId,
                                                                  Auth::user()->currentBridge,
                                                                  $this->amountPaid,
                                                                  $this->remains,
                                                                  auth()->id(),
                                                                  $this->selectedAccount,
                                                                  $this->selectedTrailer,
                                                                  $this->selectedCustomer,
                                                                 true);

                $this->reset(['modePaymentId','weighbridgeId','amountPaid',
                    'weighbridgeId','remains','tax_amount','subtotal']);

                $this->accounts = [];
                $this->customers = [];
                $this->trailers = [];
                $this->highlightIndex = 0;
                $this->highlightIndexTrailer = 0;
                $this->highlightIndexCustomer = 0;
                $this->query = '';
                $this->trailer = '';
                $this->customer = '';
                $this->selectedAccount = 0;
                $this->selectedTrailer = 0;
                $this->selectedCustomer = 0;
                $this->showDropdown = true;
                $this->showDropdown2 = true;
                $this->showDropdown3 = true;

                session()->flash('message', 'Enregistré avec succès');

                $this->dispatchBrowserEvent('closeAlert');
        DB::commit();
         }catch(\Exception $e){
            Log::error(sprintf('%d'.$e->getMessage(), __METHOD__));
            session()->flash('error', 'Une erreur c\'est produite, veuillez actualiser le navigateur et essayer à nouveau.
            Rapprochez vous d\'un IT en service si necessaire.');
            DB::rollBack();
         }


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
