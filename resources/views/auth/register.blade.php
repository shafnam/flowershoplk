
@extends('layouts.app')

@section('content')
@include('inc.header')


<div id="mainBody">
    <div class="container">
        <div class="row">
            <div class="span12">
                <h3>Register</h3>
                <div class="row">
                   <div class="span6">
                        <div class="well">
                            <form method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}
                                <div class="control-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="control-label" for="inputName">Name</label>
                                    <div class="controls">
                                        <input class="span3" type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="control-label" for="Email">Email</label>
                                    <div class="controls">
                                        <input class="span3" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
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
                                        <input type="password" id="password" class="span3" name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="password-confirm">Confirm Password</label>
                                    <div class="controls">
                                        <input type="password" id="password-confirm" class="span3" name="password_confirmation" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-inverse">Register</button>
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