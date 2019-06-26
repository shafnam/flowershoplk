
@extends('layouts.app')

@section('content')
@include('inc.header')


<div id="mainBody">
    <div class="container">
        <div class="row">
            <div class="span12">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                
                <h3>Reset Password</h3>
                <hr class="soft"/>

                <div class="row">
                    
                    <div class="span6">
                        <div class="well">
                            <form method="POST" action="{{ route('password.email') }}">
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
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-inverse">Send Password Reset Link</button>
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