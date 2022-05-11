<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use Mail;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailAcceptationStagiaire;
use App\Mail\MailRefusStagiaire;
use App\Models\Stagiaire;

class MailController extends Controller
{
    
 //service de formation accepte un stagiaire


public function accepter(Request $request){

    $data=[
          
          'name'=>$request->name,
          'prenom'=>$request->prenom,
          'email'=>$request->email
    ];
    
   
    try{
       // Mail::mailer('smtp')->to($stagiaire->email)->send( new MailAcceptationStagiaire ($stagiaire));receiver@gmail.com
          Mail::to($request->email)->send(new MailAcceptationStagiaire ($data));
          //return 'Email Envoyéé';
   return response()->json([
             'status'=>200,
             'message '=> 'Email Acceptation du stagiaire envoyé avec succès',

        ],200);
    }
    
    catch(\Exception $err){
        return response()->json([
            'status'=>500,
            'errors '=> 'Email Acceptation stagiaire non envoyé réessayer!',

       ],500);
    }    


   
   
    

}

public function refuser(Request $request){

    $data=[
         
          'name'=>$request->name,
          'prenom'=>$request->prenom,
          'email'=>$request->email
    ];
    
   
    try{
       // Mail::mailer('smtp')->to($stagiaire->email)->send( new MailAcceptationStagiaire ($stagiaire));receiver@gmail.com
          Mail::to($request->email)->send(new MailRefusStagiaire ($data));
          //return 'Email Envoyéé';
   return response()->json([
             'status'=>200,
             'message '=> 'Email Refus du stagiaire envoyé avec succès',
           

        ],200);
    }
    
    catch(\Exception $err){
        return response()->json([
            'status'=>500,
            'errors '=> 'Email Refus stagiaire non envoyé réessayer!',

       ],500);
    }    


}


}
