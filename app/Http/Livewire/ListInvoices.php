<?php

namespace App\Http\Livewire;

use App\Models\invoice;
use Livewire\Component;

class ListInvoices extends Component
{
    public $search_invoice_no_tractor_trailer;

    public function render()
    {
        return view('livewire.list-invoices',[
            'invoices' => invoice::where(function($query){
                    $query->where('invoice_no','LIKE',"%{$this->search_invoice_no_tractor_trailer}%");
            })->orderBy('created_at','DESC')->paginate(2),
        ]);
    }
}
