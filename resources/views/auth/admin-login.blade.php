@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-4 login-f">
          <div align="center">
              <img src="{{ URL::asset('images/logo.png') }}" alt="FlowerShoplk"/>
          </div>
          <div class="card">
            <div class="card-header card-header-primary">              
              <h4 class="card-title">LOGIN</h4>
              {{-- <p class="card-category">Complete your profile</p> --}}
            </div>
            <div class="card-body">
              <form method="POST" action="{{ route('admin.login.submit') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="bmd-label-floating">Username</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="bmd-label-floating">Password</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                            @if($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {{-- <div class="col-md-8 col-md-offset-4"> --}}
                                <button type="submit" class="btn btn-primary pull-right">
                                    Login
                                </button>
    
                                <a class="btn btn-link" href="{{ route('admin.password.request') }}">
                                    Forgot Your Password?
                                </a>
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
                {{-- <button type="submit" class="btn btn-primary pull-right">Update Profile</button> --}}
                <div class="clearfix"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection