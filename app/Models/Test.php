<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Question;

class Test extends Model
{
    use HasFactory;
    protected $fillable = [

        'titre',
        'departement',
        'niveaustagiaire',
        'niveautest',
        'duree',
        'questions',
        'note'
    ];
    public static function questions() {
        return $this->embedsMany(Question::class);
    }

}

