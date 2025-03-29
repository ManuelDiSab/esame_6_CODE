<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TipologiaIndirizzoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        $tmp = parent::toArray($request);
        $tmp = array_map(array($this, 'getCampi'),$tmp);
        return $tmp;
    }

    protected function getCampi($item){
        return [
        "idTipologiaIndirizzi"=>$item['idTipologiaIndirizzi'],
        "nome"=>$item['nome']
        ];
    }
}
