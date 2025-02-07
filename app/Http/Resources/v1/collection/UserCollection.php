<?php

namespace App\Http\Resources\v1\collection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tmp = parent::toArray($request);
        $tmp = array_map(array($this, 'getCampi'),$tmp);
        return $tmp;
    }
    protected function getCampi($item){
        return [
        'nome' => $item['name'],
        'cognome'=> $item['cognome'],
        'idRuolo'=>$item['idRuolo'],
        'idUser'=>$item['idUser']
        ];
    }
}
