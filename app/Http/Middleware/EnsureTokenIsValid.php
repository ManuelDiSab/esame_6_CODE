<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\v1\AccessoController;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken(); 
        // $token = $_SERVER['PHP_AUTH_PW']; //--> Da un errore di tipo 500 sia su server che sul client 
        // $token = $_SERVER['HTTP_AUTHORIZATION'];
        // $token = trim(str_replace('Bearer','',$token)); //-->funziona sul lato server ma se provato ad usare in anuglar da un 500 internal server error

        $payload = AccessoController::verificaToken($token);
        if($payload !== null)
        {
            $user = User::where('idUser',$payload->data->idUser)->first();
            if($user->status == 1){
            Auth::login($user);
            return $next($request); 
            }else{
                abort(403, "Error TK02");
            }
        }else{
            abort(403, "Error TK01");
        }
    }
}
