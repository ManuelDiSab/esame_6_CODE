<?php

namespace App\Http\Resources\v1;

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
        return [
            'idSerie'=>$this->idSerie,
            'idGenere'=>$this->idGenere,
            'titolo' => $this->titolo,
            'trama' => $this->trama,
            'n_stagioni' => $this->n_stagioni,
            'anno_inizio' => $this->anno_inizio,
            'anno_fine' => $this->anno_fine,
            'path'=>$this->path,
            'voto'=>$this->voto
        ];
    }
}
