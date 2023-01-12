<?php

namespace App\Http\Controllers\Api\AdminApi;

use App\Http\Controllers\Api\GeneralApiTrait;

use App\Http\Resources\Api\AdminResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthAdmin extends Controller
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

            $token = Auth::guard('apiAdmin')->attempt($credentials);

            if (!$token)
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');

            $admin = Auth::guard('apiAdmin')->user();
            $admin->api_token = $token;

            return $this->returnData('admin', $admin );

        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


    public function logout( Request  $request){

//        $token=$request->header('auth-token');
//        if ($token){
        try {
//                JWTAuth::setToken($token)->invalidate(); //logout user
            Auth::guard('apiAdmin')->logout();
        } catch (TokenInvalidException $e) {
            return $this->returnError('405', 'some ting went wrong');
        }
        return $this->returnSuccessMessage('تم تسجيل الخروج بنجاح', '200');
    }
//        }else{
//            return   $this->returnError('405','some ting went wrong');
//        }

//        try {
//
//            $rules = [
//                'email'=>'required|email',
//                'password'=>'required',
//
//            ];
//
//            $validator = \Validator::make($request->all(), $rules);
//
//            if ($validator->fails()) {
//                $code = $this->returnCodeAccordingToInput($validator);
//                return $this->returnValidationError($code, $validator);
//            }
//
//
//            $remember_me = $request->has('remember_me') ? true : false;
//
//           $token=Auth::guard('apiAdmin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'),'status' => 1], $remember_me) ;
//            if (!$token)
//                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');
//
//            $admin = Auth::guard('apiAdmin')->user();
//            $admin->api_token = $token;
//            //return token
//            return $this->returnData('admin', $admin);
////                return redirect()->route('admin.dashboard');
//
//        }catch (Exception $exception){
//            return $this->returnError('E001', 'هناك خطا بالبيانات');
//        }

//    }

//    public function logout()
//    {
//        auth()->guard('admin')->logout();
//        return redirect(route('admin.login'));
//    }
//
//    public function logout(Request $request)
//    {
//        try {
//            auth()->guard('admin')->logout();
//
//            $request->session()->invalidate();
//
//            $request->session()->regenerateToken();
//
//            return redirect()->route('admin.login');
//        } catch (\Exception $e) {
//            return redirect()->back()->with('error', __('message.something_wrong'));
//        }
//    }

}
