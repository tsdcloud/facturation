<?php

namespace App\Http\Livewire;

use App\Models\invoice;
use Livewire\Component;

class ListInvoices extends Component
{
    public function render()
    {
        return view('livewire.list-invoices',[
            'invoices' => invoice::paginate(10),
        ]);
    }
}
