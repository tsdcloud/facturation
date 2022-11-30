<?php

namespace App\Http\Livewire\Report;

use App\Models\Report;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.report.index',[
            'reports' => Report::paginate(10),
        ]);
    }
}
