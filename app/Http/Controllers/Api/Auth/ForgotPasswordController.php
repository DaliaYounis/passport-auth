<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//traits
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
      use SendsPasswordResetEmails;

    public function forgotPassword(Request $request)
    {
        try {
            $response = $this->broker()->sendResetLink(
                $this->credentials($request)
            );

            if ($response == Password::RESET_LINK_SENT) {
                return responseJson(true, trans('msg.send_reset_link_success'), [] , 200);
            } else {
                return responseJson(false, trans('error.send_reset_link_error'), [] , 422);
            }
        }catch (\Exception $e) {
            return responseJson(false, $e->getMessage(), [] , 422);
        }catch (\Error $e) {
            return responseJson(false, $e->getMessage(), [] , 422);
        }

    }




}
