<?php

namespace App\Http\Livewire\Export;

use App\Models\Invoice;
use Livewire\Component;

use function PHPUnit\Framework\returnSelf;

class Export extends Component
{
    public  $invoices;
    public function render()
    {
        return view('livewire.export.export');
    }

    public function mount(){
        $this->invoices =  Invoice::whereDate('created_at',now())
                                  ->where('status_invoice','validated')
                                  ->where('export',null)
                                  ->get();
    }

    public function markexport(){

        sleep(30);
        foreach($this->invoices as $invoice)
        {
            tap($invoice)->update(['export' => true]);
        }
    }
}
