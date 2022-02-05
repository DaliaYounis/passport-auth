<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

  public function register(Request $request){

      $input = $request->all();
      $input['password'] = bcrypt($input['password']);
      $user = User::create($input);
      $token = $user->createToken('My Token')->accessToken;
      $user->update(['api_token' => $token]);
      return  responseJson(true , 'success register' , ['token' => $token] , 200);





  }





}
