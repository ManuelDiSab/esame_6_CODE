<?php

namespace App\Http\Resources\v1;

use App\Models\Ruoli;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nome' => $this->nome,
            'cognome'=> $this->cognome,
            'idRuolo'=>$this->idRuolo,
            'idUser'=>$this->idUser,
            'status'=>$this->status,
            'nome_status'=>($this->status === 1)? 'attivo' : 'inattivo',
            'ruolo'=>Ruoli::where('idRuolo',$this->idRuolo)->first('ruolo')
        ];
    }
}
