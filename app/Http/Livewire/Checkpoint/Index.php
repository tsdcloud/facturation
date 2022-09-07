<?php

namespace App\Http\Livewire\Checkpoint;

use App\Models\Invoice;
use Livewire\Component;

class Index extends Component
{
    public $search;
    public function render()
    {
        $query = Invoice::where('date_exit',null);
        
        $query->whereHas('myTractor', function($query){
            $query->where('label','LIKE',strtoupper("%$this->search%") );
        })
        ->orWhereHas('myTrailer',function($query) {
            $query->where('label','LIKE',strtoupper("%$this->search%") );
            });
                  
        return view('livewire.checkpoint.index',[
            'invoices' => $query->get()
        ]);
    }
}
