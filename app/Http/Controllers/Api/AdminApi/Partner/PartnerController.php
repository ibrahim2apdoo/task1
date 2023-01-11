<?php

namespace App\Http\Controllers\Api\AdminApi\Partner;

use App\Http\Controllers\Api\GeneralApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Http\Resources\Api\PartnerResource;
use App\Models\Partner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    use GeneralApiTrait;
    public function index()
    {
        $partners=Partner::all();
        return $this->returnData('Partners', PartnerResource::collection($partners)  ,"ok");
    }


    public function store(PartnerRequest $request)
    {
        try {
            if ($request->has('logo')) {
                $filePath = UploadImage('partners', $request->logo);
            }
            $partner=new Partner();
            $partner->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $partner->description = ['en' => $request->description_en, 'ar' => $request->description_ar];
            $partner->logo = $filePath;
            $partner->save();
            return $this->returnSuccessMessage(  "Partner Has Been Created Successful ",201);

        }catch (\Exception $exception){
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }
    }
    public function show($partner_id)
    {
        try {
            $partners=Partner::find($partner_id);
            if (!$partners){
                return $this->returnError( 401,"this Partner does not exits");
            }else{
                return $this->returnData('Partner',new PartnerResource($partners)  ,"ok" );
            }

        }catch (\Exception $exception){
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }
    }


    public function update(PartnerRequest $request, $partner_id)
    {
        try {
            $partners=Partner::find($partner_id);

            if (!$partners){
                return $this->returnError( 401,"this Partner does not exits");
            }else{
                    if (!$request->has('status')) {
                        $request->request->add(['status' => false]);
                    } else {
                        $request->request->add(['status' => true]);
                    }
                $partners->update([
                    $partners->name = ['en' => $request->name_en, 'ar' => $request->name_ar],
                    $partners->description = ['en' => $request->description_en, 'ar' => $request->description_ar],
                    $partners->status = $request->status,
                ]);
                if ($request->has('logo')) {
                    $filePath = UploadImage('partners', $request->logo);
                    File::delete($partners->logo);

                    $partners->update([
                        $partners->logo = $filePath,
                    ]);
                }
                return $this->returnSuccessMessage( "Partner updated Successful",200);
            }
        }catch (\Exception $exception){
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }
    }
    public function destroy($partner_id)
    {
        try {
            $partner = Partner::find($partner_id);
            if (!$partner) {
                return $this->returnError( 401,"this Partner does not exits");
            }

            $deleteImage= Str::after($partner->logo,'images/') ;
            $deleteImage=base_path('public/images/'.$deleteImage);
            unlink($deleteImage);
            $partner->delete();
            return $this->returnSuccessMessage( "Partner Deleted Successful",200);
        } catch (\Exception $exception) {
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }
    }
}
