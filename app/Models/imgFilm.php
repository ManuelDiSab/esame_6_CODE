<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class imgFilm extends Model
{
    Use HasFactory,SoftDeletes;

    protected $table = 'imgFoto';
    protected $primaryKey = 'idFotoFilm';

    protected $fillable = [
        'idFilm',
        'path'
    ];
}
