<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void 
     */
    public function up()
    {
        Schema::create('demande_stages', function (Blueprint $table) {
            $table->id();
            //$table->string('NiveauEtude');
            $table->string('TypeStage');
            $table->string('nomDepartement');  
           // $table->string('cv')->nullable();
            $table->string('cv');
         // $table->file('cv');
            $table->integer('cinoupassport_demande');
           
           
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demande_stages');
    }
}
