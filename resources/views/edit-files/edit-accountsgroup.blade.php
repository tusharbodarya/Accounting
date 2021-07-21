@extends('layouts.layout')
@section('title')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Accounts Group</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Accounts</a></li>
                        <li class="breadcrumb-item active">Edit Accounts Group</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Add New Account Group</h4>

                                        <form class="form-horizontal" action="{{ route('update_acgroup') }}" method="POST">
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

                                     @csrf  
                                            <input type="hidden" name='id' value="{{ $editacgroup->id }}">
                                            <div class="form-group">
                                                <label for="groupname">Account Group Name</label>
                                                <input type="text" class="form-control" id="groupname" name="groupname" value="{{ $editacgroup->groupname }}" placeholder="Enter Account Group Name">
                                                <span class="text-danger">@error('groupname'){{ $message }}@enderror</span>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="effecton">Effect On</label>
                                                        <select id="effecton" name="effecton" class="form-control">
                                                            <option value='{{ $editacgroup->effecton }}' hidden>{{ $editacgroup->effecton }}</option>
                                                            <option value='Balance Sheet'>Balance Sheet</option>
                                                            <option value='Profit & Loss Accounts'>Profit & Loss Accounts </option>
                                                            <option value='Trading Accounts'>Trading Accounts  </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="sequence">Sequence</label>
                                                        <select id="sequence" name="sequence" class="form-control">
                                                            <option value='{{ $editacgroup->sequence }}'>{{ $editacgroup->sequence }}</option>
                                                            <option value='left'>Left</option>
                                                            <option value='right'>Right</option>
                                                            <option value='off'>Off</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
    </div>
@endsection