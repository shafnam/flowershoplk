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
            <div class="card-header card-header-info">
                <h4 class="card-title ">All Customers</h4>
                <p class="card-category"> Here is a subtitle for this table</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-info">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($all_users as $au)
                            <tr>
                                <td>{{ $au->id }}</td>
                                <td>{{ $au->name }}</td>
                                <td>
                                    <a href="{{ route('admin.user.view.get',[$au->id]) }}" rel="tooltip" title="View Full Profile" class="btn btn-info btn-link btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @endforeach   
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <div class="col-md-12">
                        {{ $all_users->links() }}
                    </div>
                </div>
            </div>        
        </div>
    </div>
    
</div>
@endsection