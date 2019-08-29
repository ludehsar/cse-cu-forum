@extends('backend.app')

@section('title', 'Categories')

@push('extra-css')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="clearfix">
        <h1 class="h3 mb-2 text-gray-800 float-left">Categories</h1>
    </div>

    <div class="card shadow mt-4 mb-4">
        <div class="card-header py-3">
            <button class="btn btn-primary float-right">Add New Category</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Category Slug</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"></i></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Category Slug</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th style="width: 100px; min-width: 100px;" class="text-center text-danger"><i class="fa fa-bolt"></i></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>System Architect</td>
                            <td>system-architect</td>
                            <td>2011/04/23</td>
                            <td>2011/04/25</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Second group">
                                    <a href="#" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection

@push('extra-js')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
@endpush