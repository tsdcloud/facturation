<?php

namespace App\Http\Livewire\Invoice;


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
           $typeWeighing = null,
           $type = null,
           $test = null,
           $hiddenCustomer = "",
           $hiddenTractor = "",
           $hiddenTrailer = "",
           $selectedTrailer = null;

    public bool  $isRefunded = false ;

    public array $tractors = [],
                 $trailers = [],
                 $customers = []
                ;

    public int   $selectedTractor = 0,
                 $selectedCustomer = 0,
                 $highlightIndex = 0,
                 $highlightIndexTrailer = 0,
                 $highlightIndexCustomer = 0,
                    $bridge_id = 0;

    public bool  $showDropdown1 = true,
                 $showDropdown2 = true,
                 $showDropdown3 = true;

    public function render()
    {
        return view('livewire.invoice.create',[
            'modePayments' => ModePayment::all()->reject(function($mode){
                return $mode->label == "Virement Bancaire";}),

            'recups' => Customer::where('label','like', '%' . strtoupper($this->trailer). '%')->first(),
            'bridges' => Weighbridge::whereIn('label', ['P18', 'P19'])->get()

            ]);
    }

    //customer
    public function hideDropdown1()
    {
        $this->showDropdown1 = false;
    }
    //tractor
   public function hideDropdown2()
    {
        $this->showDropdown2 = false;
    }
   //trailer
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
            $this->showDropdown2 = true;
            $this->tractor = $tractor['label'];
            $this->selectedTractor = $tractor['id'];

            // on masque la liste group
            $this->hiddenTractor = "hidden";
        }
    }
    public function selectTrailer($id = null)
    {
        $id = $id ?: $this->highlightIndexTrailer;

        $trailer = $this->trailers[$id] ?? null;

        if ($trailer) {
            $this->showDropdown3 = true;
            $this->trailer = $trailer['label'];
            $this->selectedTrailer = $trailer['id'];

            // on masque la liste group
            $this->hiddenTrailer = "hidden";
        }
    }

    public function selectCustomer($id = null)
    {
        $id = $id ?: $this->highlightIndexCustomer;

        $customer = $this->customers[$id] ?? null;

        if ($customer) {
            $this->showDropdown1 = true;
            $this->customer = $customer['label'];
            $this->selectedCustomer = $customer['id'];

            // on masque la liste group
            $this->hiddenCustomer = "hidden";
        }
    }

    public function updatedTractor()
    {
        //en cas de modification on l'affiche
        $this->hiddenTractor = "";
            $this->tractors = Tractor::where('label', 'like', '%' . strtoupper($this->tractor). '%')
                    ->take(4)
                    ->get()
                    ->toArray();



    }

    public function updatedTrailer()
    {
        //en cas de modification on l'affiche
        $this->hiddenTrailer = "";

        $this->trailers = Trailer::where('label', 'like', '%' . strtoupper($this->trailer). '%')
            ->take(4)
            ->get()
            ->toArray();

    }

    public function updatedCustomer()
    {
        //en cas de modification on l'affiche
        $this->hiddenCustomer = "";

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
        $this->bridge_id = $bridge->id;
        $this->listTypeWeighing = TypeWeighing::all()->reject(function ($type){
            return $type->label =='Direction';
        });

    }

    public function updatedTypeWeighing()
    {

        if($this->typeWeighing == ""){
            $this->reset(['tax_amount','subtotal','total_amount']);
            return 0;
        }
        
        $this->type = TypeWeighing::where('id',$this->typeWeighing)->first();

        $this->subtotal = $this->type->price;
        $this->tax_amount = $this->type->tax_amount;
        $this->total_amount = $this->type->total_amount;

        if ($this->amountPaid != "" )
            $this->remains =  $this->amountPaid - $this->total_amount;

    }

    public function updatedAmountPaid(){

        if ($this->amountPaid != "" )
            $this->remains =  $this->amountPaid - $this->total_amount;
    }

    public function updatedisRefunded(){

            if ($this->isRefunded)
            $this->remains = 0;

            if (!$this->isRefunded)
                $this->remains =  $this->amountPaid - $this->total_amount;
        }
    public function updated(){

        if ($this->amountPaid == "")
             $this->remains = 0;

        if ($this->bridge_id == "")
           return 0;
    }

    protected $rules = [
        'customer' => 'required',
        'tractor' => 'required',
        // 'trailer' => 'required',
        'modePaymentId' => 'required',
        'amountPaid' => 'required',
        'typeWeighing' => 'required',
    ];

    protected $messages = [
        'customer.required' => 'veuillez saisir le nom du client',
        'tractor.required' => 'veuillez saisir le numero du tracteur',
        // 'trailer.required' => 'veuillez saisir le numero de la remorque',
        'modePaymentId.required' => 'veuillez selectionner le mode de paiment',
        'amountPaid.required' => 'veuillez saisir le montant',
        'typeWeighing.required' => 'veuillez selectionner la pesée',

    ];

    public function store(){
        $this->validate();

        try{

            if (!$this->isRefunded){
                DB::beginTransaction();
                     InvoiceService::storeInvoice($this->subtotal,
                                                     $this->tax_amount,
                                                     $this->total_amount,
                                                     $this->modePaymentId,
                                                     $this->bridge_id,
                                                     $this->amountPaid,
                                                     $this->remains,
                                                     auth()->id(),
                                                     $this->selectedTractor,
                                                     $this->selectedCustomer,
                                                     $this->type->id,
                                                     $this->isRefunded,
                                                     $this->selectedTrailer,
                                                     false
                                                    );

                    session()->flash('message', 'facture enregistrée avec succès.');
                    $this->emptyField();
            DB::commit();
            }
            
            if ($this->isRefunded){
                DB::beginTransaction();
                   $this->id_invoice =  InvoiceService::storeInvoice($this->subtotal,
                                                     $this->tax_amount,
                                                     $this->total_amount,
                                                     $this->modePaymentId,
                                                     $this->bridge_id,
                                                     $this->amountPaid,
                                                     $this->remains,
                                                     auth()->id(),
                                                     $this->selectedTractor,
                                                     $this->selectedCustomer,
                                                     $this->type->id,
                                                     $this->isRefunded,
                                                     $this->selectedTrailer,
                                                     false
                                                    );

                    session()->flash('message', 'facture enregistrée avec succès.');
                    $this->dispatchBrowserEvent('closeAlert');
                    $this->emptyField();
            DB::commit();
            }
            
        }catch(\Exception $e){
                    Log::error(sprintf('%d'.$e->getMessage(), __METHOD__));
                    session()->flash('error', 'Une erreur c\'est produite, veuillez actualiser le navigateur et essayer à nouveau.
                    Rapprochez vous d\'un IT en service si necessaire.');
                    DB::rollBack();
        }
    }

    public function cancelCustomer(){

        $this->customer = '';
    }
    public function cancelTractor(){

        $this->newTractor = "";
    }
    public function cancelTrailer(){

        $this->newTrailer = "";
    }

    public function storeTractor(){

            if ($this->newTractor == "")
                return 0;
        try {
           $data = Tractor::create(['label' => strtoupper($this->newTractor)]);
            $this->newTractor = "";
            $this->tractors[] = $data;

            session()->flash('new-tractor', 'Tracteur enregistré avec succès.');

        }catch (\Illuminate\Database\QueryException $e){

            if ($e->getCode() == 23505)
                session()->flash('error-tractor', 'vous essayez d\'ajouter un client qui existe déjà, si besoin actualiser le navigateur.');

            if ($e->getCode() != 23505)
                session()->flash('error-tractor', 'une erreur est survenu, veuillez actualiser le navigateur si besoin rapprochez-vous d\'un IT.');
        }
        catch(\Exception $e){
            session()->flash('error-tractor', 'une erreur est survenu, veuillez actualiser le navigateur si besoin rapprochez-vous d\'un IT.');
        }

    }

    public function storeTrailer(){

        try {

            if ($this->newTrailer == "")
                return 0;

            $data = Trailer::create(['label'=> strtoupper($this->newTrailer)]);
            $this->newTrailer = "";
            $this->trailers[] = $data;
            session()->flash('new-trailer', 'remorque enregistré avec succès.');
        }catch (\Illuminate\Database\QueryException $e){

            if ($e->getCode() == 23505)
                session()->flash('error-trailer', 'vous essayez d\'ajouter un client qui existe déjà, si besoin actualiser le navigateur.');

            if ($e->getCode() != 23505)
                session()->flash('error-trailer', 'une erreur est survenu, veuillez actualiser le navigateur si besoin rapprochez-vous d\'un IT.');
        }
        catch(\Exception $e){
            session()->flash('error-trailer', 'une erreur est survenu, veuillez actualiser le navigateur si besoin rapprochez-vous d\'un IT.');
        }

    }

    public function storeCustomer(){

        try {
            if ($this->newCustomer == "")
                return 0;

            $data = Customer::create(['label'=> strtoupper($this->newCustomer)]);
            $this->newCustomer = "";
            $this->customers[] = $data;
            session()->flash('new-customer', 'client enregistré avec succès.');

        }catch (\Illuminate\Database\QueryException $e){

            if ($e->getCode() == 23505)
                  session()->flash('error-customer', 'vous essayez d\'ajouter un client qui existe déjà, si besoin actualiser le navigateur.');

            if ($e->getCode() != 23505)
                session()->flash('error-customer', 'une erreur est survenu, veuillez actualiser le navigateur si besoin rapprochez-vous d\'un IT.');
        }
        catch(\Exception $e){
            session()->flash('error-customer', 'une erreur est survenu, veuillez actualiser le navigateur si besoin rapprochez-vous d\'un IT.');
        }
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
        $this->selectedTrailer = null;
        $this->selectedCustomer = 0;
        $this->showDropdown = true;
        $this->showDropdown2 = true;
        $this->showDropdown3 = true;
        $this->typeWeighing = null;
        $this->total_amount = 0;
        $this->isRefunded = false;
    }
}
