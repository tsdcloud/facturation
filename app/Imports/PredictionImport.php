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
        // dd($row);
        return new Prediction([
            'tractor'     => $row['vehicules'],
           'trailer'    => $row['remorques'], 
           'container_number'    => $row['n_conteneur'], 
           'seal_number'    => $row['nplomb'], 
           'loader'    => $row['chargeur'], 
           'product'    => $row['produit'], 
        ]);
    }
}
