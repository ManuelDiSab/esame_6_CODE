<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nazione extends Model
{
    use HasFactory,SoftDeletes;

    protected $table ="nazioni";
    protected $primaryKey = "idNazione";

    protected $fillable = [
        'nome',
        'continente', 
        'iso',
        'iso3',
        'PrefissoTelefonico'
    ];
}

