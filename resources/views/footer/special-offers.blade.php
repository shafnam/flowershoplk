
@extends('layouts.app')

@section('content')
@include('inc.header')

<div id="mainBody">
    
    <div class="container-fluid">
        <div class="container">
            <div class="row fb-row">
                <div class="span12">
                    <h2 style="font-family: 'Playball', cursive;">Special Offers</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="span12">
                <h2>No Special Offers Yet!</h2>
            </div>
        </div>
    </div>    

</div>

@include('inc.footer')

@endsection