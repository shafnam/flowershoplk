<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Auth;
use App\Shop;
use App\ProductDelivery;
use App\Location;

class ShopsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function shopsList($id =null){
        $all_shops =  Shop::orderBy('status', 'DESC')->paginate(10);
        $user_type  = Auth::user()->title;
        if($id){            
            $shop = Shop::where('id',$id)->first();            
            return view('admin.shops.shops-list',compact('all_shops','shop','user_type'));
        }
        return view('admin.shops.shops-list',compact('all_shops','shop','user_type'));
    }

    public function shopAdd(){
        $user_type  = Auth::user()->title;
        $all_locations = Location::all();
        return view('admin.shops.shop-add',compact('user_type','all_locations'));
    }

    public function shopSave(Request $request){
        
        $validator = Validator::make($request->all(),[
            'shop_name' => 'required',
            'owner_name' => 'required',
            'shop_phone' => 'required|numeric|digits:10',
            'shop_email' => 'required',
            'shop_address' => 'required',
            'delivery_area'    => 'required|array',
            'delivery_area.*'  => 'required',
            'delivery_charge'    => 'required|array',
            'delivery_charge.*'  => 'required',
        ]);
        if($validator->fails()){
            return redirect(route('admin.shop.add.get'))
                ->withErrors($validator)
                ->withInput();
        }

        //Save shop details
        $shop = new Shop();
        $shop->name = $request->get('shop_name');
        $shop->owner_name = $request->get('owner_name');
        $shop->address = $request->get('shop_address');
        $shop->phone = $request->get('shop_phone');
        $shop->email = $request->get('shop_email'); 
        $shop->status = '1';
        $shop->save();
        
        $count = count($request->get('delivery_area')); //get total number of array element
        if($count > 0) {
            for ($i = 0; $i < $count; $i++) { // loop through array and assign values in variable and insert it to database 
                $location = Location::find($request->get('delivery_area')[$i]);
                $delivery_charge = $request->get('delivery_charge')[$i];
                //save many to many data
                $shop->locations()->attach($location,['delivery_charge' => $delivery_charge]);
            }    
        } else {            
            $location = 'Colombo 01';
            $delivery_charge = 100.00;
            //save many to many data
            $shop->locations()->attach($location,['delivery_charge' => $delivery_charge]);               
        }            

        return redirect(route('admin.shop.add.get'))->with('success_messge',"Shop Added successfully...");
    }

    public function shopEdit($id,Request $request){
        $shop = Shop::where('id',$id)->first();
        $user_type  = Auth::user()->title;
        $all_locations = Location::all();
        if(!$shop){
            return redirect(route('admin.shops.list'));
        }
        return view('admin.shops.shop-edit',compact('shop','user_type','all_locations'));
    }

    public function shopUpdate($id,Request $request){
        //dd($id);
        $validator = Validator::make($request->all(),[
            'shop_name' => 'required',
            'owner_name' => 'required',
            'shop_phone' => 'required|numeric|digits:10',
            'shop_email' => 'required',
            'shop_address' => 'required',
            'delivery_area'    => 'required|array',
            'delivery_area.*'  => 'required',
            'delivery_charge'    => 'required|array',
            'delivery_charge.*'  => 'required',
        ]);
        if($validator->fails()){
            return redirect(route('admin.shop.edit.post',[$id]))
                ->withErrors($validator)
                ->withInput();
        }

        // Update Shop Details
        $shop = Shop::find($id);
        $shop->name = $request->get('shop_name');
        $shop->owner_name = $request->get('owner_name');
        $shop->address = $request->get('shop_address');
        $shop->phone = $request->get('shop_phone');
        $shop->email = $request->get('shop_email'); 
        $shop->status = '1';
        $shop->save();

        $delivery_areas = $shop->locations()->wherePivot('shop_id', $id)->pluck('locations.id')->toArray();
        $edit_delivery_areas = $request->input('delivery_area');

        $count = count($request->get('delivery_area'));

        //check whether any area has been deleted when editing the shop details. if so delete them
        foreach ($delivery_areas as $delivery_area) {
            if (!in_array($delivery_area, $edit_delivery_areas)) {
                // Delete record 
                $shop->locations()->detach($delivery_area);
            }
        }

        for ($i = 0; $i < $count; $i++) { 
            if (!in_array($request->get('delivery_area')[$i], $delivery_areas)) {
                // save many to many data
                // $user->roles()->attach($roleId, ['expires' => $expires]);
                $shop->locations()->attach($request->get('delivery_area')[$i],['delivery_charge' => $request->get('delivery_charge')[$i]]);
            } else {   
                // update  many to many data         
                // $shop->locations()->sync(array(1, 2, 5));      
                $shop->locations()->sync([$request->get('delivery_area')[$i] => ['delivery_charge' => $request->get('delivery_charge')[$i]]],false);
            }
        }

        return redirect(route('admin.shop.edit.get',[$id]))->with('success_messge',"Shop updated successfully...");
    }

    public function shopView($id){
        $shop = Shop::find($id);
        $user_type  = Auth::user()->title;
        return view('admin.shops.shop-view',compact('shop','user_type'));
    }

    public function shopDeactivate($id){
        $shop = Shop::find($id);
        $shop->status = '0';
        $shop->save();

        return redirect(route('admin.shops.list'))->with('success', 'Shop Deactivated');
    }

    public function shopActivate($id){
        $shop = Shop::find($id);
        $shop->status = '1';
        $shop->save();

        return redirect(route('admin.shops.list'))->with('success', 'Shop Activated');
    }

    public function shopBulkUpdate(Request $request){        

        $validator = Validator::make($request->all(),[
            'shop_name.*' => 'required',
            'owner_name.*' => 'required',
            'shop_phone.*' => 'required|numeric|digits:10',
            'shop_email.*' => 'required',
            'shop_address.*' => 'required'
        ]);
        if($validator->fails()){
            return redirect(route('admin.shops.list'))
                ->withErrors($validator)
                ->withInput();
        }    

        $count = count($request->get('id')); //get total number of array element
        for ($i = 0; $i < $count; $i++) { // loop through array and assign values in variable and insert itin database
            
            /*$shop_name = $request->get('shop_name')[$i];
            $owner_name = $request->get('owner_name')[$i];*/
            $id = $request->get('id')[$i];

            // Update shop
            $shop = Shop::find($id);
            $shop->name = $request->get('shop_name')[$i];
            $shop->owner_name = $request->get('owner_name')[$i];
            $shop->address = $request->get('shop_address')[$i];
            $shop->phone = $request->get('shop_phone')[$i];    
            $shop->email = $request->get('shop_email')[$i];
            $shop->status = $request->get('status')[$i];
            $shop->save();
            //dd($shop_name);
        }

        return redirect()->back()->with('success_messge',"Shop details updated successfully...");
    }


}
