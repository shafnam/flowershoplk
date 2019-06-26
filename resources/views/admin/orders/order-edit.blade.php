@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-danger">
                    <h4 class="card-title">CHANGE ORDER STATUS</h4>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Order Name </label><br/>
                                    <label name="order_name" class="black">{{ $order->title }}</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Total Amount</label><br/>
                                    <label name="total" class="black">{{ $order->total }}</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Order Status</label>
                                    
                                    <?php $order_status = ['0','2','3','-1']; ?>
                                    
                                    <select class="form-control" name="status" id="status" required>
                                        @foreach($order_status as $oa)
                                            <option value="{{ $oa }}" {{ $oa == $order->status ? 'selected' : '' }} >
                                                @if($oa == 0)
                                                    Incomplete
                                                @elseif($oa == 2)
                                                    Processing
                                                @elseif($oa == 3)
                                                    Completed
                                                @elseif($oa == -1)
                                                    Cancelled
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">                                    
                                    <button type="submit" class="btn btn-danger pull-right" id="order_submit_btn">Update</button>
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