<?php

namespace App\Http\Livewire\Report;


use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Report extends Component
{
    public  $users,
        $user_id,
        $startDate = '',
        $endDate = '',
        $invoices,
        $cancelledInvoices,
        $numberCashMoney,
        $numberMobileMoney,
        $numberRemains,
        $startHour,
        $endHour,
        $paybacks;

    public bool $shift_22 = false;

    public ?int $number_invoice;
    public ?float $cashMoney, $totalValue,  $mobileMoney, $numberCancelledInvoice, $amountCancelledInvoice, $total_amount, $payback, $excessAmount;

    public function render()
    {
        return view('livewire.report.report');
    }

    public function updating($name, $value)
    {

        if ($name === 'shift_22') {
            if (!$this->shift_22) {
                $this->invoices = null;
                $this->user_id = null;
                $this->startDate = null;
                $this->endDate = null;
            }
        }
    }

    public function mount()
    {

        $this->users = User::where('role', 'user')
            ->orWhere('role', 'support')
            ->orWhere('role', 'account')
            ->get();
    }

    public function search(): void
    {

        try {

            if ($this->startDate == "" || $this->endDate == "") {
                exit;
            }

            if (auth()->user()->isChefGuerite())
                $this->user_id = auth()->user()->id;

            if ($this->shift_22) {
                $start = new \DateTime($this->startDate . $this->startHour);
                $end = new \DateTime($this->endDate . $this->endHour);
            } else {
                $start = Carbon::createFromFormat('Y-m-d', $this->startDate)->startOfDay();
                $end = Carbon::createFromFormat('Y-m-d', $this->endDate)->endOfDay();
            }

            // affiche moi seulement
            $this->invoices = Invoice::where('user_id', $this->user_id)
                ->whereBetween('created_at', [$start, $end])
                ->get();

            $this->total_amount = $this->invoices->sum('amount_paid');
            $amounts = $this->invoices->sum('total_amount');

            $this->number_invoice = $this->invoices->count();

            //montant espèce
            $this->cashMoney = Invoice::where('user_id',  $this->user_id)
                ->where('mode_payment_id', 2) //Espèce
                ->where('status_invoice', 'validated')
                ->whereBetween('created_at', [$start, $end])
                ->sum('total_amount');
            //nombre d'espèce en cash
            $this->numberCashMoney =  Invoice::where('user_id',  $this->user_id)
                ->where('mode_payment_id', 2) //Espèce
                ->where('status_invoice', 'validated')
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $this->mobileMoney = Invoice::where('user_id',  $this->user_id)
                ->where('mode_payment_id', 1) //Paiement mobile
                ->where('status_invoice', 'validated')
                ->whereBetween('created_at', [$start, $end])
                ->sum('total_amount');

            $this->numberMobileMoney = Invoice::where('user_id',  $this->user_id)
                ->where('mode_payment_id', 1) //Paiement mobile
                ->where('status_invoice', 'validated')
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $this->amountCancelledInvoice = Invoice::where('user_id', $this->user_id)
                ->where('status_invoice', 'cancelling')
                ->whereBetween('created_at', [$start, $end])
                ->sum('total_amount');

            $amountTotalCancelledInvoice = Invoice::where('user_id', $this->user_id)
                ->where('status_invoice', 'cancelling')
                ->whereBetween('created_at', [$start, $end])
                ->sum('amount_paid');

            $this->numberCancelledInvoice = Invoice::where('user_id', $this->user_id)
                ->where('status_invoice', 'cancelling')
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $this->cancelledInvoices = Invoice::where('user_id', $this->user_id)
                ->where('status_invoice', 'cancelling')
                ->whereBetween('created_at', [$start, $end])
                ->get();

            //            nombre de remboursement
            $this->payback = Invoice::where('who_paid_back_id', $this->user_id)
                ->where('status_invoice', 'validated')
                ->whereBetween('date_payback', [$start, $end])
                ->sum('remains');

            //            collections de remboursement
            $this->paybacks = Invoice::where(function ($query) use ($start, $end) {
                $query->where('who_paid_back_id', $this->user_id);
                $query->whereBetween('date_payback', [$start, $end]);
            })
                ->orWhere(function ($q) use ($start, $end) {
                    $q->where('status_invoice', 'validated');
                    $q->whereBetween('created_at', [$start, $end]);
                })
                ->where('status_invoice', 'validated')
                ->where('user_id', $this->user_id)
                ->get();

            $this->excessAmount = Invoice::where('isRefunded', false)
                ->where('user_id', $this->user_id)
                ->where('status_invoice', 'validated')
                ->whereBetween('created_at', [$start, $end])
                ->sum('remains');

            $this->numberRemains = Invoice::where('who_paid_back_id', $this->user_id)
                ->where('status_invoice', 'validated')
                ->whereBetween('date_payback', [$start, $end])
                ->count();

            $recp = $this->total_amount - $amounts;

            $this->total_amount -= $this->payback;
            $this->totalValue = $this->total_amount - $amountTotalCancelledInvoice - $recp;
        } catch (\Exception) {

            session()->flash('error-trailer', 'une erreur est survenu, veuillez actualiser le navigateur');
        }
    }


    public function renitialize(): void
    {

        $this->reset(['startDate', 'endDate', 'invoices', 'startHour', 'endHour']);
    }
    public function exportCG()
    {

        // $recup = InvoiceService::export($this->invoices,$this->cashMoney,$this->mobileMoney,$this->total_amount,'preview');

        //    dd($recup);
        //        return response()->download(storage_path($recup));
    }
}
