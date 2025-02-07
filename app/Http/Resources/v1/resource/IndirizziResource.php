<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class indirizziResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "idUser"=>$this->idUser,
            "idTipologiaIndirizzo"=>$this->idTipologiaIndirizzo,
            "idNazione"=>$this->idNazione,
            "idComune"=>$this->idComune,
            "indirizzo"=>$this->indirizzo,
            "civico"=>$this->civico,
            "cap"=>$this->cap,
            "località"=>$this->località
        ];
    }
}
