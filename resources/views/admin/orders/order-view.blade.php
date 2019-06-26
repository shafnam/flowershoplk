@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-success">
                    <h4 class="card-title">ORDER DETAILS</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Product</th>
                                <th style="width: 30%;">Description</th>
                                <th>Shop</th>
                                <th>Shop Phone</th>
                                <th>Qty</th>                                
                                <th>Price (Rs)</th>                                
                                <th>Delivery Fee (Rs)</th>
                                <th>Delivery Address (Rs)</th>
                                <th>Total (Rs)</th>                        
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalPrice = 0; ?>
                            <?php //dd($order->order_items) ?>
                            @foreach($order->order_items as $product)
                                <tr>
                                    <td><img width="60" src="{{ asset('product-photos/'.$product['product_image']) }}" alt=""/></td>
                                    <td>
                                        <strong>{{ $product['product_name'] }}</strong><br/>
                                        <strong>Width :</strong>{{ $product['product_width'] }}<br/>
                                        <strong>Height :</strong>{{ $product['product_height'] }}<br/>
                                    </td>
                                    <td>{{ $product['product_shop_name'] }}</td>
                                    <td>{{ $product['product_shop_phone'] }}</td>
                                    <td>{{ $product['product_qty'] }}</td>
                                    <td><?php echo number_format($product['product_price'] , 2); ?></td>
                                    <td><?php echo number_format($product['product_delivery_fee'] , 2); ?></td>
                                    <td>{{ $product['delivery_address'] }}, {{ $product['delivery_city'] }}</td>
                                    <td><?php 
                                        $price = ($product['product_price'] *  $product['product_qty']) + $product['product_delivery_fee'];
                                        echo number_format($price, 2); ?>                                
                                    </td>
                                </tr> 
                                <?php $totalPrice += $price;  ?>  
                            @endforeach           
                            <!-- summary-->
                            <tr>
                                <td colspan="8" style="text-align:right; font-size: 17px;"><strong>TOTAL</strong></td>
                                <td style="font-size: 17px;"><b><?php echo number_format($totalPrice, 2); //dd($totalPrice);  ?></b></td>
                            </tr>
                            <!-- summary-->                    
                        </tbody>
                    </table>

                    <h4> Customer Details </h4>
                    <p><strong>Customer Name:</strong> {{ $order['first_name'] }} {{ $order['last_name'] }}</p>
                    <p><strong>Contact Number:</strong> {{ $order['phone'] }}</p>
                    <p><strong>Email:</strong> {{ $order['email'] }}</p>
                    <div class="row">
                        <div class="form-group col-lg-6">
                        <a class="btn btn-success" href="{{ route('admin.orders.list') }}">Back</a>
                        </div>
                    </div>
                                      
                </div>
            </div>
        </div>
    </div>
@endsection