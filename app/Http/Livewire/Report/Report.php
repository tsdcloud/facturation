<?php

namespace App\Http\Livewire\Report;

use App\Models\invoice;
use App\Models\User;
use Livewire\Component;

class Report extends Component
{
    public $users, $user_id, $startDate, $endDate, $invoices, $total_amount;
    public function render()
    {
        return view('livewire.report.report');
    }


    public function mount(){

        $this->users = User::all();
    }


    public function search(){

      $this->invoices = invoice::where('user_id',$this->user_id)
                ->whereBetween('created_at',[$this->startDate, $this->endDate])
                ->get();


     //  dd($this->invoices);
    $this->total_amount = $this->invoices->sum('total_amount');
    }
}
