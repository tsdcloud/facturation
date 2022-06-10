<?php

namespace App\Http\Livewire;

use App\Models\invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListInvoices extends Component
{
    public $search_invoice_no_tractor_trailer;

    public function render()
    {
        return view('livewire.list-invoices',[
            'invoices' => invoice::where(function($query){
                $query->where('invoice_no','LIKE',"%{$this->search_invoice_no_tractor_trailer}%");
                $query->where('user_id', auth()->user()->id);
                $query->where('status_invoice','validated');
            })->orderBy('created_at','DESC')->paginate(2),
        ]);
    }
}
