
@extends('layouts.app')

@section('content')
@include('inc.header')

<div id="mainBody" style="padding-top: 0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session()->has('success_messge'))
                    <div id="successMessageContactForm" class="alert alert-success">
                        {{ session()->get('success_messge') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row map-box">
        <div class="col-md-12">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.614981335333!2d79.8434223143179!3d6.936534994988344!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25926c7806b77%3A0x4f47fdbdb2a2896b!2sW.I.+Tel+Solutions+(Pvt)+Ltd!5e0!3m2!1sen!2slk!4v1515649053947" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen=""></iframe>
        </div>
    </div>
    <div class="container">
        <!--<hr class="soften">-->
        <h1>Get In Touch</h1>
        <hr class="soften"/>        
        <div class="row">
            
            <div class="span4">
                <h4>Contact Details</h4>
                <p>	 27-1/3,York Arcade Building,<br>
                    Leyden Bastian Rd,<br>
                    Colombo 00100<br>
                    <br/><br/>
                    info@witellsolutions.com<br/>
                    ﻿Tel  011 3 010005<br/>
                    web: www.flowershoplk.com
                </p>		
            </div>

            <div class="span4">
                <h4>Opening Hours</h4>
                <h5>Monday - Friday</h5>
                <p>10:00am - 07:00pm<br/><br/></p>
                {{-- <h5>Saturday</h5>
                <p>09:00am - 07:00pm<br/><br/></p>
                <h5>Sunday</h5>
                <p>12:30pm - 06:00pm<br/><br/></p> --}}
            </div>
            <div class="span4">
                <h4>Email Us</h4>
                <form class="form-horizontal" method="POST" action="{{ route('contactUs') }}">
                    {{ csrf_field() }}
                    <div class="control-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <input type="text" name="name" id="name" placeholder="name" class="input-xlarge" value="{{ old('name') }}" autofocus>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="control-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" name="email" id="email" placeholder="email" class="input-xlarge" value="{{ old('email') }}" autofocus>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="control-group{{ $errors->has('message') ? 'has-error' : '' }}">
                        <textarea rows="3" id="message" name="message" class="input-xlarge"></textarea>
                        @if ($errors->has('message'))
                            <span class="help-block">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                        @endif                        
                    </div>
                    <input type="hidden" name="contact_form" value="1">
                    <button class="btn btn-success" type="submit">Send Messages</button>          
                </form>
            </div>
        </div>
    </div>
</div>

@include('inc.footer')

@endsection