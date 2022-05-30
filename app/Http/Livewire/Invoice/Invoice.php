<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Tractor;
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
    public ?int $modePaymentId = null, $weighbridgeId = null, $tax_amount = 1925, $subtotal = 10000, $total_amount = 11925;
    public $amountPaid = null ,$remains = 0, $weighedTest = false, $url= null, $newTractor = null;

    public $query= '';
    public array $accounts = [];
    public int $selectedAccount = 0;
    public int $highlightIndex = 0;
    public bool $showDropdown;

    public function reset(...$properties)
    {
        $this->accounts = [];
        $this->highlightIndex = 0;
        $this->query = '';
        $this->selectedAccount = 0;
        $this->showDropdown = true;
    }

    public function hideDropdown()
    {
        $this->showDropdown = false;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->accounts) - 1) {
            $this->highlightIndex = 0;
            return;
        }

        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->accounts) - 1;
            return;
        }

        $this->highlightIndex--;
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

    public function updatedQuery()
    {
        $this->accounts = Tractor::where('label', 'like', '%' . $this->query. '%')
            ->take(5)
            ->get()
            ->toArray();
    }

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
           $this->remains =  $this->amountPaid - 11925;

        if ($this->amountPaid != "" && $this->weighedTest == true)
           $this->remains =  $this->amountPaid - 5962 ;

        if ($this->amountPaid == "")
           $this->remains = 0;

        if ($this->weighedTest){

            $this->subtotal = 5000;
            $this->tax_amount = 962;
            $this->total_amount = 5962;

        }

        if (!$this->weighedTest){

            $this->subtotal = 10000;
            $this->tax_amount = 1925;
            $this->total_amount = 11925;
        }

    }
    protected $rules = [
        'name' => 'required',
        'query' => 'required',
       // 'trailer' => 'required',
        'modePaymentId' => 'required',
        'weighbridgeId' => 'required',
        'amountPaid' => 'required',
    ];
    protected $messages =[
        'name.require' => 'le nom est obligatoire',
//        'tractor.require' => 'le tracteur est obligatoire',
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
           'name'=> strtoupper($this->name),
           'invoice_no' => str_pad(1,7,0,STR_PAD_LEFT),
           'trailer'=> strtoupper($this->query) ,
           'subtotal' => $this->subtotal,
           'tax_amount' => $this->tax_amount,
           'total_amount' => $this->total_amount,
           'mode_payment_id'=> $this->modePaymentId,
           'weighbridge_id'=> $this->weighbridgeId,
           'amount_paid'=> $this->amountPaid,
           'remains'=> $this->remains,
           'approved' => 'validated',
           'user_id'=> auth()->id(),
           'tractor_id'=> $this->selectedAccount,
       ]);
   }

       if (!is_null($lastId)){
           $data = ModelsInvoice::create([
               'name'=> strtoupper($this->name),
               'invoice_no' => str_pad($lastId->id + 1,7,0,STR_PAD_LEFT),
               'trailer'=> strtoupper($this->trailer),
               'subtotal' => $this->subtotal,
               'tax_amount' => $this->tax_amount,
               'total_amount' => $this->total_amount,
               'mode_payment_id'=> $this->modePaymentId,
               'weighbridge_id'=> $this->weighbridgeId,
               'amount_paid'=> $this->amountPaid,
               'remains'=> $this->remains,
               'approved' => 'validated',
               'user_id'=> auth()->id(),
               'tractor_id'=> $this->selectedAccount,
           ]);
       }

        $this->url = $data->id;


        $this->reset(['name','tractor','trailer','modePaymentId','weighbridgeId','amountPaid',
                     'weighbridgeId','remains','tax_amount','subtotal']);

        session()->flash('message', 'facture enregistreé avec succès.');

        $this->dispatchBrowserEvent('closeAlert');

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
        $this->url= null;
        $this->amountPaid = null;
        $this->tractor = null;
        $this->modePaymentId = null;
        $this->weighbridgeId = null;
        $this->remains = null;
        $this->weighedTest = false;
        $this->name = null;

        if (!$this->weighedTest){

            $this->subtotal = 10000;
            $this->tax_amount = 1925;
            $this->total_amount = 11925;
        }


    }

    public function storeTractor(){

        if ($this->newTractor == "")
            return 0;

        Tractor::create(['label' => strtoupper($this->newTractor)]);

        $this->newTractor = "";

        session()->flash('new-tractor', 'Tracteur enregistré avec succès.');
    }
}
