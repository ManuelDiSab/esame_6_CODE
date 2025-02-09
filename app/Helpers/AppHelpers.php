<?php

namespace App\Helpers;

use App\Models\Anagrafica_utenti;
use App\Models\Nazione;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AppHelpers{

    /**
     * Funzione per controllare se l'utente è admin
     * 
     * @param integer $idRuolo id del ruolo dell'utente passato
     * @return boolean
     */
    public static function isAdmin($idRuolo)
    {
        return ($idRuolo === 2) ? true : false;
    }

    /**
     * Funzione per non dover inserire tutte le voci quando si voole modificare una risorsa in una chiamata http POST
     * 
     * @param $rules parent request
     * @return array 
     */
    public static function AggiornaRegoleHelper($rules)
    {
        $newRules =array();
        foreach($rules as $key=>$value)
        {
            $newRules[$key] = str_replace('required|', "", $value);
        }
        return $newRules;   
    }

    /**
     * Funzione per cifrare
     * @param string $testo da cifrare
     * @param string $chiave usata per cifrare
     */
    public static function cifra($testo, $chiave)
    {
        $testoCifrato = AesCtr::encrypt($testo, $chiave, 256);
        return base64_encode($testoCifrato);
    }

    /**
     * Funzione per decifrare
     * 
     * @param string $testoDecifrato testo da decifrare
     * @param string $chiave chiave usata per la decifrazione
     * 
     * @return string  
     * 
     */
    public static function decifra($testoCifrato, $chiave)
    {
        $testoCifrato= base64_decode($testoCifrato);
        return AesCtr::decrypt($testoCifrato, $chiave, 256);    
    }
        


    /**
     * Funzione per unire password e salt per poi fare un HASH
     * 
     *@param string $password
     *@param string $salt
     *
     *@return string
     */
    public static function nascondiPassword($password, $salt)
    {
        return hash('sha512', $salt . $password);
    }


    /**
     * Funzione che crea il token 
     * 
     * @param string $secretJWT chiave di cifratura
     * @param integer $idContatto
     * @param integer $usaDa unixtime abilitazione utilizzo token
     * @param integer $scadenza unixtime scadenza utilizzo token 
     * 
     * @return string 
     */
    public static function creaTokenSessione($idUser, $secretJWT, $usaDa = null, $scadenza = null)
    {
        $maxTime = 15 * 24 * 60 * 60; // Scadenza del token dopo un massimo di 15 giorni
        $recordContatto = User::where('idUser', $idUser)->first();
        $t = time(); // prendo il current time e lo metto nella variabile $t
        $nbf = ($usaDa == null) ? $t:$usaDa;
        $exp = ($scadenza == null) ? $nbf + $maxTime : $scadenza;
        $idRuolo = $recordContatto->idRuolo; //prendo l'id ruolo dell'utente
        $anagraficaContatto = Anagrafica_utenti::where('idUser',$idUser);
        $nazione = Nazione::where('idNazione',$anagraficaContatto->idNazione)->first();
        $arr = array( //creo un array e ci inserisco i dati utili del token
            'iss'=>'',
            'aud'=>null,
            'iat'=>$t,
            'nbf'=>$nbf,
            'exp'=>$exp,
            'data'=>array(
                'idUser'=>$idUser,
                'status'=>$recordContatto->status, //Status attivo o non attivo (bannato, sospeso)
                'idRuolo'=>$idRuolo,
                'nome_status'=>trim($recordContatto->nome . " " . $recordContatto->cognome),
                'sesso'=>$anagraficaContatto->sesso,
                'nazione'=>$nazione

            )
            );
            $token = JWT::encode($arr, $secretJWT,'HS256');
            return $token;
    }


    /**
     * Funzione che ritorna una risposta in un formato customizzato
     * 
     * @param array $dati Dati richiesti
     * @param string $messaggio 
     * @param array $errori 
     *
     * @return array
     */
    public static function rispostaCustom($dati, $messaggio= null, $errori = null)
    {
        $response = array();
        $response["data"] = $dati;
        if ( $messaggio != null) $response["message"] = $messaggio;
        if ( $errori != null) $response["error"] = $errori;
        return $response;
    }

    /**
     * Funzione per validare il token passato
     * 
     */
    public static function validaToken($token, $jwt, $sessione){
        $rit = null;
        $payload = JWT::decode($token,new Key($jwt, 'HS256')); // Per fare il decode devl creare una nuova istanza key e passargli la secretJWT e l'algoritmo
        if($payload->iat <= $sessione->inizioSessione) {
            if($payload->data->idUser == $sessione->idUser) {
                $rit = $payload;
            }
        }
        return $rit;
    }
}