@extends('layouts.app')

@section('content')
@include('inc.header')

<div id="mainBody">
    <div class="container">
        <div class="row">            
            <div class="span12">               
                @if(Session::has('cart'))
                <form class="summary-form" method="post" action="https://www.payhere.lk/pay/checkout">  
                    <div class="row">
                        <div class="span6">
                            <h3>Order Summary</h3> 
                        </div>
                        <div class="span6">
                            <input type="submit" class="btn btn-success btn-large pull-right" style="background:darkorange" value="Proceed with Payhere">
                        </div>
                    </div>
                    <hr/>

                    <h4 style="color: crimson;"> Sender Details </h4>
                    <div class="row">
                        <div class="span3 control-group">
                            <label><strong>First Name</strong></label>
                            <input type="text" name="first_name" id="first_name" class="input-xlarge" value="{{ $order->first_name }}" required readonly>
                        </div>
                        <div class="span3 control-group">
                            <label><strong>Last Name</strong></label>
                            <input type="text" name="last_name" id="last_name" class="input-xlarge" value="{{ $order->last_name }}" required readonly>
                        </div>
                        <div class="span3 control-group">
                            <label><strong>Phone Number</strong></label>
                            <input type="text" name="phone" id="phone" class="input-xlarge" value="{{ $order->phone }}" required readonly>
                        </div>
                        <div class="span3 control-group">
                            <label><strong>Email</strong></label>
                            <input type="email" name="email" id="email" class="input-xlarge" value="{{ $order->email }}"  required readonly>
                        </div>
                    </div>
                    <hr/>

                    <h4 style="color: crimson;">Receiver Details</h4>
                    <?php 
                        $totalPrize = 0; 
                        $i = 1;
                    ?>
                    
                    @foreach($order->order_items as $oi) 
                        {{-- <h4>Item {{ $i }}</h4> --}}
                        <div class="row">  
                            <div class="span3 control-group">
                                <label><strong>Delivery Date</strong></label>
                                <label class="date form-control input-xlarge">{{ $oi->delivery_date }}</label>
                            </div>
                            <div class="span3 control-group">
                                <label><strong>Delivery Address</strong></label>
                                <label class="date form-control input-xlarge">{{ $oi->delivery_address }}</label>
                                {{-- <textarea name="address[]" class="form-control" rows="1" style="width: 100%;" readonly>{{ $oi->delivery_address }}</textarea> --}}
                            </div>
                            <div class="span3 control-group">
                                <label><strong>City</strong></label>
                                <label class="date form-control input-xlarge">{{ $oi->delivery_city }}</label>
                            </div>
                            <div class="span3 control-group">
                                <label><strong>Delivery Phone Number</strong></label>
                                <label class="date form-control input-xlarge">{{ $oi->delivery_phone }}</label>
                            </div> 
                            <div class="span12 control-group">
                                <label><strong>Delivery Special Note</strong></label>
                                <label class="date form-control input-xlarge">{{ $oi->delivery_special_note }}</label>
                            </div>  
                        </div>
                        
                        <hr/>
                        <h4 style="color: crimson;">Prodcut Details</h4>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Delivery Fee</th>
                                    <th>Total</th>                        
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img width="80" src="{{ asset('product-photos/'.$oi->product_image) }}" alt=""/></td>
                                    <td>
                                        <input type="hidden" name="item_name_{{$i}}" value="{{ $oi->product_name }}"> {{-- payhere variable --}}
                                        {{ $oi->product_name }}
                                    </td>
                                    <td>
                                        <input type="hidden" name="quantity_{{$i}}" value="{{ $oi->product_qty }}"> {{-- payhere variable --}}
                                        {{ $oi->product_qty }}   
                                    </td>
                                    <td>
                                        Rs <?php echo number_format($oi->product_price , 2); ?>
                                    </td>
                                    <td>
                                        Rs <?php echo number_format($oi->product_delivery_fee, 2)?>                           
                                    </td>
                                    <td>
                                        Rs 
                                        <?php 
                                            $price = $oi->product_price *  $oi->product_qty;
                                            $total_price = $price + $oi->product_delivery_fee;
                                            echo number_format($total_price, 2); 
                                        ?>
                                        <input type="hidden" name="amount_{{$i}}" value="{{ $total_price }}">        {{-- payhere variable --}}                    
                                    </td>
                                </tr>
                                <?php 
                                    $totalPrize += $total_price;  
                                    $i++;
                                ?>   
                            </tbody>
                        </table>
                        <hr/>                          
                                
                    @endforeach
                        <div class="row">
                            <div class="span12"><h3 style="text-align: right;">TOTAL: Rs <?php echo number_format($totalPrize, 2); ?></h3></div>
                        </div>
                    </div>

                    <!-- Payhere related fields -->
                    <input type="hidden" name="merchant_id" value="211664">    <!-- Replace your Merchant ID 1210805 -->
                    <input type="hidden" name="return_url" value="{{ route('returnPayment') }}">
                    <input type="hidden" name="cancel_url" value="{{ route('cancelPayment') }}">
                    <input type="hidden" name="notify_url" value="http://flowershoplk.com/notify-res.php">  
                    <input type="hidden" name="order_id" value="{{ $order->title }}">
                    <input type="hidden" name="items" value="FlowerShoplk Delivery Items"><br>
                    <input type="hidden" name="currency" value="LKR">
                    <input type="hidden" name="amount" value="<?php echo $totalPrize; ?>"> 
                    <input type="hidden" name="address" value="No.1, Galle Road">
                    <input type="hidden" name="city" value="Colombo">
                    <input type="hidden" name="country" value="Sri Lanka">
                    
                </form>              
                @endif  
            </div>
        </div>
    </div>
</div>
<!-- MainBody End ============================= -->

@include('inc.footer')

@endsection