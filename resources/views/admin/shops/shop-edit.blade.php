@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-danger">
                    <h4 class="card-title">EDIT SHOP</h4>
                </div>
                <div class="card-body">

                    @if(session()->has('success_messge'))
                        <div id="successMessageEditProduct" class="alert alert-success">
                            <ul>
                                <li>{{ session()->get('success_messge') }}</li>
                            </ul>
                        </div>
                    @endif

                    <form action="{{-- route('admin.product.edit.post') --}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Shop Name *</label>
                                    <input type="text" class="form-control" name="shop_name" id="shop_name" value="{{ $shop->name }}" required>
                                    <span class="text-danger">{{ $errors->first('shop_name') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Owner Name *</label>
                                    <input type="text" class="form-control" name="owner_name" id="owner_name" value="{{ $shop->owner_name }}" required>
                                    <span class="text-danger">{{ $errors->first('owner_name') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Email *</label>
                                    <input type="email" class="form-control" name="shop_email" id="shop_email" value="{{ $shop->email }}">
                                    <span class="text-danger">{{ $errors->first('shop_email') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Phone *</label>
                                    <input type="text" class="form-control" name="shop_phone" id="shop_phone" value="{{ $shop->phone }}">
                                    <span class="text-danger">{{ $errors->first('shop_phone') }}</span>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Address *</label>
                                    <textarea name="shop_address" id="shop_address" class="form-control" rows="1" required>{{ $shop->address }}</textarea>
                                    <span class="text-danger">{{ $errors->first('shop_address') }}</span>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Delivery Areas *<em><small> add comma seperated values </small><em></label>
                                    <textarea name="delivery_areas" id="delivery_areas" class="form-control" rows="5" required>{{ $shop->delivery_areas }}</textarea>
                                    <span class="text-danger">{{ $errors->first('delivery_areas') }}</span>
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
                                        @foreach($shop->locations as $sl)
                                        <tr>
                                            <td>
                                                <select class="form-control" name="delivery_area[]" required>
                                                    <option value="" selected="true" disabled>Select...</option>
                                                    @foreach($all_locations as $al)
                                                        <option value="{{ $al->id }}" {{ $al->name == $sl->name ? 'selected' : '' }} >
                                                            {{ $al->name }}
                                                        </option>
                                                    @endforeach                                                    
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control del_d" name="delivery_charge[]" placeholder="Rs." value="{{ $sl->pivot->delivery_charge }}" step="any" required>
                                            </td>
                                            <td><input class='btn btn-sm btn-link btn-danger del' type='button' value='delete'></td>
                                        </tr> 
                                        @endforeach                                       
                                    </tbody>
                                </table>                                                  
                              
                                <a href="#" class="btn btn-danger btn-link pull-left" id="addrow"><i class="fa fa-plus-square"></i> Add New Delivery Area </a>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">                                    
                                    <button type="submit" class="btn btn-danger pull-right" id="product_submit_btn">Update</button>
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