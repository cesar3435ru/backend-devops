<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Administrador
        $user1 = new User();
        $user1->nue = "SEBAS12345";
        $user1->password = "Cesar1234*";
        $user1->rol_id = 1;
        $user1->save();

        //Agremiado
        $user2 = new User();
        $user2->nue = "CESAR12345";
        $user2->password = "Cesar1234*";
        $user2->rol_id = 2;
        $user2->save();
    }
}
