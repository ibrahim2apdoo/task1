<?php

namespace App\Http\Controllers\Api\AdminApi\Admins;

use App\Http\Controllers\Api\GeneralApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Resources\Api\AdminResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use GeneralApiTrait;


    public function AllAdmins(){
        $admins=Admin::all();
//        dd($admins);
        return $this->returnData('Admins',AdminResource::collection($admins),"ok");
    }

    public function show($admin_id){
        try {
            $admins=Admin::find($admin_id);
            if (!$admins){
                return $this->returnError( 401,"this Admin does not exits");
            }else{
                return $this->returnData('Admin', new AdminResource($admins),"ok");
            }
        }catch (\Exception $exception){
            return $this->returnError( 404,"some thing wrong please try later");
        }

    }



















    public function store(AdminRequest $request){
        try {
            $admin=new Admin();
            $admin->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $admin->email = $request->email;
            $admin->password = Hash::make($request['password']);
            $admin->save();
            return $this->returnSuccessMessage( "Admin Has Been Created Successful ",201);
        }catch (\Exception $exception){
            return $this->returnError( 404,"some thing wrong please try later");
        }
    }









    public function update(AdminRequest $request,$admin_id){

        try {

            $admins=Admin::find($admin_id);
            if (!$admins){
                return $this->returnError( 401,"this Admin does not exits");
            }else{
                if (!$request->has('status')) {
                    $request->request->add(['status' => false]);
                } else {
                    $request->request->add(['status' => true]);
                }
                if (!$request->has('Is_admin')) {
                    $request->request->add(['Is_admin' => false]);
                } else {
                    $request->request->add(['Is_admin' => true]);
                }
                $admins->update([
                    $admins->name =['en' => $request->name_en, 'ar' => $request->name_ar],
                    $admins->email = $request->email,
                    $admins->password = Hash::make($request['password']),
                    $admins->status = $request->status,
                    $admins->Is_admin = $request->Is_admin,
                ]);
                return $this->returnSuccessMessage( "Admin Has Been Updated Successful ",201);
            }
        }catch (\Exception $exception){
            return $this->returnError( 404,"some thing wrong please try later");
        }
    }

    public function destroy($admin_id)
    {
        try {
            $admin = Admin::find($admin_id);
            if (!$admin) {
                return $this->returnError( 401,"this Admin does not exits");
            }else{
                $admin->delete();
            }
            return $this->returnSuccessMessage( "Admin Has Been Deleted Successful ",201);

        } catch (\Exception $exception) {
            return $this->returnError( 404,"some thing wrong please try later");
        }
    }





    public function changeStatus($admin_id)
    {
        try {
            $admin = Admin::find($admin_id);
            if (!$admin) {
                return $this->returnError( 401,"this Admin does not exits");
            }
            $active = $admin->status == 0 ? 1 : 0;
            $admin->update([$admin->status=$active]);
            return $this->returnSuccessMessage( "Admin Status Has Been Changed Successful ",201);

        } catch (\Exception $exception) {
            return $this->returnError( 404,"some thing wrong please try later");
        }
    }
}
