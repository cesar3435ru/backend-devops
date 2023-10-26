<?php

namespace Database\Seeders;

use App\Models\Genero;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenerosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $g1 = new Genero();
        $g1->genero="MASCULINO";
        $g1->save();

        $g2 = new Genero();
        $g2->genero="FEMENINO";
        $g2->save();

        $g3 = new Genero();
        $g3->genero="PREFIERO NO DECIRLO";
        $g3->save();

       
    }
}
