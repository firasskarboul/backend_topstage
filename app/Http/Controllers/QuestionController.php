<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Stagiaire;
use App\Models\Test;
use App\Models\TestsQuestion;
use App\Models\QuestionsReponse;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //pour la création de l'examen
    {
        $questions = Question::all()->slice(0, 5); // slice 5 for test after change to random 20
        return response()->json([
            'questions' => $questions->map(function ($item, $key) {
                $rep = $item->getReponses;
                return $item->toArray();
            })
        ]);
    }

    public function showByTest($id_test)
    {
        $testQuestions = TestsQuestion::where('test_id', $id_test)->get();
        if ($testQuestions) {

            $questions = array();
            foreach ($testQuestions as $testQuestion) {
                $question = Question::find($testQuestion->question_id);
                array_push($questions, $question);
            }
            return   response()->json([
                'questions' => $questions,
                'status' => 200,
            ]);
        } else {
            return response()->json(
                [
                    'validation_errors' => 'test non trouvée', //$validator->messages()
                    'status' => 404,
                ]
            );
        }
    }

    public function getQuestionsByTest($id_test)
    {
        $testQuestions = TestsQuestion::where('test_id', $id_test)->get();
        if ($testQuestions) {

            $questions = array();
            foreach ($testQuestions as $testQuestion) {
                $reponses = QuestionsReponse::where('question_id', $testQuestion->question_id)->get();
                $question = Question::find($testQuestion->question_id);
                $reponsess = array();
                foreach ($reponses as $rep) {
                    $reponse = Reponse::find($rep->reponse_id);
                    array_push($reponsess, $reponse);
                }
                $question->réponses = $reponsess;
                array_push($questions, $question);
            }
            return   response()->json([
                'questions' => $questions,
                'status' => 200,
            ]);
        } else {
            return response()->json(
                [
                    'validation_errors' => 'test non trouvée', //$validator->messages()
                    'status' => 404,
                ]
            );
        }
    }



    public function show($id)
    {
        $question = Question::find($id);
        if ($question) {

            return   response()->json([
                'question' => $question,
                'status' => 200,
            ]);
        } else {
            return response()->json(
                [
                    'validation_errors' => 'question non trouvée', //$validator->messages()
                    'status' => 404,
                ]
            );
        }
    }

    /*  public function Question() {
        $questions = [];
        $etudiant = Stagiaire::login();
        if($etudiant->niveauetude === "bac") {
            $questions = allquestion::all();
        }
        
    } */


    public function allquestion()
    {
        $question = Question::all();
        return response()->json([
            'status' => 200,
            'questions' => $question

        ]);
    }

    public function sum()
    {
        $req = Question::all();
        $req = $req->pluck('time');
        return $req->sum();
        /* return response()->json([
            'Full time' => $req,
            'Nombre de question' =>count($req),
        ]);*/
    }
    public function random()
    {
        $req = Question::all();
        $req = $req->random(2);

        $sum = $req->pluck('time');
        return response()->json([
            'question' => $req,
            'full Time' => $sum->sum(),
        ]);
    }
    //return Questions::find(1)->getReponses;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'niveau' => 'required',
            'duree' => 'required',
            'points' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {

            $question = Question::create([
                'question' => $request['question'],
                'niveau' => $request['niveau'],
                'duree' => $request['duree'],
                'points' => $request['points'],
                'etat' => 'active',
                'réponses' => []

            ]);

            $linkTestQuestion = TestsQuestion::create([
                'question_id' => $question->id,
                'test_id' => $request['idTest']
            ]);

            $test = Test::where('titre', $request['titre'], 'departement', $request['departement'])->push([
                'questions' => [$question->id, $question->question, $question->niveau, $question->duree, $question->points]

            ]);
            /*      $test = Test::where('titre',$request['titre'])->push([
            'réponses'=>[$reponse->id , $reponse->reptexte , $reponse->repimage ,$reponse->repcorrecte]
        ]);
       */
            return response()->json([
                'status' => 200,
                'test' => $test,
                'message' => 'question est ajouté avec succès',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'niveau' => 'required',
            'duree' => 'required',
            'points' => 'required',
            'etat' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'validation_errors' => $validator->messages(),
                    'status' => 422,
                ]
            );
        } else {
            $question = Question::find($id);
            if ($question) {
                $question->question = $request->question;
                $question->niveau = $request->niveau;
                $question->duree = $request->duree;
                $question->points = $request->points;
                $question->etat = $request->etat;
                /*      $question->update($request->all());    */
                $question->save();

                return response()->json(
                    [
                        'status' => 200,
                        'message' => 'question updated successfully',

                    ]
                );
            } else {
                return response()->json(
                    [
                        'status' => 404,
                        'message' => 'question non trouvé',

                    ]
                );;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Question::destroy($id);
    }


    /**
     * Search the specified resource from storage.
     *
     * @param  str  $question
     * @return \Illuminate\Http\Response
     */
    public function search($question)
    {
        return Question::where('question', 'like', '%' . $question . '%')->get();
    }
}
