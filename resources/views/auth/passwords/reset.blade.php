
@extends('layouts.app')

@section('content')
@include('inc.header')


<div id="mainBody">
    <div class="container">
        <div class="row">
            <div class="span12">
                
                <h3>Reset Password</h3>
                <hr class="soft"/>

                <div class="row">                    
                    <div class="span6">
                        <div class="well">
                            <form method="POST" action="{{ route('password.request') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="control-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="control-label" for="inputEmail1">Email</label>
                                    <div class="controls">
                                        <input class="span3" type="email" id="email" name="email" placeholder="Email" value="{{ $email or old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="control-label" for="password">Password</label>
                                    <div class="controls">
                                        <input type="password" id="password" class="span3" name="password" placeholder="Password" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label class="control-label" for="password-confirm">Confirm Password</label>
                                    <div class="controls">
                                        <input type="password" id="password-confirm" class="span3" name="password_confirmation" placeholder="Password" required>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-inverse">Reset Password</button>
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