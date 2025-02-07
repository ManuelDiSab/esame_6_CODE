<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EpisodiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return $this->getCampi();
    }

    protected function getCampi()
    {
        return [
            'idEpisodio' => $this->idEpisodio,
            'idSerie,' => $this->idSerie,
            'titolo' => $this->titolo,
            'durata,' => $this->durata,
            'numero' => $this->numero,
            'stagione' => $this->stagione
        ];
    }
}