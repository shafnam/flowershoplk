<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\OrderItem;
use App\Shop;
use DB;
use Mail;
use App\Mail\SendMail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $featured_products = Product::where('status',1)->where('featured',1)->get();
        $latest_products = Product::where('status',1)->orderBy('created_at','desc')->take(8)->get();
        $all_products = Product::where('status',1)->get();
        return view('index',compact('all_products','featured_products','latest_products'));

    }

    public function contact()
    {
        //$products = Product::where('status',1)->get();
        return view('contact');
    }

    public function postContactUs(Request $request) {    
        
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);

        //Send email
        Mail::send(new SendMail());

        return redirect(route('contact'))->with('success_messge',"Stay tuned, Your message was sent successfully..!!");
    }

    public function newProducts()
    {
        $new_products = Product::where('status',1)->orderBy('created_at','desc')->take(8)->get();
        return view('footer.new-products',compact('new_products'));
    }

    public function topSellers()
    {
        $top_sellers_products = DB::table('order_items')
        ->select(DB::raw('COUNT(product_qty) as qty'), DB::raw('product_name as name'))
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->where('status', '=', 2) 
        ->groupBy('name')
        ->orderBy('qty','asc')
        ->pluck('qty','name');

        foreach($top_sellers_products as $key => $val){
            $top_sellers_product[] = $key; 
        }

        $top_sellers = Product::whereIn('name', $top_sellers_product)->get();
        //whereIn('name', array('Daisy Posy', 'White Gerberas Standing Wreath', 'Red Rose Side Pot'))->get();

        return view('footer.top-sellers',compact('top_sellers'));
    }

    public function specialOffers()
    {
        //$special_offers = Product::where('status',1)->orderBy('created_at','desc')->take(8)->get();
        return view('footer.special-offers');
    }

    public function suppliers()
    {
        $suppliers = Shop::where('status',1)->orderBy('created_at','desc')->get();
        return view('footer.suppliers',compact('suppliers'));
    }

    public function aboutUs()
    {
        return view('about-us');

    }
}
