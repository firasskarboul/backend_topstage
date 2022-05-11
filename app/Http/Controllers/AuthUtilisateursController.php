<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Compte;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


use Auth;
use Validator;

class AuthUtilisateursController extends Controller
{
     //Create
  public function register(Request $request)
  {
      $validator = Validator::make($request->all(),[
          'nom'=>'required|string|min:3|max:20 ',
          'prenom'=>'required|string|min:3|max:20 ',
          'email'=>'required|email|unique:users,email ',
          'numTel'=>'required|numeric',
          'datenaissance'=>' required|date',
          'matricule'=>'required|numeric  ',
          'role'=>'required ',
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
          'role'=> $request->role,
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



}
