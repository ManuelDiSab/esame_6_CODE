<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AnagraficaCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array\Illuminate\Contracts\Support\Arrayble\JsonSerializable
     */
    public function toArray(Request $request)
    {
        return $this->collection;
    }
}
