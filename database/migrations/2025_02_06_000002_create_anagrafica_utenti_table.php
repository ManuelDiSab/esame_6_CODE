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
        Schema::create('anagrafica_utenti', function (Blueprint $table) {
            $table->id('idAnag');
            $table->unsignedBigInteger('idUser')->unsigned();
            $table->unsignedBigInteger('idNazione')->unsigned();
            $table->string('cod_fis',50)->nullable();
            $table->date('dataNascita');
            $table->unsignedTinyInteger('sesso')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("idUser")->references("idUser")->on("users");
            $table->foreign('idNazione')->references('idNazione')->on('nazioni');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anagrafica_utenti');
    }
};
