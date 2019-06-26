
@extends('layouts.app')

@section('content')
@include('inc.header')

<div id="mainBody">
    
    <div class="container-fluid">
        <div class="container">
            <div class="row fb-row">
                <div class="span12">
                    <h2 style="font-family: 'Playball', cursive;">New Products</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="span12">
                <ul class="thumbnails">
                @foreach($new_products as $lp)
                    <?php if(count($lp->product_photos)>0) { ?>
                    <li class="span3">
                        <div class="thumbnail">
                            <a  href="{{ route('product.view.get', [$lp->id]) }}"><img src="{{ URL::asset('/product-photos/'.$lp->product_photos->first()->title) }}" alt=""/></a>
                            <div class="caption">
                                <h5><a href="{{ route('product.view.get', [$lp->id]) }}">{{ $lp->name }}</a></h5>
                                <p class="product-price">Rs {{ $lp->price }}</p>
                                <h5> 
                                    <a href="{{ route('product.view.get', [$lp->id]) }}" class="btn btn-success" style="margin-right: 10px;">View More</a>
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