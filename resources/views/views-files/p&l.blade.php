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
                <h4 class="mb-0 font-size-18">P&L Report</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">P&L Report</a></li>
                        <li class="breadcrumb-item active">P&L Report</li>
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
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-sm-12">
								    <h4 class="table-info text-center">INCOME</h4>
							    </div>
                                <table class="table text-center">
								    <tbody>
                                         @foreach ($incomeac_groups as $incomeac_group)
                                            <tr>
											    <th class="text-danger" colspan="3">{{ $incomeac_group->groupname }}</th>
										    </tr>
                                            <tr>
												<td>{{ $incomeac_group->balance }}</td>
												<td>{{ $incomeac_group->name }}</td>
												<td><a href="view-accountsreport.php?purchasetextype={{ $incomeac_group->id }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View</a></td>
											</tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-12">
								    <h4 class="table-info text-center">EXPENSE</h4>
							    </div>
                                <table class="table text-center">
                                    <tbody>
                                        @foreach ($expenseac_groups as $expenseac_group)
                                            <tr>
											    <th class="text-danger" colspan="3">{{ $expenseac_group->groupname }}</th>
										    </tr>
                                            <tr>
												<td>{{ $expenseac_group->balance }}</td>
												<td>{{ $expenseac_group->name }}</td>
												<td><a href="view-accountsreport.php?purchasetextype={{ $expenseac_group->id }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View</a></td>
											</tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
