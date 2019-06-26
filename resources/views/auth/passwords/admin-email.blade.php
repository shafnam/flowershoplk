@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Admin Reset Password</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.password.email') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="bmd-label-floating">E-Mail Address</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            </div>
                        </div>
                    </div>        
                    <button type="submit" class="btn btn-primary pull-right">
                        Send Password Reset Link
                    </button>
                    <div class="clearfix"></div>
                </form>
            </div>
          </div>
        </div>
        
      </div>
@endsection