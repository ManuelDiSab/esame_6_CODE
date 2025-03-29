<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComuniResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->getCampi();
    }

    protected function getCampi()
    {
        return [
            'idComune' => $this->idComune,
            'nome' => $this->nome,
            'regione' => $this->regione,
            'provincia' => $this->provincia,
            'cap' => $this->cap,
            'siglaAuto'=>$this->siglaAuto,
            'metropolitana'=>$this->metropolitana,
            'codCat'=>$this->codCat,
            'capoluogo'=>$this->capoluogo,
            'multicap'=>$this->multicap,
            'capFine'=>$this->capFine,
            'capInizio'=>$this->capInizio
        ];
    }
}