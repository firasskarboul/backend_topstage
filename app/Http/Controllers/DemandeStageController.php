<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Stagiaire;
use App\Models\DemandeStage;

use Validator;


use Illuminate\Support\Facades\DB;
class DemandeStageController extends Controller
{



    
      //Read All
      public function index()
      {
          $demande = DemandeStage::all();
          return response()->json([
              'status' =>200,
              'demandeStage' =>$demande
          ]);
      }
  


         //Read All demande de stagiaire
         /*    public function index_demande_stagiaire()
           {
          $demande = DemandeStage::all();
          return response()->json([
              'status' =>200, 
              'demandeStage' =>$demande
          ]); 

         
      } */
 
       //Ajouter
       public function store(Request $request)
       {
           $validator = Validator::make($request->all(),[
               //'niveauetude'=>'required',
              'typestage'=>'required',
               'nom_dept'=>'required',
               //'cv'=>'required|file',
               //'cv'=>'required',
               //'cin_demande'=>'required',
              'cinoupassport_demande'=> 'unique:demande_stages,cinoupassport_demande', 
               
              
               

              
       
           ]);
   
           if($validator->fails()){
               return response()->json(
                   [ 'validation_errors' => $validator->messages() ,
                     'status'=>400,
                   ]);   
   
           }
   
   
           else{    

            $demande = new DemandeStage;
           // $demande ->niveauetude =$request->niveauetude;
            $demande ->typestage =$request->typestage;
            $demande ->nom_dept =$request->nom_dept;
            $demande ->cinoupassport_demande =$request->cinoupassport_demande;
            $demande ->cv =$request->cv;
           
         
          
          if($request->hasFile('cv')){
                $file = $request->file('cv');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
                $finalName = time(). '_' . $filename ;
                $request->file('cv')->storeAs('public/Upload/Cvs' , $finalName );
                $demande->cv='public/Upload/Cvs/'.$finalName;
          } 
                $demande->save();
 
          /*   $demande = DemandeStage::create([
               'niveauetude' => $request->niveauetude,
               'typestage'=> $request->typestage,
               'nom_dept'=> $request->nom_dept,
               'cin'=> $request->cin,
               'cv' => 'public/Cvs/'.$finalName,
              
               
            ]); */
   


           
                $cin_demande= Stagiaire::where('cinoupassport_stagiaire' , $request->cinoupassport_demande)->push(
                    ['demandeStages'=>[$demande ->_id, $demande ->typestage,$demande ->nom_dept ,$demande ->cv] ]);
                
            //.Relation


            return response()->json(
                ['message' => 'Demande de stage ajoutée avec succès',
                'status'=>200,
                'demandeStage' =>$demande,
               
               
                ] );
           }
       }




    //Delete
    public function destroy($id){
        $demande = DemandeStage::find($id);
        if($demande){
            $demande->delete();
                return response()->json([
                    'status' =>200,
                    'message' =>'Demande de stage supprimée avec succès',
                ]);
        }
        else{
            return response()->json([
                'status' =>404,
                'message' =>'Demande de stage avec cet ID introuvable',
            ]);
        }
    }




}
