<?php

namespace Database\Seeders;

use App\Models\Cuota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CuotasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $c1 = new Cuota();
        $c1->respuesta="NO";
        $c1->save();

        $c1 = new Cuota();
        $c1->respuesta="SI";
        $c1->save();
    }
}
