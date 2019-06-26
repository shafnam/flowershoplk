<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Input;
use App\Product;
use App\ProductPhoto;
use DB;
use Session;
use Excel;

class ExcelController extends Controller
{
    public function importFile(Request $request){

        if($_FILES["sample_file"]) {

            $filename = $_FILES["sample_file"]["tmp_name"];

            $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
            
            if(in_array($_FILES['sample_file']['type'],$mimes)){
                if($filename != "") {
                    
                    if($_FILES["sample_file"]["size"] > 0) {

                        $file = fopen($filename, "r");
        
                        $i = 0;
        
                        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
                        {
                            //dd($emapData);
                            $product_category_id;
                            $shop_id;
                            $name;
                            $code;
                            $price;
                            $width;
                            $height;
                            $description;
                            $status;
                            $errordata=array();
        
                            if($emapData[0]){
                                $product_category_id = $emapData[0];
                            }else{
                                $product_category_id = '';
                            } 

                            if($emapData[1]){
                                $shop_id = $emapData[1];
                            }else{
                                $shop_id = '';
                            } 
                                
                            if($emapData[2]){
                                $name = $emapData[2];
                            }else{
                                $name = '';
                            } 

                            if($emapData[3]){
                                $code = $emapData[3];
                            }else{
                                $code = '';
                            }
        
                            if($emapData[4]){
                                $price = $emapData[4];
                            }else{
                                $price = '';
                            }
        
                            if($emapData[5]){
                                $width = $emapData[5];
                            }else{
                                $width = '';
                            }
        
                            if($emapData[6]){
                                $height = $emapData[6];
                            }else{
                                $height = '';
                            }
        
                            if($emapData[7]){
                                $description = $emapData[7];
                            }else{
                                $description = '';
                            }
        
                            if($emapData[8]){
                                $status = $emapData[8];
                            }else{
                                $status = '';
                            }

                            //Validation
                            if($name == ''){
                                $errordata[]  = ['One of the records conatin an empty name field. Please check csv file and upload again.'];
                            }

                            if($code == ''){
                                $errordata[]  = ['One of the records conatin an empty name field. Please check csv file and upload again.'];
                            }

                            if($price == ''){
                                $errordata[]  = ['One of the records conatin an empty price field. Please check csv file and upload again.'];
                            }

                            if($description == ''){
                                $errordata[]  = ['One of the records conatin an empty description field. Please check csv file and upload again.'];
                            }
                            
                            //To ignore the first row from csv file
                            if($i > 0){
                                //not header of the table
                                if(sizeof($errordata) == 0){
                                    $product = new Product();
                                    $product->product_category_id = $product_category_id;
                                    $product->shop_id = $shop_id;
                                    $product->name = $name;
                                    $product->code = $code;
                                    $product->price = $price;
                                    $product->width = $width;
                                    $product->height = $height;
                                    $product->description = $description;
                                    $product->status = '0';
                                    $product->save();
                                    //store image details to db
                                    $file_name_to_store_in_db = 'default-placeholder-300x300.png';
                                    $product_photo = new ProductPhoto();
                                    $product_photo->title = $file_name_to_store_in_db;
                                    $product->product_photos()->save($product_photo);
                                }
                                else {
                                    return redirect(route('admin.products.list'))
                                    ->withErrors($errordata)
                                    ->withInput();
                                }
                            }
                            $i++;
                        }
                        fclose($file);
        
                        return redirect(route('admin.products.list'))->with('success_messge',"Products Added successfully...");              
                
                    }else{
                        return redirect(route('admin.products.list'))->with('error_messge',"Empty Sheet");
                    }

                }else{
                    return redirect(route('admin.products.list'))->with('error_messge',"Please import your csv file!");
                } 
            } else{
                return redirect(route('admin.products.list'))->with('error_messge',"File format error! only csv files allowed");
            }            
   
        }else{
            return redirect(route('admin.products.list'))->with('error_messge',"Please import your csv file!");
        } 
    }
}
