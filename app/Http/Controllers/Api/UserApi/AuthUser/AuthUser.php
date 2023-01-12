<?php

namespace App\Http\Controllers\Api\UserApi\AuthUser;

use App\Http\Controllers\Api\GeneralApiTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthUser extends Controller
{
    use  GeneralApiTrait;

    public function login(Request $request)
    {
        try {
            $rules = [
                "email" => "required",
                "password" => "required"

            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //login

              $credentials = $request->only(['email', 'password']);

             $token = Auth::guard('user-api')->attempt($credentials);

            if (!$token)
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');

            $user = Auth::guard('user-api')->user();
            $user->api_token = $token;
            //return token
            return $this->returnData('user', $user);

        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


    public function logout(Request $request)
    {

//        $token = $request->header('auth-token');
//        if ($token) {
            try {
//                JWTAuth::setToken($token)->invalidate(); //logout user
                Auth::guard('user-api')->logout();
            } catch (TokenInvalidException $e) {
                return $this->returnError('405', 'some ting went wrong');
            }
            return $this->returnSuccessMessage('تم تسجيل الخروج بنجاح', '200');
    }
//        } else {
//            return $this->returnError('405', 'some ting went wrong');
//        }
//
//    }
}
