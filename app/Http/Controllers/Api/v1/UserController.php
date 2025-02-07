<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UserUpdateRequest;
use App\Http\Resources\v1\collection\UserCollection;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UserController extends Controller
{

    /**
     * Funzione per mostrare la lista degli utenti
     */
    public function indexAdmin()
    {
        if (Gate::allows('admin')) {
            if (Gate::allows('attivo')) {
                $collection =  User::all();
                return new UserCollection($collection);
            } else {
                abort(403, "Il tuo account è disabilitato");
            }
        } else {
            abort(403, "Ops! Non sei autorizzato!");
        }
    }

    public function showAdmin(User $idUser)
    {
        if (Gate::allows('admin')) {
            if (Gate::allows('attivo')) {
                $user = new UserResource($idUser);
                if (! $user) {
                    return ["message" => "L'utente non esiste"];
                }
            } else {
                abort(403, "Il tuo account è disabilitato");
            }
        } else {
            abort(403, "Ops! Non sei autorizzato!");
        }
    }
    /**
     * mostra i dati dell'utente loggato
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return response()->json(Auth::user());
    }
    /**
     * 
     * 
     * 
     */
    public function update(UserUpdateRequest $request)
    {

        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $user = Auth::user();
                $id= $user->idUser;
                $data = $request->validated();
                $validato = User::findOrFail($id)->fill($data);
                $validato->save();
                $new = new UserResource($validato);
                return [
                    'messaggio' => 'Modifiche completate con successo',
                    'utente' => $new
                ];
            }
            }
        }
    

    /**
     * 
     * 
     * 
     */
    public function updateAdmin(UserUpdateRequest $request, User $idUser)
    {
        if (Gate::allows('admin')) {
            if (Gate::allows('attivo')) {
                if ($idUser) {
                    $data = $request->validated();
                    $idUser->fill($data);
                    $idUser->save();
                    $new = new UserResource($idUser);

                    return response()->json(["risorsa" => $new], 200);
                } else {
                    return response()->json(['message' => 'Utente non trovato'], 404);
                }
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function destroy()
    {
        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $user = Auth::user();
                $id = $user->idUser;

                $utente = User::findOrFail($id);
                $utente->delete();

                return response()->json([
                    "messaggio" => "Il tuo profilo è stato cancellato correttamente"
                ], 204);
            }
        }
    }
    /**
     * 
     * 
     * 
     */
    public function destroyAdmin(Request $request, $idUser)
    {
        if (Gate::allows('user')) {
            if (Gate::allows('attivo')) {
                $utente = User::findOrFail($idUser);
                $utente->delete();

                return response()->json([
                    "messaggio" => "Utente cancellato correttamente"
                ], 204);
            }
        }
    }
}
