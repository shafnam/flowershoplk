
@extends('layouts.app')

@section('content')
@include('inc.header')


<div id="mainBody">
    <div class="container">
        <div class="row">
            <div class="span12">
                {{-- <hr class="soft"/> --}}

                <div class="row">
                    <div class="span6">
                        <h3>Returning Customer?</h3>
                        <div class="well">
                            <h5>Sign in with your account »</h5>
                            <form method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="control-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="control-label" for="inputEmail1">Email</label>
                                    <div class="controls">
                                        <input class="span3" type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="control-label" for="inputPassword1">Password</label>
                                    <div class="controls">
                                        <input type="password" id="password" class="span3" name="password" placeholder="Password" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-inverses" style="background: olivedrab;color: #fff;text-shadow: none;">Login</button> <br/><br/>
                                        <a href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                    <div align="center" class="span6">
                        <h3>New Customer?</h3>
                        <div class="well">
                        <img src="{{ URL::asset('/images/products/m5.jpg') }}" style="width: 185px;margin-right: auto;margin-left: auto;display: block;">    
                            <h5>
                                <a class="btn" href=" {{ route('register') }}" style="background: olivedrab;color: #fff;text-shadow: none;">Sign Up to Create New Account</a> Or
                                <a class="btn" href=" {{ route('orderItemsGuest.get') }}" style="background: olivedrab;color: #fff;text-shadow: none;">Continue as Guest</a>
                            </h5>
                        </div>
                    </div>                            
                        
                    <div class="span12">
                        
                    </div>
                </div>	

            </div>
        </div>
    </div>
</div>

@include('inc.footer')

@endsection