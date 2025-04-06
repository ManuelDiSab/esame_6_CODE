<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecapitiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->getCampi();
    }

    protected function getCampi(){

        return [
            'tel'=>$this->tel,
            'idUser'=>$this->idUser
        ];

    }
}
