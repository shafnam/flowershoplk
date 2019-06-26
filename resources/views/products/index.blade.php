
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
            <!-- Sidebar ================================================== -->
            @include('inc.sidebar')
            <!-- Sidebar end=============================================== -->
            <div class="span9">
                
                @if($category !=null)
                    <h3 style="margin-top: 0px;">Flower {{ $category}}s<small class="pull-right"> {{ $products->count() }} products are available </small></h3>
                @else
                    <h3 style="margin-top: 0px;">Flowers for Any Occasion<small class="pull-right"> {{ $products->count() }} products are available </small></h3>	
                @endif                
                
                <hr class="soft"/>
                <p>
                    Whenever you’re looking to send flowers within Sri Lanka, you can send flowers online from our website. 
                    We let you place orders online and have them delivered by hand, thanks to our professional florists . 
                    Choose an islandwide floral service which has years of experience in delivering flowers.
                </p>
                <hr class="soft"/>

                <!-- Form -->
                <form name="productsFilter" class="form-horizontal span6" style="margin-left: 0px;" method="GET" action="{{ route('products') }}">
                    <div class="control-group">
                        <label class="control-label alignL" style="width: 80px;">Sort By </label>
                        <select name="sortTerm" class="form-control" id="exampleFormControlSelect1" onChange="this.form.submit();">
                            <option value="name_asc" <?php if(!isset($sortTerm) || $sortTerm=='name_asc'){echo "selected";} ?>>Product name A - Z</option>
                            <option value="name_desc" <?php if(isset($sortTerm) && $sortTerm=='name_desc'){echo "selected";} ?>>Product name Z - A</option>
                            <option value="price_desc" <?php if(isset($sortTerm) && $sortTerm=='price_desc'){echo "selected";} ?>>Price: High to Low</option>
                            <option value="price_asc" <?php if(isset($sortTerm) && $sortTerm=='price_asc'){echo "selected";} ?>>Price: Low to High</option>
                        </select>
                    </div>
                    <input type="hidden" name="oldSearchTerm" value="{{ $searchTerm }}">
                    <input type="hidden" name="oldSortTerm" value="{{ $sortTerm }}">
                    <input type="hidden" name="oldMinPrice" value="{{ $minPrice }}">
                    <input type="hidden" name="oldMaxPrice" value="{{ $maxPrice }}">
                </form>

                <div id="myTab" class="pull-right">
                    <a href="#listView" data-toggle="tab"><span class="btn btn-sm"><i class="icon-list"></i></span></a>
                    <a href="#blockView" data-toggle="tab"><span class="btn btn-sm"><i class="icon-th-large"></i></span></a>
                </div>
                <br class="clr"/>
                <div class="tab-content">
                    <!-- List -->
                    <div class="tab-pane" id="listView">
                        @foreach($products as $product)
                            <div class="row">	  
                                <div class="span2">
                                    <a href="{{ route('product.view.get', [$product->id]) }}">
                                        <img src="{{ URL::asset('/product-photos/'.$product->product_photos->first()->title) }}" alt=""/>
                                    </a>
                                </div>
                                <div class="span4">
                                    <a href="{{ route('product.view.get', [$product->id]) }}">
                                        <h5 class="k-title">{{ $product->name }}</h5>
                                    </a>
                                    <p style="text-align: justify;">
                                        <?php $excerpt = substr($product->description, 0, 300); ?>
                                        {{ $excerpt }} ...
                                    </p>
                                    <br class="clr"/>
                                </div>
                                <div class="span3 alignR">
                                    <div class="qtyFrm">
                                        <h3 class="k-price"> Rs <?php echo number_format($product->price, 2) ; ?></h3>    
                                        {{-- <form class="form-horizontal home-form" method="POST" action="{{ route('addTocart', $product->id) }}" 
                                            style="margin-left: 135px; float: left;"
                                            onsubmit="document.getElementById('AddCart_{{ $product->id }}').disabled=true;
                                            document.getElementById('AddCart_{{ $product->id }}').value='Submitting, please wait...';"
                                        >
                                            {{ csrf_field() }}
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="product_color" value="{{ $product->colors }}">
                                            <button type="submit" id="AddCart_{{ $product->id }}" class="btn btn-success">Add To <i class="icon-shopping-cart"></i></button>
                                        </form> --}}
                                        {{-- <a href="{{ route('product.view.get', [$product->id]) }}" class="btn"><i class="icon-zoom-in"></i></a> --}}
                                        {{-- <a href="{{ route('product.view.get', [$product->id]) }}/#myTabContent" style="font-size: 12px; color: #343a40; line-height: 40px;"><i class="fa fa-truck"></i> Check Delivery Areas</a> --}}
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#productListModal-{{ $product->id }}" id="open">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                            <hr class="soft"/>  
                        
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

                        @endforeach
                    </div>
                    <!-- Grid -->   
                    <div class="tab-pane active" id="blockView">
                        <ul class="thumbnails">
                        @foreach($products as $product)
                            <li class="span3">
                                <div class="thumbnail">
                                    <div class="grid">
                                        <figure class="effect-julia">
                                            <img src="{{ URL::asset('/product-photos/'.$product->product_photos->first()->title) }}" style="width: 260px;" alt=""/>
                                            <figcaption>
                                                <div class="fg-txt">
                                                    <p>{{ $product->name }}</p>
                                                    <p>From {{ $product->shops->name }}</p>
                                                    <p class="v-more">
                                                        <a href="{{ route('product.view.get', [$product->id]) }}" class="btn btn-success">View More</a>
                                                    </p>
                                                </div>
                                            </figcaption>			
                                        </figure>
                                    </div>
                                    <div class="caption">
                                        <a href="{{ route('product.view.get', [$product->id]) }}"><h5>{{ $product->name }}</h5></a>
                                        <p class="product-price">Rs <?php echo number_format($product->price, 2) ; ?></p>
                                        <h4 style="text-align:center"> 
                                            {{-- <form class="home-form" method="POST" action="{{ route('addTocart', $product->id) }}"
                                                    onsubmit="document.getElementById('AddCart__{{ $product->id }}').disabled=true;
                                                    document.getElementById('AddCart__{{ $product->id }}').value='Submitting, please wait...';"
                                            >
                                                {{ csrf_field() }}
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="product_color" value="{{ $product->colors }}">
                                                <button type="submit" id="AddCart__{{ $product->id }}" class="btn btn-success"> Add To <i class="icon-shopping-cart"></i></button>
                                            </form> --}}
                                            {{-- <a href="{{ route('product.view.get', [$product->id]) }}/#myTabContent" style="font-size: 12px; color: #343a40;"><i class="fa fa-truck"></i> Check Delivery Areas</a><br/> --}}
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#productGridModal-{{ $product->id }}" id="open">Add to cart</button>
                                        
                                        </h4>
                                    </div>
                                </div>
                            </li>

                            <!-- ADD TO CART MODAL POPUP
                            ========================================================= -->
                            <form role="form" name="add_to_cart_form" id="add_to_cart_form_{{ $product->id }}" class="login-from form-signin" style="margin: 0;" method="POST" action="{{ route('addTocart', $product->id) }}" onsubmit="document.getElementById('AddCart-{{ $product->id }}').disabled=true; document.getElementById('AddCart-{{ $product->id }}').value='Submitting, please wait...';">
                                {{ csrf_field() }}
        
                                <div class="modal fade" tabindex="-1" role="dialog" class="rmp" id="productGridModal-{{ $product->id }}" role="dialog" aria-labelledby="productGridModal-{{ $product->id }}Label">
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
                                            <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button  class="btn btn-success" id="ajaxSubmit">Save changes</button>-->
                                            <?php if(Session::has('cart')){ ?><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><?php } ?>
                                            <button type="submit" class="btn btn-success pull-right" id="addProduct" name="buy_product" value="submit">
                                                Proceed Chekout
                                            </button>
                                        </div>
                                    </div>
                                    </div>
                                </div>                        
                            </form>                            
                            <!-- / ADD TO CART MODAL POPUP  -->

                        @endforeach
                        </ul>
                        <hr class="soft"/>
                    </div>
                </div>

                <div class="pagination">
                    {{$products->links()}}
                </div>
                <br class="clr"/>
            </div>
        </div>
    </div>
</div>
<!-- MainBody End ============================= -->

@include('inc.footer')

@endsection