<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\EpisodiStoreRequest;
use App\Http\Requests\v1\EpisodiUpdateRequest;
use App\Http\Resources\v1\EpisodiCollection;
use App\Http\Resources\v1\EpisodiResource;
use App\Models\episodi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class episodiController extends Controller
{
     /**
     * Display a listing of the resource.
     * 
     * @return JsonResource
     */
    public function index($idSerie){
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                // $resource = episodi::where('idSerie',$idSerie)->get();
                $request = request('stagione');
                if($request){
                    $resource = episodi::all()->where('stagione','=',$request);
                    return new EpisodiCollection($resource);
                }else{
                    $resource = DB::table('episodi')->where('idSerie','=',$idSerie)->get();
                    return new EpisodiCollection($resource);   
                }
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function show($idSerie, $episodio)
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $resource = episodi::where('idSerie',$idSerie)->where('idEpisodio',$episodio)->first();
                $ep = new EpisodiResource($resource);
                return $ep;
            }
        }
    }
    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return JsonResource
     */
    public function store(EpisodiStoreRequest $request){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $data = $request->validated();
                $resource = episodi::create($data);

                $new =  new EpisodiResource($resource);
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
    public function update(EpisodiUpdateRequest $request,episodi $episodio){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $data = $request->validated();
                $episodio -> fill($data);
                $episodio->save();
                $new = new EpisodiResource($episodio); 
                return $data;
                // return response()->json(["risorsa" => $new], 200);  
            }
        }
    }

    /**
     * Elimina una risorsa
     * 
     * @param integer $idSerie 
     * @return 
     */
    public function destroy($idEpisodio){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $Episodio = episodi::findOrFail($idEpisodio);
                $Episodio->delete();

                return response()->json(['message'=>'Episodio eliminato con successo'],204);
            }
        }
    }
}
