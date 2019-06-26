@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">EDIT PRODUCT</h4>
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
                            <div class="form-group col-lg-12">
                                <label> Product Images <small><em>(Image resolution sholud be less than 500px X 500px)</em></small></label>
                            </div>
                            <div class="form-group col-lg-7" style="margin-top: 0;">
                                @if(count($product->product_photos) > 0)
                                    <?php $i = 0; ?>
                                    @foreach($product->product_photos as $product_photo)
                                        <?php $i++; ?>
                                        <div class="row edit-img-preview upimg ad_img-<?php echo $i; ?>">
                                            <div class="col-lg-4">
                                                <img src="{{ asset('product-photos/'.$product_photo->title) }}" class="responsive-image" alt="Responsive image">
                                            </div>
                                            <div class="col-lg-4">      
                                                <input type="hidden" name="file_upload[]" value="{{$product_photo->id}}">          
                                            </div>
                                            <a href="javascript:void(0);" id='remove-<?php echo $i; ?>' class="remImg">
                                                <i class="fa fa-minus-circle remove-num" aria-hidden="true"></i>
                                                Delete Image
                                            </a>                                                              
                                        </div>
                                    @endforeach
                                @endif
                                
                                <div class="input-files">
                                    <!-- new upload div is added here -->                         
                                </div>
    
                                <?php $imgCount = count($product->product_photos); ?>
                                <input type="hidden" name="e_img_count" id="e_img_count" value="{{$imgCount}}">
                                
                                @if(count($product->product_photos) < 5)
                                <div class="row">
                                    <div id='editAddAnother' class="col-lg-12">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" class="addImg"> Add Another Image</a>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('images_error') }}</span>
                                    <span class="text-danger">{{ $errors->first('file_upload') }}</span>
                                </div>
                                @endif

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Product Name *</label>
                                    <input type="text" class="form-control" name="product_name" id="product_name" value="{{ $product->name }}" required>
                                    <span class="text-danger">{{ $errors->first('product_name') }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Product Code *</label>
                                    <input type="text" class="form-control" name="product_code" id="product_code" value="{{ $product->code }}" required>
                                    <span class="text-danger">{{ $errors->first('product_code') }}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Product Category*</label>
                                    <select class="form-control" name="product_category" id="product_category" required>
                                        @foreach($all_categories as $ac)
                                            <option value="{{ $ac->id }}" {{ $ac->name == $product->product_categories->name ? 'selected' : '' }} >
                                                {{ $ac->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('product_category') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Shop Name*</label>
                                    <select class="form-control" name="shop_name" id="shop_name" required>
                                        @foreach($all_shops as $as)
                                            <option value="{{ $as->id }}" {{ $as->name == $product->shops->name ? 'selected' : '' }} >
                                                {{ $as->name }}
                                            </option>
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
                                    <input type="number" class="form-control" name="product_price" id="product_price" value="{{ $product->price }}" required step="any">
                                    <span class="text-danger">{{ $errors->first('product_price') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Product Width </label>
                                    <input type="text" class="form-control" name="product_width" id="product_width" value="{{ $product->width }}">
                                    <span class="text-danger">{{ $errors->first('product_width') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Product Height </label>
                                    <input type="text" class="form-control" name="product_height" id="product_height" value="{{ $product->height }}">
                                    <span class="text-danger">{{ $errors->first('product_height') }}</span>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Product Description *</label>
                                    <textarea name="product_description" id="product_description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                                    <span class="text-danger">{{ $errors->first('product_description') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">                                    
                                    <button type="submit" class="btn btn-primary pull-right" id="product_submit_btn">Update</button>
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