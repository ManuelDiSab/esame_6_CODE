<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class contatti_recapiti extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'contatti_recapiti';
    protected $primaryKey = 'idRecapito';

    protected $fillable = [
        'idUser',
        'tel'
    ];

}
