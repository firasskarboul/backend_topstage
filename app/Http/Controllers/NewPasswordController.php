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
use App\Models\User;
use App\Models\Stagiaire;




class NewPasswordController extends Controller
{
    
    // public function forgotPassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);

    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );

    //     if ($status == Password::RESET_LINK_SENT) {
    //         return [
    //             'status' => __($status)
    //         ];
    //     }

    //   /*  throw ValidationException::withMessages([
    //         'email' => [trans($status)],
    //     ]); */
    //      else{
    //         return [
    //             'email' => [trans($status)],
    //         ];
    //      }

    // }



        public function UforgotPassword(Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
        ]);


        if($request->validate->email->fails()){
            return response([
                'status'=> 422,
                'validation_errors' => $request->validate->email->messages() ,
                'message' =>'Vérifier votre Email !'
               
               
                ]
                
            );
    
         }
   

        $user =User::where('email',$request->email)->first();
        if($user){
            $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(
             [
                //'status'=>200,
                'status' => __($status),
                'message' =>'Vérifier votre Email',
            ]


            ) ;
        }

        }
       
         else if(!$user){
            return response()->json(
            [
                //'email' => [trans($status)],
                'status'=>404,
                'message' =>'Aucun utilisateur avec cet email',
            ]

        );
         }

    }












    public function SforgotPassword(Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
        ]);
   

        $stagiaire =Stagiaire::where('email',$request->email)->first();
        if($stagiaire){
            $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(
             [
               // 'status'=>200,
                'status' => __($status),
                'message' =>'Vérifier votre Email',
            ]


            ) ;
        }

        }
       
         else{
            return response()->json(
            [
                //'email' => [trans($status)],
                'message' =>'Aucun stagiaire avec cet email',
            ]

        );
         }

    }









  


















   


     





   /*  public function forgotPassword(Request $request){
        $email = $request->input('email');
        $token = Str::random(12);

     DB::table('password_resets')->insert([
           'email'=>$email,
           'token'=>$token,
           'created_at'=>Carbon::now()
        ]);
 
     Mail::send('reset' , ['token'=> $token], function (Message $message) use ($email) {
         $message->subject('Reset your password');
         $message->to($email);
     });

     return[
         'message' => 'vérifier votre email'
     ];

   }
 */


 /*    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',

            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $user =User::where('email',$request->email)->first();
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'status'=>200,
                'message'=> 'Password reset successfully'
            ]);
        }

        return response([
            'message'=> __($status)
        ], 500);

    } */


  /*   public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message'=> 'Password reset successfully'
            ]);
        }

        return response([
            'message'=> __($status)
        ], 500);

    } 
 */



public function UresetPassword(Request $request)
{/* 
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => ['required', 'confirmed', RulesPassword::defaults()],
    ]);
     */


    $validator = Validator::make($request->all(), [
            
        'token' => 'required',
        'email' => 'required|email',
        'password' => ['required', 'confirmed', RulesPassword::defaults()],
        
                 ]);
    if($validator->fails()) {
        return response()->json([
            'status'=>422,
            'validation_errors' => $validator->messages() ,
            'message'=>'vérifier les champs il ya un erreur',
        ]);
    }
 

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user) use ($request) {
            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();

            $user->tokens()->delete();

            event(new PasswordReset($user));
        }
    );

    if ($status == Password::PASSWORD_RESET) {
    

        return response()->json(
            [
                'status'=>200,
                'message'=> 'Mot de passe utilisateur réinitialisé avec succès',
                
            ]

        );
    }
   
    return response([
        'status'=>500,
        // 'message'=> __($status)
        'message'=>'utililisateur avec cet email non existe',
    ]);

}














public function SresetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => ['required', 'confirmed', RulesPassword::defaults()],
    ]);
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($stagiaire) use ($request) {
            $stagiaire->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();

            $stagiaire->tokens()->delete();

            event(new PasswordReset($stagiaire));
        }
    );
    if ($status == Password::PASSWORD_RESET) {
        return response()->json(
            [
                'status'=>200,
                'message'=> 'Stagiaire Password reset successfully',
                
            ]

        );
    }
    return response([
        'message'=> __($status)
    ], 500);

}


}
