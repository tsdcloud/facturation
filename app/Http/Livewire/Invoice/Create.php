<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Invoice;
use App\Models\Tractor;
use App\Models\Trailer;
use App\Models\TypeWeighing;
use Livewire\Component;
use App\Models\Customer;
use App\Models\ModePayment;
use App\Models\Weighbridge;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public ?int
            $modePaymentId = null,
            $weighbridgeId = null,
            $tax_amount = 0,
            $subtotal = 0,
            $total_amount = 0;


    public $amountPaid = null ,
           $remains = 0,
           $weighedTest = false,
           $id_invoice= null,
           $newTractor = null,
           $newTrailer = null,
           $newCustomer = null,
           $tractor = '',
           $trailer = '',
           $customer = '',
           $weighbridge = null,
           $listTypeWeighing = null,
           $typeWeighing = null;

    public array $tractors = [],
                 $trailers = [],
                 $customers = [];

    public int   $selectedTractor = 0,
                 $selectedTrailer = 0,
                 $selectedCustomer = 0,
                 $highlightIndex = 0,
                 $highlightIndexTrailer = 0,
                 $highlightIndexCustomer = 0;

    public bool  $showDropdown = true,
                 $showDropdown2 = true,
                 $showDropdown3 = true;

    public function render()
    {
        return view('livewire.invoice.create',[
            'modePayments' => ModePayment::all()->reject(function($mode){
                return $mode->label == "Virement Bancaire";})
        ]);
    }

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
        if ($this->highlightIndex === count($this->tractors) - 1) {
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
            $this->highlightIndex = count($this->tractors) - 1;
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


    public function selectTractor($id = null)
    {
        $id = $id ?: $this->highlightIndex;

        $tractor = $this->tractors[$id] ?? null;

        if ($tractor) {
            $this->showDropdown = true;
            $this->tractor = $tractor['label'];
            $this->selectedTractor = $tractor['id'];
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

    public function updatedTractor()
    {
        $this->tractors = Tractor::where('label', 'like', '%' . strtoupper($this->tractor). '%')
                ->take(4)
                ->get()
                ->toArray();

    }

    public function updatedTrailer()
    {
        $this->trailers = Trailer::where('label', 'like', '%' . strtoupper($this->trailer). '%')
            ->take(4)
            ->get()
            ->toArray();

    }

    public function updatedCustomer()
    {
        $this->customers = Customer::where('label', 'like', '%' . strtoupper($this->customer). '%')
            ->take(7)
            ->get()
            ->toArray();

    }


    public function mount()
    {
        if(Auth::user()->isAdmin() || Auth::user()->isAdministration())
           return $this->weighbridge = '';

        $bridge = Weighbridge::where('id',Auth::user()->currentBridge)->first();
        $this->weighbridge = $bridge->label;

        $this->listTypeWeighing = TypeWeighing::all()->reject(function ($type){
            return $type->label =='Direction';
        });

    }

    public function updatedTypeWeighing()
    {


            $this->typeWeighing = TypeWeighing::where('id',$this->typeWeighing)->first();

            // dd($this->typeWeighing);
            $this->subtotal = $this->typeWeighing->price;
            $this->tax_amount = $this->typeWeighing->tax_amount;
            $this->total_amount = $this->typeWeighing->total_amount;

        if ($this->amountPaid != "" )
            $this->remains =  $this->amountPaid - $this->total_amount;

    }

    public function updatedAmountPaid(){

        if ($this->amountPaid != "" )
            $this->remains =  $this->amountPaid - $this->total_amount;
    }


    public function updated(){

        if ($this->amountPaid == "")
             $this->remains = 0;

    }


    protected $rules = [
        'customer' => 'required',
        'tractor' => 'required',
        'trailer' => 'required',
        'modePaymentId' => 'required',
        'amountPaid' => 'required',
        'typeWeighing' => 'required',
    ];

    protected $messages = [
        'customer.required' => 'veuillez saisir le nom du client',
        'tractor.required' => 'veuillez saisir le numero du tracteur',
        'trailer.required' => 'veuillez saisir le numero de la remorque',
        'modePaymentId.required' => 'veuillez selectionner le mode de paiment',
        'amountPaid.required' => 'veuillez saisir le montant',
    ];

    public function store(){
        $this->validate();
     //   dd($this->typeWeighing->id);
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
                                                     $this->selectedTractor,
                                                     $this->selectedTrailer,
                                                     $this->selectedCustomer,
                                                     $this->typeWeighing->id,
                                                     false
                                                    );

                    session()->flash('message', 'facture enregistreé avec succès.');
                    $this->dispatchBrowserEvent('closeAlert');
                    $this->emptyField();
                    DB::commit();
        }catch(\Exception $e){
                    Log::error(sprintf('%d'.$e->getMessage(), __METHOD__));
                    session()->flash('error', 'Une erreur c\'est produite, veuillez actualiser le navigateur et essayer à nouveau.
                    Rapprochez vous d\'un IT en service si necessaire.');
                    DB::rollBack();
                }
    }

    public function cancel(){


    }

    public function storeTractor(){

        if ($this->newTractor == "")
            return 0;

       $data = Tractor::create(['label' => strtoupper($this->newTractor)]);

        $this->newTractor = "";
        $this->tractors[] = $data;

        session()->flash('new-tractor', 'Tracteur enregistré avec succès.');
    }

    public function storeTrailer(){

        if ($this->newTrailer == "")
            return 0;

        $data = Trailer::create(['label'=> strtoupper($this->newTrailer)]);
        $this->newTrailer = "";
        $this->trailers[] = $data;
        session()->flash('new-trailer', 'remorque enregistré avec succès.');
    }

    public function storeCustomer(){

        if ($this->newCustomer == "")
            return 0;

        $data = Customer::create(['label'=> strtoupper($this->newCustomer)]);
        $this->newCustomer = "";
        $this->customers[] = $data;
        session()->flash('new-customer', 'client enregistré avec succès.');
    }

    protected function emptyField(){

        $this->reset(['tax_amount','subtotal']);

        $this->modePaymentId = null;
        $this->weighbridgeId = null;
        $this->amountPaid = null;
        $this->remains = null;
        $this->tractors = [];
        $this->customers = [];
        $this->trailers = [];
        $this->highlightIndex = 0;
        $this->highlightIndexTrailer = 0;
        $this->highlightIndexCustomer = 0;
        $this->tractor = '';
        $this->trailer = '';
        $this->customer = '';
        $this->selectedTractor = 0;
        $this->selectedTrailer = 0;
        $this->selectedCustomer = 0;
        $this->showDropdown = true;
        $this->showDropdown2 = true;
        $this->showDropdown3 = true;
        $this->typeWeighing = null;
    }
}
