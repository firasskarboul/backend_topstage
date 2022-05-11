<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rapport;

use Validator;


class RapportController extends Controller
{
    
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(),[
       // 'rfile'=>'required|file|mimes:pdf,docx ',
      // 'description'=>'string|max:200 ',
      
     ]);

     if($validator->fails()){
      return response()->json(
          [ 'validation_errors' => $validator->messages() ,
            'status'=>400,
          ]);   
       }

       else{    
         $rapport = new Rapport;
         // $rapport->description =$request->description;
          
            if($request->hasFile('rfile')){
             $file = $request->file('rfile');
             $filename = $file->getClientOriginalName();
             $extension = $file->getClientOriginalExtension();
             
             $finalName = time(). '_' . $filename ;
             $request->file('rfile')->storeAs('public/Upload/Rapports' , $finalName );
             $rapport->rfile='public/Upload/Rapports/'.$finalName;
             } 

             $rapport->save();
            
    

           
                return response()->json(
                    ['message' => 'Rapport déposé avec succès',
                    'status'=>200,
                    'rapport' => $rapport,
       
                    ] );
       
               }


    }

    

}
