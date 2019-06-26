@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-danger">
                    <h4 class="card-title">SHOP DETAILS</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="form-group col-lg-3">
                                    <label>Shop Name</label>
                                    <p>{{ $shop->name }}</p>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>Owner</label>
                                    <p>{{ $shop->owner_name }}</p>
                                </div>
                            {{-- </div>
                            <div class="row"> --}}
                                <div class="form-group col-lg-3">
                                    <label>Email</label>
                                    <p>{{ $shop->email }}</p>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>Phone</label>
                                    <p>{{ $shop->phone }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>Address</label>
                                    <p>{{ $shop->address }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label style="margin-left: 15px;">Delivery Details </label> <br/>                                                 
                                    <table class="table">
                                        <thead class="text-danger">
                                            <td>Area Name *</td>
                                            <td>Delivery Charge *</td>
                                        </thead>
                                        <tbody>
                                            @foreach($shop->locations as $sl)
                                            <tr>
                                                <td>
                                                    {{ $sl->name }}
                                                </td>
                                                <td>
                                                    {{ $sl->pivot->delivery_charge }}
                                                </td>
                                            </tr> 
                                            @endforeach                                       
                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="form-group col-lg-6">
                                <a class="btn btn-danger" href="{{ route('admin.shops.list') }}">Back</a>
                                </div>
                            </div>
                        </div> 
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection