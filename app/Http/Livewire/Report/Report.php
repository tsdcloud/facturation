<?php

namespace App\Http\Livewire\Report;

use App\Models\User;
use Livewire\Component;

class Report extends Component
{
    public $users;
    public function render()
    {
        return view('livewire.report.report');
    }


    public function mount(){

        $this->users = User::all();
    }
}
