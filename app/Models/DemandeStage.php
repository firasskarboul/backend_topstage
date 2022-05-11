<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

//Relation
use App\Models\DemandeStage;

class DemandeStage extends Model
{
    use HasFactory;

    protected $fillable = [
       // 'niveauetude',
        //'cin_demande',
        'cinoupassport_demande',
        'typestage',
        'nom_dept',
        'cv',
       
       
    ];

    


      //Relation 
      public static function cinoupassport_demandes(){
        return $this->embedsOne(Stagiaire::class);
    }

} 


