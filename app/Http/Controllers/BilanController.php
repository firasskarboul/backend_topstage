<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bilan;

use Validator;


class BilanController extends Controller
{

    
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(),[
       // 'bfile'=>'file|mimes:pdf,docx ',
        // 'description'=>'string|max:200 ',
      
     ]);

     if($validator->fails()){
      return response()->json(
          [ 'validation_errors' => $validator->messages() ,
            'status'=>400,
          ]);   
       }

       else{    
         $bilan = new Bilan;
         //$bilan ->description =$request->description;
          
            if($request->hasFile('bfile')){
             $file = $request->file('bfile');
             $filename = $file->getClientOriginalName();
             $extension = $file->getClientOriginalExtension();
             
             $finalName = time(). '_' . $filename ;
             $request->file('bfile')->storeAs('public/Upload/Bilans' , $finalName );
             $bilan->bfile='public/Upload/Bilans/'.$finalName;
             } 

             $bilan ->save();
            
    

              /*  $travail = Travail::create([
                  'bfile' => 'public/Traveaux/'.$finalName,
                   'description'=> $request->description,
                  
                   
                ]); */
           
                return response()->json(
                    ['message' => 'Bilan déposé avec succès',
                    'status'=>200,
                    'bilan' =>$bilan ,
       
                    ] );
       
               }


    }

    

}
