<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rapport;
use App\Models\Stagiaire;
use Illuminate\Support\Facades\Validator;

class RapportController extends Controller
{

  public function store(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'file' => 'required' //|image|mimes:pdf,docx ',  //'required|image|mimes:pdf,xlx,csv|max:2048',
      // 'description'=>'string|max:200 ',

    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'validation_errors' => $validator->messages(),
          'status' => 400,
        ]
      );
    } else {
      $rapport = new Rapport;
      //  $rapport->description =$request->description;
      /*      
            if($request->hasFile('filerapport')){
             $file = $request->file('filerapport');
             $filename = $file->getClientOriginalName();
             $extension = $file->getClientOriginalExtension();
             
             $finalName = time(). '_' . $filename ;
             $request->file('filerapport')->storeAs('public/Upload/Rapports' , $finalName );
             $rapport->rfile='public/Upload/Rapports/'.$finalName;
             }  
 */
      if ($request->file('file')) {
        $filenameWithExt = $request->file('file')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('file')->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        $path = $request->file('file')->storeAs('public/Upload/Rapports', $fileNameToStore);
      }
      $insert_rapport_stagiaire = Stagiaire::where('_id', '=', $id)->update(['Rapport' => ['_id' => $id, 'rfile' => $path]]);

      $rapport->save();

      return response()->json(
        [
          'message' => 'Rapport déposé avec succès',
          'status' => 200,
          'rapport' => $rapport,

        ]
      );
    }
  }
}
