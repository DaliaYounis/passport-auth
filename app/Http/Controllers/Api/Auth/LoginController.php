<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

use Illuminate\Foundation\Auth\ThrottlesLogins;


class LoginController extends Controller
{
    use ThrottlesLogins;


    public function login(Request $request) {

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return responseJson(false ,['too many login attempts' , 'minute' => $this->decayMinutes()] , [] , 422);
        }

        $user = User::where($this->username() ,'=' , $request->email)->first();
        if(Hash::check($request->password, $user->password)) {

            $this->clearLoginAttempts($request);
            $this->removeTokens($user);
            $token = $user->createToken('My Token')->accessToken;
            $data = [
                'api_token' => $token
            ];

            $user->update($data);
            return  responseJson(true , trans('msg.success_login') , ['token' => $token] , 200);

        }else {
            $this->incrementLoginAttempts($request);
            return  responseJson(false , trans('error.wrong_password') , [] , 422);
        }
    }

    public function logout() {

        $user = Auth::user();
        $this->removeTokens($user);
        return  responseJson(true , trans('msg.success_logout') , [] , 200);

    }




    public function username() {
        return "email";
    }


    public function removeTokens($user) {
        $tokens = $user->tokens()->pluck('id')->toArray();
        DB::table('oauth_access_tokens')->whereIn('id', $tokens)->delete();
    }

}
