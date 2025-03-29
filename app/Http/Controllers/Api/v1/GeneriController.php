<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\GeneriStoreRequest;
use App\Http\Requests\v1\GeneriUpdateRequest;
use App\Http\Resources\v1\GeneriCollection;
use App\Http\Resources\v1\GeneriResource;
use App\Models\generi;
use App\Models\serieTv;
use Illuminate\Support\Facades\Gate;

class GeneriController extends Controller
{
    /**
     * Funzione per prendere tutte le risorse
     * 
     */
    public function index(){
    if(Gate::allows('user')){
            // return response()->json(generi::all(),200);
            return new GeneriCollection(generi::all());
        }
    }

    /**
     * 
     * 
     */
    public function show($id){
        $resource = generi::where('idGenere',$id)
        ->get('nome')
        ->first();
        if($resource){
            return $resource;
        }else{
            return response()->json(['message' => 'Genere non trovato'], 404);
        }

    }

    /**
     * 
     * 
     */
    public function store(GeneriStoreRequest $request){
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $data = $request->validated();
                $resource = generi::create($data);

                $new =  new GeneriResource($resource);
                return response()->json(["nuova risorsa"=> $new],201);
            
            }
        }
    }
    /** 
    * Update the specified resource in storage.     
    * @param \Illuminate\Http\Request $request
    * @param $idGenere ID del genere 
    * @return JsonResource
    */
    public function update(GeneriUpdateRequest $request, $idGenere){

        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $data = $request->validated();
                $genere = generi::where('idGenere', $idGenere)->first();
                $genere -> fill($data);
                $genere->save();
                $new = new GeneriResource($genere); 
 
                return response()->json(["risorsa" => $new], 200);      
            }
        }
    }


    /**
     * 
     * 
     */
    public function destroy($idGenere){
        $genere = generi::find($idGenere);
        if($genere){
            $genere->delete();
            return response()->json(["message"=> 'genere cancellato correttamente'],200);
        }else{
            return response()->json(['message' => 'Genere non trovato'], 404);
        }
    }

}

