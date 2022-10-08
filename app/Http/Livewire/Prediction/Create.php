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
   
    }

    public function valideOrinvalidateItem($item){

    }

    public function import(){

        for ($i=0; $i < count($this->predictions); $i++) {

                Prediction::create([
                    'partenaire' => $this->predictions[$i]['n_conteneur'],
                    'tractor'     => $this->predictions[$i]['vehicules'],
                    'trailer'    => $this->predictions[$i]['remorques'], 
                    'container_number'    => $this->predictions[$i]['n_conteneur'], 
                    'seal_number'    => array_key_exists('nplomb',$this->predictions[$i]) ? $this->predictions[$i]['nplomb'] : $this->predictions[$i]['n_plomb'], 
                    'loader'    => $this->predictions[$i]['chargeur'], 
                    'product'    => $this->predictions[$i]['produit'], 
                    'user_id' => auth()->user()->id,
                    'operation' => $this->predictions[$i]['operations']
                ]);
              
          }
        $this->reset('predictions','file_excel');
        $this->iteration++;
    }
}
