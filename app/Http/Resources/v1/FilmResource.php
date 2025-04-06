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
        return [
            "idFilm"=>$this->idFilm,
            "idGenere"=>$this->idGenere,
            "genere"=>generi::where('idGenere',$this->idGenere)->valueOrFail('nome'),
            "titolo"=>$this->titolo,
            "regista"=>$this->regista,
            "durata"=>$this->durata,
            "anno"=>$this->anno,
            "path"=>$this->path_img,
            "trama"=>$this->trama,
            "voto"=>$this->voto,
            "generi_secondari"=>$this->generi_secondari
        ];
    }
}
