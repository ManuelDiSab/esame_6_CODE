<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ComuniStoreRequest;
use App\Http\Requests\v1\ComuniUpdateRequest;
use App\Http\Resources\v1\ComuniResource;
use App\Models\Comuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ComuniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                return response()->json(Comuni::limit(100)->get(
                ["nome","regione","cap","siglaAuto"]),200);
            }
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
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $comune = Comuni::where('nome',$comune)
                ->get()
                ->first();

                if($comune) {
                    return response()->json($comune, 200);
                }else{
                    return response()->json(['message' => 'Comune non trovato'], 404);
                }
            }
        }
    }

    /**
     * Update the specified resource in storage.
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

