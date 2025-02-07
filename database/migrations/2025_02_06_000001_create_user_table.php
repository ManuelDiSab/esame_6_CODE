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
        Schema::create('ruoli', function(Blueprint $table){
            $table->id('idRuolo');
            $table->string('ruolo',45);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id('idUser');
            $table->unsignedBigInteger("idRuolo")->unsigned()->default(1);  
            $table->string('utente',256);
            $table->string('nome',45);
            $table->string('cognome',45);
            $table->unsignedTinyInteger('status')->unsigned()->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',255);
            $table->string('salt',256);
            $table->string('secretJWT',256);
            $table->integer('inizioSfida');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("idRuolo")->references("idRuolo")->on("ruoli");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruoli');
        Schema::dropIfExists('users');
    }
};
