<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ComuniStoreRequest;
use App\Http\Requests\v1\ComuniUpdateRequest;
use App\Http\Resources\v1\ComuniCollection;
use App\Http\Resources\v1\ComuniResource;
use App\Models\Comuni;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ComuniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {      
        $nome = request('nome');
                if($nome){
                    $comuni = Comuni::where('nome','like',"{$nome}%")
                    ->take(5)->get();
                    return new ComuniCollection($comuni);
                }else{
                    $comuni = DB::table('comuni')
                    ->orderBy('nome', 'asc')
                    // ->limit(100)
                    ->get();
                    return new ComuniCollection($comuni);
                    // return null;
                }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ComuniStoreRequest $request)
    {
        if (Gate::allows('admin')) {
            if (Gate::allows('attivo')) {
                $data = $request->validated();
                $comune = comuni::create($data);

                $new = new ComuniResource($comune);
                return response()->json(["nuova risorsa"=> $new],201);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($comune)
    {
                $comune = Comuni::where('nome','like', "%{$comune}%")
                ->get(['idComune','nome','siglaAuto']);
                if($comune) {
                    return $comune;
                }else if($comune == '' || $comune == null){
                    return null;
                }
    }

    /**
     * Funzione oer ritornare l'elenco delle province senza ripetizioni
     */
    public function showProvincia($comune){
                $province = DB::table('comuni')->where('nome', $comune)->get('siglaAuto');
                return $province;
    }

    /**
     * Funzione oer ritornare l'elenco delle province senza ripetizioni
     */
    public function siglaAutoCollection(){

                $province = DB::table('comuni')->orderBy('siglaAuto','asc')->distinct()->get('siglaAuto');
                return AppHelpers::rispostaCustom($province);
    }


    /**
     * Update the specified resource in storage.
     * 
     */
    public function update(ComuniUpdateRequest $request,Comuni $comune)
    {
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $data = $request->validated();
                $comune -> fill($data);
                $comune->save();
                $new = new ComuniResource($comune); 
 
                return response()->json(["risorsa" => $new], 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idComune)
    {
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $comune = Comuni::find($idComune);

                if($comune){
                    $comune->delete();
                    return response()->json(["message"=> 'Comune cancellato correttamente'],200);
                }else{
                    return response()->json(['message' => 'Comune non trovato'], 404);
                }
            }
        }
    }                                                                                                 
}

