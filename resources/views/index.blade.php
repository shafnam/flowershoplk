
@extends('layouts.app')

@section('content')
@include('inc.header')

<div class="container-fluid">
    <div class="row">
        <ul class="pgwSlider">
            <li><img src="{{ URL::asset('images/slider/s1.jpg') }}"></li>
            <li><img src="{{ URL::asset('images/slider/s2.jpg') }}"></li>
            <li><img src="{{ URL::asset('images/slider/s3.jpg') }}"></li>
            <li><img src="{{ URL::asset('images/slider/s4.jpg') }}"></li>
        </ul>
    </div>
</div>

<div id="mainBody">
    
    <div class="container feature-main">
        <div class="row">
            <div class="span12">		
                <h4 class="title-txt">Featured Products <small class="pull-right">{{ $featured_products->count() }} featured products</small></h4>
                <hr>
                <div class="row-fluid">
                    <div id="featured" class="carousel slide">
                        <div class="carousel-inner">
                        <?php $k = 0; ?>
                        @foreach ($featured_products->chunk(4) as $chunk)<?php //dd($chunk); ?>
                            <div class="item {{ $k == 0 ? 'active' : '' }}">
                                <ul class="thumbnails">
                                    @foreach ($chunk as $product)
                                    <li class="span3">
                                        <div class="thumbnail">
                                            <i class="tag"></i>
                                            <?php if(count($product->product_photos)>0) { ?>
                                            <a href="{{ route('product.view.get', [$product->id]) }}"><img src="{{ URL::asset('/product-photos/'.$product->product_photos->first()->title) }}" alt=""></a>
                                            <div class="caption">
                                                <a href="{{ route('product.view.get', [$product->id]) }}"><h5>{{ $product->name }}</h5></a>
                                                <h5>Rs <?php echo number_format($product->price, 2) ; ?></h5>
                                                <h5>
                                                    <a class="btn" href="{{ route('product.view.get', [$product->id]) }}">View More..</a> 
                                                    {{-- <form class="home-form" method="POST" action="{{ route('addTocart', $product->id) }}">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <input type="hidden" name="product_color" value="{{ $product->colors }}">
                                                        <button type="submit"  class="btn btn-success"> Add To <i class="icon-shopping-cart"></i></button>
                                                    </form> --}}
                                                </h5>
                                            </div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                    @endforeach
                                </ul>
                            </div>
                            <?php $k++; ?>
                        @endforeach
                        </div>
                        <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                        <a class="right carousel-control" href="#featured" data-slide="next">›</a>
                    </div>
                </div>	

            </div>

        </div>
    </div>

    <div class="container-fluid flower-box">
        <div class="container">
            <div class="row fb-row">
                <div class="span12">
                    <h2 style="font-family: 'Playball', cursive;">Blooms to excite your loved ones, and enliven their day…</h2>
                    <h4 style="text-align:center"><a class="btn btn-success btn-large" href="{{ route('products') }}">Shop Now <i class="icon-shopping-cart"></i></a></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="span12">
                <h4 class="title-txt">Latest Products </h4>
                <hr>
                <ul class="thumbnails">
                    @foreach($latest_products as $lp)
                    <?php if(count($lp->product_photos)>0) { ?>
                    <li class="span3">
                        <div class="thumbnail">
                            <a  href="{{ route('product.view.get', [$lp->id]) }}"><img src="{{ URL::asset('/product-photos/'.$lp->product_photos->first()->title) }}" alt=""/></a>
                            <div class="caption">
                                <h5><a href="{{ route('product.view.get', [$lp->id]) }}">{{ $lp->name }}</a></h5>
                                <p class="product-price">Rs <?php echo number_format($lp->price, 2) ; ?></p>
                                <h5> 
                                    <a href="{{ route('product.view.get', [$lp->id]) }}" class="btn btn-success" style="margin-right: 10px;">View More</a>
                                    {{-- <form class="home-form pull-left" method="POST" action="{{ route('addTocart', $product->id) }}" style="display: grid;">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="product_color" value="{{ $product->colors }}">
                                        <button type="submit"  class="btn btn-success"> Add To <i class="icon-shopping-cart"></i></button>
                                    </form> --}}
                                </h5>
                            </div>
                        </div>
                    </li> 
                    <?php } ?>
                    @endforeach
                   
                </ul>	

            </div>

        </div>
    </div>

</div>

@include('inc.footer')

@endsection