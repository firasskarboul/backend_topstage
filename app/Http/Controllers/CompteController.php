<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
/* 
use Illuminate\Support\Facades\Hash;


use Auth;
use Validator;
 */

class CompteController extends Controller
{

    //CRUD

    //Read All
    public function index()
    {
        $user = User::all();
        return response()->json([
            'status' =>200,
            'user' => $user
        ]);
    }


    


   //retourner un utilisateur par Id
   public function show($id){
    $user= User::find($id);
    if($user){

     return   response()->json(
     [
     
     'user' => $user,
     'status'=>200,
     ] );

    }else{
     return response()->json(
         [ 'validation_errors' => 'Utilisateur non existe' , //$validator->messages()
           'status'=>404,
         ]);   
     
    }
} 





    //Modifier utilisateur
 public function update(Request $request, $id)
{

    $validator = Validator::make($request->all(),[
        'nom'=>'required|string |min:3|max:20 ',
        'prenom'=>'required|string |min:3|max:20 ',
        'email'=>'required|email|unique:users,email ',
        'numTel'=>'required| numeric ',
        'datenaissance'=>' required | date',
        'matricule'=>'required| numeric  ',
        'role'=>'required ',

        'departement'=>'required ',

        'etat'=>'required',
        'password'=>'required|string|confirmed|min:5',

    ]);

    if($validator->fails()){
        return response()->json(
            [ 'validation_errors' => $validator->messages() ,
              'status'=>422,
            ]);   

    }
    else{
         $user = User::find($id);
         if($user){

            // $compte->update($request->all());

            $user->nom = $request->nom;
            $user->prenom= $request->prenom;
            $user->email =$request->email;
            $user->numTel= $request->numTel;
            $user->datenaissance =$request->datenaissance;
            $user-> matricule=$request->matricule;
            $user-> role=$request->role;
            //$user->password = Hash::make($request->password);
     
            $user->etat = $request->etat;

            $user->departement = $request->departement;
            $user->password = $request->password;
      
            
            $user->save();
            $token = $user->createToken('auth_token')->plainTextToken;
             return response()->json(
                [    'status'=>200,
                    'message' =>'Compte modifié avec succès' ,
                  
                ]);   
         }
         else{
            return response()->json(
                [    'status'=>404,
                    'message' =>'Compte avec cet ID introuvable' ,
                  
                ]);   ;
         } 
    }


   
}  




//Désactiver et Activer un utilisateur























/* 
  //Create
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nom'=>'required|string|min:3|max:20 ',
            'prenom'=>'required|string|min:3|max:20 ',
            'email'=>'required|email|unique:users,email ',
            'numTel'=>'required|numeric',
            'datenaissance'=>' required|date',
            'matricule'=>'required|numeric  ',
           //'role'=>'required ',
            'password'=>'required|string|confirmed|min:5',
    
        ]);

        if($validator->fails()){
            return response()->json(
                [ 'validation_errors' => $validator->messages() ,
                  'status'=>400,
                ]);   

        }

        // return Compte::create($request->all());

        $compte = Compte::create([
            'nom' => $request->nom,
            'prenom'=> $request->prenom,
             'email' => $request->email,
             'numTel'=> $request->numTel,
            'datenaissance' =>$request->datenaissance,
            'matricule'=> $request->matricule,
            'password' => Hash::make($request->password),
            
         ]);


         
         $token = $compte->createToken('auth_token')->plainTextToken;

         return response()->json(
             ['message' => 'compte successfully registered',
             'access_token' => $token, 
             'token_type' => 'Bearer',
             'username' => $compte->nom,
             'status'=>200,
             ] );

    }




 */



 
  //Create
 /*  public function register(Request $request)
  {
      $validator = Validator::make($request->all(),[
          'nom'=>'required|string|min:3|max:20 ',
          'prenom'=>'required|string|min:3|max:20 ',
          'email'=>'required|email|unique:users,email ',
          'numTel'=>'required|numeric',
          'datenaissance'=>' required|date',
          'matricule'=>'required|numeric  ',
         //'role'=>'required ',
          'password'=>'required|string|confirmed|min:5',
  
      ]);

      if($validator->fails()){
          return response()->json(
              [ 'validation_errors' => $validator->messages() ,
                'status'=>400,
              ]);   

      }

      // return Compte::create($request->all());

      $compte = Compte::create([
          'nom' => $request->nom,
          'prenom'=> $request->prenom,
           'email' => $request->email,
           'numTel'=> $request->numTel,
          'datenaissance' =>$request->datenaissance,
          'matricule'=> $request->matricule,
          'password' => Hash::make($request->password),
          
       ]);


       
       $token = $compte->createToken('auth_token')->plainTextToken;

       return response()->json(
           ['message' => 'compte successfully registered',
           'access_token' => $token, 
           'token_type' => 'Bearer',
           'username' => $compte->nom,
           'status'=>200,
           ] );

  }





     */

    //Update
/*     public function update(Request $request, $id)
    {
        $compte = Compte::find($id);
        $compte->update($request->all());
        return $compte;
    } 
 */


  
   


   //Search
   /* public function search($key){
       return Compte::where('nom' , 'Like',"%$key%")->get();
   } */
   
    //Delete
   /*  public function destroy($id)
    {
        return Compte::destroy($id);
    }
 */



/*  
public function incheck (){
    return response()->json([
        'message' => 'You are in' ,
         'status' =>200
    ],200);
}

 */

    
}



