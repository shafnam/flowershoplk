@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(session()->has('success_messge'))
            <div class="alert alert-success">
                {{ session()->get('success_messge') }}
            </div>
        @endif
        @if(session()->has('error_messge'))
            <div class="alert alert-danger">
                {{ session()->get('error_messge') }}
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
            <div class="card-header card-header-danger">
                <h4 class="card-title ">All Shops</h4>
                <p class="card-category"> Here is a subtitle for this table</p>
            </div>
            <div class="card-body">
                <div class="text-right">
                    <a href="{{ route('admin.shop.add.get') }}" class="btn btn-sm btn-success" style="margin-bottom: 2rem;">
                        <i class="fa fa-plus-square"></i> Add New Single Shop
                    </a>
                </div> 
                {{-- <form action="{{ route('admin.shop.bulk-edit.post') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text"  name="val" value="1">
                    <input type="submit" name="submit" id="submit" value="Edit" class="btn btn-success"/>
                </form>       --}}
                <div class="table-responsive">
                    <form action="{{ route('admin.shop.bulk-edit.post') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table">
                            <thead class="text-danger">
                                <th>Name</th>
                                <th>Owner</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($all_shops as $as)
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" name="shop_name[]" value="{{ $as->name }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="owner_name[]" value="{{ $as->owner_name }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="shop_address[]" value="{{ $as->address }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="shop_phone[]" value="{{ $as->phone }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="shop_email[]" value="{{ $as->email }}">
                                    </td>
                                    <td>
                                        <?php $shop_status = ['0','1']; ?>
                                        <select class="form-control" name="status[]" required>
                                            @foreach($shop_status as $sa)
                                                <option value="{{ $sa }}" {{ $sa == $as->status ? 'selected' : '' }} >
                                                    @if($sa == 1)
                                                        Active
                                                    @elseif($sa == 0)
                                                        Inactive
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.shop.edit.get',[$as->id]) }}" title="Edit" rel="tooltip" class="btn btn-sm btn-link btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a href="{{ route('admin.shop.view.get',[$as->id]) }}" title="View" rel="tooltip" class="btn btn-sm btn-link btn-info"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        {{-- @if($as->status == '1')
                                            <!--Deactivate Function-->
                                            <form action="{{ route('admin.shop.deactivate', $as->id) }}" method="POST" onsubmit="return confirm('Do you really want to deactivate?');" style="display: inline;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <button class="btn btn-sm btn-danger" type="submit" title="deactivate"><i class="fa fa-ban" aria-hidden="true"></i></button>
                                            </form>
                                        @else
                                            <!--Activate Function-->
                                            <form action="{{ route('admin.shop.activate', $as->id) }}" method="POST" onsubmit="return confirm('Do you really want to activate?');" style="display: inline;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <button class="btn btn-sm btn-success" type="submit" title="activate"><i class="fa fa-check" aria-hidden="true"></i></button>
                                            </form>
                                        @endif --}}
                                    </td>
                                    <td><input type="hidden"  name="id[]" value="{{ $as->id }}" /></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="submit" name="submit" id="submit" value="Bulk Edit" class="btn btn-warning"/>
                    </form>
                </div>
                <div class="pagination">
                    <div class="col-md-12">
                        {{ $all_shops->links() }}
                    </div>
                </div>
            </div>        
        </div>
    </div>
    
</div>
@endsection