<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\CartItem;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;

class CartsController extends Controller
{
    public function addItem (Request $request, $item_id) {
        // Currently we are allowing to add only one item per order.
        if(Session::has('cart')){
            Session::flush();
        }
        //get product details with related images
        $product = Product::where('id', $item_id)->with('product_photos')->with('shops')->first();
        $delivery_area = $request->input('delivery_area');
        $delivery_array = explode(",",$delivery_area);
        //dd($delivery_array);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id,$delivery_array[0],$delivery_array[1]);
        $request->session()->put('cart', $cart); 
        
        return redirect(route('shoppingCart'))->with('success_messge',"Item successfully added to the cart...");
        //return redirect()->back()->with("success_messge","Item successfully added to the cart...");
    }

    public function updateItem (Request $request, $item_id) {
        $qty = $request->input('product_qty');
        $pid = $request->input('product_key');
        $product = Product::where('id', $item_id)->with('product_photos')->first();
        $delivery_area = $request->input('delivery_area');        
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        //dd($oldCart->items);
        //$key = array_search($pid, array_column($oldCart->items, 'pid'));
        
        foreach ($oldCart->items as $key => $val) {
            if($val['pid'] == $pid && $val['delivery_area'] == $delivery_area) {
                $item_key = $key;
                $oldQty = $oldCart->items[$item_key]['qty'];
                $updatedQty = $qty - $oldQty;
                $cart->updateQty($product, $product->id, $updatedQty, $pid, $delivery_area);   
                Session::put('cart', $cart);
            }
        }
        //dd($item_key);
        
        return redirect(route('shoppingCart'))->with("success_messge","Cart successfully updated...");
    }

    public function removeItem($pid) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($pid);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect(route('products'))->with('success_messge',"Item successfully removed from the cart...");
        //return redirect()->back()->with("success_messge","Item successfully removed from the cart...");
    }

    public function showCart () {
        //Session::flush(); // removes all session data , 'hasOrder' => 1
        if(!Session::has('cart')){
            return view('cart.view', ['products' => null]);
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('cart.view', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }
}
