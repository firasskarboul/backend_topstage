<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Jenssegers\Mongodb\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


//relation
use App\Models\Departement;
use App\Models\SujetStage;


use App\Models\Sujet;
use App\Notifications\ResetPasswordNotification;



class User  extends Authenticatable
{
  

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    
        
        //utilisateur
        'nom',
        'prenom',
        'email',
        'numTel',
        'datenaissance',
       
        'role',
        'etat',
        'password',
        'matricule',
        //Relation
        'departement',


        //Relation
        'sujetsEn',


       
    ];
    
    //relation
    public static function departements(){
        return $this->embedsOne(Departement::class);
    }


      //relation
      public static function sujetsEn(){
        return $this->embedsMany(SujetStage::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    
    public function sendPasswordResetNotification($token)
    {
        //https://spa.test   $url = 'http://localhost:3000/U-reset?token=' . $token;
        $url = 'http://localhost:3000/U-reset/' . $token;

        $this->notify(new ResetPasswordNotification($url));
    }



}
