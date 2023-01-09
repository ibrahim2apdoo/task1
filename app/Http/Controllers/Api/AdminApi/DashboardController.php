<?php

namespace App\Http\Controllers\Api\AdminApi;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        return view('Admin.dashboard');
    }

}
