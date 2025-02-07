<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\SerieTVStoreRequest;
use App\Http\Requests\v1\SerieTVUpdateRequest;
use App\Http\Resources\v1\collection\SerieTvCollection;
use App\Http\Resources\v1\SerieTvResource;
use App\Models\serieTv;
use Illuminate\Support\Facades\Gate;

class serieTvController extends Controller
{
 /**
     * Display a listing of the resource.
     * 
     * @return JsonResource
     */
    public function index(){
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $resource = serieTv::all();
                $serie = new SerieTvCollection($resource);
                return response()->json($serie, 200);
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function show( serieTv $serie)
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $resource = new SerieTvResource($serie);
                if($resource){
                    return response()->json($resource, 200);
                }else{
                    return response()->json(['message' => 'SerieTv non trovata'], 404);
                }
            }
        }
    }
    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return JsonResource
     */
    public function store(SerieTVStoreRequest $request){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $data = $request->validated();
                $resource = SerieTV::create($data);

                $new =  new SerieTvResource($resource);
                return response()->json(["nuova risorsa"=> $new],201);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param $idSerie 
     * @return JsonResource
     */
    public function update(SerieTVUpdateRequest $request, serieTv $serie){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $data = $request->validated();
                $serie -> fill($data);
                $serie->save();
                $new = new SerieTvResource($serie); 
 
                return response()->json(["risorsa" => $new], 200);  
            }
        }
    }

    /**
     * Elimina una risorsa
     * 
     * @param integer $idSerie 
     * @return 
     */
    public function destroy($idSerie){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $serie = serieTv::findOrFail($idSerie);
                $serie->delete();
                return response()->json(['message'=>'serie eliminata con successo'],204);
            }
        }
    }

}
