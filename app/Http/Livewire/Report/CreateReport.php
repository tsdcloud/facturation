<?php

namespace App\Http\Livewire\Report;

use App\Mail\report\ReportEmail;
use App\Models\Report;
use Livewire\Component;
use App\Models\Attachment;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CreateReport extends Component
{
    use WithFileUploads;
    public string $disciplinary_comment = "",
                  $incidental_comment ="",
                  $production_comment ="",
                  $shift ="",
                  $type_report = "coordonnateur";

    public int $number_incident = 0,
               $total_complete_weighing = 0,
               $total_complete_weighing_cash = 0,
               $total_complete_weighing_prepaid = 0,
               $total_complete_weighing_invoiced = 0,
               $total_incomplete_weighing = 0,
               $total_incomplete_weighing_cash = 0,
               $total_incomplete_weighing_prepaid = 0,
               $total_incomplete_weighing_invoiced = 0
               ;
    public $incident, $bridge;
    public string $name = "";
    public $images = [];
    protected $rules = [
        'shift' => 'required',
    ];
    protected $messages = [
        'shift.required' => 'Veuillez selectionner votre shift',
    ];

    public function render()
    {
        return view('livewire.report.create-report');
    }

    public function save(): void {

       // dd($this->pictures);
        $this->validate();
       try {
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

                'total_incomplete_weighing' => $this->total_incomplete_weighing,
                'total_incomplete_weighing_prepaid' => $this->total_incomplete_weighing_prepaid,
                'total_incomplete_weighing_invoiced' => $this->total_incomplete_weighing_invoiced,
                'total_incomplete_weighing_cash' => $this->total_incomplete_weighing_cash,
                'shift' => $this->shift,
            ]);

            foreach ($this->images as $image) {
                Attachment::create([
                    'report_id' => $report->id,
                    'path' => $image->store('attachments/report','public'),
                ]);
            }

            session()->flash('success','votre rapport a été enregistré avec succès');
            $this->reset(['shift','number_incident','production_comment',
                'disciplinary_comment','incidental_comment','images',
                'total_complete_weighing','total_complete_weighing_cash',
                'total_complete_weighing_prepaid','total_complete_weighing_invoiced',
                'total_incomplete_weighing','total_incomplete_weighing_cash','total_incomplete_weighing_prepaid','total_incomplete_weighing_invoiced']);

                $this->dispatchBrowserEvent('filepont');
                $this->dispatchBrowserEvent('closeAlert');
                Mail::to('alexgobe92@gmail.com')->send(new ReportEmail($report));
       }catch (\Exception $e){
           Log::error($e->getMessage());
           session()->flash('success','Une erreur c\'est produite veuillez actualiser');
       }

    }
}
