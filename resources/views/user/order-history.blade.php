@extends('layouts.app')
@section('content')
@include('inc.header')

<div id="mainBody" style="min-height: 280px;">
    <div class="container">
        
        <div class="row">
            <div class="span12">
                <h2>My Orders</h2>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Order ID</th>
                            <th>Item Count</th>
                            <th>Total (Rs)</th>
                            <th></th>
                        </tr>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->title }}</td>
                            <td>{{ $order->items_count }}</td>
                            <td><?php echo number_format($order->total, 2) ?></td>
                            <td><a href="{{ route('user.orderView',[$order->id]) }}" class="btn btn-success btn-sm" style="background-color: #5bb75b;"><i class="fa fa-eye" aria-hidden="true"></i> View More...</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<!-- MainBody End ============================= -->
@include('inc.footer')

@endsection