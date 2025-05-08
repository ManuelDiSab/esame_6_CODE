<?php

namespace App\Http\Resources\v1;

use App\Models\generi;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SerieTvResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = "http://localhost/ESAMI/ESAME%20SESSIONE%206%20ACCADEMIA%20CODE%20DI%20SABATINO%20MANUEL/esame_6_CODE/public/storage/img/";
        $server = 'http://127.0.0.1:8000/storage/img/';
        return [
            'idSerie'=>$this->idSerie,
            'idGenere'=>$this->idGenere,
            "genere"=>generi::where('idGenere',$this->idGenere)->valueOrFail('nome'),//Prendo solo il valore della colonna 
            'titolo' => $this->titolo,
            'trama' => $this->trama,
            'n_stagioni' => $this->n_stagioni,
            'anno' => $this->anno,
            'anno_fine' => $this->anno_fine,
            'path'=>$locale.$this->path,
            'voto'=>$this->voto
        ];
    }
}
