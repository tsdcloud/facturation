<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\prediction\TruckPassage;

class AppController extends Controller
{


    // afficher le détail du conteneur 
    public function edit(Prediction $prediction, String $param = null){
        $breadcrumb = "Détails";
        $prediction = Prediction::where('id',$prediction->id)->first();

       $controle = '';        
        if (is_null($prediction))
            throw new \Exception;
        
        if ($param != '' && $param === 'oui')
            return view('apurement.detail',compact('breadcrumb', 'prediction','param'));


            $breadcrumb = "Détails";
            return view('apurement.detail', 
            compact('breadcrumb', 'prediction'));
    }

    public function entry(Prediction $prediction, String $param = null){

        if ($param != '' && $param === 'oui'){

            // $prediction = tap($prediction)->update([
            //                 'seen_entry_control' => 'oui',
            //                 'name_controleur_input' => auth()->user()->name,
            //                 'date_entry' => Carbon::now(),
            //                 'weighbridge_entry' => 'P10',
            //               ]);
                $prediction->update([
                    'seen_entry_control' => 'oui',
                    'name_controleur_input' => auth()->user()->name,
                    'date_entry' => Carbon::now(),
                    'weighbridge_entry' => 'P10',
                ]); 
               // Mail::to('alexgobe92@gmail.com')->send(new TruckPassage($prediction));
                session()->flash('success', 'apuré en entrée ok');
                return redirect()->to('/checkpoint/index');
        }
        $prediction = tap($prediction)->update([
            'head_guerite_entry' => auth()->user()->name,
            'guerite_entry' => 'P10',
            'date_weighing_entry' => now(),
            'weighing_in' => 'oui',
        ]);
    //    Mail::to('alexgobe92@gmail.com')->send(new TruckPassage($prediction));
        session()->flash('success', 'apuré en entrée ok');
        
        return redirect()->to('/search/container');
    }   

    public function exit(Prediction $prediction, String $param = null){

        if ($param != '' && $param === 'oui'){
            $prediction->update([
                'seen_exit_control' => 'oui',
               'name_controleur_ouput' => auth()->user()->name,
               'date_exit' => Carbon::now(),
              'weighbridge_exit' => 'P10',
            ]); 
            session()->flash('success', 'apuré en sortie ok');
            return redirect()->to('/checkpoint/index');
    }

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
