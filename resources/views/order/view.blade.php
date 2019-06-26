@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css') }}">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
@stop

@section('content')
@include('inc.header')

<div id="mainBody">
    <div class="container">
        <div class="row">            
            <div class="span12">        
                @if(session()->has('success_messge'))
                    <div id="successMessageCart" class="alert alert-success alert-block">
                        <strong><i class="ion-ios-checkmark-outline"></i>{{ session()->get('success_messge') }}</strong>
                    </div>
                @endif
            </div>
        </div> 
        <div class="row">
            <div class="span12">
                @if(Session::has('cart'))                     
                    <form class="guest-order" method="post" action="{{ route('saveOrder.post') }}">  
                        {{ csrf_field() }}    
                        
                        <h3> Sender Details </h3>
                        <hr class="soft"/>		
                            
                        <div class="row">
                            <div class="span3 control-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label><strong>First Name*</strong></label>
                                <input type="text" name="first_name" id="first_name" class="input-xlarge" value="{{ old('first_name') }}" required>
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="span3 control-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label><strong>Last Name</strong></label>
                                <input type="text" name="last_name" id="last_name" class="input-xlarge" value="{{ old('last_name') }}" >
                            </div>
                            <div class="span3 control-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label><strong>Mobile Number*</strong></label>
                                <input type="text" name="phone" id="phone" class="input-xlarge" value="{{ old('phone') }}" required>
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>  
                            <div class="span3 control-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label><strong>Email*</strong></label>
                            @guest
                                <input type="email" name="email" id="email" class="input-xlarge" required value="{{ old('email') }}"> 
                            @else
                                <input type="email" name="email" id="email" class="input-xlarge" required value="{{ $user->email }}" readonly>
                                <input type="hidden" name="u_email" id="u_email" value="{{ $user->email }}">
                            @endguest
                                
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <h3> Product Details </h3>
                        <hr class="soft"/>

                        <?php 
                            $totalPrize = 0; 
                            $i = 1;
                        ?>
                        @foreach($products as $product)

                            <?php $pid = $product['pid']; ?> 
                            <?php //dd($product['item']['shops']['phone']) ?>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Price (Rs)</th>
                                        <th>Delivery Fee (Rs)</th>
                                        <th>Total (Rs)</th>                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="item_id[]" value="{{ $i }}">
                                            <input type="hidden" name="item_height[]" value="{{ $product['item']['height'] }}">
                                            <input type="hidden" name="item_width[]" value="{{ $product['item']['width'] }}">
                                            <input type="hidden" name="item_description[]" value="{{ $product['item']['description'] }}">
                                            <input type="hidden" name="item_shop_phone[]" value="{{ $product['item']['shops']['phone'] }}">
                                            <input type="hidden" name="item_shop_name[]" value="{{ $product['item']['shops']['name'] }}">
                                            
                                            {{-- Image --}}
                                            <input type="hidden" name="item_image[]" value="{{ $product['item']['product_photos'][0]['title'] }}">
                                            <img width="100" src="{{ asset('product-photos/'.$product['item']['product_photos'][0]['title']) }}" alt=""/>
                                            {{-- Category --}}
                                            <input type="hidden" name="item_category[]" value="{{ $product['item']['product_category_id'] }}">
                                            {{-- <img width="60" src="http://funeral-parlour-platform.test/product-photos/IMG_2494-1538980838.JPG" alt=""> --}}
                                        </td>
                                        <td>                                                
                                            {{-- Name --}}
                                            <input type="hidden" name="item_name_{{$i}}" value="{{ $product['item']['name'] }}"> {{-- payhere variable --}}
                                            <input type="hidden" name="item_name[]" value="{{ $product['item']['name'] }}"> 
                                            {{ $product['item']['name'] }}
                                        </td>
                                        <td>    
                                            {{-- Qty --}}
                                            <input type="hidden" name="quantity_{{$i}}" value="{{ $product['qty'] }}"> {{-- payhere variable --}}
                                            <input type="hidden" name="quantity[]" value="{{ $product['qty'] }}"> 
                                            {{ $product['qty'] }}
                                        </td>
                                        <td>
                                            {{-- Price --}}  
                                            <p> 
                                                <input type="hidden" name="amount_{{$i}}" value="{{ $product['price'] }}">{{-- payhere variable --}}
                                                <input type="hidden" name="amount[]" value="{{ $product['price'] }}"> 
                                                <?php echo number_format($product['price'] , 2); ?>
                                            </p>
                                        </td>
                                        <td>    
                                            {{-- Delivery Fee --}}
                                            <p>
                                                <input type="hidden" name="delivery_fee_{{$i}}" value="{{ $product['delivery_fee'] }}">
                                                <input type="hidden" name="delivery_fee[]" value="{{ $product['delivery_fee'] }}"> 
                                                <?php echo number_format($product['delivery_fee'], 2)?>
                                            </p>
                                        </td>
                                        <td> 
                                            {{-- Total --}}
                                            <p>
                                                <?php 
                                                    $price = $product['price'] *  $product['qty'];
                                                    $total_price = $price + $product['delivery_fee'];
                                                    echo number_format($total_price, 2); 
                                                ?>  
                                                <input type="hidden" name="total_price_{{$i}}" value="{{ $total_price }}">       
                                                <input type="hidden" name="total_price[]" value="{{ $total_price }}">                                 
                                            </p>                      
                                        </td>
                                    </tr>    
                                </tbody>
                            </table>

                            <?php 
                                $totalPrize += $total_price;  
                                $i++;
                            ?> 

                            <h3> Receiver Details </h3>
                            <hr class="soft"/>	
                                                        
                            <div class="row">  
                                <div class="span3 control-group{{ $errors->has('date.0') ? ' has-error' : '' }}">
                                    <label><strong>Delivery Date*</strong></label>
                                    <input type="text" name="date[]" class="date form-control input-xlarge" value="{{ old('date.0') }}" data-date-start-date="+1d" data-date-end-date="+8d" required>
                                    @if($errors->has('date.0'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('date.0') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="span3 control-group{{ $errors->has('address.0') ? ' has-error' : '' }}">
                                    <label><strong>Delivery Address*</strong></label>
                                    <textarea name="address[]" class="form-control" rows="1" style="width: 100%;">{{ old('address.0') }}</textarea>
                                    @if($errors->has('address.0'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('address.0') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="span3 control-group{{ $errors->has('delivery_area') ? ' has-error' : '' }}">
                                    <label><strong>City*</strong></label>
                                    <input type="text" name="city[]" class="input-xlarge" value="{{ $product['delivery_area'] }}" required readonly>
                                    @if($errors->has('delivery_area'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('delivery_area') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="span3 control-group{{ $errors->has('dphone.0') ? ' has-error' : '' }}">
                                    <label><strong>Delivery Phone Number*</strong></label>
                                    <input type="text" name="dphone[]" class="input-xlarge" value="{{ old('dphone.0') }}" required>
                                    @if($errors->has('dphone.0'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('dphone.0') }}</strong>
                                        </span>
                                    @endif                                    
                                </div>
                                
                                <div class="span12 control-group{{ $errors->has('special_note.0') ? ' has-error' : '' }}">
                                    <label class="checkbox">
                                        <strong><input type="checkbox" name="special_note_checker[]" class="special_note_checker"> Send your personal message: (200 characters maximum).</strong>
                                    </label>
                                    @if($errors->has('special_note.0'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('special_note.0') }}</strong>
                                        </span>
                                    @endif  
                                    <textarea name="special_note[]" class="form-control special_note" rows="3" maxlength="200" style="width: 100%; display:none;">{{ old('special_note.0') }}</textarea>
                                </div>


                            </div>

                        @endforeach

                        <div class="row">
                            <div class="span12">
                                <h3 style="text-align: right;">TOTAL: Rs <?php echo number_format($totalPrize, 2); ?></h3>
                                <input type="hidden" name="total" class="input-xlarge" value="{{ $totalPrize }}">
                            </div>
                        </div> 
                        
                        <div class="row" style="margin-bottom: 40px; margin-top: 40px;">
                            <div class="span6">
                                <a class="btn btn-default pull-left" href="{{ route('shoppingCart') }}">Cancel Order</a>
                            </div>
                            <div class="span6">
                                <input type="submit" class="btn btn-success btn-large pull-right" style="background:olivedrab" value="Proceed Payment">
                                {{-- <a class="btn btn-info pull-left" href="{{ route('products') }}">Continue Shopping</a> --}}
                            </div>
                        </div>

                    </form>                      
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

<script type="text/javascript">
$('.date').datepicker({  
    format: 'yyyy-mm-dd'
}); 
$(".date").on('change', function () {
    var selectedDate = $(this).val();
    var todaysDate = new Date().ddmmyyyy();
    if (selectedDate < todaysDate) {
        alert('Selected date must be greater than today date');
        $(this).val('');
    }
}); 
</script> 

@include('inc.footer')

@endsection