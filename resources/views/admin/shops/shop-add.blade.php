@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-danger">
                    <h4 class="card-title">ADD SHOP</h4>
                </div>
                <div class="card-body">

                    @if(session()->has('success_messge'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{{ session()->get('success_messge') }}</li>
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.shop.add.post') }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">                            
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Shop Name *</label>
                                    <input type="text" class="form-control" name="shop_name" id="shop_name" value="{{ old('shop_name') }}" required>
                                    <span class="text-danger">{{ $errors->first('shop_name') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Owner Name *</label>
                                    <input type="text" class="form-control" name="owner_name" id="owner_name" value="{{ old('owner_name') }}" required>
                                    <span class="text-danger">{{ $errors->first('owner_name') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Phone *</label>
                                    <input type="text" class="form-control" name="shop_phone" id="shop_phone" value="{{ old('shop_phone') }}" required>
                                    <span class="text-danger">{{ $errors->first('shop_phone') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Email *</label>
                                    <input type="email" class="form-control" name="shop_email" id="shop_email" value="{{ old('shop_email') }}" required>
                                    <span class="text-danger">{{ $errors->first('shop_email') }}</span>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Address *</label>
                                    <textarea name="shop_address" id="shop_address" class="form-control" rows="1" required>{{ old('shop_address') }}</textarea>
                                    <span class="text-danger">{{ $errors->first('shop_address') }}</span>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <label class="bmd-label-floating">Opening Hours *</label>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Mon - Fri</label>
                                    <input type="time" class="form-control" name="shop_opening_hours" id="shop_opening_hours" value="{{ old('shop_opening_hours') }}" required>
                                    <span class="text-danger">{{ $errors->first('shop_opening_hours') }}</span>
                                </div>
                            </div> --}}
                        </div>  
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="bmd-label-floating">Delivery Details *</label>
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif                                                        
                                <table class="ftable" id="delivery_charges" width="100%">
                                    <thead class="text-danger">
                                        <td>Area Name *</td>
                                        <td>Delivery Charge *</td>
                                        <td></td>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control" name="delivery_area[]" required>
                                                    <option value="" selected="true" disabled>Select...</option>
                                                    @foreach($all_locations as $al)
                                                        <option value="{{ $al->id }}">{{ $al->name }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <input type="text" class="form-control del_d" name="delivery_area[]" value="{{ old('delivery_area.0') }}" required> --}}
                                            </td>
                                            <td>
                                                <input type="number" class="form-control del_d" name="delivery_charge[]" placeholder="Rs." value="{{ old('delivery_charge.0') }}" step="any" required>
                                            </td>
                                            <td><input class='btn btn-sm btn-link btn-danger del' type='button' value='delete'></td>
                                        </tr>                                        
                                    </tbody>
                                </table>
                                <a href="#" class="btn btn-danger btn-link pull-left" id="addrow" style="display: none"><i class="fa fa-plus-square"></i> Add New Delivery Area </a>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">                                    
                                    <button type="submit" class="btn btn-danger pull-right" id="product_submit_btn">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection