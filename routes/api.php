<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
//use App\Http\Controllers\ForgotPasswordController;
//use App\Http\Controllers\ResetPasswordController;


use App\Http\Controllers\CompteController;
use App\Http\Controllers\DepartementController;

use App\Http\Controllers\DemandeStageController;

use App\Http\Controllers\SujetStageController;

use App\Http\Controllers\AuthControllerStagiaire;

use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\ForgotPasswordController;


use App\Http\Controllers\TravailController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\BilanController;

use App\Http\Controllers\MailController;

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\TestController;

use App\Http\Controllers\EventController;


// use App\Http\Controllers\AuthUtilisateursController;


// use App\Http\Controllers\ResetPasswordController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//accepter stagiaire

Route::post('accepter-demande', [MailController::class, 'accepter']);
Route::post('refuser-demande', [MailController::class, 'refuser']);
//Route::get('/profile', [AuthController::class, 'profile']);
//Route::put('/modifier-profile', [AuthController::class, 'update_profile']);

//Demande de stage
Route::get('/afficher-demandes-stagiaires', [DemandeStageController::class, 'index_demande_stagiaire']);
// Route::post('/ajouter-demande-stage',[DemandeStageController::class,'store']);
Route::get('/afficher-demandes-stages', [DemandeStageController::class, 'index']);
Route::delete('supprimer-demandes-stages/{id}', [DemandeStageController::class, 'destroy']);
Route::post('/ajouter-demande-stage', [DemandeStageController::class, 'store']);
//.Demande de stage 

//Sujet de stage
Route::post('/ajouter-sujet-stage', [SujetStageController::class, 'store']);
Route::delete('/supprimer-sujet/{id}', [SujetStageController::class, 'destroy']);
Route::get('/find-sujet/{id}', [SujetStageController::class, 'show']);
Route::put('/modifier-sujet/{id}', [SujetStageController::class, 'update']);
Route::get('/afficher-sujets-stages', [SujetStageController::class, 'index']);
//.Sujet de stage



//déposer travail / rapport / bilan
Route::post('/deposer-travail', [TravailController::class, 'store']);
Route::post('/deposer-rapport', [RapportController::class, 'store']);
Route::post('/deposer-bilan', [BilanController::class, 'store']);
//.déposer travail / rapport / bilan


//Afficher Tous Stagiaire
Route::get('/afficher-stagiaire', [AuthControllerStagiaire::class, 'index']);



//Utilisateur
Route::post('/u-forgot-password', [NewPasswordController::class, 'UforgotPassword']);
Route::post('/u-reset-password', [NewPasswordController::class, 'UresetPassword']);

//Stagiaire
Route::post('/s-forgot-password', [NewPasswordController::class, 'SforgotPassword']);
Route::post('/s-reset-password', [NewPasswordController::class, 'SresetPassword']);



/* Route::get('/profile', [AuthController::class, 'profile']);
Route::put('/modifier-profile', [AuthController::class, 'update_profile']);
 */

// Public routes
//Auth utilisateurs
Route::post('register', [AuthController::class, 'register']);
//Route::post('/login', [AuthController::class, 'login'])->name('login');


//Auth stagiaire
//Stagiaire
Route::post('/register-stagiaire', [AuthControllerStagiaire::class, 'register']);
Route::post('/login-stagiaire', [AuthControllerStagiaire::class, 'login']);
Route::put('submit-score/{id}', [AuthControllerStagiaire::class, 'submit_score']);


/* 
Route::post('ajouter-utilisateur', [AuthUtilisateursController::class, 'register']);
Route::post('login-utilisateur', [AuthUtilisateursController::class, 'login']);

 */





Route::get('comptes', [CompteController::class, 'index']);
Route::get('comptes/{id}', [CompteController::class, 'show']);
Route::put('comptes/{id}', [CompteController::class, 'update']);



// Route::post('forgotpassword', [ForgotPasswordController::class, 'forgotassword']);
/* 
Route::post('/comptes', [CompteController::class, 'store']);

Route::delete('/comptes/{id}', [CompteController::class, 'destroy']);
Route::get('/comptes/{key}', [CompteController::class, 'search']);

 */





// Protected routes
// Encadrant ---------------
// Route::group(['middleware' => ['auth:sanctum' , 'isAPIEncadrant']], function () {
//Route::get('comptes/{id}', [CompteController::class, 'show']);
/*  Route::get('/read_profile', [AuthController::class, 'profile']);
  Route::put('/update_profile', [AuthController::class, 'update_profile']);
   */
/*   Route::get('checkingAuthenticated', [AuthController::class, 'incheck']);
  Route::post('logout', [AuthController::class, 'logout']);
    
}); */

//Route::group(['middleware' => ['auth:sanctum' , 'isAPIEncadrant' ]], function () {

Route::get('checkingAuthenticated', [AuthController::class, 'incheck']);
Route::post('logout', [AuthController::class, 'logout']);

/* 
Route::post('/ajouter-sujet-stage',[SujetStageController::class,'store']);
//Route::get('/afficher-sujets-stages',[SujetStageController::class,'index']);
// Route::delete('/supprimer-sujet/{id}', [SujetStageController::class, 'destroy']);
Route::get('/find-sujet/{id}', [SujetStageController::class, 'show']);
Route::put('/modifier-sujet/{id}', [SujetStageController::class, 'update']); */


//}); 

/* 
  Route::group(['middleware' => ['auth:sanctum' , 'isAPIChefDepartement']], function () {
  
  //Route::get('/profile', [AuthController::class, 'profile']);
*/
//Route::get('checkingAuthenticated', [AuthController::class, 'incheck']);
Route::post('logout', [AuthController::class, 'logout']);

//Route::get('is-ChefDept', [AuthController::class, 'isChefDept']);

//});  





//service de formation
// Route::group(['middleware' => ['auth:sanctum' , 'isAPIServiceFormation']], function () {

//Route::get('checkingAuthenticated', [AuthController::class, 'incheck']);  
//logout
/*   Route::post('logout', [AuthController::class, 'logout']); */

//profile
/*  Route::get('profile', [AuthController::class, 'profile']);
  Route::put('modifier-profile', [AuthController::class, 'update_profile']); 
 */

//Département
Route::get('afficher-departements', [DepartementController::class, 'index']);
Route::post('ajouter-departement', [DepartementController::class, 'store']);
Route::get('find-departement/{id}', [DepartementController::class, 'show']);
Route::put('modifier-departement/{id}', [DepartementController::class, 'update']);
Route::delete('supprimer-departement/{id}', [DepartementController::class, 'destroy']);
//  }); 





/*Route::group(['middleware' => ['auth:sanctum' , 'isAPIStagiaire']], function () {
  
  // Route::get('/profile', [AuthController::class, 'profile']);

  Route::get('checkingAuthenticated', [AuthControllerStagiaire::class, 'incheck']);
  //Route::post('logout', [AuthControllerStagiaire::class, 'logout']);

  */
// Route::post('ajouter-demande-stage',[DemandeStageController::class,'store']); 

/*}); */
















/*  Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 */



//Route::post('/reset-password', [NewPasswordController::class, 'reset']);


Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::get('checkingAuthenticated', [AuthController::class, 'incheck']);

  Route::get('profile', [AuthController::class, 'profile']);
  Route::put('modifier-profile', [AuthController::class, 'update_profile']);
  Route::put('modifier-profile-stagiaire', [AuthControllerStagiaire::class, 'update_profile']);
  // Route::post('/deconnexion', [AuthController::class, 'deconnexion']);



  Route::post('logout', [AuthController::class, 'logout']);
});







//Questions
Route::get('/question', [QuestionController::class, 'index']);
Route::get('/allquestion', [QuestionController::class, 'allquestion']);
Route::get('/getramdom', [QuestionController::class, 'random']); // récuppérer les questions aléatoirement
Route::get('/question/{id}', [QuestionController::class, 'show']); //récupérer question avec réponse 
Route::delete('/question/{id}', [QuestionController::class, 'destroy']);
Route::put('/question/{id}', [QuestionController::class, 'update']);
Route::post('question', [QuestionController::class, 'store']);
Route::get('/question/{question}', [QuestionController::class, 'search']);
Route::get('/questionTest/{id_test}', [QuestionController::class, 'showByTest']);
Route::get('/questions/{id_test}', [QuestionController::class, 'getQuestionsByTest']);

//réponses
Route::get('/reponse', [ReponseController::class, 'index']);
Route::get('/reponse/{id}', [ReponseController::class, 'show']);
Route::get('/reponse-question/{id_question}', [ReponseController::class, 'showByQuestion']);
Route::put('/reponse/{id}', [ReponseController::class, 'update']);
Route::delete('/reponse/{id}', [ReponseController::class, 'destroy']);
Route::post('reponse', [ReponseController::class, 'store']);

//test
Route::post('test', [TestController::class, 'store']);
Route::get('/test', [TestController::class, 'index']);
Route::get('/randomTest/{niveau_stagiaire}', [TestController::class, 'random']);


Route::post('identifier/stage', [AuthControllerStagiaire::class, 'identifier']);
//calendrier
Route::get('events', [EventController::class, 'index']);
Route::delete('event/{id}', [EventController::class, 'destroy']);
Route::put('event/{id}', [EventController::class, 'update']);
Route::post('event', [EventController::class, 'store']);
Route::get('event/{id}', [EventController::class, 'show']);
