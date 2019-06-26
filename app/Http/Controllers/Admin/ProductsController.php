<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Auth;
use App\Product;
use App\ProductCategory;
use App\ProductPhoto;
use App\Shop;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        //$this->middleware('auth:admin', ['except' => ['admin/login']]);  
    }

    public function productsList($id =null){
        // $all_products =  Product::orderBy('created_at', 'desc')->paginate(20);
        $all_products =  Product::all();
        $user_type  = Auth::user()->title;
        
        if($id){
            $product = Product::where('id',$id)->first();            
            return view('admin.products.products-list',compact('all_products','product','user_type'));
        }
        
        return view('admin.products.products-list',compact('all_products','product','user_type'));
        //return view('middleware')->withMessage("Admin");
    }

    public function productAdd(){
        $all_categories = ProductCategory::where('status',1)->get();
        $all_shops = Shop::where('status',1)->get();
        $user_type  = Auth::user()->title;
        return view('admin.products.product-add',compact('all_categories','all_shops','user_type'));
    }

    public function productSave(Request $request){
        
        $validator = Validator::make($request->all(),[
            'product_name' => 'required',
            'product_code' => 'required',
            'product_category' => 'required',
            'shop_name' => 'required',
            'product_price' => 'required',
            'product_description' => 'required',
            // 'product_height' => 'nullable',
            // 'product_width' => 'nullable',
            'file_upload' => 'required|array|min:1',
            'file_upload.*' => 'required|min:1|dimensions:ratio=1/1'
        ]);
        if($validator->fails()){
            return redirect(route('admin.product.add.get'))
                ->withErrors($validator)
                ->withInput();
        }       

        //Handle file uploads (five uploads)
        if($request->hasFile('file_upload'))
        {
            foreach($request->file('file_upload') as $file_upload){

                // Get File name with the extension
                $filenameWithExt = $file_upload->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $file_upload->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'-'.time().'.'.$extension;
                $path =  public_path().'/product-photos/';
                // Upload Image
                $file_upload->move($path, $fileNameToStore);
                //Store the names of the files in an array
                $fileNamesToStore[] = $fileNameToStore;
            }
        }

        $product = new Product();
        $product->product_category_id = $request->get('product_category');
        $product->shop_id = $request->get('shop_name');
        $product->name = $request->get('product_name');
        $product->code = $request->get('product_code');
        $product->price = $request->get('product_price');
        $product->width = $request->get('product_width');
        $product->height = $request->get('product_height');
        $product->description = $request->get('product_description');
        $product->status = '1';
        $product->save();

        //Create Product Photos
        if($request->hasFile('file_upload')){
            foreach($fileNamesToStore as $fileNameToStoreinDb){
                $product_photo = new ProductPhoto();
                $product_photo->title = $fileNameToStoreinDb;
                //Save one to many relationship
                $product->product_photos()->save($product_photo); 
            }
        }
        else{
            $fileNameToStoreinDb = 'default-placeholder-300x300.png';
            $product_photo = new ProductPhoto();
            $product_photo->title = $fileNameToStoreinDb;
            //Save one to many relationship
            $product->product_photos()->save($product_photo); 
        }

        return redirect(route('admin.product.add.get'))->with('success_messge',"Product Added successfully...");
    }

    public function productView($id){
        $product = Product::find($id);
        $user_type  = Auth::user()->title;
        return view('admin.products.product-view',compact('product', 'user_type'));
    }

    public function productEdit($id,Request $request){
        $product = Product::where('id',$id)->first();
        $all_categories = ProductCategory::where('status',1)->get();
        $all_shops = Shop::where('status',1)->get();
        $user_type  = Auth::user()->title;
        if(!$product){
            return redirect(route('admin.products.list'));
        }
        return view('admin.products.product-edit',compact('product','all_categories','all_shops','user_type'));
    }

    public function productUpdate($id,Request $request){

        $validate_these = [
            'product_name' => 'required',
            'product_code' => 'required',
            'product_category' => 'required',
            'shop_name' => 'required',
            'product_price' => 'required',
            'product_description' => 'required'
        ];

        if(count($request->input('file_upload')) <= 0){
            $validate_these['file_upload'] = 'required|array|min:1';
            $validate_these['file_upload.*'] = 'required|min:1|dimensions:ratio=1/1';
        }

        $validator = Validator::make($request->all(), $validate_these);
        if($validator->fails()){
            return redirect(route('admin.product.edit.post',[$id]))
                ->withErrors($validator)
                ->withInput();
        }

        //$product = Product::find($id);

        //Handle file uploads
        if($request->hasFile('file_upload'))
        {
            foreach($request->file('file_upload') as $file_upload){
                
                // Get File name with the extension
                $filenameWithExt = $file_upload->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $file_upload->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'-'.time().'.'.$extension;
                $path =  public_path().'/product-photos/';
                // Upload Image
                $file_upload->move($path, $fileNameToStore);
                //Store the names of the files in an array
                $fileNamesToStore[] = $fileNameToStore;
            }
        }

        // Update Product
        $product = Product::find($id);
        $product->product_category_id = $request->get('product_category');
        $product->shop_id = $request->get('shop_name');
        $product->name = $request->get('product_name');
        $product->code = $request->get('product_code');
        $product->price = $request->get('product_price');
        $product->width = $request->get('product_width');
        $product->height = $request->get('product_height');
        $product->description = $request->get('product_description');
        $product->status = '1';
        $product->save();

        //check whether any image has been deleted when editing the product
        $product_image_ids = ProductPhoto::where('product_id', $id)->pluck('id'); //1 3 5
        if($request->input('file_upload')){
            $existing_product_image_ids = $request->input('file_upload');
        } else {
            $existing_product_image_ids = ['-1'];
        }        
        
        foreach ($product_image_ids as $product_image_id) {
            if(!in_array($product_image_id , $existing_product_image_ids)) {
                $imageName = ProductPhoto::where('id', $product_image_id)->pluck('title');                
                if($imageName[0] != 'default-placeholder-300x300.png'){
                    //dd($imageName[0]);
                    // Delete photo from folder
                    $image_path = public_path('product-photos/'.$imageName[0]);
                    //dd($image_path);
                    unlink($image_path);
                } 
                // Delete record from db
                ProductPhoto::where('id', $product_image_id)->delete();           
            }
        }    

        //If new photos are uploaded 
        if($request->hasFile('file_upload')){
            foreach($fileNamesToStore as $fileNameToStoreinDb){                
                $product = Product::find($id);
                $productPhoto = new ProductPhoto;
                $productPhoto->title = $fileNameToStoreinDb;
                $product->product_photos()->save($productPhoto);
            }
        }

        return redirect(route('admin.product.edit.get',[$id]))->with('success_messge',"Product updated successfully...");
    }

    public function productDeactivate($id){
        $product = Product::find($id);
        $product->status = '0';
        $product->save();

        return redirect(route('admin.products.list'))->with('success', 'Product Deactivated');
    }

    public function productActivate($id){
        $product = Product::find($id);
        $product->status = '1';
        $product->save();

        return redirect(route('admin.products.list'))->with('success', 'Product Activated');
    }
}
