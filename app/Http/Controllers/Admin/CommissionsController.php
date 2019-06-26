<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use Auth;
use App\Order;
use App\OrderItem;

class CommissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function commissionsList($id =null){
        $user_type  = Auth::user()->title;
        $all_commissions =  OrderItem::paginate(10);
        //dd($all_commissions);

        if($id){
            $commission = Commission::where('id',$id)->first();
            return view('admin.commissions.commissions-list',compact('all_commissions','commission','user_type'));
        }
        return view('admin.commissions.commissions-list',compact('all_commissions','user_type'));
    }
}
