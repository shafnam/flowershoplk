
@extends('layouts.app')

@section('content')
@include('inc.header')

<div id="mainBody">
    
    <div class="container-fluid">
        <div class="container">
            <div class="row fb-row">
                <div class="span12">
                    <h2 style="font-family: 'Playball', cursive;">Suppliers</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="span12">
                <ul class="thumbnails">
                @foreach($suppliers as $lp)
                    <li class="span3">
                        <div class="thumbnail">
                            <img src="{{ URL::asset('images/flower-shop.jpg') }}" alt=""/>
                            <div class="caption">
                                <h5>{{ $lp->name }}</h5>
                                <p class="product-price">{{ $lp->address }}</p>
                                <p class="product-price">{{ $lp->phone }}</p>
                                <p class="product-price">{{ $lp->email }}</p>
                            </div>
                        </div>
                    </li>                    
                @endforeach                   
                </ul>
            </div>
        </div>
    </div>    

</div>

@include('inc.footer')

@endsection