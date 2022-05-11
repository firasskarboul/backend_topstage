<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Stagiaire;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

//relation
use App\Models\Departement;

use Auth;
use Validator;

//premiere fois
use Carbon\Carbon;

class AuthController extends Controller
{


    //Register stagiaire
    /*  public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|string |min:3|max:20',
            'prenom'=>'required|string|min:3|max:20' ,
            'datenaissance' =>'required | date',
            //'numCP'=>'required|numeric|min:3', 
            //'num'=>'required',
            'niveauetude'=> 'required|string',
            'specialite'=> 'required|string',
            'filiere'=> 'required|string',  
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:5',
            
            
        ]);

        if($validator->fails()){
            return response()->json(
                [ 'validation_errors' => $validator->messages() ,
                  'status'=>400,
                ]);   

        }

        $user = User::create([
            'name' => $request->name,
            'prenom'=> $request->prenom,
            'datenaissance' =>$request->datenaissance,
            // 'numero'=>$request->num.$request->numCP ,
            'niveauetude'=> $request->niveauetude,
            'specialite'=> $request->specialite,
            'filiere'=> $request->filiere,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
         ]);

         $token = $user->createToken('auth_token')->plainTextToken;

         return response()->json(
             ['message' => 'user successfully registered',
             'access_token' => $token, 
             'token_type' => 'Bearer',
             'username' => $user->name,
             'status'=>200,
             ] );

    }



 */



 

 //Register : Ajouter utilisateur
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

          'departement'=>'required ',

         'password'=>'required|string|confirmed|min:5',


         
 
     ]);

     if($validator->fails()){
        return response([
           
            'validation_errors' => $validator->messages() ,
            'status'=>422,
           
            ]
            
        );

     }

     // return Compte::create($request->all());

     $user = User::create([
         'nom' => $request->nom,
         'prenom'=> $request->prenom,
          'email' => $request->email,
          'numTel'=> $request->numTel,
         'datenaissance' =>$request->datenaissance,
       
         'role'=> $request->role,
         'password' => $request->password,
         'etat'=> 'Active',//$request->etat,
          'matricule'=> $request->matricule,
        // 'password' => Hash::make($request->password),
        'departement'=>$request->departement,
      

        //Relation
        'sujetsEn'=>[],

         
      ]);

//Relation
      $departement= Departement::where('nom_dept' , $request->departement)->push(
          ['users'=>[$user->id , $user->nom  , $user->prenom ,$user->role] ]);
//.Relation
      $token = $user->createToken($user->mail.'_auth_token')->plainTextToken;

      return response()->json(
          ['message' => 'Compte est ajouté avec succès',
          'access_token' => $token, 
          'token_type' => 'Bearer',

          'departement'=>$departement,

          'username' => $user->nom,
          'role' => $user->role,
          'status'=>200,
          ] );

 }












    //Login
  /*   public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string|max:50',
            'password' => 'required|string|min:5'
        ]);

      
        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds',
                'status'=>401,
            ]);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

       
        return response()->json(
            ['message' => 'Welcome !',
            'access_token' => $token, 
            'token_type' => 'Bearer',
            'username' => $user->name,
            'status'=>200,
            ] );
    }

 
 */


 //------------------------------------------------test

 public function login(Request $request){
    $fields = $request->validate([
        'email'=>'required|email|unique:users,email ',
        'password' =>'required|string|min:5',
    ]);

    
    //check email
    $user = User::where('email',$fields['email'])->first();
    //check password
   // if(!$user || !Hash::check($fields['password'],$user->password )){
        if(!$user || ($fields['password'] !==$user->password )){    
        return response()->json([
            'status'=>401,
             'message'=>' email ou mot de passe invalide ',
    ]);
    }

    if($user->etat === 'Désactive'){
        return response([
            'message' => 'vous étes Désactivé ',
            'status'=>402,
        ]);
    }
  //create token
    if($user->role == 'encadrant')
    {
        $role='encadrant';
        $token = $user->createToken($user->email.'_EncadrantToken' , ['server:encadrant'])->plainTextToken;

    }else if($user->role == 'chef_dept')
    {
        $role='chef_dept';
        $token = $user->createToken($user->email.'_Chef_deptToken' , ['server:chef_dept'])->plainTextToken;

    }

else if($user->role == 'service_formation')
{
    $role='service_formation';
    $token = $user->createToken($user->email.'_Service_formationToken' , ['server:service_formation'])->plainTextToken;

}


else if($user->role == 'coordinateur')
{
    $role='coordinateur';
    $token = $user->createToken($user->email.'_Coordinateur' , ['coordinateur'])->plainTextToken;

}



   




    $response = ['token' => $token];
    return response()->json(
        ['message' => 'Welcome !',
        'access_token' => $token, 
        'token_type' => 'Bearer',
        'username' => $user->nom,
        'lastname' => $user->prenom,
       
        'id' => $user->id,
        'status'=>200,
        'role'=>$role,

     

       

        ] );



  
}




 //------------------------------------------------test





////////////////////////////////login

/* 
public function login (Request $request) {
    $validator = Validator::make($request->all(), [
        'email'=>'required|email|unique:users,email ',
        'password' => 'required|string|min:5',
    ]);
    if ($validator->fails())
    {
        return response([ 
            'validation_errors' => $validator->messages() ,
            'status'=>422,
            ]
            
        );
    }

    
     $user = User::where('email', $request->email)->first();
    if ($user) {
        
        if ($request->password == $user->password) {//Hash::check
            

            if($user->role == 'encadrant')
            {
                $role='encadrant';
                $token = $user->createToken($user->email.'_EncadrantToken' , ['server:encadrant'])->plainTextToken;

            }else if($user->role == 'chef_dept')
            {
                $role='chef_dept';
                $token = $user->createToken($user->email.'_Chef_deptToken' , ['server:chef_dept'])->plainTextToken;

            }
      
        else if($user->role == 'service_formation')
        {
            $role='service_formation';
            $token = $user->createToken($user->email.'_Service_formationToken' , ['server:service_formation'])->plainTextToken;

        }

           
            $response = ['token' => $token];
            return response()->json(
                ['message' => 'Welcome !',
                'access_token' => $token, 
                'token_type' => 'Bearer',
                'username' => $user->nom,
                'id' => $user->id,
                'status'=>200,
                'role'=>$role,
                ] );
        } else{

            return response([
                'message' => 'user not exist ',
                'status'=>401,
            ]);
        }
    } 
}

 */

///////////////.login

    

   //Log out
 public function logout(Request $request) {
    auth()->user()->tokens()->delete();

     return response()->json(
            [
                'status'=>200,
                'message' => 'Déconnecté avec succès',
            ]);
}

 /* public function logout(Request $request)
    {

        $request->user()->tokens()->delete();

        return response()->json(
            [
                'message' => 'Logged out'
            ]
        );

    }*/


 


 //verifier login
   public function incheck (){
    return response()->json([
        'message' => 'You are in' ,
         'status' =>200,
          'user' => auth()->user(),
    ],200);
}




  //profile
    public function profile(){
    
 return response()->json([
        
         'status' =>200,
         //'user'=> auth()->user(),
        // 'user'=> auth()->check()->user(),
        'valid' => auth()->check() ,
        // 'user'=> auth()->user(),
        // 'user'=>Auth::user(),

        'user'=> response()->json (auth()->user()),
        //   return  response()->json (auth()->user());*/
       
  
   ]); //,200
     
}   
 


//profile
/*public function profile(){
    
    $user = Auth::user(); 
    return response()->json([
         'status' =>200,
         'user'=> $user,
    
     ]);
    //  return new UserResource(auth()->user());
}   */



  //profile


/*  //profile
 public function profile(){
    return response()->json(auth()->user());
} */


//afficher profile
/* public function read_profile(Request $request ){
    $user_id = $request->$user()->id;
    $user =User::find($user_id );
    if($user){
        return response()->json([
            'message' => 'Profile utilisateur' ,
             'status' =>200,
             'user' => $user,
        ]);
    }
    else{
        return response()->json([
            'message' => 'Profile utilisateur not' ,
             'status' =>500,
           
        ]);
    }
}
 */



//modifier profile
public function update_profile (Request $request){
    $validator = Validator::make($request->all(), [
        'nom'=>'required|string|min:3|max:20 ',
        'prenom'=>'required|string|min:3|max:20 ',
        'email'=>'required|email|unique:users,email ',
        'numTel'=>'required|numeric',
        'datenaissance'=>' required|date',
        'matricule'=>'required|numeric  ',
        //'role'=>'required ',
        //'password'=>'required|string|confirmed|min:5',
        // 'profile_photo'=>'nullable|image|mimes:jpg,bmp,png'
    ]);
    if ($validator->fails()) {
        return response()->json([
            'message'=>'Validations fails',
            'validation_errors'=>$validator->messages()
        ],422);
    } 

    $user=$request->user();

    $user->update([
        'nom' => $request->nom,
        'prenom'=> $request->prenom,
         'email' => $request->email,
         'numTel'=> $request->numTel,
        'datenaissance' =>$request->datenaissance,
        'matricule'=> $request->matricule,
        'role'=> $request->role,
        // 'password' => Hash::make($request->password),
       
    ]);

    return response()->json([
        'message'=>'Profil modifié avec succès',
    ],200);


}








}


