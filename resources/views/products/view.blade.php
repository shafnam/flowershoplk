
@extends('layouts.app')

@section('content')
@include('inc.header')

<div id="mainBody">
    <div class="container">
        <div class="row">            
            <div class="span12">
                @if(session()->has('success_messge'))
                    <div id="successMessageAddToCart" class="alert alert-success alert-block">
                        <strong><i class="ion-ios-checkmark-outline"></i>{{ session()->get('success_messge') }}</strong>
                    </div>
                @endif
            </div>
        </div> 
        <div class="row">
            <div class="span12">
                <ul class="breadcrumb">
                    <li><a href="{{ route('index') }}">Home</a> <span class="divider">/</span></li>
                    <li><a href="{{ route('products') }}">Products</a> <span class="divider">/</span></li>
                    <li class="active">{{ $product->name }}</li>
                </ul>	
                <div class="row">	  
                    <div id="gallery" class="span5">
                        <!--featured image-->
                        <a href="{{ URL::asset('/product-photos/'.$product->product_photos->first()->title) }}" title="">
                            <img src="{{ URL::asset('/product-photos/'.$product->product_photos->first()->title) }}" class="pro-detail-img" style="width:100%" alt=""/>
                        </a>

                        <div id="differentview" class="moreOptopm carousel slide">
                            <div class="carousel-inner">
                                <div class="item active">
                                    @foreach($product->product_photos as $pp)
                                    <a href="{{ URL::asset('/product-photos/'.$pp->title) }}"> <img style="width:29%" src="{{ URL::asset('/product-photos/'.$pp->title) }}" alt=""/></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="span7" style="height: 435px; position: relative;">
                        <h3>{{ $product->name }}</h3>
                        <small>From - {{ $product->shops->name }}</small>
                        <hr class="soft">
                        <div class="form-horizontal qtyFrm">
                            <div class="control-group">
                                <label class="control-label"><span>Rs <?php echo number_format($product->price, 2) ; ?></span></label>
                            </div>
                        </div>
                        <hr class="soft clr"/>
                        <p>{{ $product->description }}</p>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#productListModal-{{ $product->id }}" id="open" style="position: absolute; left: 0; bottom: 0;">Add to cart</button>
                        {{-- <button type="submit" id="AddCart-{{ $product->id }}" class="btn btn-large btn-success pull-left" style="position: absolute; left: 0; bottom: 0;"><i class="icon-shopping-cart"></i> Add To Cart</button> --}}
                        <br class="clr">
                    </div>
                    

                    <div class="span12">
                        <ul id="productDetail" class="nav nav-tabs">
                            <li class="active"><a href="#home" data-toggle="tab">Product Details</a></li>
                            {{-- <li><a href="#profile" data-toggle="tab">Related Products</a></li> --}}
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="home">
                                <h4>Product Information</h4>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr class="techSpecRow"><th colspan="2">Product Details</th></tr>
                                        <tr class="techSpecRow"><td class="techSpecTD1">From </td><td class="techSpecTD2">{{ $product->shops->name }}</td>
                                        <tr class="techSpecRow"><td class="techSpecTD1">Width </td><td class="techSpecTD2">{{ $product->width }}</td></tr>
                                        <tr class="techSpecRow"><td class="techSpecTD1">Height</td><td class="techSpecTD2">{{ $product->height }}</td></tr>
                                        <tr class="techSpecRow"><td class="techSpecTD1">Delivery Areas</td><td class="techSpecTD2">@foreach($shop->locations as $sl){{ $sl->name }},@endforeach</strong></td></tr>
                                    </tbody>
                                </table>
        
                                {{-- <h5>Features</h5>
                                <p>
                                    {{ $product->features }}
                                </p> --}}
        
                            </div>
                            {{-- <div class="tab-pane fade" id="profile">
                                <br class="clr"/>
                                <div class="tab-content">                            
                                    <div class="tab-pane active" id="blockView">
                                        <ul class="thumbnails">
                                            <li class="span3">
                                                <div class="thumbnail">
                                                    <a href=""><img src="{{ URL::asset('/images/products/m3.jpg') }}" alt=""/></a>
                                                    <div class="caption">
                                                        <h5>Rest in Peace</h5>
                                                        <p class="product-price">Rs 4000</p>
                                                        {{-- <h4 style="text-align:center">
                                                            <a class="btn" href=""> <i class="icon-zoom-in"></i></a> 
                                                            <a class="btn btn-success" href="">Add to <i class="icon-shopping-cart"></i></a>
                                                        </h4> --}
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="span3">
                                                <div class="thumbnail">
                                                    <a href=""><img src="{{ URL::asset('/images/products/m2.jpg') }}" alt=""/></a>
                                                    <div class="caption">
                                                        <h5>Eternel Peace</h5>
                                                        <p class="product-price">Rs 1200</p>
                                                        {{-- <h4 style="text-align:center">
                                                            <a class="btn" href=""> <i class="icon-zoom-in"></i></a> 
                                                            <a class="btn btn-success" href="">Add to <i class="icon-shopping-cart"></i></a>
                                                        </h4> --}
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="span3">
                                                <div class="thumbnail">
                                                    <a href=""><img src="{{ URL::asset('/images/products/m3.jpg') }}" alt=""/></a>
                                                    <div class="caption">
                                                        <h5>Heartfelt Sympathy</h5>
                                                        <p class="product-price">Rs 8200</p>
                                                        {{-- <h4 style="text-align:center">
                                                            <a class="btn" href=""> <i class="icon-zoom-in"></i></a> 
                                                            <a class="btn btn-success" href="">Add to <i class="icon-shopping-cart"></i></a>
                                                        </h4> --}
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="span3">
                                                <div class="thumbnail">
                                                    <a href=""><img src="{{ URL::asset('/images/products/m4.jpg') }}" alt=""/></a>
                                                    <div class="caption">
                                                        <h5>Pastel Peace Basket</h5>
                                                        <p class="product-price">Rs 6400</p>
                                                        {{-- <h4 style="text-align:center">
                                                            <a class="btn" href=""> <i class="icon-zoom-in"></i></a> 
                                                            <a class="btn btn-success" href="">Add to <i class="icon-shopping-cart"></i></a>
                                                        </h4> --}
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <hr class="soft">
                                    </div>
                                </div>
                                <br class="clr">
                            </div> --}}
                        </div>
                    </div>

                    <!-- ITEM MODAL POPUP
                    ========================================================= -->
                    <form role="form" name="add_to_cart_form" id="add_to_cart_form_{{ $product->id }}" class="login-from form-signin" style="margin: 0;" method="POST" action="{{ route('addTocart', $product->id) }}" onsubmit="document.getElementById('AddCart-{{ $product->id }}').disabled=true; document.getElementById('AddCart-{{ $product->id }}').value='Submitting, please wait...';">
                        {{ csrf_field() }}
    
                        <div class="modal fade" tabindex="-1" role="dialog" class="rmp" id="productListModal-{{ $product->id }}">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="alert alert-danger" style="display:none"></div>

                                    <div class="modal-header">
                                        <h2 class="modal-title">{{ $product->name }}</h2>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="span5 mb-3" style="margin-bottom: 20px; color: crimson;">
                                                <?php if(Session::has('cart')){ ?> You already have ordered an item. If you add this item, your previous item will be removed. Continue anyway?<?php } ?>
                                            </div>
                                        </div>
                                        <div class="row">	
                                            @if($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="span2">
                                                <img src="{{ URL::asset('/product-photos/'.$product->product_photos->first()->title) }}" style="width: 260px;" alt=""/>
                                            </div>
                                            <div class="span2">
                                                <label>Select Delivery Location</label>
                                                <select class="form-control" name="delivery_area" required>
                                                    <option value="" selected="true" disabled>Select...</option>
                                                    @foreach($product->shops->locations as $al)
                                                        <option value="{{ $al->pivot->delivery_charge }},{{ $al->name }}">{{ $al->name }} - Rs {{ $al->pivot->delivery_charge }}</option>
                                                    @endforeach                                                    
                                                </select>
                                                <p class="product-price">Rs <?php echo number_format($product->price, 2) ; ?></p>
                                            </div>
                                        </div>
                                        <!-- Other details about the product -->
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">				
                                    </div>
                                    <div class="modal-footer">
                                    
                                    <?php if(Session::has('cart')){ ?><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><?php } ?>
                                    <button type="submit" class="btn btn-success pull-right" id="addProduct" name="buy_product" value="submit">
                                        Buy this Product
                                    </button>
                                </div>
                            </div>
                            </div>
                        </div>                        
                    </form>                            
                    <!-- / ITEM MODAL POPUP  -->

                </div>
            </div>
        </div> 
    </div>
</div>
<!-- MainBody End ============================= -->

@include('inc.footer')

@endsection