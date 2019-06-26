@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(session()->has('success_messge'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session()->get('success_messge') }}</li>
                </ul>
            </div>
        @endif
        @if(session()->has('error_messge'))
            <div class="alert alert-danger">
                <ul>
                    <li>{{ session()->get('error_messge') }}</li>
                </ul>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
<!-- /.row --> 
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title ">All Commissions</h4>
                <p class="card-category">Here is a subtitle for this table</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{-- route('admin.order.bulk-edit.post') --}}" method="post" id="order_form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table">
                            <thead class="text-success">
                                <th>Order ID</th>
                                <th>Product Name</th>
                                <th>Product Total<small> (Rs)</small></th>
                                <th>Commission<small> (Rs)</small></th>
                                {{-- <th>Action</th> --}}
                            </thead>
                            <tbody>
                                @foreach($all_commissions as $ac)
                                <tr>
                                    <td>{{ $ac->order_id }}</td>
                                    <td>{{ $ac->product_name }}</td>
                                    <td>{{ $ac->product_total }}</td>
                                    <td class="text-success">{{ $ac->product_commission }}</td>
                                    {{-- <td>
                                        <a href="{{ route('admin.commissions.view.get',[$ac->id]) }}" rel="tooltip" title="View Commission" class="btn btn-info btn-link btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </td>                                     --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <input type="submit" name="submit" id="submit" value="Change Status" class="btn btn-warning"/> --}}
                    </form>
                </div>
                <div class="pagination">
                    <div class="col-md-12">
                        {{ $all_commissions->links() }}
                    </div>
                </div>
            </div>        
        </div>
    </div>
    
</div>
@endsection