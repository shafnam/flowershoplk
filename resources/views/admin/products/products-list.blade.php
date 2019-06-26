@extends('layouts.master')

@section('css')
<style>
    .row { width: 100%; margin:0;}
</style>
@stop

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
            <div class="card-header card-header-primary">
                <h4 class="card-title ">All Products</h4>
                <p class="card-category"> Here is a subtitle for this table</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('admin.import.file') }}" class="form-inline pull-left" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}                    
                            <label for="sample_file" style="margin-right: 5px; color: #5f5f5f;">Add products: (csv format only)</label>
                            <input type="file" name="sample_file" style="width: 32%; color: #afafaf;" required/>  
                            <button class="btn btn-sm btn-info">Import File</button>           
                        </form>
                    </div>
                    <div class="col-md-12">
                        <div class="text-right">
                            <a href="{{ URL::to( '/downloads/sample-product-file.csv' ) }}" target="_blank" class="btn btn-sm btn-danger" style="margin-bottom: 2rem;">
                                <i class="fa fa-download"></i> Download sample file format
                            </a>
                            <a href="{{ route('admin.product.add.get') }}" class="btn btn-sm btn-success" style="margin-bottom: 2rem;">
                                <i class="fa fa-plus-square"></i> Add New Single Product
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">                    
                            <table id="pageTable" class="table">
                                <thead class="text-primary">
                                    <th></th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Price</th>
                                    <th>Shop</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($all_products as $ap)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('product-photos/'.$ap->product_photos->first()->title) }}" class="img-responsive" style="width: 100px">
                                        </td>
                                        <td>{{ $ap->name }}</td>
                                        <td>{{ $ap->code }}</td>
                                        <td class="text-primary">{{ $ap->price }}</td>
                                        <td>{{ $ap->shops->name }}</td>
                                        <td>
                                            @if($ap->status == 1)
                                                <span class="label label-success">Active</span>
                                            @else
                                                <span class="label label-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.product.edit.get',[$ap->id]) }}" title="edit" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="{{ route('admin.product.view.get',[$ap->id]) }}" title="view" class="btn btn-sm btn-info"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @if($ap->status == '1')
                                                <!--Deactivate Function-->
                                                <form action="{{ route('admin.products.deactivate', $ap->id) }}" method="POST" onsubmit="return confirm('Do you really want to deactivate?');" style="display: inline;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <button class="btn btn-sm btn-danger" type="submit" title="deactivate"><i class="fa fa-ban" aria-hidden="true"></i></button>
                                                </form>
                                            @else
                                                <!--Activate Function-->
                                                <form action="{{ route('admin.products.activate', $ap->id) }}" method="POST" onsubmit="return confirm('Do you really want to activate?');" style="display: inline;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <button class="btn btn-sm btn-success" type="submit" title="activate"><i class="fa fa-check" aria-hidden="true"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>                    
                        </div>
                    </div>
                </div>                
                
                {{-- <div class="pagination">
                    <div class="col-md-12">
                        {{ $all_products->links() }}
                    </div>
                </div> --}}
            </div>        
        </div>
    </div>
    
</div>
@endsection

@section('js')

<script>
$(document).ready(function() {
    $('#pageTable').DataTable();
} );   
    // jQuery(function($) {
    //     //initiate dataTables plugin
    //     var myTable = $('#pageTable')
    //     //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
    //     .DataTable( {
    //         bAutoWidth: false,
    //         "aoColumns": [
    //             null,
    //             null,
    //             null,
    //             null,
    //             null,
    //             null,
    //             null
    //         ],
    //         "aaSorting": [],        
        
    //         //"bProcessing": true,
    //         //"bServerSide": true,
    //         //"sAjaxSource": "http://127.0.0.1/table.php"   ,

    //         //,
    //         //"sScrollY": "200px",
    //         //"bPaginate": false,

    //         //"sScrollX": "100%",
    //         //"sScrollXInner": "120%",
    //         //"bScrollCollapse": true,
    //         //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
    //         //you may want to wrap the table inside a "div.dataTables_borderWrap" element

    //         //"iDisplayLength": 50
    //         select: {
    //             style: 'multi'
    //         }
    //     });
    // });
</script>
@stop