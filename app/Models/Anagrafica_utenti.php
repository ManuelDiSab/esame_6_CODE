<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anagrafica_utenti extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'anagrafica';
    protected $primaryKey = 'idAnag';

    protected $fillable = [
        'cod_fis',
        'dataNascita',
        'sesso'
    ];
}
