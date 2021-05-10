<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    public function signUp(Request $reg){
        $validate = Validator::make($reg->all(),
            [
                "name" => 'required',
                "second_name" => 'required',
                "login" => 'required',
                "password" => 'required|min:6',
            ]);
        if($validate->fails())
        {
            return respons()->json(
                [
                    "message"=>$validate->errors(),
                ]
            );
        }
        User::create($reg->all());
        return respons()->json("norm");
    }

    function signIn(Request$vhod){

        $validate=Validator::make($vhod->all(),
            [
                "login"=>'required',
                "password"=>'required',
            ]);

        if($validate->fails())
        {
            return respons()->json([
                "message"=>$validate->error(),
            ]);
        }

        $user = User::where("login",$vhod->login)->first();

        if($user)
        {
            if($vhod->password&&$user->password)
            {
                $user->api_token=Str::random(50);
                $user->save();
                return respons()->json([
                    "api_token"=>$user->api_token,
                ]);
            }
        }
return respons()->json([
            "message"=>"Вы не зарегестрированы!"
        ]);
    }

    public function output(Request$output){
        $user=User::where("login",$output->login)->first();
        if($user->api_token!=null)
        {
            $user->api_token=null;
            $user->save();
        }
    }

    public function reset_password(Request$reset){
        $validator=Validator::make($reset->all(),[
            "login"=>"required",
        ]);

        $user=User::where("login",$reset->login)->first();

        if($user){
            $new_password=Validator::make($reset->all(),[
                "password"=>"required|min:6",
            ]);
            $user->password=$new_password->password;
            $user->save();
        	return response()->json(
            [
            "password" => $user->password,
            ]
            );
        }
        return respons()->json("Логин не существует");
    }
}
