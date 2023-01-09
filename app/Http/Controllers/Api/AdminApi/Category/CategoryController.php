<?php

namespace App\Http\Controllers\Api\AdminApi\Category;

use App\Http\Controllers\Api\GeneralApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Http\Resources\Api\CategoryResource;
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
        return $this->returnData(CategoryResource::collection($categories),"ok",200);
    }
    public function edit($category_id)
    {
        try {
            $categories=Category::find($category_id) ;
            if (!$categories){
                return $this->returnError( 401,"this category does not exits");
            }else{
                return $this->returnData(new CategoryResource($categories),"ok",200);
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
            $category->added_by = auth()->user()->id;
            $category->save();
            return redirect()->route('Category.index')->with(['success'=>trans('massage.success')]);
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
        }
    }



    public function update(CategoryRequest $request, $category_id)
    {
        try {
            $categories=Category::find($category_id);

            if (!$categories){
                return redirect()->back()->withErrors(['error'=>trans('massage.no')]);
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
                return redirect()->route('Category.index')->with(['success'=>trans('massage.update')]);
            }
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
        }
    }
    public function destroy($category_id)
    {
        try {
            $category = Category::find($category_id);
            if (!$category) {
                return redirect()->back()->withErrors(['error'=>trans('massage.no')]);
            }
            $product = $category->products();
            if (isset($product) && $product->count() > 0) {
                return redirect()->route('Category.index')->with(['error' => trans('massage.noPermation')]);
            }
            $deleteImage= Str::after($category->image,'images/') ;
            $deleteImage=base_path('public/images/'.$deleteImage);
            unlink($deleteImage);
            $category->delete();
            return redirect()->route('Category.index')->with(['success'=>trans('massage.delete')]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
        }
    }
    public function show_product($id)
    {

        $categories=Category::find($id);
        return view('website.home.show' ,compact('categories'));
    }
}
