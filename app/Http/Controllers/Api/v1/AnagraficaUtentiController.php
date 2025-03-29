<?php

namespace  App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AnagraficaUtentiUpdateRequest;
use App\Http\Resources\v1\AnagraficaResource;
use App\Models\Anagrafica_utenti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AnagraficaUtentiController extends Controller
{
    /**
     * Funzione che ritona i dati anagrafici dell'utente connesso
     */
    public function index()
    {
        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $user = Auth::user();
                $id= $user->idUser;
                $rit = Anagrafica_utenti::where('idUser', $id)->get()->first();
                return new AnagraficaResource($rit);

            }else{
                return response()->json(['message' => 'Il tuo account non risulta attivo'], 403);
            }
        }else{
            return response()->json(['message' => 'Non sei autorizzato'], 403);
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
    public function show(Anagrafica_utenti $anagrafica_utenti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnagraficaUtentiUpdateRequest $request)
    {
        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $user = Auth::user();
                $id= $user->idUser;
                $data = $request->validated();
                $validato = User::findOrFail($id)->fill($data);
                $validato->save();
                $new = new AnagraficaResource($validato);
                return [
                    'messaggio' => 'Modifiche completate con successo',
                    'dati' => $new
                ];
            }
        }
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anagrafica_utenti $anagrafica_utenti)
    {
        //
    }
}
