<?php

namespace App\Imports;

use App\Models\Prediction;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
class PredictionImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         /**
          * ! ajouter le created_at 
         */
        // row ce sont les lignes excel
        // dd($row);
        return new Prediction([
           'partenaire'     => $row['partenaires'],
           'tractor'     => $row['vehicules'],
           'trailer'    => $row['remorques'], 
           'container_number'    => $row['n_conteneur'], 
           'seal_number'    => $row['nplomb'], 
           'loader'    => $row['chargeur'], 
           'product'    => $row['produit'], 
           'user_id' => auth()->user()->id,
           'operation' => $row['operations'],
           'weighing_status' => 'En attente',
           'created_at' => now(),
           'updated_at' => now(),
        ]);
        // return new Prediction([
        //     'partenaire'     => $row['partenaires'],
        //     'tractor'     => $row['vehicules'],
        //     'trailer'    => $row['remorques'], 
        //     'container_number'    => $row['n_conteneur'], 
        //     'seal_number'    => $row['nplomb'], 
        //     'loader'    => $row['chargeur'], 
        //     'product'    => $row['produit'], 
        //     'user_id' => auth()->user()->id,
        //     'operation' => $row['operations'],
        //     'head_guerite_entry' => $row['noms_chefs_guerite'],
        //     'guerite_entry' => $row['guerite_entree'],
        //     'date_weighing_entry' => $row['date_pesee_entree'],
        //     'weighing_in' => $row['pesee_entree'],
        //     'head_geurite_output' => $row['nom_chef_de_geurite_sortie'],
        //     'geurite_output' => $row['guerite_sortie'],
        //     'date_weighing_output' => $row['date_pesee_sortie'],
        //     'weighing_status' => $row['statut_de_la_pesee'],
        //  ]);
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
