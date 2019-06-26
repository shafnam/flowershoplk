@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">PRODUCT DETAILS</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="bxslider">
                                @foreach( $product->product_photos as $photo )
                                    <div>
                                        <img src="{{ asset('product-photos/'.$photo->title) }}" style="max-width: 600px; width: 100%;" alt="">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>Product Name</label>
                                    <p>{{ $product->name }}</p>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Product Code</label>
                                    <p>{{ $product->code }}</p>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Product Category</label>
                                    <p>{{ $product->product_categories->name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>Width</label>
                                    <p>{{ $product->width }}</p>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Height</label>
                                    <p>{{ $product->height }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-10">
                                    <label>Description</label>
                                    <p>{{ $product->description }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>Price*</label>
                                    <p>{{ $product->price }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                <a class="btn btn-primary" href="{{ route('admin.products.list') }}">Back</a>
                                </div>
                            </div>
                        </div> 
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection