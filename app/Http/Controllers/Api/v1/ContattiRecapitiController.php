<?php

namespace App\Http\Controllers;

use App\Models\contatti_recapiti;
use Illuminate\Http\Request;
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
    public function show(contatti_recapiti $contatti_recapiti)
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $resource = new ($contatti_recapiti);
                if($resource){
                    return response()->json($resource, 200);
                }else{
                    return response()->json(['message' => 'Recapito non trovato'], 404);
                }
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, contatti_recapiti $contatti_recapiti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(contatti_recapiti $contatti_recapiti)
    {
        //
    }
}
