<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruoli extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'ruoli';
    protected $primaryKey = 'idRuolo';


    protected $fillable = [
        'nome'
    ];
}