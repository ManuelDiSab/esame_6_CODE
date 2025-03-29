<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\TipologiaIndirizzoStoreRequest;
use App\Http\Requests\v1\TipologiaIndirizzoUpdateRequest;
use App\Http\Resources\v1\TipologiaIndirizzoCollection;
use App\Http\Resources\v1\TipologiaIndirizzoResource;
use App\Models\TipologiaIndirizzi;
use Illuminate\Support\Facades\Gate;

class TipologiaIndirizziController extends Controller
{
    public function index()
    {
        $resource = TipologiaIndirizzi::all();
        return new TipologiaIndirizzoCollection($resource);
    }

    public function show(TipologiaIndirizzi $tipo){
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $resource = new TipologiaIndirizzoResource($tipo);
                if($resource){
                    return response()->json($resource, 200);
                }else{
                    return response()->json(['message' => 'Tipologia indirizzo non trovato non trovato'], 404);
                }
                return $resource;
            }
        }
    }

    public function store(TipologiaIndirizzoStoreRequest $request)
    {
        if (Gate::allows('admin')) {
            if (Gate::allows('attivo')) {
                $data = $request->validated();
                $tipoIndirizzo = TipologiaIndirizzi::create($data);

                return new TipologiaIndirizzoResource($tipoIndirizzo);
            }
        }
    }


    /**
     * Update the specifies resource
     * 
     * @param \Illuminate\Http\Request\v1\TipologiaIndirizzoUpdateRequest $request
     * @param \app\Models\TipologiaIndirizzi $idTipo
     * @return \Illuminate\Http\Response
     * 
     */
    public function update(TipologiaIndirizzoUpdateRequest $request, TipologiaIndirizzi $tipologia)
    {
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
               $data = $request->validated();
               $tipologia -> fill($data);
               $tipologia->save();
               return new TipologiaIndirizzoResource($tipologia); 
                
            }
        }
    }

    /** Funzione per eliminare la risorsa
     * 
     */
    public function destroy($idTipo)
    {
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $tipo = TipologiaIndirizzi::find($idTipo);

                if($tipo){
                    $tipo->delete();
                    return response()->json(["message"=> 'tipologia indirizzo cancellato correttamente'],200);
                }else{
                    return response()->json(['message' => 'tipologia indirizzo non trovato'], 404);
                }
            }
        }
    }
}
