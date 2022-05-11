<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Question;
use App\Models\QuestionsReponse;

class ReponseController extends Controller
{
    public function index()
    {
        $reponse = Reponse::all();
        return response()->json([
            'status' => 200,
            'reponses' => $reponse

        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            //'repimage'=> 'required|image|mimes:jpeg,png,jpg|max:2048',
            'reptext' => 'required',
            'repcorrecte' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $reponse = new Reponse;

            $reponse->reptext = $request->input('reptext');
            $reponse->repcorrecte = $request->input('repcorrecte');

            if ($request->hasfile('repimage')) {
                $file = $request->file('repimage');
                $extension = $file->getClientOriginalExtension();

                $filename = time() . '.' . $extension;
                $file->move('uploads/images/', $filename);
                $reponse->repimage = 'uploads/images/' . $filename;
            }

            $reponse->save();

            $linkTestQuestion = QuestionsReponse::create([
                'correctAnswer' => $request['repcorrecte'],
                'question_id' => $request['id_question'],
                'reponse_id' => $reponse->id,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'réponse est ajouté avec succès',
            ]);
        }
    }

    public function showByQuestion($id_question)
    {
        $questionResponses = QuestionsReponse::where('question_id', $id_question)->get();
        if ($questionResponses) {

            $reponses = array();
            foreach($questionResponses as $questionResponse){
                $reponse = Reponse::find($questionResponse->reponse_id);
                array_push($reponses, $reponse);
            }
            return   response()->json([
                'reponses' => $reponses,
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
        return Reponse::find($id);
    }


    public function update(Request $request, $id)
    {
        $reponse = Reponse::find($id);
        $reponse->update($request->all());
        return $reponse;
    }


    public function destroy($id)
    {
        return Reponse::destroy($id);
    }
}
