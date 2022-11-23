<?php

namespace App\Http\Livewire\Report;

use Carbon\Carbon;
use App\Models\Report;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Mail\report\ReportEmail;
use App\Models\Image;
use App\Models\Prediction;
use App\Models\Weighbridge;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CreateReport extends Component
{
    use WithFileUploads;
    public string $disciplinary_comment = "RAS",
        $incidental_comment = "RAS",
        $production_comment = "RAS",
        $shift = "",
        $type_report = "CG",
        $operator_name_one = "OPE 1",
        $operator_name_two = "OPE 2",
        $operator_hse_one = "HSE 1",
        $operator_hse_two = "HSE 2",
        $amount_pay = "",
        $subject = "",
        $startHour = "",
        $endHour = "";

    public int $number_incident = 0,
                $total_complete_weighing = 0,
                $total_complete_weighing_cash = 0,
                $total_complete_weighing_prepaid = 0,
                $total_complete_weighing_invoiced = 0,
                $total_incomplete_weighing = 0,
                $total_incomplete_weighing_cash = 0,
                $total_incomplete_weighing_prepaid = 0,
                $total_incomplete_weighing_invoiced = 0,
                $number_invoice_to_be_billed = 0,
                $total_number_weighings = 0,
                $number_cash_invoices = 0,
                $total_number_type_1_weighings = 0,
                $total_number_type_2_weighings = 0;

    public $incident, $bridge;
    public string $name = "";
    public $images = [];
    public bool $shift_22h = false;
    public $attachements = [];
    protected $rules = [
        'shift' => 'required',
    ];
    protected $messages = [
        'shift.required' => 'Veuillez selectionner votre shift',
    ];

    public function mount()
    {

        $start = new Carbon();
        $end = new Carbon();

        if (auth()->user()->shift === '22h30-06h30')
            $this->shift_22h = true;

        if (auth()->user()->shift != '22h30-06h30') {
            $this->amount_pay = Invoice::where('user_id',  3)
                ->where('mode_payment_id', 2) //Espèce
                ->where('status_invoice', 'validated')
                ->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])->sum('total_amount');
            $this->number_cash_invoices = Invoice::where('user_id', 3)
                ->where('mode_payment_id', 2) //Espèce
                ->where('status_invoice', 'validated')
                ->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])->count();
            $this->number_invoice_to_be_billed = Prediction::where('user_id', 3)
                ->orWhereBetween('date_weighing_entry', [$start->startOfDay(), $end->endOfDay()])
                ->orWhereBetween('date_weighing_output', [$start->startOfDay(), $end->endOfDay()])->count();
        }
    }
    public function render()
    {
        return view('livewire.report.create-report');
    }

    public function shift22h()
    {

        $start = new Carbon();
        $end = new Carbon();

        $this->amount_pay = Invoice::where('user_id',  3)
            ->where('mode_payment_id', 2) //Espèce
            ->where('status_invoice', 'validated')
            ->whereBetween('created_at', ['2022-09-06 00:00:00', '2022-10-07 00:00:00'])->sum('total_amount');
        $this->number_cash_invoices = Invoice::where('user_id', 3)
            ->where('mode_payment_id', 2) //Espèce
            ->where('status_invoice', 'validated')
            ->whereBetween('created_at', ['2022-09-06 00:00:00', '2022-10-07 00:00:00'])->count();
        $this->number_invoice_to_be_billed = Prediction::where('user_id', 3)
            ->orWhereBetween('date_weighing_entry', [$start->startOfDay(), $end->endOfDay()])
            ->orWhereBetween('date_weighing_output', [$start->startOfDay(), $end->endOfDay()])->count();
    }
    // public function updatedShift()
    // {
    //     $start = new Carbon();
    //     $end = new Carbon();
    //     //   $start = Carbon::createFromFormat('Y-m-d', today())->startOfDay();
    //     // $end = Carbon::createFromFormat('Y-m-d', '2022-09-21 09:44:44')->endOfDay();
    //     //  dd($date->startOfDay());

    //     $this->amount_pay = Invoice::where('user_id',  3)
    //         ->where('mode_payment_id', 2) //Espèce
    //         ->where('status_invoice', 'validated')
    //         ->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])
    //         ->sum('total_amount');
    //     $this->number_cash_invoices = Invoice::where('user_id', 3)
    //         ->where('mode_payment_id', 2) //Espèce
    //         ->where('status_invoice', 'validated')
    //         ->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])
    //         ->count();
    //     $this->number_invoice_to_be_billed = Prediction::where('user_id', 3)
    //         ->whereBetween('date_entry', [$start->startOfDay(), $end->endOfDay()])->count();
    // }
    public function save(): void
    {

       // dd('ok');
       // $this->validate();
        // try {

            $bridge = Weighbridge::where('id',auth()->user()->currentBridge)->first();
            $report = Report::create([

                'type_report' => $this->type_report,
                'disciplinary_comment' => $this->disciplinary_comment,
                'incidental_comment' => $this->incidental_comment,
                'production_comment' => $this->production_comment,
                'number_incident' => $this->number_incident,

                'total_complete_weighing' => $this->total_complete_weighing,
                'total_complete_weighing_prepaid' => $this->total_complete_weighing_prepaid,
                'total_complete_weighing_invoiced' => $this->total_complete_weighing_invoiced,
                'total_complete_weighing_cash' => $this->total_complete_weighing_cash,

                'operator_hse_one' => $this->operator_hse_one,
                'operator_hse_two' => $this->operator_hse_two,
                'operator_name_one' => $this->operator_name_one,
                'operator_name_two' => $this->operator_name_two,

                'number_cash_invoices' => $this->number_cash_invoices,
                'amount_pay' => $this->amount_pay,
                'number_invoice_to_be_billed' => $this->number_invoice_to_be_billed,
                'total_number_weighings' => $this->total_number_weighings,
                'subject' => $this->subject,
                'total_number_type_1_weighings' => $this->total_number_type_1_weighings,
                'total_number_type_2_weighings' => $this->total_number_type_2_weighings,
                'weighbridge' => $bridge->label,

                'total_incomplete_weighing' => $this->total_incomplete_weighing,
                'total_incomplete_weighing_prepaid' => $this->total_incomplete_weighing_prepaid,
                'total_incomplete_weighing_invoiced' => $this->total_incomplete_weighing_invoiced,
                'total_incomplete_weighing_cash' => $this->total_incomplete_weighing_cash,
                'shift' => $this->shift,
            ]);

            foreach ($this->images as $image) {
                Image::create([
                    'name' => $image->getClientOriginalName(),
                    'report_id' => $report->id,
                    'path' => $image->store('attachments/report', 'public'),
                ]);
            }
            Mail::to('alexgobe92@gmail.com')
                ->send(new ReportEmail($report, $report->images->toArray()));
            session()->flash('success', 'votre rapport a été enregistré avec succès');
            $this->reset([
                'shift', 'number_incident', 'production_comment',
                'disciplinary_comment', 'incidental_comment', 'images',
                'total_complete_weighing', 'total_complete_weighing_cash',
                'total_complete_weighing_prepaid', 'total_complete_weighing_invoiced',
                'total_incomplete_weighing', 'total_incomplete_weighing_cash',
                'operator_hse_one', 'operator_hse_two', 'operator_name_one', 'operator_name_two',
                'total_incomplete_weighing_prepaid', 'total_incomplete_weighing_invoiced'
            ]);

            $this->dispatchBrowserEvent('filepont');
            $this->dispatchBrowserEvent('closeAlert');
           
         
        // } catch (\Exception $e) {
        //     Log::error($e->getMessage());
        //     session()->flash('success', 'Une erreur c\'est produite veuillez actualiser');
        // }
    }
}
