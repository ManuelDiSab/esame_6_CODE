<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable 
{
    
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'idUser';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'idRuolo',
        'cognome',
        'utente',
        'password',
        'secretJWT',
        'salt',
        'inizioSfida'
        ];

    /**
     * Attributi con valore di default
     * 
     * @var array
     */
    protected $attributes = [
        'idRuolo' => 1,
        'status' => 1,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'user',
        'secretJWT',
        'salt',
        'inizioSfida',
        'utente'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 
     * Controlla se esiste l'utente passato
     * 
     * @param string $user
     * @return boolean
     */
    public static function EsisteUtenteValidoPerIlLogin($utente){
        $rit = DB::table('users')->where('status',1)->where('utente',$utente)->select('idUser')->get()->count();
        return $rit ? true:false;
    }
}
