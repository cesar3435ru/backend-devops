<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agremiados', function (Blueprint $table) {
            $table->id();
            $table->string('a_paterno',40);
            $table->string('a_materno',40);
            $table->string('nombre',50);
            $table->foreign('genero')->references('id')->on('generos');
            $table->unsignedBigInteger('genero');
            $table->string('nup',10); //Numero unico del patron
            $table->foreign('nue')->references('id')->on('users');
            $table->unsignedBigInteger('nue');
            $table->string('rfc',13)->unique();
            $table->string('nss',11)->unique();
            $table->date('f_nacimiento');
            $table->string('telefono',20)->unique(); //+52 1 951 345 67 89
            $table->foreign('cuota')->references('id')->on('cuotas');
            $table->unsignedBigInteger('cuota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agremiados');
    }
};
