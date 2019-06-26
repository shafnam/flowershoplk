
@extends('layouts.app')

@section('content')
@include('inc.header')

<div id="mainBody" style="padding-top: 0; min-height: 301px">
    <div class="container" style="padding-top: 30px;">
        <h1>About Us</h1>
        <hr class="soften"/>        
        <div class="row">            
            <div class="span12">
                <p>
                    W.I. Tel Solutions (pvt) Ltd is a call center service features a wide range of possible business process. 
                    We ensure to achieve high customer satisfaction with our quality product and services. 
                    Our main goal is to provide impeccable customer experience be it sales or after sales service.
                </p>		
            </div>
        </div>
    </div>
</div>

@include('inc.footer')

@endsection