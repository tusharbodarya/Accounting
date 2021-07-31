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
                <h4 class="mb-0 font-size-18">Sales Invoice</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sales Invoice</a></li>
                        <li class="breadcrumb-item active">Sales Invoice</li>
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

                    <a type="button" class="btn btn-outline-info" href="{{ url('/saleinvoice/create') }}"><i
                            class="icon-note mr-2"></i>ADD NEW Sale Invoice</a>
                    <div class="dropdown-divider"></div>
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if (Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                    @endif
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Challan No.</th>
                                <th>Qty</th>
                                <th>Account Name</th>
                                <th>Order Date</th>
                                <th>Order Due Date</th>
                                <th>Total Ammount</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php $ammount = 0;
                            $qty = 0; ?>
                            @foreach ($salesInvoice as $saleInvoice)
                                <?php
                                $ammount += str_replace(',', '', $saleInvoice->total);
                                $products = unserialize($saleInvoice->productarray);
                                ?>
                                <tr>
                                    <td>{{ $saleInvoice->id }}</td>
                                    <td>{{ $saleInvoice->challannum }}</td>
                                    <td>
                                        @foreach ($products as $p)
                                            <?php
                                            $product = explode('-', $p['product_name']);
                                            $qty += $p['product_qty'];
                                            echo $p['product_qty'] . ' - ' . $product[0] . '<br>';
                                            ?>
                                        @endforeach
                                    </td>
                                    <td>{{ $saleInvoice->account_name }}</td>
                                    <td>{{ $saleInvoice->orderdate }}</td>
                                    <td>{{ $saleInvoice->orderduedate }}</td>
                                    <td>{{ $saleInvoice->total }}</td>
                                    <td>
                                        <a href="saleinvoice/{{ $saleInvoice->id }}"
                                            class="btn btn-success btn-xs delete-object" title="Show"><i
                                                class="mdi mdi-eye"></i></a>
                                        <a href="/saleinvoice/{{ $saleInvoice->id }}/edit"
                                            class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
                                        <a href="/saleinvoice-delete/{{ $saleInvoice->id }}"
                                            class="btn btn-danger btn-xs delete-object" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                        {{-- {!! method_field('DELETE') !!}
                                                    <input type="hidden" name="_method" value="DELETE"> --}}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <td></td>
                            <td></td>
                            <td>{{ $qty }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ $ammount }}</td>
                            <td></td>
                        </tfoot>
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
