<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;


use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



//Relation
use App\Models\Stagiaire;

use App\Notifications\ResetPasswordNotification;

class Stagiaire extends EloquentModel

{
    use HasFactory, Notifiable, HasApiTokens;


    protected $fillable = [
        'name',
        'prenom',
        'datenaissance',
        'email',
        'cinoupassport_stagiaire',
        //'passport',
        'niveauetude',
        'specialite',
        'filiere',
        'adresse',
        'telephone',
        'password',

     
         //Relation
         'demandesStages',

         //Relation
         'travaux',
       
       
        
    ];

    //Relation
    public static function demandeStages(){
        //return $this->embedsMany(DemandeStage::class);
        return $this->embedsMany(DemandeStage::class);
        
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
        $url = 'http://localhost:3000/S-reset/' . $token;

        $this->notify(new ResetPasswordNotification($url));
    }
}

