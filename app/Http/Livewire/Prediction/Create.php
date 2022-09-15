<?php

namespace App\Http\Livewire\Prediction;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\PredictionImport;
use Maatwebsite\Excel\Facades\Excel;

class Create extends Component
{
    use WithFileUploads;
    public $predictions, $file_excel;
    public function render()
    {
        return view('livewire.prediction.create');
    }

    public function preview(){

      //  $path = $this->file_excel->store('temp');
      $this->predictions = Excel::toArray(new PredictionImport, $this->file_excel->store('temp'));   

       $this->predictions = array_slice( $this->predictions[0],0);
      //  dd($this->predictions);
    }

    public function import(){
        Excel::import(new PredictionImport, $this->file_excel->store('temp'));
        $this->reset('predictions','file_excel');

    }
}
