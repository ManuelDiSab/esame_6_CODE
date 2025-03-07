<?php

namespace App\Http\Resources\v1\collection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SerieTvCollection extends ResourceCollection
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
            'titolo'=>$item['titolo'],
            'trama'=>$item['trama'],
            'n_stagioni'=>$item['n_stagioni'],
            'anno_inizio'=>$item['anno_inizio'],
            'anno_fine'=>$item['anno_fine']
        ];
    }
}
