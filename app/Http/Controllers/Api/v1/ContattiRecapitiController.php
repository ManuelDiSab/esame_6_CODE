<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\RecapitiUpdateRequest;
use App\Http\Resources\v1\RecapitiResource;
use App\Models\contatti_recapiti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ContattiRecapitiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                return response()->json(contatti_recapiti::get(),200);
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
    public function show()
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $user = Auth::user();
                $id = $user->idUser;
                $recapito = contatti_recapiti::where('idUser',$id)->first();
                return new RecapitiResource($recapito);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecapitiUpdateRequest $request, $id)
    {
        if(gate::allows('user')){
            if(Gate::allows('attivo')){
                $data = $request->validated();
                $resource = contatti_recapiti::where('idUser',$id)->first();
                $resource->fill($data);
                $resource->save();
                $new =  new RecapitiResource($resource);
                return response()->json(["nuova risorsa"=> $new],201);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(contatti_recapiti $contatti_recapiti)
    {
        //
    }
}
