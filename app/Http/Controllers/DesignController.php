<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\Design;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    use GeneralTrait;

    public function deletedesign($id){

        $design=Design::findOrfail($id);
        $design->delete();
        return $this->returnSuccessMessage('deleted seccessfully','');
    }

    public function createdesign(Request $request){
        try{
            $rules = [
                "header"=> "required",
                // "logo_path"=> "required",
            ];
            if (!empty($request->logo_path)) {
                $file =$request->file('logo_path');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.' . $extension;

                $file->move(public_path('designimages/'), $filename);
                $data['logo_path']= 'public/designimages/'.$filename;

            }
            // dd($data);

            $validator = Validator::make ($request->all(),$rules) ;
            if($validator->fails ()) {
            $code = $this->returnCodeAccordingToInput ($validator);
            return $this->returnValidationError ($code, $validator);

            }


            //create task

            Design::create([
                'header' => $request->header,
                'logo_path' =>'/designimages/'.$filename,


            ]  );

        }
        catch(\Exception $ex) {
        return $this->returnError($ex->getCode(),$ex->getMessage());
                }


    }
    public function Showdesign(){

            $Design = Design::get();
            return $this->returnData('Design',$Design,"This is your data.");
    }
    public function updatedesign(Request $request){

        $Design=Design::where('id',$request->id)->first();
        if(!$Design)
           return $this->returnError(404,"id not found");


        $userval = [
            'id'=>'required|integer',
            "header"=> "required",
            // "logo_path"=> "required",


        ];
        if (!empty($request->logo_path)) {
            $file =$request->file('logo_path');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.' . $extension;

            $file->move(public_path('designimages/'), $filename);
            $data['logo_path']= 'public/designimages/'.$filename;

        }
        $Design->update(
            [

                'header'=>$request->header,
                'logo_path'=> '/designimages/'.$filename,

            ]
        );
        $validator = Validator::make ($request->all(),$userval) ;
        if($validator->fails ()) {
              $code = $this->returnCodeAccordingToInput ($validator);
             return $this->returnValidationError ($code, $validator);
            }


        return $this->returnSuccessMessage('Data updated','200');

    }
}
