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
        Schema::create('contatto_sessioni', function (Blueprint $table) {
            $table->id('idSessione');
            $table->unsignedBigInteger('idUser')->unsigned();
            $table->string('token',500);
            $table->integer('inizioSessione');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("idUser")->references("idUser")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contatto_sessioni');
    }
};
