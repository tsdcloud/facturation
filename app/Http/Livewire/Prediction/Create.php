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

    public function mount(){
        $this->existingItems = collect([]);
    }

    public function updating(){
       // dd($this->existingItems);
        $this->existingItems = $this->existingItems;
    }
    protected $listeners = ['refreshComponent' => '$refresh'];
    public function preview(){

      //  $path = $this->file_excel->store('temp');
      $this->predictions = Excel::toArray(new PredictionImport, $this->file_excel->store('temp'));   

       $this->predictions = array_slice( $this->predictions[0],0);
   
    }

    public function valideOrinvalidateItem($item){

    }

    public function import(){
        
        
        for ($i=0; $i < count($this->predictions); $i++) {

            $item = Prediction::where('container_number',str_replace(" ",'',strtoupper($this->predictions[$i]['n_conteneur'])), )->exists();

            if ($item){
                $existItem = Prediction::where('container_number',str_replace(" ",'',strtoupper($this->predictions[$i]['n_conteneur'])), )->first();
                $this->existingItems->push($existItem);
            }

            if (!$item) {
                $prediction = Prediction::create([
                    'partenaire' => $this->predictions[$i]['partenaires'],
                    'tractor'     => str_replace(" ",'',
                            strtoupper($this->predictions[$i]['vehicules'])),
                    'trailer'    => str_replace(" ",'',
                                    strtoupper($this->predictions[$i]['remorques'])), 
                    'container_number' => str_replace(" ",'',
                                        strtoupper($this->predictions[$i]['n_conteneur'])), 
                    'seal_number'    => array_key_exists('nplomb',$this->predictions[$i]) ? $this->predictions[$i]['nplomb'] : $this->predictions[$i]['n_plomb'], 
                    'loader'    => strtoupper($this->predictions[$i]['chargeur']) , 
                    'product'    => strtoupper($this->predictions[$i]['produit']) , 
                    'user_id' => auth()->user()->id,
                    'weighing_status' => 'En attente',
                    'operation' => strtoupper($this->predictions[$i]['operations']),
                ]);
                //$this->newItems = $this->newItems->push($prediction);
            }
        }     
       // dd($this->existingItems);
        $this->reset('predictions','file_excel');
        $this->iteration++;
   }

   public function add($id){
   // dd($this->existingItems->firstWhere('id',$id));
   // session()->flash('message', 'Post successfully updated.');
    //$item = $this->existingItems->firstWhere('id',$id);
    Prediction::create($this->existingItems->firstWhere('id',$id));
    $this->existingItems->pull($id);
    $this->existingItems->all();
   // $this->emit('refreshComponent');
    //dd($item);
   }
}