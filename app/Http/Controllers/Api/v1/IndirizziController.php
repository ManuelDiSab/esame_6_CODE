<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\indirizzoStoreRequest;
use App\Http\Requests\v1\indirizzoUpdateRequest;
use App\Http\Resources\v1\indirizziCollection;
use App\Http\Resources\v1\indirizziResource;
use App\Models\Indirizzo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IndirizziController extends Controller
{
    /**
     * Display a listing of the resource.
     *  
     * @return JsonResource
     */
    public function index()
    {
        if(Gate::allows('utente')){
            if(Gate::allows('attivo'))
            {   
                $user = Auth::user();
                $id= $user->idUser;
                return new indirizziCollection(Indirizzo::where('idUser',$id));
            }
        }
    }

    public function show( $idIndirizzo){
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $indirizzo = Indirizzo::where('idIndirizzo',$idIndirizzo)->first();
                $resource = new indirizziResource($indirizzo);
                return $resource;
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return JsonResource
     */
    public function store(indirizzoStoreRequest $request){
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $data = $request->validated();
                $resource = Indirizzo::create($data);
                $new =  new indirizziResource($resource);
                return response()->json(["nuova risorsa"=> $new],201);
            }
        }
    }
    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param $idIndirizzo 
     * @return JsonResource
     */
    public function update(indirizzoUpdateRequest $request,Indirizzo $indirizzo){
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $user = Auth::user();
                $id = $user->idUser;
                $data = $request->validated();
                $indirizzo = Indirizzo::where('idUser',$id);
                $indirizzo -> fill($data);
                $indirizzo->save();
                $new = new indirizziResource($indirizzo); 
                return response()->json(["risorsa" => $new], 200);    
                }                
            }
        }
    


    /**
     * 
     * 
     */
    public function destroy($idIndirizzo)
    {
        if(Gate::allows('user')){
            if(Gate::allows('admin')){
                $user = Auth::user();
                $id = $user->idUser;
                $indirizzo = Indirizzo::findOrFail($idIndirizzo);
                $verifica = $indirizzo->idUser;

                if($id === $verifica){
                    $indirizzo->delete();
                    return response()->json(["messagge"=>"Indirizzo eliminato con successso"], 204);
                }{
                    return "Non puoi effettuare questa azione";
                }
            }
        }
    }
}
