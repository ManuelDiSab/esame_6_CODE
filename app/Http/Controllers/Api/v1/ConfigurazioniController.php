<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelpers;
use App\Http\Controllers\Controller;
use App\Models\Configurazioni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConfigurazioniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                return response()->json(Configurazioni::get(),200);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $resource = Configurazioni::where('idConfig',$id)->FirstOrFail();
                if($resource){
                    return AppHelpers::rispostaCustom($resource, 'Configurazione trovata');
                }else{
                    return AppHelpers::rispostaCustom(null, 'Risorsa non trovata', 'errore 404');
                }
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Configurazioni $configurazioni)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Configurazioni $configurazioni)
    {
        //
    }
}
