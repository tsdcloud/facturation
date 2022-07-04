<?php

namespace App\Http\Livewire\Report;


use App\Models\Invoice;
use App\Models\User;
use App\Services\InvoiceService;
use Carbon\Carbon;
use Livewire\Component;

class Report extends Component
{
    public $users, $user_id, $startDate = '', $endDate = '', $invoices, $total_amount, $mobileMoney, $cancelledInvoice;
    public ?int $number_invoice;
    public float $cashMoney;

    public function render()
    {
        return view('livewire.report.report');
    }


    public function mount(){

        $this->users = User::all();
    }


    public function search(){

      if ($this->startDate =='' || $this->endDate == '' ){

          $this->invoices = Invoice::where('user_id',$this->user_id)
                                     ->get();

      }else{
          $start = Carbon::createFromFormat('Y-m-d',$this->startDate)->startOfDay();
          $end = Carbon::createFromFormat('Y-m-d', $this->endDate)->endOfDay();

          $this->invoices = Invoice::where('user_id',$this->user_id)
                                    ->whereBetween('created_at',[$start, $end])
                                    ->get();
      }

        $this->total_amount = $this->invoices->sum('total_amount');
        $this->number_invoice = $this->invoices->count();

    }

    public function searchCG(){

        if ($this->startDate == "" || $this->endDate == ""){
                return 0;
        }
        $start = Carbon::createFromFormat('Y-m-d',$this->startDate)->startOfDay();
        $end = Carbon::createFromFormat('Y-m-d', $this->endDate)->endOfDay();

        $this->invoices = Invoice::where('user_id',auth()->user()->id)
                                    ->whereBetween('created_at',[$start, $end])
                                    ->get();

        $this->total_amount = $this->invoices->sum('total_amount');
        $this->number_invoice = $this->invoices->count();

        $this->cashMoney = Invoice::where('user_id', auth()->user()->id)
                                    ->where('mode_payment_id',2)
                                     ->whereBetween('created_at',[$start, $end])
                                    ->sum('total_amount');

            $this->mobileMoney = Invoice::where('user_id', auth()->user()->id)
                                    ->where('mode_payment_id',1)
                ->whereBetween('created_at',[$start, $end])
                                    ->sum('total_amount');

            $this->cancelledInvoice = Invoice::where('user_id',auth()->user()->id)
                                    ->where('status_invoice','cancelling')
                ->whereBetween('created_at',[$start, $end])
                                    ->count();

    }

    public function exportCG(){

        $recup = InvoiceService::export($this->invoices,$this->cashMoney,$this->mobileMoney,$this->total_amount,'preview');

        dd($recup);
//        return response()->download(storage_path($recup));
    }
}
