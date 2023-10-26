<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol1 = new Role();
        $rol1->rol="ADMINISTRADOR";
        $rol1->descripcion="Gestiona y controla toda la aplicacion";
        $rol1->save();

        $rol2 = new Role();
        $rol2->rol="AGREMIADO";
        $rol2->descripcion="Registra solamente solicitudes";
        $rol2->save();
    }
}
