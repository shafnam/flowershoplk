
@extends('layouts.app')

@section('content')
@include('inc.header')


<div id="mainBody">
    <div class="container">
        <div class="row">
            <div class="span12">
                
                <h3>Login</h3>
                <hr class="soft"/>

                <div class="row">
                    
                    <div class="span6">
                        <div class="well">
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
                                        <button type="submit" class="btn btn-inverse">Login</button> <br/><br/>
                                        <a href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                        <h5>
                                        <a href=" {{ route('register') }}" style="color: hotpink;">Sign Up to Create New Account</a>
                                        </h5>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>	

            </div>
        </div>
    </div>
</div>

@include('inc.footer')

@endsection