<?php

namespace App\Http\Livewire\Invoice;

use App\Http\Controllers\InvoiceController;
use App\Models\Customer;
use App\Models\Tractor;
use App\Models\Trailer;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Models\ModePayment;
use App\Models\Weighbridge;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Auth;
use App\Models\invoice as ModelsInvoice;


class Invoice extends Component
{
    public ?string $name = null, $tractor = null, $searchTrailerandTractorNumFac = null;
    public bool $isDisabled = false;
    public ?int $modePaymentId = null, $weighbridgeId = null, $tax_amount = 1925, $subtotal = 10000, $total_amount = 11925;
    public $amountPaid = null ,$remains = 0, $weighedTest = false, $url= null, $newTractor = null, $newTrailer = null,
           $newCustomer = null;

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

//    public function reset(...$properties)
//    {
//        $this->accounts = [];
//        $this->trailers = [];
//        $this->highlightIndex = 0;
//        $this->highlightIndexTrailer = 0;
//        $this->highlightIndexCustomer = 0;
//        $this->query = '';
//        $this->trailer = '';
//        $this->selectedAccount = 0;
//        $this->selectedTrailer = 0;
//        $this->showDropdown = true;
//        $this->showDropdown2 = true;
//        $this->showDropdown3 = true;
//    }
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

        return view('livewire.invoice.invoice',[
            'modePayments' => ModePayment::all()->reject(function($mode){
                return $mode->label == "Virement Bancaire";}),
            'weighbridges' => Weighbridge::all(),
            'invoices' => ModelsInvoice::all(),
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
////        'name' => 'required',
//        'query' => 'required',
//       // 'trailer' => 'required',
        'modePaymentId' => 'required',
        'weighbridgeId' => 'required',
//        'amountPaid' => 'required',
    ];
//    protected $messages =[
////        'name.require' => 'le nom est obligatoire',
////        'tractor.require' => 'le tracteur est obligatoire',
//        // 'trailer.require' => 'la remorque est obligatoire',
//        'modePaymentId.require' => 'choisissez le mode de paiement',
//        'weighbridgeId.require' => 'choisissez le pont bascule',
//        'amountPaid.require' => 'veuillez entrer le montant',
//    ];

    public function store() {

      // $this->validate();
       $lastId = ModelsInvoice::latest('id')->first();

       if (is_null($lastId)){
       $data = ModelsInvoice::create([
//           'name'=> strtoupper($this->name),
           'invoice_no' => str_pad(1,7,0,STR_PAD_LEFT),
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
           'trailer_id' => $this->selectedTrailer,
           'customer_id' => $this->selectedCustomer,
       ]);
   }

       if (!is_null($lastId)){
           $data = ModelsInvoice::create([
//               'name'=> strtoupper($this->name),
               'invoice_no' => str_pad($lastId->id + 1,7,0,STR_PAD_LEFT),
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
               'trailer_id' => $this->selectedTrailer,
               'customer_id' => $this->selectedCustomer,
           ]);
       }

        $this->url = $data->id;

//        $path = action([InvoiceController::class, 'pdf'], ['id' => $data->id]);
//        $p = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->generate($path);
//        $output_file = '/img/img-' . time() . '.png';

      //$path = Storage::putFile('qrcode', $p);

//        Storage::disk('public')->put($output_file, $p);
       // dd(asset($output_file));
//        $recup = asset($output_file);
       // dd($recup);
//        tap($data)->update(['path_qrcode'=> $output_file]);
      //  dd($path);

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
        $this->newTrailer = "";
        $this->newCustomer = "";
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
}
