<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AllAdmins(){
        $admins=Admin::all();
        return view('Admin.Admins.index',compact('admins'));
    }
    public function create(){
        return view('Admin.Admins.create');
    }
    public function store(AdminRequest $request){
        try {
            $admin=new Admin();
            $admin->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $admin->email = $request->email;
            $admin->password = Hash::make($request['password']);
            $admin->save();
            return redirect()->route('admin.AllAdmins');
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
        }
    }
}
