@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">USER DETAILS</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>User Full Name</label>
                                    <p>{{ $user->name }}</p>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Email</label>
                                    <p>{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                <a class="btn btn-info" href="{{ route('admin.users.list') }}">Back</a>
                                </div>
                            </div>
                        </div> 
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection