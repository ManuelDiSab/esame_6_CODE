<?php


namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelpers;
use App\Http\Controllers\Controller;
use App\Models\Configurazione;
use App\Models\Configurazioni;
use App\Models\contattiAccessi;
use App\Models\ContattoSessioni;
use App\Models\Crediti;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccessoController extends Controller
{


    /**
     * Create a new AuthController instance
     *
     * @return void
     */



    public function login($user, $hash = null)
    {
        if ($hash == null) {
            return AccessoController::controlloUtente($user);
        } else {
            return AccessoController::ControlloPassword($user, $hash);
        }
    }





    /**
     * GEt JWT via given credentials
     *
     * @return Illuminate\Http\JsonResponse
     */


    protected static function controlloUtente($user)
    {
        $salt = hash('sha512', trim(Str::random(200)));
        if (User::where("utente", $user)->first() != null) {
            $utente = User::where('utente', $user)->first();
            $utente->inizioSfida = time();
            $utente->secretJWT =  hash('sha512', trim(Str::random(256)));
            $utente->salt = $salt;
            $utente->save();
            // return response()->json(["message" => "utente trovato, ritorno del sale", "salt" => $salt]);
        } else {
            $salt = hash('sha512', trim(Str::random(200)));
            $dati = array('salt'=>$salt);
            return AppHelpers::rispostaCustom(($dati));
        }
        $dati = array("salt" => $salt);
        return AppHelpers::rispostaCustom($dati);
    }
    protected static function ControlloPassword($user, $hash)
    {
        if (User::EsisteUtenteValidoPerIlLogin($user)) {
            $utente = User::where('utente', $user)->first();
            $secret = $utente->secretJWT;
            $inizioSfida = $utente->inizioSfida;
            $durataSfida = Configurazioni::LeggiValore('durataSfida');
            $maxTentativi = Configurazioni::LeggiValore('maxLoginErrati');
            $scadenzaSfida = $inizioSfida + $durataSfida;

            if (time() < $scadenzaSfida) {

                $tentativi = contattiAccessi::contaTentativi($utente->idUser);

                if ($tentativi < $maxTentativi - 1) {
                    $password = $utente->password;
                    $salt = $utente->salt;

                    $pswNascostaDB = AppHelpers::nascondiPassword($password, $salt);

                    if ($hash == $pswNascostaDB) {
                        $token = AppHelpers::creaTokenSessione($utente->idUser, $secret);
                        contattiAccessi::eliminaTentativi($utente->idUser);
                        $accesso = contattiAccessi::aggiungiAccesso($utente->idUser);

                        ContattoSessioni::eliminaSessione($utente->idUser);
                        ContattoSessioni::aggiornaSessione($utente->idUser, $token);
                        $dati = array('tk' => $token, 'message' => 'accesso eseguito');
                        return AppHelpers::rispostaCustom($dati);
                    } else {
                        contattiAccessi::addFailedAttempt($utente->idUser);
                        abort(403, "E004");
                    }
                } else {
                    return abort(403, "Too many attempted failed (E003)");
                }
            } else {
                contattiAccessi::addFailedAttempt($utente->idUser);
                abort(403, "E002");
            }
        }else {
                abort(404, "User not found (E001");
            }
    }
    /**
     * Funzione per registrare un utente
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validatore = Validator::make($request->all(), [
            'nome' => 'required|string|between:2,30',
            'cognome' => 'required|string|between:2,30',
            'utente' => 'required|string|min:6',
            'password' => 'required|string|confirmed|min:6',
            'dataNascita' => 'date|required',
            'sesso' => 'between:0,1|required', // 1 maschio, 0 femmina

        ]);
        if ($validatore->fails()) {
            return response()->json($validatore->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
            $validatore->validated(),
            ['password' => hash('sha512', ($request->password))],
            ['utente' => hash('sha512', ($request->utente))],
            ['salt' => hash('sha512', trim(Str::random(200)))],
            ['secretJWT' => hash('sha512', trim(Str::random(256)))],
        ));
        $id = $user->idUser;
        return response()->json([
            'message' => 'Utente creato con successo',
            'utente' => $user,
        ], 201);
    }
    /**
     * Funzione per il Logout (invalida il token)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logout effettuato con successo']);
    }

    /**
     * 
     */
    public static function verificaToken($token)
    {
        $rit = null;
        $sessione = ContattoSessioni::datiSessione($token);
        if ($sessione != null) {
            $inizioSessione = $sessione->inizioSessione;
            $durataSessione = Configurazioni::LeggiValore('durataSessione');
            $scadenzaSessione = $inizioSessione + $durataSessione   ;
            if (time() < $scadenzaSessione) {
                $auth = User::where('idUser', $sessione->idUser)->first();
                if ($auth != null) {
                    $jwt = $auth->secretJWT;
                    $payload = AppHelpers::validaToken($token, $jwt, $sessione);
                    if ($payload != null) {
                        $rit = $payload;
                    } else {
                        abort(403, "ERRORE TOKEN 6");
                    }
                } else {
                    abort(403, "ERRORE TOKEN 5");
                }
            } else {
                abort(403, "ERRORE TOKEN 4");
            }
        } else {
            abort(403, "ERRORE TOKEN 3");
        }
        return $rit;
    }
}
