<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\NazioniCollection;
use App\Http\Resources\v1\NazioniResource;
use App\Models\Nazione;
use Illuminate\Support\Facades\Gate;

class nazioniController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if(Gate::allows('user')){
        //     if(Gate::allows('attivo')){
                $nazioni = Nazione::get()   ;
                return new NazioniCollection($nazioni);
                // return $nazioni;
    //     }
    // }
    }

    public function show(Nazione $nazione){
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $resource = new NazioniResource($nazione);
                if($resource) {
                    return response()->json($resource, 200);
                }else{
                    return response()->json(['message' => 'Nazione non trovata'], 404);
                }
            }
        }
    }
}
