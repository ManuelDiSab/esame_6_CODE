<?php

namespace App\Http\Resources\v1\resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnagraficaResource extends JsonResource
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

    protected function getCampi(){
        return [
            'idUser'=>$this->idUser,
            'cod_fis'=>$this->cod_fis,
            'dataNascita'=>$this->dataNascita,
            'sesso'=>$this->sesso 
        ];
    }

}
