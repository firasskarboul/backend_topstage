<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;

// use Illuminate\Support\Facades\BD;
use Illuminate\Support\Facades\Validator;
use App\Models\Stagiaire;



class ForgotPasswordController extends Controller
{
   

    public function StforgotPassword(Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
        ]);
   

        $stagiaire =Stagiaire::where('email',$request->email)->first();
       
            $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(
             [
               // 'status'=>200,
                'status' => __($status),
                'message' =>'Vérifier votre Email',
            ]) ;
        }

      
       
        if(!$stagiaire){
            return response()->json(
            [
                //'email' => [trans($status)],
                'message' =>'Aucun stagiaire avec cet email',
            ]

        );
         }

    }

}
