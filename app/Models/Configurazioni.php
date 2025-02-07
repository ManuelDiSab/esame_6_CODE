<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Configurazioni extends Model
{
    protected $table = 'configurazioni';
    protected $primaryKey = 'idConfig';

    protected $fillable = [
        'chiave',
        'valore'
    ];


    /**
     * Trovare il valore associato ad una chiave all'interno del DBs configurazioni
     * 
     * @param string $chiave 
     * @return int
     */
    public static function LeggiValore($chiave){
        $valore = DB::table('configurazioni')->where('chiave',$chiave)->value('valore');
        return $valore;
    }
}
