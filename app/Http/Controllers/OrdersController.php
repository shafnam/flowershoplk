<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Cart;
use App\User;
use App\Order;
use App\OrderItem;
use App\Product;
use App\ProductCategory;
use App\Location;
use App\Shop;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/
    
    public function orderItems () {
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        if (Auth::user()) { 
            $user = User::where('id',Auth::user()->id)->first();
            return view('order.view', ['user' => $user, 'products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
        }        
        return view('auth.order-login');
        //return view('order.view', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function orderItemsGuest () {
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $locations = Location::all();
        //dd($locations);

        if (Auth::user()) { 
            $user = User::where('id',Auth::user()->id)->first();
            return view('order.view', ['user' => $user, 'products' => $cart->items, 'totalPrice' => $cart->totalPrice, 'locations' => $locations]);
        }
        return view('order.view', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice, 'locations' => $locations]);
    }

    public function saveOrder(Request $request) {

        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'phone' => 'required|numeric|digits:10',
            'email' => 'required',
            'date'    => 'required|array|min:1',
            'date.*'  => 'required|after:today',
            'dphone'    => 'required|array|min:1',
            //'dphone.*'  => 'required|numeric|digits:9|regex:/(7)[0-9]{8}/',
            'dphone.*'  => 'required|regex:/(07)[0-9]{8}/',
            'address'    => 'required|array|min:1',
            'address.*'  => 'required',
            'special_note_checker.*'    => 'sometimes|array|min:1',
            'special_note_checker.*' => 'sometimes',
            'special_note.*'    => 'required|array|min:1',
            'special_note.*'       => 'required_if:special_note_checker.*,on',
            //|regex:/(07)[0-9]{8}/ number starts with 07 has 8 more numbers in between 0-9
        ]);
        if($validator->fails()){
            return redirect(route('orderItemsGuest.get'))
                ->withErrors($validator)
                ->withInput();
        }   
        
        // create new order id
        $order_id = Order::count() + 101; 

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        if (Auth::user()) { 
            $email = $request->input('u_email');
        }
        else {
            $email = $request->input('email');
        }
        $phone = $request->input('phone');

        // save order details to db if not exist
        $order = new Order();
        $order->title = 'FP_Order_#'. $order_id;
        $order->total = $request->get('total');
        $order->items_count = $cart->totalQty;
        $order->first_name = $first_name;
        $order->last_name = $last_name;
        $order->email = $email;
        $order->phone = $phone;
        $order->status = 0;
        $order->save();            
        $id = $order->id;

       
        $count = count($request->get('item_id')); 
        for ($i = 0; $i < $count; $i++) {
            $product_category = ProductCategory::where('id',$request->get('item_category')[$i])->first();
            $product_code = Product::where('name',$request->get('item_name')[$i])->first();
            $product_total = ($request->get('amount')[$i] * $request->get('quantity')[$i] ) + $request->get('delivery_fee')[$i];
            $product_commission = ( ($request->get('amount')[$i] * $request->get('quantity')[$i] ) + $request->get('delivery_fee')[$i] ) * 0.15 ;
            $product_payhere_fee = ( ( ($request->get('amount')[$i] * $request->get('quantity')[$i] ) + $request->get('delivery_fee')[$i] ) * 0.033 ) + 30 ;
            // save order item details to db
            $order_item = new OrderItem();
            $order_item->order_id = $id;
            $order_item->product_category = $product_category->name;
            $order_item->product_code = $product_code->code;
            $order_item->product_name = $request->get('item_name')[$i];
            $order_item->product_price = $request->get('amount')[$i];
            $order_item->product_delivery_fee = $request->get('delivery_fee')[$i];
            $order_item->product_total = number_format($product_total, 2, '.', '');
            $order_item->product_commission = number_format($product_commission, 2);
            $order_item->product_payhere_fee = number_format($product_payhere_fee, 2);
            $order_item->product_image = $request->get('item_image')[$i];
            $order_item->product_height = $request->get('item_height')[$i];
            $order_item->product_width = $request->get('item_width')[$i];
            $order_item->product_description = $request->get('item_description')[$i];
            $order_item->product_shop_phone =  $request->get('item_shop_phone')[$i];
            $order_item->product_shop_name =  $request->get('item_shop_name')[$i];
            $order_item->product_qty = $request->get('quantity')[$i];
            $order_item->delivery_date = $request->get('date')[$i];
            $order_item->delivery_address = $request->get('address')[$i];
            $order_item->delivery_city = $request->get('city')[$i];
            $order_item->delivery_phone = $request->get('dphone')[$i];
            $order_item->delivery_special_note = $request->get('special_note')[$i];
            //Save one to many relationship
            $order->order_items()->save($order_item);
        }
        
        return redirect(route('showOrder.get',[$id]));
    }

    public function showOrder ($id,Request $request) {
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $products = $cart->items;
        $order = Order::where('id',$id)->with('order_items')->first(); 
        
        return view('order.payhere',compact('order','products'));
    }

    public function payhereNotify(Request $request) {
        error_log("ABC");
    }

    public function payhereReturn(Request $request) {
        Session::forget('cart');
        $order_id = str_replace("FP_Order_#", "",  $request->input('order_id'));
        $order_id -= 100;
        /*$order = Order::where('id', $order_id)->first();
        $order_status = $order->status;*/
        return view('order.return',compact('order_id'));
    }

    public function payhereCancel(Request $request) {
        return 123;
    }
}
