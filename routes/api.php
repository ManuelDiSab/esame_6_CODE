<?php


use App\Http\Controllers\Api\v1\AbbonamentiController;
use App\Http\Controllers\Api\v1\AccessoController;
use App\Http\Controllers\Api\v1\ComuniController;
use App\Http\Controllers\Api\v1\ConfigurazioniController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\CreditiController;
use App\Http\Controllers\api\v1\episodiController;
use App\Http\Controllers\Api\v1\FilmController;
use App\Http\Controllers\Api\v1\GeneriController;
use App\Http\Controllers\Api\v1\IndirizziController;
use App\Http\Controllers\Api\v1\LingueController;
use App\Http\Controllers\api\v1\nazioniController;
use App\Http\Controllers\api\v1\serieTvController;
use App\Http\Controllers\Api\v1\TipologiaIndirizziController;
use App\Http\Controllers\Api\v1\TraduzioniController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Models\Configurazioni;
use Illuminate\Support\Facades\Route;


// Definisco una costante per le versione delle api
if (!defined("_VERS")) {
    define('_VERS', 'v1');
}

Route::post(_VERS . '/logout', [AccessoController::class, 'logout']);
Route::get(_VERS . '/accedi/{user}/{hash?}', [AccessoController::class, 'login']);
Route::post(_VERS . '/register', [AccessoController::class, 'register']);

//Api protette dall'autenticazione 
Route::middleware([EnsureTokenIsValid::class])->group(function () {
    //---------------------------------------------  SOLO ADMIN  -------------------------------------------------------
    #################################################################################################################################
    //Route per la gestione utenti
    Route::get(_VERS . '/profili', [UserController::class, 'indexAdmin']);
    Route::get(_VERS . '/profili/{idUser}', [UserController::class, 'showAdmin']);
    Route::put(_VERS . '/profili', [UserController::class, 'updateAdmin']);
    Route::delete(_VERS . '/profili/{idUser}', [UserController::class, 'destroyAdmin']);


    //Route per indirizzi e tipologie indirizzi
    Route::post(_VERS . '/Tipo-inidirizzo', [TipologiaIndirizziController::class, 'store']);
    Route::put(_VERS . '/Tipo-inidirizzo/{tipologia}', [TipologiaIndirizziController::class, 'update']);
    Route::delete(_VERS . '/Tipo-inidirizzo/{idTipo}', [TipologiaIndirizziController::class, 'destroy']);
    Route::get(_VERS . '/indirizzi', [IndirizziController::class, 'index']);
    Route::get(_VERS . '/indirizzi/{indirizzo}', [IndirizziController::class, 'show']);


    //Route per i comuni
    Route::put(_VERS . '/comuni/{idComune}', [ComuniController::class, 'update']);
    Route::delete(_VERS . '/comuni/{idComune}', [ComuniController::class, 'destroy']);

    // Route per la gestione dei film e delle serie tv
    Route::post(_VERS . '/genere', [GeneriController::class, 'store']);
    Route::post(_VERS . '/film', [FilmController::class, 'store']);
    Route::put(_VERS . '/film/{film}', [FilmController::class, 'update']);
    Route::delete(_VERS . '/film/{idFilm}', [FilmController::class, 'destroy']);
    Route::post(_VERS . '/serie', [serieTvController::class, 'store']);
    Route::put(_VERS . '/serie/{serie}', [serieTvController::class, 'update']);
    Route::delete(_VERS . '/serie/{idSerie}', [serieTvController::class, 'destroy']);
    Route::post(_VERS . '/episodi', [episodiController::class, 'store']);
    Route::put(_VERS . '/episodi/{episodio}', [episodiController::class, 'update']);
    Route::delete(_VERS . '/episodi/{idEpisodio}', [episodiController::class, 'destroy']);






    //---------------------------------------------  USERS & ADMIN  -------------------------------------------------------
    #################################################################################################################################

    // Route accessibili da user e amministratori
    //Route per i profili
    Route::put(_VERS . '/mio-profilo', [UserController::class, 'update']);
    Route::delete(_VERS . '/mio-profilo', [UserController::class, 'destroy']);
    Route::get(_VERS . '/mio-profilo', [UserController::class, 'show']);

    //Api per indirizzi e tipologia indirizzi
    Route::get(_VERS . '/Tipo-inidirizzo', [TipologiaIndirizziController::class, 'index']);
    Route::get(_VERS . '/Tipo-inidirizzo/{tipo}', [TipologiaIndirizziController::class, 'show']);
    Route::put(_VERS . '/indirizzi/{idIndirizzo}', [IndirizziController::class, 'update']);
    Route::post(_VERS . '/indirizzi', [IndirizziController::class, 'store']);
    Route::delete(_VERS . '/indirizzi/{idIndirizzo}', [IndirizziController::class, 'destroy']);

    //Route per i comuni e le nazioni
    Route::get(_VERS . '/comuni', [ComuniController::class, 'index']);
    Route::get(_VERS . '/comuni/{comune}', [ComuniController::class, 'show']);
    Route::get(_VERS . '/nazioni', [nazioniController::class, 'index']);
    Route::get(_VERS . '/nazioni/{id}', [nazioniController::class, 'show']);

    //Route per la gestione dei film e serie tv
    Route::get(_VERS . '/genere', [GeneriController::class, 'index']);
    Route::get(_VERS . '/genere/{genere}', [GeneriController::class, 'show']);
    Route::get(_VERS . '/film', [FilmController::class, 'index']);
    Route::get(_VERS . '/film/{film}', [FilmController::class, 'show']);
    Route::get(_VERS . '/serie', [serieTvController::class, 'index']);
    Route::get(_VERS . '/serie/{serie}', [serieTvController::class, 'show']);
    Route::get(_VERS . '/serie/{idSerie}/episodi', [episodiController::class, 'index']);
    Route::get(_VERS . '/serie/{idSerie}/{episodio}', [episodiController::class, 'show']);
});
