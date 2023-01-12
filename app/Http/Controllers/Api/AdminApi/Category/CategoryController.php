<?php

namespace App\Http\Controllers\Api\AdminApi\Category;

use App\Http\Controllers\Api\GeneralApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Http\Resources\Api\CategoryResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use GeneralApiTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::get();
        return $this->returnData('categories',CategoryResource::collection($categories),"ok");
    }
    public function show($category_id)
    {
        try {
            $categories=Category::find($category_id) ;
            if (!$categories){
                return $this->returnError( 401,"this category does not exits");
            }else{
                return $this->returnData('Category',new CategoryResource($categories),"ok");
            }

        }catch (\Exception $exception){
            return $this->returnError( 404,"some thing wrong please try later ");
        }
    }





















    public function store(CategoryRequest $request)
    {
        try {
            if ($request->has('image')) {

            $filePath = UploadImage('categories', $request->image);
        }
            $category=new Category();
            $category->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $category->description = ['en' => $request->description_en, 'ar' => $request->description_ar];
            $category->image = $filePath;
            $category->added_by = Auth::guard('apiAdmin')-> user()->id;/* auth()->user()->id; */
            $category->save();
            return $this->returnSuccessMessage(  "Category Has Been Created Successful ",201);
        }catch (\Exception $exception){
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }
    }



    public function update(CategoryRequest $request, $category_id)
    {
        try {
            $categories=Category::find($category_id);

            if (!$categories){
                return $this->returnError( 401,"this category does not exits");
            }else{
                $categories->update([
                $categories->name = ['en' => $request->name_en, 'ar' => $request->name_ar],
                $categories->description = ['en' => $request->description_en, 'ar' => $request->description_ar],
                $categories->added_by = auth()->user()->id,
                ]);
                if ($request->has('image')) {
                    $filePath = UploadImage('categories', $request->image);
                    File::delete($categories->image);

                    $categories->update([
                        $categories->image = $filePath,
                    ]);
                }
                return $this->returnSuccessMessage( "Category Has Been Updated Successful",200);
            }
        }catch (\Exception $exception){
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }
    }



    public function destroy($category_id)
    {
        try {
            $category = Category::find($category_id);
            if (!$category) {
                return $this->returnError( 401,"this category does not exits");
            }
            $product = $category->products();
            if (isset($product) && $product->count() > 0) {
                return $this->returnError( 404,"You Can Not Delete This Category It Has A Products ");
            }
            $deleteImage= Str::after($category->image,'images/') ;
            $deleteImage=base_path('public/images/'.$deleteImage);
            unlink($deleteImage);
            $category->delete();
            return $this->returnSuccessMessage( "Category Has Been Deleted Successful ",201);
        } catch (\Exception $exception) {
            return $this->returnError( 404,"some thing wrong please try later");
        }
    }
    public function show_product($id)
    {
        try {
            $categories=Category::with('products')->find($id);
            if (!$categories) {
                return $this->returnError( 401,"this category does not exits");
            }
            return $this->returnData('Category', $categories ,"ok");
//            return view('website.home.show' ,compact('categories'));
        }catch (\Exception $exception) {
            return $this->returnError( 404,"some thing wrong please try later");
        }

    }
}
