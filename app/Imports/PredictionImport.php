<?php

namespace App\Imports;

use App\Models\Prediction;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class PredictionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
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
           'weighing_status' => 'en attente',
        ]);
    }
}
