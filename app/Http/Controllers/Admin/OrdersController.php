<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use Auth;
use App\Order;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function ordersList($id = null, Request $request){
        
        $items = $request->items ?? 10;      // get the pagination number or a default
        $user_type  = Auth::user()->title;
        
        $processing_orders =  Order::where('status', '2')->paginate($items);
        //dd($processing_orders);
        $completed_orders =  Order::where('status', '3')->paginate($items);
        $incomplete_orders = Order::where('status', '0')->paginate($items);
        $cancelled_orders = Order::where('status', '-1')->paginate($items);

        if($id){
            $order = Order::where('id',$id)->first();
            return view('admin.orders.orders-list',compact('processing_orders','completed_orders','cancelled_orders','incomplete_orders','order','user_type','items'));
        }
        return view('admin.orders.orders-list',compact('processing_orders','completed_orders','incomplete_orders','cancelled_orders','order','user_type','items'));
    }

    public function orderView($id){
        $order = Order::find($id);
        $user_type  = Auth::user()->title;
        return view('admin.orders.order-view',compact('order', 'user_type'));
    }

    public function orderEdit($id,Request $request){
        $order = Order::where('id',$id)->first();
        $user_type  = Auth::user()->title;
        if(!$order){
            return redirect(route('admin.orders.list'));
        }
        return view('admin.orders.order-edit',compact('order','user_type'));
    }

    public function orderUpdate($id,Request $request){
        //dd($id);
        $validator = Validator::make($request->all(),[
            'status' => 'required'
        ]);
        if($validator->fails()){
            return redirect(route('admin.order.edit.post',[$id]))
                ->withErrors($validator)
                ->withInput();
        }       

        // Update Order Status
        $order = Order::find($id);
        $order->status = $request->get('status');
        $order->save();       

        return redirect(route('admin.order.edit.get',[$id]))->with('success_messge',"Order status updated successfully...");
    }

    public function orderBulkUpdate(Request $request){
        $validator = Validator::make($request->all(),[
            'status.*' => 'required'
        ]);
        if($validator->fails()){
            return redirect(route('admin.orders.list'))
                ->withErrors($validator)
                ->withInput();
        }    

        $count = count($request->get('id')); //get total number of array element
        for ($i = 0; $i < $count; $i++) { // loop through array and assign values in variable and insert itin database
            
            $id = $request->get('id')[$i];
            //dd($id);
            // Update Status
            $order = Order::find($id);
            $order->status = $request->get('status')[$i];
            $order->save();
            //dd($shop_name);
        }

        return redirect()->back()->with('success_messge',"Order status updated successfully...");
    }

    
}
