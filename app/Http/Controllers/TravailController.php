<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Travail;

use Validator;

class TravailController extends Controller
{
  // public function deposer(Request $request){
  /*   $travail = new Travail;
         if($request->hasFile('tfile')){
             $completeFileName  = $request->file('tfile')->getClientOriginalName();
             $fileNameOnly = pathinfo($completeFileName , PATHINFO_FILENAME);
             $extension = $request->file('tfile')->getClientOriginalExtension();
             $comPic = str_replace(' ','_',$fileNameOnly).'-'.rand() . '_'.time().
             $extension;
             $path = $request->file('tfile')->storeAs('public/Traveaux' , $comPic);
             $travail->tfile =$comPic;
             //dd($path);
         }
         
       
         if($travail->save()){
              return ['status' => true , 'message' => 'Travail déposé avec succés']; 
         }else{
            return ['status' => false , 'message' => ' Error !! Travail non déposé']; 
         }  */














  //$travail = new Travail;
  /*  if($request->hasFile('tfile')){
             $file = $request->file('tfile');
             $filename = $file->getClientOriginalName();
             $extension = $file->getClientOriginalExtension();
             
             $finalName = time(). '_' . $filename ;
             $request->file('tfile')->storeAs('public/Traveaux' , $finalName );
              */
  //$finalName = date('His') . $filename;
  // $fileNameOnly = pathinfo($file , PATHINFO_FILENAME);
  //$finalName = date('His') . $filename;
  //$extension = $request->file('tfile')->getClientOriginalExtension();
  //$comPic = str_replace(' ','_',$fileNameOnly).'-'.rand() . '_'.time().$extension;            
  // $travail->tfile =$comPic;
  /*   $travail = Travail::create([
               'tfile' => 'public/Traveaux/'.$finalName,
               
            ]);
             return response()->json(["status" => true ,"message" => "Travail déposé avec succes"]);
          }
          else{
            return response()->json(["status" => false ,"message" => "vous devez sélectioner un fichier D'abord"]);
          } */

  //} 



  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      // 'tfile'=>'file|mimes:pdf,docx ',
      'description' => 'string|max:200 ',

    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'validation_errors' => $validator->messages(),
          'status' => 400,
        ]
      );
    } else {
      $travail = new Travail;

      $travail->description = $request->description;

      if ($request->hasFile('tfile')) {
        $file = $request->file('tfile');
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $finalName = time() . '_' . $filename;
        $request->file('tfile')->storeAs('public/Upload/Traveaux', $finalName);
        $travail->tfile = 'public/Upload/Traveaux/' . $finalName;
      }

      $travail->save();






      /*  $travail = Travail::create([
                  'tfile' => 'public/Traveaux/'.$finalName,
                   'description'=> $request->description,
                  
                   
                ]); */

      return response()->json(
        [
          'message' => 'Travail déposé avec succès',
          'status' => 200,
          'travail' => $travail,

        ]
      );
    }
  }
}
