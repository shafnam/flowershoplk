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

        <div class="card card-nav-tabs card-plain">
            <div class="card-header card-header-success">
                <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="#processing" data-toggle="tab">Processing</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#completed" data-toggle="tab">Completed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#incomplete" data-toggle="tab">Incomplete</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#cancelled" data-toggle="tab">Cancelled</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content text-left">
                    <div class="tab-pane active" id="processing">
                        <div class="card">
                            <div class="card-header card-header-success" style="margin: 1rem;">
                                <h4 class="card-title ">Processing Orders</h4>
                                <p class="card-category"> Here is a subtitle for this table</p>
                            </div>
                            <div class="card-body" style="margin: 1rem;">
                                <div class="table-responsive">
                                    <form action="{{ route('admin.order.bulk-edit.post') }}" method="post" id="order_process_form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <!-- Pagination select -->
                                        {{-- <select id="processing_pagination" onChange="this.form.submit();">
                                            <option value="5" @if($items == 5) selected @endif >5</option>
                                            <option value="10" @if($items == 10) selected @endif >10</option>
                                            <option value="25" @if($items == 25) selected @endif >25</option>
                                        </select>--}}
                                        <table class="table">
                                            <thead class="text-success">
                                                <th>Order ID</th>
                                                <th>Total Amount<small> (Rs)</small></th>
                                                <th>Items</th>
                                                <th>Customer Name</th>
                                                <th>Sender Phone </th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                @foreach($processing_orders as $ao)
                                                <tr class="table-tr" data-url="">
                                                    <td>{{ $ao->title }}</td>
                                                    <td class="text-success"><?php echo number_format($ao->total, 2); ?></td>
                                                    <td>{{ $ao->items_count }}</td>
                                                    <td>{{ $ao->first_name }}<br/> {{ $ao->last_name }}</td>
                                                    <td>{{ $ao->phone }}</td>
                                                    <td id="cont">
                                                        {{-- onchange="this.form.submit()" --}}
                                                        <?php $order_status = ['3','2','0','-1']; ?>
                                                        <select runat="server" id="order_status" class="form-control" name="status[]" required data-id="{{ $ao->status }}">
                                                            @foreach($order_status as $os)
                                                                <option value="{{ $os }}" {{ $os == $ao->status ? 'selected' : '' }} >
                                                                    @if($os == 3)
                                                                        Completed
                                                                    @elseif($os == 2)
                                                                        Processing
                                                                    @elseif($os == 0)
                                                                        Incomplete
                                                                    @elseif($os == -1)
                                                                        Cancelled
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.order.view.get',[$ao->id]) }}" rel="tooltip" title="View Order" class="btn btn-info btn-link btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        {{-- <a href="{{ route('admin.order.edit.get',[$ao->id]) }}" rel="tooltip" title="Change order status" class="btn btn-link btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> --}}
                                                    </td>
                                                    <td><input type="hidden"  name="id[]" value="{{ $ao->id }}" /></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{-- <input type="submit" name="submit" id="submit" value="Change Status" class="btn btn-warning"/> --}}
                                    </form>
                                </div>
                                <div class="pagination">
                                    <div class="col-md-12">
                                        {{ $processing_orders->links() }}
                                    </div>
                                </div>
                            </div>        
                        </div>
                    </div>
                    <!-- Completed -->
                    <div class="tab-pane" id="completed">
                        <div class="card">
                            <div class="card-header card-header-success" style="margin: 1rem;">
                                <h4 class="card-title ">Completed Orders</h4>
                                <p class="card-category">Here is a subtitle for this table</p>
                            </div>
                            <div class="card-body" style="margin: 1rem;">
                                <div class="table-responsive">
                                    <form action="{{ route('admin.order.bulk-edit.post') }}" method="post" id="order_complete_form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <!-- Pagination select -->
                                        {{-- <select id="completed_pagination" onChange="this.form.submit();">
                                            <option value="5" @if($items == 5) selected @endif >5</option>
                                            <option value="10" @if($items == 10) selected @endif >10</option>
                                            <option value="25" @if($items == 25) selected @endif >25</option>
                                        </select>                         --}}
                                        <table class="table">
                                            <thead class="text-success">
                                                <th>Order ID</th>
                                                <th>Total Amount<small> (Rs)</small></th>
                                                <th>Items</th>
                                                <th>Customer Name</th>
                                                <th>Sender Phone </th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                @foreach($completed_orders as $co)
                                                <tr class="table-tr" data-url="">
                                                    <td>{{ $co->title }}</td>
                                                    <td class="text-success"><?php echo number_format($co->total, 2); ?></td>
                                                    <td>{{ $co->items_count }}</td>
                                                    <td>{{ $co->first_name }}<br/> {{ $co->last_name }}</td>
                                                    <td>{{ $co->phone }}</td>
                                                    <td id="cont">
                                                        {{-- onchange="this.form.submit()" --}}
                                                        <?php $order_status = ['3','2','0','-1']; ?>
                                                        <select runat="server" id="order_status" class="form-control" name="status[]" required data-id="{{ $co->status }}">
                                                            @foreach($order_status as $os)
                                                                <option value="{{ $os }}" {{ $os == $co->status ? 'selected' : '' }} >
                                                                    @if($os == 3)
                                                                        Completed
                                                                    @elseif($os == 2)
                                                                        Processing
                                                                    @elseif($os == 0)
                                                                        Incomplete
                                                                    @elseif($os == -1)
                                                                        Cancelled
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.order.view.get',[$co->id]) }}" rel="tooltip" title="View Order" class="btn btn-info btn-link btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                    </td>
                                                    <td><input type="hidden"  name="id[]" value="{{ $co->id }}" /></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <div class="pagination">
                                    <div class="col-md-12">
                                        {{ $completed_orders->links() }}
                                    </div>
                                </div>
                            </div>        
                        </div>
                    </div>
                    <!-- Incomplete -->
                    <div class="tab-pane" id="incomplete">
                        <div class="card">
                            <div class="card-header card-header-success" style="margin: 1rem;">
                                <h4 class="card-title ">Incomplete Orders</h4>
                                <p class="card-category">Here is a subtitle for this table</p>
                            </div>
                            <div class="card-body" style="margin: 1rem;">
                                <div class="table-responsive">
                                    <form action="{{ route('admin.order.bulk-edit.post') }}" method="post" id="order_incomplete_form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <!-- Pagination select -->
                                        {{-- <select id="incomplete_pagination" onChange="this.form.submit();">
                                            <option value="5" @if($items == 5) selected @endif >5</option>
                                            <option value="10" @if($items == 10) selected @endif >10</option>
                                            <option value="25" @if($items == 25) selected @endif >25</option>
                                        </select>                         --}}
                                        <table class="table">
                                            <thead class="text-success">
                                                <th>Order ID</th>
                                                <th>Total Amount<small> (Rs)</small></th>
                                                <th>Items</th>
                                                <th>Customer Name</th>
                                                <th>Sender Phone </th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                @foreach($incomplete_orders as $io)
                                                <tr class="table-tr" data-url="">
                                                    <td>{{ $io->title }}</td>
                                                    <td class="text-success"><?php echo number_format($io->total, 2); ?></td>
                                                    <td>{{ $io->items_count }}</td>
                                                    <td>{{ $io->first_name }}<br/> {{ $io->last_name }}</td>
                                                    <td>{{ $io->phone }}</td>
                                                    <td id="cont">
                                                        {{-- onchange="this.form.submit()" --}}
                                                        <?php $order_status = ['3','2','0','-1']; ?>
                                                        <select runat="server" id="order_status" class="form-control" name="status[]" required data-id="{{ $io->status }}">
                                                            @foreach($order_status as $os)
                                                                <option value="{{ $os }}" {{ $os == $io->status ? 'selected' : '' }} >
                                                                    @if($os == 3)
                                                                        Completed
                                                                    @elseif($os == 2)
                                                                        Processing
                                                                    @elseif($os == 0)
                                                                        Incomplete
                                                                    @elseif($os == -1)
                                                                        Cancelled
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.order.view.get',[$io->id]) }}" rel="tooltip" title="View Order" class="btn btn-info btn-link btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                    </td>
                                                    <td><input type="hidden"  name="id[]" value="{{ $io->id }}" /></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <div class="pagination">
                                    <div class="col-md-12">
                                        {{ $incomplete_orders->links() }}
                                    </div>
                                </div>
                            </div>        
                        </div>
                    </div>
                    <!-- Cancelled -->
                    <div class="tab-pane" id="cancelled">
                        <div class="card">
                            <div class="card-header card-header-success" style="margin: 1rem;">
                                <h4 class="card-title ">Cancelled Orders</h4>
                                <p class="card-category">Here is a subtitle for this table</p>
                            </div>
                            <div class="card-body" style="margin: 1rem;">
                                <div class="table-responsive">
                                    <form action="{{ route('admin.order.bulk-edit.post') }}" method="post" id="order_cancelled_form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <!-- Pagination select -->
                                        {{-- <select id="cancelled_pagination" onChange="this.form.submit();">
                                            <option value="5" @if($items == 5) selected @endif >5</option>
                                            <option value="10" @if($items == 10) selected @endif >10</option>
                                            <option value="25" @if($items == 25) selected @endif >25</option>
                                        </select>                         --}}
                                        <table class="table">
                                            <thead class="text-success">
                                                <th>Order ID</th>
                                                <th>Total Amount<small> (Rs)</small></th>
                                                <th>Items</th>
                                                <th>Customer Name</th>
                                                <th>Sender Phone </th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                @foreach($cancelled_orders as $cno)
                                                <tr class="table-tr" data-url="">
                                                    <td>{{ $cno->title }}</td>
                                                    <td class="text-success"><?php echo number_format($cno->total, 2); ?></td>
                                                    <td>{{ $cno->items_count }}</td>
                                                    <td>{{ $cno->first_name }}<br/> {{ $cno->last_name }}</td>
                                                    <td>{{ $cno->phone }}</td>
                                                    <td id="cont">
                                                        {{-- onchange="this.form.submit()" --}}
                                                        <?php $order_status = ['3','2','0','-1']; ?>
                                                        <select runat="server" id="order_status" class="form-control" name="status[]" required data-id="{{ $cno->status }}">
                                                            @foreach($order_status as $os)
                                                                <option value="{{ $os }}" {{ $os == $cno->status ? 'selected' : '' }} >
                                                                    @if($os == 3)
                                                                        Completed
                                                                    @elseif($os == 2)
                                                                        Processing
                                                                    @elseif($os == 0)
                                                                        Incomplete
                                                                    @elseif($os == -1)
                                                                        Cancelled
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.order.view.get',[$cno->id]) }}" rel="tooltip" title="View Order" class="btn btn-info btn-link btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                    </td>
                                                    <td><input type="hidden"  name="id[]" value="{{ $cno->id }}" /></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <div class="pagination">
                                    <div class="col-md-12">
                                        {{ $cancelled_orders->links() }}
                                    </div>
                                </div>
                            </div>        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('js')

<script>   
// $(function() {
//     $('table.table').on("click", "tr.table-tr", function() {
//         window.location = $(this).data("url");
//         //alert($(this).data("url"));
//     });
// });

document.getElementById('processing_pagination').onchange = function() {
    window.location = "{{ $processing_orders->url(1) }}&items=" + this.value;
};
document.getElementById('completed_pagination').onchange = function() {
    window.location = "{{ $completed_orders->url(1) }}&items=" + this.value;
};
document.getElementById('incomplete_pagination').onchange = function() {
    window.location = "{{ $incomplete_orders->url(1) }}&items=" + this.value;
};
document.getElementById('cancelled_pagination').onchange = function() {
    window.location = "{{ $incomplete_orders->url(1) }}&items=" + this.value;
};
</script>
@stop