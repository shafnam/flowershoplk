@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">ADD PRODUCT</h4>
                </div>
                <div class="card-body">

                    @if(session()->has('success_messge'))
                        <div class="alert alert-success">
                            {{ session()->get('success_messge') }}
                        </div>
                    @endif

                    @if (count($errors) > 0) 
                    <div class="alert alert-danger">                    
                        <ul>                    
                        @foreach ($errors->all() as $error)                    
                            <li>{{ $error }}</li>                    
                        @endforeach                    
                        </ul>                    
                    </div>                    
                    @endif

                    <form action="{{ route('admin.product.add.post') }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label> Product Images <small><em>(Image resolution sholud be less than 500px X 500px)</em></small></label>
                            </div>
                            <div class="form-group col-lg-7" style="margin-top: 0;">
                                <div class="input-files">
                                    <div class="row upimg img-1">
                                        <div class="col-lg-3">
                                            <div id="uploadPreview-1" class="prev-img"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="file-upload" class="custom-file-upload" id="file-up-btn-1">
                                                Add a Photo
                                            </label>        
                                            <input type="file" name="file_upload[]" required>
                                        </div>
                                        <a href="javascript:void(0);" id='remove-1' class="remImg" style="display:none;">
                                            <i class="fa fa-minus-circle remove-num" aria-hidden="true"></i>
                                            Delete Image
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div id='addAnother' class="col-lg-12" style="display:none;">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" class="addImg"> Add Another Image</a>
                                        </div>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('file_upload[]') }}</span>
                                </div>                                
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Product Name *</label>
                                    <input type="text" class="form-control" name="product_name" id="product_name" value="{{ old('product_name') }}" required>
                                    <span class="text-danger">{{ $errors->first('product_name') }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Product Code *</label>
                                    <input type="text" class="form-control" name="product_code" id="product_code" value="{{ old('product_code') }}" required>
                                    <span class="text-danger">{{ $errors->first('product_code') }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="product_category" id="product_category" required>
                                        <option value="" selected="true" disabled>Product Category *</option>
                                        @foreach($all_categories as $ac)
                                            <option value="{{ $ac->id }}">{{ $ac->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('product_category') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control" name="shop_name" id="shop_name" required>
                                        <option value="" selected="true" disabled>Shop Name *</option>
                                        @foreach($all_shops as $as)
                                            <option value="{{ $as->id }}">{{ $as->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('shop_name') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Product Price (Rs)*</label>
                                    <input type="number" class="form-control" name="product_price" value="{{ old('product_price') }}" id="product_price" required step="any">
                                    <span class="text-danger">{{ $errors->first('product_price') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Product Width </label>
                                    <input type="text" class="form-control" name="product_width" value="{{ old('product_width') }}" id="product_width" >
                                    <span class="text-danger">{{ $errors->first('product_width') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Product Height </label>
                                    <input type="text" class="form-control" name="product_height" value="{{ old('product_height') }}" id="product_height" >
                                    <span class="text-danger">{{ $errors->first('product_height') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Product Description *</label>
                                    <textarea name="product_description" id="product_description" class="form-control" rows="3" required>{{ old('product_description') }}</textarea>
                                    <span class="text-danger">{{ $errors->first('product_description') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">                                    
                                    <button type="submit" class="btn btn-primary pull-right" id="product_submit_btn">Save</button>
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