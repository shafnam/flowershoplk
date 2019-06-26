
@extends('layouts.app')

@section('content')
@include('inc.header')

<div id="mainBody">
    <div class="container">
        <div class="row">            
            <div class="span12">        
                @if(session()->has('success_messge'))
                    <div id="successMessageCart" class="alert alert-success alert-block">
                        <strong>{!! session()->get('success_messge') !!}</strong>
                    </div>            
                @endif  
                @if(session()->has('success_messge_order'))
                    <div id="successMessageOrder" class="alert alert-success alert-block">
                        <p>{!! session()->get('success_messge_order') !!}</p>
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">OK</a>
                    </div>
                @endif  
                {{-- <div id="successMessageOrder" class="alert alert-success alert-block">
                        <p>Your order has been successfully submitted. One of our agents will contact you soon!<br>Phone Number - (877)-926-5025</p>
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">OK</a>
                    </div>      --}}
            </div>
        </div> 
        <div class="row">
            <div class="span12">
                {{-- <ul class="breadcrumb">
                    <li><a href="{{ route('index') }}">Home</a> <span class="divider">/</span></li>
                    <li class="active">Cart</li>
                </ul>	 --}}
                @if(Session::has('cart'))
                    <h3>SHOPPING CART
                        {{-- <a href="{{ route('index') }}" class="btn pull-right"><i class="icon-arrow-left"></i> Back </a> --}}
                    </h3>	
                    <hr class="soft"/>		

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price (Rs)</th>
                                <th>Delivery Fee (Rs)</th>
                                <th>Total (Rs)</th>                        
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalPrize = 0; ?>
                            @foreach($products as $product)
                            <?php //dd($product['item']['shops']->locations[0]['pivot']['delivery_charge']); ?>
                            <?php $pid = $product['pid']; ?>                                
                            <?php //dd($product); ?>
                                <tr>
                                    <td>
                                        <form method="POST" action="{{ route('removeFromCart', $pid) }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-link btn-xs">
                                                <span class="fa fa-trash-o"> </span>
                                            </button>                                                                        
                                        </form>
                                    </td>
                                    <td><img width="60" src="{{ asset('product-photos/'.$product['item']['product_photos'][0]['title']) }}" alt=""/></td>
                                    <td>
                                        <a href="{{ route('product.view.get', [$product['item']['id']]) }}">{{ $product['item']['name'] }}</a><br/>
                                        <small><em>From: {{ $product['item']['shops']['name'] }}</em></small><br/>
                                        <small><em>Deliver to: {{ $product['delivery_area'] }}</em></small>
                                    </td>
                                    <td>{{ $product['qty'] }}
                                        {{-- <form method="POST" action="{{ route('updateCart', $product['item']['id']) }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="product_key" value="{{ $pid }}">
                                            <input type="hidden" name="delivery_area" value="{{ $product['delivery_area'] }}">
                                            <input class="span1 product_qty" type="number" name="product_qty" min="1" max="10" class="form-control input-sm" value="{{ $product['qty'] }}">
                                            <button type="submit" class="btn qty-btn btn-xs" style="margin-top: -10px;">
                                                <span title="Update" class="fa fa-refresh"></span>
                                            </button>                                   
                                        </form> --}}
                                    </td>
                                    <td> <?php echo number_format($product['price'] , 2); ?></td>
                                    <td> <?php echo number_format($product['delivery_fee'], 2)?></td>
                                    <td> <?php 
                                        $price = $product['price'] *  $product['qty'];
                                        $total_price = $price + $product['delivery_fee'];
                                        echo number_format($total_price, 2); ?>                                
                                    </td>
                                </tr>
                                <?php $totalPrize += $total_price;  ?>   
                            @endforeach
                            <tr>
                                <td colspan="6" style="text-align:right; font-size: 17px;"><strong>TOTAL</strong></td>
                                <td style="font-size: 17px;"><b>Rs <?php echo number_format($totalPrize, 2); ?></b></td>
                            </tr>
                            <!-- summary-->

                        </tbody>
                    </table>

                    {{-- <a href="{{ route('products') }}" class="btn btn-default btn-sm"> Continue Shopping </a> --}}
                    <a href="{{ route('orderItems.get') }}" class="btn btn-success btn-sm pull-right" style="background:olivedrab"><i class="icon-arrow-right"></i> Place Order</a>
                @else 
                <div>           
                    {{-- <h3>No Items</h3> --}}
                    <div class="row">
                        <div class="span12">
                            <img src="{{ asset('images/empty-cart.jpg') }}" alt="" style="margin-left: auto;margin-right: auto;display: block;"/>
                        </div>
                        <div align="center" class="span12">
                            <a href="{{ route('products') }}" class="btn btn-info btn-large"><i class="icon-arrow-left"></i> Click here to purchase Items </a>     
                        </div>
                    </div>                  
                </div>           
                @endif  
            </div>
        </div> 
    </div>
</div>
<!-- MainBody End ============================= -->

@include('inc.footer')

<script>
    function myFunction() {
        return "Write something clever here...";
    }
</script>

@endsection