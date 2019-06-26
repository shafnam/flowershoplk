<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductCategory;
use App\Shop;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get('searchTerm')){
            $searchTerm = $request->get('searchTerm');
        }else {
            $searchTerm = $request->get('oldSearchTerm');
        }

        if($request->get('sortTerm')){
            $sortTerm = $request->get('sortTerm');
        }else {
            $sortTerm = $request->get('oldSortTerm');
        }

        if($request->get('maxPrice')){
            $maxPrice = $request->get('maxPrice');
        }else {
            $maxPrice = $request->get('oldMaxPrice');
        }

        if($request->get('minPrice')){
            $minPrice = $request->get('minPrice');
        }else {
            $minPrice = $request->get('oldMinPrice');
        }       
        
        $products = Product::where('status',1)->with('shops.locations');
        //$products = Product::find(1)->shops()->locations->name;
        $category = $request->category;
        //dd($category);
        $categories = ProductCategory::where('status', 1)->get();
        //$shop = Shop::where('id',$shop_id)->first();

        if($searchTerm){
            $products->where('name', 'like', '%' . $searchTerm . '%');
        }
        if($sortTerm){
            //there is a sort term
            if($sortTerm =='name_desc'){
                $orderByColomnName = "name";
                $orderByColomnValue = "desc";
            }
            else if($sortTerm =='name_asc'){
                $orderByColomnName = "name";
                $orderByColomnValue = "asc";
            }
            else if($sortTerm =='price_desc'){
                $orderByColomnName = "price";
                $orderByColomnValue = "desc";
            }
            else if($sortTerm =='price_asc'){
                $orderByColomnName = "price";
                $orderByColomnValue = "asc";
            }
            $products->orderBy($orderByColomnName, $orderByColomnValue);
        }
        if($minPrice){
            $products->where('price','>=',$minPrice);
        }
        if($maxPrice){
            $products->where('price','<=',$maxPrice);
        }
        if($category){
            $category_id = ProductCategory::where('status', 1)->where('name', $category)->pluck('id');
            $products->where('product_category_id',$category_id);
        }
        
        $products = $products->paginate(36);
        $all_products = Product::where('status',1)->paginate(12);
        return view('products.index',compact('all_products','products','categories','searchTerm','sortTerm','minPrice','maxPrice','category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        
        //return 123;
        $product = Product::find($id);
        $shop_id = $product->shop_id;
        //dd($shop_id);
        $shop = Shop::where('id',$shop_id)->first();
        //$shop_locations = $shop->locations()->wherePivot('shop_id', '=', $shop_id)->get(); // execute the query

        //dd($shop->locations);
        return view('products.view',compact('product','shop'));    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
