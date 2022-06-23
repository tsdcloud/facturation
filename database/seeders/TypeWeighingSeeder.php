<?php

namespace Database\Seeders;

use App\Models\TypeWeighing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeWeighingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeWeighing::create([
            'id' => 1,
            'label' => 'Pesée normale',
            'price' => 10000,
            'tax_amount' => 1925,
            'total_amount' => 11925,
        ]);
        TypeWeighing::create([
            'id' => 2,
            'label' => 'Pesée test',
            'price' => 5000,
            'tax_amount' => 962,
            'total_amount' => 5962,
        ]);
        TypeWeighing::create([
            'id' => 3,
            'label' => 'Pesée test RCA/TCHAD',
            'price' => 3750,
            'tax_amount' => 721,
            'total_amount' => 3721,
        ]);
        TypeWeighing::create([
            'id' => 4,
            'type' => 'Direction',
            'label' => 'Pesée normale',
            'price' => 7500,
            'tax_amount' =>1443,
            'total_amount' => 8943,
        ]);


    }
}
