<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

//Relation
use App\Models\User;

class SujetStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sujet',
        'technologies',
        'description',
        'datedebut',
        'nom_dept',
        'typestage',
        'etatsujet',
       // 'stusujet',
        'periode',


        //Relation
        'matricule_sj',
     
    ];

    
      //Relation 
      public static function matricule_sjs(){
        return $this->embedsOne(User::class);
    }




}
