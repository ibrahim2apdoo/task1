<?php

namespace App\Http\Controllers\Api\AdminApi\Testimonial;

use App\Http\Controllers\Api\GeneralApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TestimonialResource;
use App\Models\Testimonial;
use Exception;

class TestimonialController extends Controller
{
    use GeneralApiTrait;
    public function ShowIndex(){
        $testimonials=Testimonial::all();
        return $this->returnData( TestimonialResource::collection($testimonials)  ,"ok",200);
    }
    public function destroy($id){
        try {
            $testimonials=Testimonial::find($id);
            if (!$testimonials) {
                return $this->returnError( 401,"this Testimonial does not exits");
            }
            $testimonials->delete();
            return $this->returnData(null  ,"Testimonial Deleted Successful",200);
        }catch (Exception $exception){
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }

    }
    public function changeStatus($testimonial_id)
    {
        try {
            $testimonial = Testimonial::find($testimonial_id);
            if (!$testimonial) {
                return $this->returnError( 401,"this Testimonial does not exits");
            }
            $active = $testimonial->status == 0 ? 1 : 0;
            $testimonial->update([$testimonial->status=$active]);
            return $this->returnData(new TestimonialResource($testimonial)  ,"ok",200);

        } catch (\Exception $exception) {
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }
    }
}
