<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Departement;
use Validator;

class DepartementController extends Controller
{


      //Read All
      public function index()
      {
          $dept = Departement::all();
          return response()->json([
              'status' =>200,
              'dept' => $dept,
          ]);
      }
  




    //Create
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nom_dept'=>'required ',
            'nom_chef_dept'=>'required|string|max:20 ',
             
    
        ]);

        if($validator->fails()){
            return response()->json(
                [ 'validation_errors' => $validator->messages() ,
                  'status'=>400,
                ]);   

        }


        else{    

  // return Compte::create($request->all());
         
        $dept = Departement::create([
            'nom_dept' => $request->nom_dept,
            'nom_chef_dept'=> $request->nom_chef_dept,
            'etat'=> 'Active',
             //Relation
             'users'=>[],
            
         ]);

         return response()->json(
             ['message' => 'Département ajouté avec succès',
             'status'=>200,
             'nom dept' => $dept->nom_dept,

             ] );

        }

      

    }


    //retourner un département par Id
    public function show($id){
        $dept= Departement::find($id);
        if($dept){
    
         return   response()->json(
         [
         
         'dept' => $dept,
         'status'=>200,
         ] );
    
        }else{
         return response()->json(
             [ 'validation_errors' => $validator->messages() ,
               'status'=>404,
             ]);   
         
        }
    } 

 



     //Modifier utilisateur
 public function update(Request $request, $id)
 {
 
     $validator = Validator::make($request->all(),[
        'nom_dept'=>'required ',
        'nom_chef_dept'=>'required|string|max:20 ',
 
     ]);
 
     if($validator->fails()){
         return response()->json(
             [ 'validation_errors' => $validator->messages() ,
               'status'=>422,
             ]);   
 
     }
     else{
          $dept = Departement::find($id);
          if($dept){
 
              $dept->update($request->all());
             //'nom_dept' => $request->nom_dept,
             //'nom_chef_dept'=> $request->nom_chef_dept,
            
            

             $dept->save();
           
              return response()->json(
                 [    'status'=>200,
                     'message' =>'Département modifié avec succès' ,
                   
                 ]);   
          }
          else{
             return response()->json(
                 [    'status'=>404,
                     'message' =>'Département avec cet ID introuvable' ,
                   
                 ]);   ;
          } 
     }
 
    }

    
    

    //Delete
    public function destroy($id){
        $dept = Departement::find($id);
        if($dept){
                $dept->delete();
                return response()->json([
                    'status' =>200,
                    'message' =>'Département supprimée avec succès',
                ]);
        }
        else{
            return response()->json([
                'status' =>404,
                'message' =>'Département avec cet ID introuvable ',
            ]);
        }
    }



}
