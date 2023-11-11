<?php

namespace App\Http\Controllers\User;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Partener;



class UserController extends Controller
{
    use GeneralTrait;


    public function register(Request $request){
        $user=Auth::user();

        try{
            $rules = [
                "name" => "required",
                "email" => "required",
                "password" => "required",



            ];
            $validator = Validator::make ($request->all(),$rules) ;
            if($validator->fails ()) {
            $code = $this->returnCodeAccordingToInput ($validator);
            return $this->returnValidationError ($code, $validator);

            }

            $user=Auth::user();
            //register
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,


            ]  );




        }
        catch(\Exception $ex) {
        return $this->returnError($ex->getCode(),$ex->getMessage());
                }


    }


    public function login(Request $request){



       //validation
        try{
            $rules = [
                "email" => "required|exists:users,email",
                "password" => "required"

            ];
            $validator = Validator::make ($request->all(),$rules) ;
            if($validator->fails ()) {
            $code = $this->returnCodeAccordingToInput ($validator);
            return $this->returnValidationError ($code, $validator);

            }
            //login

            $credentials = $request->only(['email', 'password']);
            $token=Auth::guard('admin-api')->attempt($credentials);

            // dd('ewrew');

            if(!$token) {
                return $this->returnError('E001','data enterd in invalid');
            }

            $user=Auth::guard('admin-api')->user();
            $user->api_token=$token;

            //return token and data
            return $this->returnData('User',$user,'your Data');

        }
        catch(\Exception $ex) {
        return $this->returnError($ex->getCode(),$ex->getMessage());
                }
            }

}
