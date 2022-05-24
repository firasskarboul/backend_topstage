<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use App\Models\DemandeStage;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Mongodb\Eloquent\Model;



class AuthControllerStagiaire extends Controller
{

    //Read All
    public function index()
    {
        $stagiaire = Stagiaire::all();
        return response()->json([
            'status' => 200,
            'stagiaire' => $stagiaire,
        ]);
    }

    //register stagiaire

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:20',
            'prenom' => 'required|string|min:3|max:20',
            'email' => 'required|email|unique:stagiaires,email',
            'password' => 'required|string|confirmed|min:5',
            'telephone' => 'required|digits:8',
            'datenaissance' => 'required|date',
            'adresse' => 'required|string|max:50',
            'cinoupassport_stagiaire' => 'required|unique:stagiaires,cinoupass_stagiaire', //digits:8|
            //'passport'=> 'digits:11|unique:stagiaires,passport',
            'niveauetude' => 'required|string',
            'specialite' => 'required|string',
            'filiere' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->messages(),
                // 'Erreur! Vérifier les Champs '
            ]);
        }
        // else if($request->cinoupassport_stagiaire){
        //     return response()->json([
        //         'status'=>500,
        //         'uni_errors'=>$validator->messages(),
        //        // 'Erreur! Cin ou Passport déjà existe'
        //     ]);
        // }
        else {

            $stagiaire = Stagiaire::create([
                'name' => $request->name,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telephone' => $request->telephone,
                'datenaissance' => $request->datenaissance,
                'adresse' => $request->adresse,

                'cinoupassport_stagiaire' => $request->cinoupassport_stagiaire,

                //'passport'=> $request->passport,
                'niveauetude' => $request->niveauetude,
                'specialite' => $request->specialite,
                'filiere' => $request->filiere,


                //role
                'role' => 'stagiaire',


                //Relation  
                'demandeStages' => [],



                //Relation2
                'travaux' => [],


            ]);

            $token = $stagiaire->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => 200,
                'username' => $stagiaire->name,
                'stagiaire' => $stagiaire,
                'token' => $token,
                //role
                'role' => 'stagiaire',
                'message' => 'vous êtes inscrits',
            ]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:stagiaires,email ',
            'password' => 'required|string|min:5',
        ]);
        if ($validator->fails()) {
            return response(
                [
                    'validation_errors' => $validator->messages(),
                    'status' => 422,
                ]
            );
        }


        $stagiaire = Stagiaire::where('email', $request->email)->first();
        if ($stagiaire) {
            if (Hash::check($request->password, $stagiaire->password)) {


                $role = 'stagiaire';
                $token = $stagiaire->createToken('StagiaireToken', ['server:stagiaire'])->plainTextToken;




                $response = ['token' => $token];
                return response()->json(
                    [
                        'message' => 'Bienvenu!',
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                        'username' => $stagiaire->name,
                        'status' => 200,

                    ]
                );
            } else {

                return response([
                    'message' => 'Stagiaire non existe',
                    'status' => 401,
                ]);
            }
        } else {

            return response([
                'message' => 'Stagiaire non existe',
                'status' => 401,
            ]);
        }
    }




    //verifier login
    public function incheck()
    {
        return response()->json([
            'message' => 'You are in',
            'status' => 200,
            'user' => auth()->user(),
        ], 200);
    }


    //Log out
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json(
            [
                'status' => 200,
                'message' => 'Logged out successfully',
            ]
        );
    }

    public function submit_score (Request $request, $id){
        $stagiaire = Stagiaire::where('_id', '=', $id)->first();
        $stagiaire->update($request->all());
        return response()->json(
            [
                'status' => 200,
                'message' => 'Score ajouté avec succée',
            ]
        );
    }

    //modifier profile
    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:20',
            'prenom' => 'required|string|min:3|max:20',
            //'email'=> 'required|email|unique:stagiaires,email',
            'email' => 'required|email',
            // 'password'=> 'required|string|confirmed|min:5',
            'telephone' => 'required|digits:8',
            'datenaissance' => 'required|date',
            'adresse' => 'required|string|max:50',
            'cinoupassport_stagiaire' => 'unique:stagiaires,cinoupass_stagiaire', //digits:8|
            //'passport'=> 'digits:11|unique:stagiaires,passport',
            'niveauetude' => 'required|string',
            'specialite' => 'required|string',
            'filiere' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validations fails',
                'validation_errors' => $validator->messages()
            ], 422);
        }

        $user = $request->user();

        $user->update([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            // 'password'=>Hash::make($request->password),
            'telephone' => $request->telephone,
            'datenaissance' => $request->datenaissance,
            'adresse' => $request->adresse,

            'cinoupassport_stagiaire' => $request->cinoupassport_stagiaire,

            //'passport'=> $request->passport,
            'niveauetude' => $request->niveauetude,
            'specialite' => $request->specialite,
            'filiere' => $request->filiere,



        ]);

        return response()->json([
            'message' => 'Profil modifié avec succès',
        ], 200);
    }


    //Test (Quiz)

    public function identifier(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:stagiaires,email',
            'cinoupassport_stagiaire' => 'required|unique:stagiaires', // cinoupass_stagiaire
            'niveauetude' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors()->first(),
            ]);
        } else {

            $etudiant = Stagiaire::create([
                'email' => $request['email'],
                'cinoupassport_stagiaire' => $request['cinoupassport_stagiaire'],
                'niveauetude' => $request['niveauetude'],
            ]);

            // $token = $etudiant->createToken($etudiant->cin . '_Token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'stagiaire' => $etudiant,
                // 'token' => $token,
                'message' => 'bienvenue au test',
            ]);
        }
    }
}
