<?php

namespace App\Http\Controllers\Api\UserApi\Testimonial;

use App\Http\Controllers\Api\GeneralApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    use GeneralApiTrait;
    public function index(){
        return view('website.Testimonial.testimonial' );
    }
    public function create(TestimonialRequest $request){
        try {
            $data = $request->all();
//            return dd($request);
            $data['user_id']=auth()->user()->id;
            $data['opinion']= ['en' => $request->opinion_en, 'ar' => $request->opinion_ar];
            Testimonial::create($data);
            return $this->returnSuccessMessage('Your Testimonial Created Successful','201');
        }catch (\Exception $exception){
            return $this->returnError('Some Thing Went Wrong ','4001');
        }

    }
}
