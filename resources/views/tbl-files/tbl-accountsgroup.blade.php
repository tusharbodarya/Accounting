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
                <h4 class="mb-0 font-size-18">Accounts</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Accounts</a></li>
                        <li class="breadcrumb-item active">Accounts</li>
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
        
                                        <a type="button" class="btn btn-outline-info" href="{{ url('/add-accountsgroup') }}"><i class="icon-note mr-2"></i>ADD NEW Account</a>
                                        <div class="dropdown-divider"></div>
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Group Name</th>
                                                <th>Effect On</th>
                                                <th>Sequence</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
        
        
                                            <tbody>
                                                @foreach ($fetch_accountgroup as $accountgroup)
                                             <tr>
                                                <td>{{ $accountgroup->id }}</td>
                                                <td>{{ $accountgroup->groupname }}</td>
                                                <td>{{ $accountgroup->effecton }}</td>
                                                <td>{{ $accountgroup->sequence }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-success waves-effect waves-light"  data-toggle="modal" onclick="modelview({{ $accountgroup->id }})" data-target="#myModal">View</button>&nbsp;
                                                <a href="edit-accountgroup/{{ $accountgroup->id }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
                                                <a href="delete-accountgroup/{{ $accountgroup->id }}"class="btn btn-danger btn-xs delete-object" title="Delete"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                                @endforeach
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-xl-3">
                            
                                                <!-- sample modal content -->
                                                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <style type="text/css">
                                                                    td{
                                                                        padding-left: 50px;
                                                                        padding-right: 50px;
                                                                    }
                                                                </style>
                                                                <table border="2px">
                                                                    <tr><td>Group Name</td><td  id='groupname'></td></tr>
                                                                    <tr><td>Effect On</td><td id='effecton'></td></tr>
                                                                    <tr><td>Sequence</td><td id='sequence'></td></tr>
                                                                    </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </div> 
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
        <script>
            function modelview(id){
            $.ajax({
                url:"{{ route('tbl-files.fetchacgroupdetails') }}",
                type : "POST",
                data : {
                    id:id,
                    _token:'{{ csrf_token() }}'
                    },
                success : function(data){
                    $("#groupname").html(data[0]['groupname']);
                    $("#effecton").html(data[0]['effecton']);
                    $("#sequence").html(data[0]['sequence']);
                }
            });
        }
        </script>    
@endsection