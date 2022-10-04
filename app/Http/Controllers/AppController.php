<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\prediction\TruckPassage;
use App\Models\Weighbridge;

class AppController extends Controller
{

    public function index(){
        $breadcrumb = "Prévisions";
        return view('prediction.all-predictions',compact('breadcrumb'));
    }

    public function prediction(){
        $breadcrumb = "Importation prévision";
        return view('prediction.create',compact('breadcrumb'));
     }

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

        $bridge = Weighbridge::where('id',auth()->user()->currentBridge)->first();
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
                    'weighbridge_entry' => $bridge->label,
                ]); 
               // Mail::to('alexgobe92@gmail.com')->send(new TruckPassage($prediction));
                session()->flash('success', 'apuré en entrée ok');
                return redirect()->to('/checkpoint/index');
        }
        $prediction = tap($prediction)->update([
            'head_guerite_entry' => auth()->user()->name,
            'guerite_entry' => $bridge->label,
            'date_weighing_entry' => now(),
            'weighing_in' => 'oui',
        ]);
    //    Mail::to('alexgobe92@gmail.com')->send(new TruckPassage($prediction));
        session()->flash('success', 'apuré en entrée ok');
        
        return redirect()->to('/search/container');
    }   

    public function exit(Prediction $prediction, String $param = null){

        $bridge = Weighbridge::where('id',auth()->user()->currentBridge)->first();

        if ($param != '' && $param === 'oui'){
            $prediction->update([
                'seen_exit_control' => 'oui',
               'name_controleur_ouput' => auth()->user()->name,
               'date_exit' => Carbon::now(),
              'weighbridge_exit' => $bridge->label,
            ]); 
            session()->flash('success', 'apuré en sortie ok');
            return redirect()->to('/checkpoint/index');
    }

        $prediction->update([
            'head_geurite_output' => auth()->user()->name,
            'geurite_output' => $bridge->label,
            'date_weighing_output' => now(),
            'weighing_out' => 'oui',
            'weighing_status' => 'Pesé',
        ]);

        session()->flash('success', 'apuré en sortie ok');
            return redirect()->to('/search/container');
    }
}
