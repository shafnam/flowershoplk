
@extends('layouts.app')

@section('content')
@include('inc.header')

<div id="mainBody">
    <div class="container" style="padding-left: 0px; padding-right: 0px;">
    <?php 
        if($order_id){
    ?>
        <div class="section-container panel-body">
            <div class="customer-info">
                <div style="width: 400px;margin: 0 auto;border: 1px solid #c7c7c7;padding: 2rem;">
                    <div class="section-head" style="padding-top: 20px;padding-bottom: 20px;text-align: center;font-size: 40px;">Thank you!</div>
                    <div align="center" style="height: 175px;">
                        <img src="https://sandbox.payhere.lk/pay/resources/images/success.png" style="margin-top: 35px;" alt="success"/>
                    </div>
                    <div align="center" style="font-size: 20px;">
                        You made the payment successfully.<br/>
                        <a href="{{ route('index') }}"><small><span style="color: deeppink"> Back to Home </span></small></a>
                    </div>                    
                    {{-- <div align="center"  class="result-ref" style="margin-bottom: 20px;">Payment ID: #320025019326</div> --}}
                </div>    
            </div>    
        </div> 
    <?php } ?>    
    
    </div>
</div>
<!-- MainBody End ============================= -->

@include('inc.footer')

@endsection