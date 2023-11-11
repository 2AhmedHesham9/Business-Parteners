<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use App\Models\Partener;
use App\Models\User;


class PartenerController extends Controller
{
    use GeneralTrait;

public function createpartener(Request $request){
    try{
        if (!empty($request->img_path)) {
            $file =$request->file('img_path');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.' . $extension;

            $file->move(public_path('partenerimages/'), $filename);
            $data['img_path']= 'public/partenerimages/'.$filename;

        }
        $rules = [
            "name_of_partener"=> "required",
            "description"=> "required",
            "link_company_profile"=> "required",
            "link_facebook"=> "required",
            "link_whatsapp"=> "required",
            "phone_number"=> "required",
            "link_instigram"=> "required",
            // "img_path"=> "required",



        ];
        $validator = Validator::make ($request->all(),$rules) ;
        if($validator->fails ()) {
        $code = $this->returnCodeAccordingToInput ($validator);
        return $this->returnValidationError ($code, $validator);

        }


        //create partener

        Partener::create([
            'name_of_partener' => $request->name_of_partener,
            'description' => $request->description,
            'link_company_profile' => $request->link_company_profile,
            'link_facebook' => $request->link_facebook,
            'link_whatsapp' => $request->link_whatsapp,
            'phone_number' => $request->phone_number,
            'link_instigram' => $request->link_instigram,
            'img_path' =>'/partenerimages/'.$filename,

        ]  );
    }
    catch(\Exception $ex) {
    return $this->returnError($ex->getCode(),$ex->getMessage());
            }


}
public function Showparteners(){

    $Partener = Partener::get();
    return $this->returnData('Partener',$Partener,"This is your data.");
}
public function updatepartener(Request $request){
    $partener=Auth::user();

    $partener=Partener::where('id',$request->id)->first();
    if(!$partener)
       return $this->returnError(404,"id not found");


       if (!empty($request->img_path)) {
        $file =$request->file('img_path');
        $extension = $file->getClientOriginalExtension();
        $filename = time().'.' . $extension;

        $file->move(public_path('partenerimages/'), $filename);
        $data['img_path']= 'public/partenerimages/'.$filename;

    }
    $userval = [
        'id'=>'required|integer',
        "name_of_partener"=> "required",
        "description"=> "required",
        "link_company_profile"=> "required",
        "link_facebook"=> "required",
        "link_whatsapp"=> "required",
        "phone_number"=> "required",
        "link_instigram"=> "required",
        // "img_path"=> "required",

    ];
    $partener->update(
        [

            'name_of_partener'=>$request->name_of_partener,
            'description'=>$request->description,
            'link_company_profile'=>$request->link_company_profile,
            'link_facebook'=>$request->link_facebook,
            'link_whatsapp'=>$request->link_whatsapp,
            'link_instigram'=>$request->link_instigram,
            'img_path'=>$request->img_path,
            'img_path'=>'/partenerimages/'.$filename,
        ]
    );
    $validator = Validator::make ($request->all(),$userval) ;
    if($validator->fails ()) {
          $code = $this->returnCodeAccordingToInput ($validator);
         return $this->returnValidationError ($code, $validator);
        }


    return $this->returnSuccessMessage('Data updated','200');

}
public function deletepartener($id){

    $Partener=Partener::findOrfail($id);

    $Partener->delete();
    return $this->returnSuccessMessage('deleted seccessfully','200');
}
public function restorepartener($id){

    if (Partener::where('id', $id )->exists()) {
    Partener::withTrashed()->findOrfail($id)->restore();
     return $this->returnSuccessMessage('restored seccessfully','200');
    }
    else
    {
        return $this->returnError('404','id not found');
    }



}
}
