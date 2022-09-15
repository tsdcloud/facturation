<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use Illuminate\Http\Request;

class AppController extends Controller
{


    public function edit(Prediction $prediction){

        $prediction = Prediction::where('id',$prediction->id)->first();

        
        if (is_null($prediction))
            throw new \Exception;

            $breadcrumb = "Détails";
            return view('apurement.detail', compact('breadcrumb', 'prediction'));
    }

    public function entry(Prediction $prediction){
        $prediction->update([
            'head_guerite_entry' => auth()->user()->name,
            'guerite_entry' => 'P10',
            'date_weighing_entry' => now(),
            'weighing_in' => 'oui',
        ]);

        session()->flash('success', 'apuré en entrée ok');
            return redirect()->to('/search/container');
    }   

    public function exit(Prediction $prediction){
        $prediction->update([
            'head_geurite_output' => auth()->user()->name,
            'geurite_output' => 'P10',
            'date_weighing_output' => now(),
            'weighing_out' => 'oui',
            'weighing_status' => 'Pesé',
        ]);

        session()->flash('success', 'apuré en sortie ok');
            return redirect()->to('/search/container');
    }
}
