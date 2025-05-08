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
        Schema::create('img_film', function (Blueprint $table) {
            $table->id('idFilmFoto');
            $table->unsignedBigInteger('idFilm')->unsigned();
            $table->string('path',150);
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('idFilm')->references('idFilm')->on('film');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('img_film');
    }
};
