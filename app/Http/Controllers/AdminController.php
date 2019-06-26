<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Order;
use App\OrderItem;
use App\User;
use App\Product;
use App\Shop;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        //$orders = Order::all();
        $users      = User::all();
        $products   = Product::all();
        $shops      = Shop::all();
        $orders     = Order::where('status', 2)->get();
        $customers  = $users;
        $all_orders = Order::paginate(10);
        $user_type  = Auth::user()->title;

        //dd($this_week_commissions);
        //dd($shop_commissions);   
        //dd($category_products);        
        //dd($lastWeekData);
        //dd($lastWeekDates);
        //dd($dailySales);
        //dd($days);
        //dd($data);
        //dd($shopz);
        //dd($months);
        //dd($weeks);

        if($user_type == 'Administrator') {
            //dd($user_type);
            return view('admin.index',compact('users','products','shops','orders','customers','user_type'));
        }
        elseif ($user_type == 'Editor') {
            //dd($user_type);
            //return view('admin.orders.orders-list',compact('all_orders','user_type'));
            return redirect(route('admin.orders.list'));
        }  
        elseif ($user_type == 'ProductEditor') {
            return redirect(route('admin.products.list'));
        }       
    }

    public function orderChart()
    {
        /*$shop_commissions = DB::table('order_items')
        ->select(DB::raw('SUM(product_commission) as total_commission, product_shop_name'))
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->where('status', '=', 2) 
        ->groupBy('product_shop_name')
        ->pluck('total_commission','product_shop_name'); */ 

        // Commission this week
        $today = date("Y-m-d");
        $lastWeek = date("Y-m-d", strtotime("-1 week"));        
        $this_week_commissions = DB::table('order_items')
        ->select(DB::raw('sum(product_commission) as total_commission'),DB::raw('date(order_items.created_at) as dates'))
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->where('status', '=', 2) 
        ->whereBetween('order_items.created_at', [$lastWeek, $today])
        ->groupBy('dates')
        ->orderBy('dates','desc')
        ->pluck('total_commission','dates');
        
        // Commission this month
        $currentMonth = date('n');       
        $shop_commissions = DB::table('order_items')
        ->select(DB::raw('sum(product_commission) as total_commission'),DB::raw('date(order_items.created_at) as dates'))
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->where('status', '=', 2) 
        ->whereMonth('order_items.created_at', $currentMonth)
        ->groupBy('dates')
        ->orderBy('dates','desc')
        ->pluck('total_commission','dates');
        
        // Product count by category
        $category_products = DB::table('order_items')
        ->select(DB::raw('COUNT(order_items.id) as total_products, product_category')) 
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->where('status', '=', 2) 
        ->groupBy('product_category')
        ->pluck('total_products','product_category');
        
        // Sales happened months
        $months = DB::table('order_items')
                ->select(DB::raw('MONTHNAME(created_at) as monthName'),DB::raw('MONTH(created_at) as monthNum')) 
                ->whereYear('created_at', '=', 2018)
                ->groupBy('monthName')
                ->groupBy('monthNum')
                ->orderBy('monthName', 'DESC')
                ->get();

        /* Get a given month's all days */
        $list = array();
        // $month = 8;
        $month = date("m");
        $year = 2018;

        for($d=1; $d<=31; $d++)
        {
            $time = mktime(12, 0, 0, $month, $d, $year);          
            if (date('m', $time)==$month)   {
                $dates[]=date('Y-m-d', $time);
            }               
        }

        /* Get last seven days */
        $m  = date("m"); // Month value
        $de = date("d"); //today's date
        $y  = date("Y"); // Year value Y-m-d

        for($i=0; $i<=7; $i++) {
            $lastWeekDates[] = date('M-d',mktime(0,0,0,$m,($de-$i),$y)); 
        }
        
        //$days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

        // Sales happened shops
        //$shopz = array('Awesome Florist', 'Shirohana');
        $shopz = DB::table('order_items')
        ->select(DB::raw('product_shop_name')) 
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->where('status', '=', 2) 
        ->where('product_price', '>', 0)
        ->groupBy('product_shop_name')
        ->orderBy('product_shop_name', 'DESC')
        ->pluck('product_shop_name');

        foreach($shopz as $key => $shop) {

            $monthlyData[$key]['label'] = $shop;
            $monthlyData[$key]['backgroundColor'] = '#'.$this->random_color();
            
            $dailyData[$key]['label'] = $shop;
            $dailyData[$key]['backgroundColor'] = '#'.$this->random_color();

            $lastWeekData[$key]['label'] = $shop;
            $lastWeekData[$key]['backgroundColor'] = '#'.$this->random_color();

            // Yearly sales by shop
            foreach($months as $month) {

                $shop_sales = DB::table('order_items')
                ->select(DB::raw('SUM(product_price) as total_sales')) 
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('status', '=', 2)
                ->where('product_shop_name', $shop)
                ->whereYear('order_items.created_at', '=', 2018)
                ->whereMonth('order_items.created_at', $month->monthNum)
                ->value('total_sales');

                $monthlyData[$key]['data'][] = $shop_sales;
            }

            // Monthly sales by shop
            foreach($dates as $date) {

                $shop_sales = DB::table('order_items')
                ->select(DB::raw('SUM(product_price) as total_sales')) 
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('status', '=', 2)
                ->where('product_shop_name', $shop)
                ->where(DB::raw('DATE(order_items.created_at)'), $date)
                ->value('total_sales');

                $dailyData[$key]['data'][] = $shop_sales;
            }

            // Last weeks sales by shop
            foreach($lastWeekDates as $lastWeekDate) {

                $shop_sales = DB::table('order_items')
                ->select(DB::raw('SUM(product_price) as total_sales'))
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('status', '=', 2) 
                ->where('product_shop_name', $shop)
                ->where(DB::raw('DATE_FORMAT(order_items.created_at, "%b-%d")'), $lastWeekDate)
                ->value('total_sales');             
                    
                $lastWeekData[$key]['data'][] = $shop_sales;               
                
            } 
        }

        return response()->json(['months'=> $months, 'monthlyData' =>$monthlyData, 'days'=> $dates, 'dailyData' =>$dailyData, 'lastWeekDays'=> $lastWeekDates, 'lastWeekData' =>$lastWeekData, 'category_products' => $category_products, 'shop_commissions'=> $shop_commissions,'this_week_commissions' => $this_week_commissions]);
    }

    private function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }
    
    private function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
    
   
}