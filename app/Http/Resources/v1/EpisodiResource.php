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
        return $this->getCampi();
    }

    public function getCampi()
    {
        $locale = "http://localhost/ESAMI/ESAME%20SESSIONE%206%20ACCADEMIA%20CODE%20DI%20SABATINO%20MANUEL/esame_6_CODE/public/storage/imgEpisodi/";
        $locale_video = "http://localhost/ESAMI/ESAME%20SESSIONE%206%20ACCADEMIA%20CODE%20DI%20SABATINO%20MANUEL/esame_6_CODE/public/storage/videoEp/";
        $server = 'http://127.0.0.1:8000/storage/imgEpisodi/';
        $server = 'http://127.0.0.1:8000/storage/videoEp/';        
        return [
            'idEpisodio' => $this->idEpisodio,
            'idSerie' => $this->idSerie,
            'titolo' => $this->titolo,
            'durata' => $this->durata,
            'numero' => $this->numero,
            'stagione' => $this->stagione,
            'trama'=>$this->trama,
            'voto'=> $this->voto,
            'path_img'=>$locale.$this->path_img,
            'path_video'=>$locale_video.$this->path_video
        ];
    }
}