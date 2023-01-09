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
        return $this->returnData(AdminResource::collection($admins),"ok",200);
    }

    public function edit($admin_id){
        try {
            $admins=Admin::find($admin_id);
            if (!$admins){
                return $this->returnError( 401,"this Admin does not exits");
            }else{
                return $this->returnData(new AdminResource($admins),"ok",200);
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
            return redirect()->route('admin.AllAdmins')->with(['success'=>trans('massage.success')]);
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
        }
    }









    public function update(AdminRequest $request,$admin_id){

        try {
            $admins=Admin::find($admin_id);
            if (!$admins){
                return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
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
                return redirect()->route('admin.AllAdmins')->with(['success'=>trans('massage.update')]);
            }
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
        }
    }

    public function destroy($admin_id)
    {
        try {
            $admin = Admin::find($admin_id);
            if (!$admin) {
                return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
            }else{
                $admin->delete();
            }
            return redirect()->route('admin.AllAdmins')->with(['success'=>trans('massage.delete')]);

        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
        }
    }
    public function changeStatus($admin_id)
    {
        try {
            $admin = Admin::find($admin_id);
            if (!$admin) {
                return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
            }
            $active = $admin->status == 0 ? 1 : 0;
            $admin->update([$admin->status=$active]);
            return redirect()->route('admin.AllAdmins')->with(['success'=>trans('massage.update')]);

        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
        }
    }
}
