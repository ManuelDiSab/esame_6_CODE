<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NazioniResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'idNazione'=>$this->idNazione,
            'nome'=>$this->nome,
            'continente'=>$this->continente,
            'iso3'=>$this->iso3,
            'prefisso'=>$this->PrefissoTelefonico
        ];
    }
}
