@extends('layouts.layout')
@section('css')
    <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('title')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Job Work Challan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Job Work Challan</a></li>
                        <li class="breadcrumb-item active">Job Work Challan</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <a type="button" class="btn btn-outline-info" href="{{ url('/jobworkchallan') }}"><i class="icon-note mr-2"></i>ADD NEW Job Work Challan</a>
                                        <div class="dropdown-divider"></div>
                                        @if(Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                        @endif
                                        
                                        @if(Session::get('fail'))
                                        <div class="alert alert-danger">
                                            {{ Session::get('fail') }}
                                        </div>
                                        @endif
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                             <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Order Id</th>
                                                <th>Account Name</th>
                                                <th>Order Date</th>
                                                <th>Order Due Date</th>
                                                <th>Total Ammount</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
        
        
                                            <tbody>
                                                @foreach ($jobworkchallan as $jc)
                                             <tr>
                                                <td>{{ $jc->id }}</td>
                                                <td>{{ $jc->orderid }}</td>
                                                <td>{{ $jc->account_name }}</td>
                                                <td>{{ $jc->orderdate }}</td>
                                                <td>{{ $jc->orderduedate }}</td>
                                                <td>{{ $jc->total }}</td>
                                                <td>
                                                    <a href="jobworkchallan-view/{{ $jc->id }}"class="btn btn-success btn-xs delete-object" title="Show"><i class="mdi mdi-eye"></i></a>&nbsp;
												<a href="jobworkchallan/{{ $jc->id }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
												<a href="jobworkchallan-delete/{{ $jc->id }}" class="btn btn-danger btn-xs delete-object" title="Delete"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                                @endforeach
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
@endsection
@section('script')
    <!-- Required datatable js -->
        <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="assets/libs/jszip/jszip.min.js"></script>
        <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="assets/js/pages/datatables.init.js"></script>
@endsection