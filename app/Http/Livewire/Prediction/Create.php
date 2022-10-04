<?php

namespace App\Http\Livewire\Prediction;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\PredictionImport;
use App\Models\Prediction;
use Maatwebsite\Excel\Facades\Excel;

class Create extends Component
{
    use WithFileUploads;
    public $predictions, $file_excel;
    public  $checkPrediction;
    public  $existingItems;
    public  $newItems ;
    public  $iteration ;
    public function render()
    {
        return view('livewire.prediction.create');
    }

    public function preview(){

      //  $path = $this->file_excel->store('temp');
      $this->predictions = Excel::toArray(new PredictionImport, $this->file_excel->store('temp'));   

       $this->predictions = array_slice( $this->predictions[0],0);
      //  dd($this->predictions);
      //  $this->checkPrediction = $this->predictions->toArray();
      //  dd(count($this->checkPrediction));
        // for ($i=0; $i < count($this->predictions); $i++) { 
        //   //  dd('ok');
        //       $item =  Prediction::where('container_number',$this->predictions[$i]['n_conteneur'])  
        //                ->first();
        //       if(!is_null($item)){
        //           $this->existingItems->push($item);
        //           dd($this->existingItems);
        //       }else $this->newItems[] = $item;
        // }
    }

    public function valideOrinvalidateItem($item){

    }

    public function import(){
        Excel::import(new PredictionImport, $this->file_excel->store('temp'));
        $this->reset('predictions','file_excel');
        $this->iteration++;
    }
}
