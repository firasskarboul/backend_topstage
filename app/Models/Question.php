<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Reponse ;
use App\Models\Test;





class Question extends Model 
{
    use HasFactory;
    public static function reponses() {
        return $this->embedsMany(Reponse::class);
    }
    protected $fillable = [
        'question',
        'niveau',
        'duree',
        'etat',
        'points',
        'réponses',
    ];
    public static function test() {
        return $this->embedsOne(Test::class);
    }

}




