<?php

namespace App\Http\Livewire\Prediction;

use Livewire\Component;
use App\Models\Prediction;
use Livewire\WithFileUploads;
use App\Imports\PredictionImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class Create extends Component
{
    use WithFileUploads;
    public $predictions, $file_excel;
    public  $checkPrediction;
    public  $existingItems;
    public  $newItems;
    public  $iteration;
    public function render()
    {
        return view('livewire.prediction.create');
    }

    protected $listeners = ['refreshComponent' => '$refresh'];
    public function preview()
    {
        $this->predictions = Excel::toArray(new PredictionImport, $this->file_excel->store('temp'));

        $this->predictions = array_slice($this->predictions[0], 0);
    }

    public function valideOrinvalidateItem($item)
    {
    }

    public function clear()
    {
        $this->reset('existingItems', 'newItems');
    }
    public function import()
    {
        $this->existingItems = collect([]);
        $this->newItems = collect([]);

        //   dd($this->predictions, count($this->predictions));
        // try {
        foreach ($this->predictions as $i => $prediction) {
            // recherche si le contenaire existe, la colonne peut parfois être null
            $item = Prediction::where('partenaire', str_replace(" ", '', strtoupper($this->predictions[$i]['partenaires'])))
                ->where('container_number', str_replace(" ", '', strtoupper($this->predictions[$i]['n_conteneur'])))
                ->where('loader', strtoupper($this->predictions[$i]['chargeur']))
                ->where('operation', strtoupper($this->predictions[$i]['operations']))
                ->first();

            if ($item)
                $this->existingItems->push($item);
            

            if (!$item) {
                $prediction = Prediction::create([
                    'partenaire' => $this->predictions[$i]['partenaires'],
                    'tractor'     => str_replace(
                        " ",
                        '',
                        strtoupper($this->predictions[$i]['vehicules'])
                    ),
                    'trailer'    => str_replace(
                        " ",
                        '',
                        strtoupper($this->predictions[$i]['remorques'])
                    ),
                    'container_number' => str_replace(
                        " ",
                        '',
                        strtoupper($this->predictions[$i]['n_conteneur'])
                    ),
                    'seal_number'    => array_key_exists('nplomb', $this->predictions[$i]) ? $this->predictions[$i]['nplomb'] : $this->predictions[$i]['n_plomb'],
                    'loader'    => strtoupper($this->predictions[$i]['chargeur']),
                    'product'    => strtoupper($this->predictions[$i]['produit']),
                    'user_id' => auth()->user()->id,
                    'weighing_status' => 'En attente',
                    'operation' => strtoupper($this->predictions[$i]['operations']),
                ]);
                $this->newItems->push($prediction);
            }
        }
        $this->reset('predictions', 'file_excel');
        $this->iteration++;
        // } catch (\Throwable $e) {
        //      Log::error($e->getMessage());
        //      $this->iteration ++;
        //      $this->file_excel = "";
        //      session()->flash('error', 'Une erreur c\'est produite veuillez vérifier l\'entête de votre fichier excel');
        // }
    }
}
