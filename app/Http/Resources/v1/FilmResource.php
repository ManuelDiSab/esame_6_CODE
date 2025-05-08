<?php

namespace App\Http\Resources\v1;

use App\Models\generi;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
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
        private function getCampi(){
            $locale = "http://localhost/ESAMI/ESAME%20SESSIONE%206%20ACCADEMIA%20CODE%20DI%20SABATINO%20MANUEL/esame_6_CODE/public/storage/img/";
            $server = 'http://127.0.0.1:8000/storage/img/';
        return [
            "idFilm"=>$this->idFilm,
            "idGenere"=>$this->idGenere,
            "genere"=>generi::where('idGenere',$this->idGenere)->valueOrFail('nome'),
            "titolo"=>$this->titolo,
            "regista"=>$this->regista,
            "durata"=>$this->durata,
            "anno"=>$this->anno,
            "path"=>$locale.$this->path_img,
            "trama"=>$this->trama,
            "voto"=>$this->voto,
            "generi_secondari"=>$this->generi_secondari
        ];
    }
}
