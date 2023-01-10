<?php

namespace App\Http\Controllers\Api\AdminApi\Product;

use App\Http\Controllers\Api\GeneralApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Api\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use GeneralApiTrait;
    public function index()
    {
        $products=Product::with('category')->get();
        return $this->returnData( ProductResource::collection($products)  ,"ok",200);
    }


    public function store(ProductRequest $request)
    {
        try {
            if ($request->has('image')) {
                $filePath = UploadImage('products', $request->image);
            }
            $product=new Product();
            $product->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $product->description = ['en' => $request->description_en, 'ar' => $request->description_ar];
            $product->image = $filePath;
            $product->quantity = $request->quantity;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->save();
            return $this->returnData(new ProductResource($product),"Product Has Been Created Successful ",201);

        }catch (\Exception $exception){
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }
    }
    public function show($product_id)
    {
        try {
            $products=Product::find($product_id);
            if (!$products){
                return $this->returnError( 401,"this Product does not exits");
            }else{
                return $this->returnData(new ProductResource($products),"ok",200);
            }

        }catch (\Exception $exception){
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }
    }


    public function update(ProductRequest $request, $product_id)
    {
        try {
            $products=Product::find($product_id);

            if (!$products){
                return $this->returnError( 401,"this Product does not exits");
            }else{
                $products->update([
                    $products->name = ['en' => $request->name_en, 'ar' => $request->name_ar],
                    $products->description = ['en' => $request->description_en, 'ar' => $request->description_ar],
                    $products->category_id = $request->category_id,
                    $products->quantity = $request->quantity,
                    $products->price = $request->price,
                ]);
                if ($request->has('image')) {
                    $filePath = UploadImage('categories', $request->image);
                    File::delete($products->image);

                    $products->update([
                        $products->image = $filePath,
                    ]);
                }
                return $this->returnData(new ProductResource($products),"ok",200);
            }
        }catch (\Exception $exception){
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }
    }



    public function destroy($product_id)
    {
        try {
            $product = Product::find($product_id);
            if (!$product) {
                return $this->returnError( 401,"this Product does not exits");
            }

            $deleteImage= Str::after($product->image,'images/') ;
            $deleteImage=base_path('public/images/'.$deleteImage);
            unlink($deleteImage);
            $product->delete();
            return $this->returnData(null ,"Product Has Been Deleted Successful ",201);
        } catch (\Exception $exception) {
            return $this->returnError( 404,$exception->getMessage()."some thing wrong please try later");
        }
    }




    public function show_product_details($id){
        try {
            $product=Product::find($id);
            if (!$product){
                return redirect()->back()->withErrors(['error'=>trans('massage.no')]);
            }
            return view('website.home.show_product_details',compact('product'));
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>trans('massage.error')]);
        }


    }
}
