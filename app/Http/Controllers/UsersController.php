<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Cart;
use App\User;
use App\Order;
use App\OrderItem;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orderHistory() {

        // $oldCart = Session::get('cart');
        // $cart = new Cart($oldCart);

        if (Auth::user()) { 
            //$user = User::where('id',Auth::user()->id)->first();
            $orders = Order::where('email',Auth::user()->email)->get();
            return view('user.order-history', ['orders' => $orders]);
        }        
        return view('user.order-history');
    }

    public function orderView($id) {

        if (Auth::user()) { 
            $order_details = OrderItem::where('order_id',$id)->get();
            return view('user.order-view', ['order_details' => $order_details]);
        }        
        return view('user.order-view');
    }
}
