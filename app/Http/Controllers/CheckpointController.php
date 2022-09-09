<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CheckpointController extends Controller
{
    public function index(){
        $breadcrumb = "Contrôle camion";
        return view('checkpoint.index',compact('breadcrumb'));
    }

    public function edit(Invoice $invoice){

        $invoice = Invoice::where('id',$invoice->id)->first();

        if (is_null($invoice))
           throw new \Exception;

        $breadcrumb = "Détails";
        return view('checkpoint.detail',compact('breadcrumb','invoice'));
    }

    public function updateEntry(Invoice $invoice){
        $invoice = Invoice::where('id',$invoice->id)->first();

        if (is_null($invoice))
           throw new \Exception;

                $invoice->update([
                    'seen_entry_control' => 'oui',
                    'name_controleur_input' => auth()->user()->name,
                    'date_entry' => Carbon::now(),
                    'weighbridge_entry' => auth()->user()->currentBridge
                ]);
      
           return redirect()->to('/checkpoint/index');
    }

    public function updateExit(Invoice $invoice){
      
        $invoice = Invoice::where('id',$invoice->id)->first();

        if (is_null($invoice))
           throw new \Exception;

            $invoice->update([
                'seen_exit_control' => 'oui',
                'name_controleur_ouput' => auth()->user()->name,
                'date_exit' => Carbon::now(),
                'weighbridge_exit' => auth()->user()->currentBridge
            ]);
            return redirect()->to('/checkpoint/index');
       }

   
}
