<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class SessionController extends Controller
{
    public function index($sessionToken){

        return user::where('name',$sessionToken)->first();
    }

    public function getSession($sessionID){
        $session = user::where('name',$sessionID)->get();
        if(count($session) == 0){return "false";}
        else{return "true";}
    }

    public function session(Request $request){
        $request->validate([
            "secretToken" => 'required'
        ]);
        $token = Str::random(60);
        $user = user::create([
            "name" => $request->secretToken,
            "password" => bcrypt($request->secretToken),
            "api_token" => hash('sha256',$token),
        ]);

        $response = [
            "User" => $user,
            "Token" => $token
        ];

        return response($response, 201);
    }

    public function sessionLogout(){
        auth()->user()->tokens()->delete();
        auth()->user()->delete();
        return "logged out!";
    }

    public function updateScenario(Request $request) {
        $request->validate([
            "secretToken" => 'required',
            "scenario" => 'required'
        ]);
        user::where('name',$request->secretToken)->update(["scenario"=>$request->scenario]);
        return $request->all();
    }
}
