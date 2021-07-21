@extends('layouts.layout')
@section('title')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Accounts</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Accounts</a></li>
                        <li class="breadcrumb-item active">Edit Accounts</li>
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
                    <h4 class="card-title mb-4">Edit Account</h4>

                    <form class="form-horizontal" action="{{ route('update_ac') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name='id' value="{{ $editac->id }}">
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
                        <label>
                            <h4><u>Main Details</u></h4>
                        </label>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $editac->name }}"
                                placeholder="Enter name">
                            <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                            </div>

                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="effecton">Effect On</label>
                                        <select id="effecton" name="effecton" class="form-control">
                                            <option value='{{ $editac->effecton }}' hidden>{{ $editac->effecton }} </option>
                                            <option value='Balance Sheet'>Balance Sheet</option>
                                            <option value='Profit & Loss Accounts'>Profit & Loss Accounts </option>
                                            <option value='Trading Accounts'>Trading Accounts </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="accountsgroup">Group Name</label>
                                        <select id="accountsgroup" name="accountsgroup" class="form-control">
                                            <option value='{{ $editac->accountsgroup }}' hidden>{{ $editac->groupname }}
                                            </option>
                                            @if (!empty($check_account))
                                                @foreach ($check_account as $ac)
                                                    <option value='{{ $ac->id }}'>{{ $ac->groupname }} </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <label>
                                <h4><u>Party Details</u></h4>
                            </label>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="area">Area</label>
                                        <input type="text" class="form-control" id="area" name="area"
                                            value="{{ $editac->area }}" placeholder="Enter Area">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            value="{{ $editac->city }}" placeholder="Enter City">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pincode">Pincode</label>
                                        <input type="text" class="form-control" id="pincode" name="pincode"
                                            value="{{ $editac->pincode }}" placeholder="Enter Pincode">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control" id="state" name="state"
                                            value="{{ $editac->state }}" placeholder="Enter State">
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="panno">PAN NO.</label>
                                        <input type="text" class="form-control" id="panno" name="panno"
                                            value="{{ $editac->panno }}" placeholder="Enter PAN NO">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="aadharno">Aadhar No.</label>
                                        <input type="text" class="form-control" id="aadharno" name="aadharno"
                                            value="{{ $editac->aadharno }}" placeholder="Enter Aadhar No">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="gstno">GSTIN NO.</label>
                                        <input type="text" class="form-control" id="gstno" name="gstno"
                                            value="{{ $editac->gstno }}" placeholder="Enter GSTIN NO">
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <label>
                                <h4><u>Balance Details</u></h4>
                            </label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="balance">Opening Balance</label>
                                        <input type="text" class="form-control" id="balance" name="balance"
                                            value="{{ $editac->balance }}" placeholder="Enter Opening Balance">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="actype">Account Type</label>
                                        <select id="actype" name="actype" class="form-control">
                                            <option value='Credit'>Credit </option>
                                            <option value='Debit'>Debit</option>
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
@section('script')
    <script>
        $(document).ready(function() {

            $('#effecton').on('change', function() {
                var effecton = this.value;
                // console.log(effecton);
                $.ajax({
                    url: "{{ route('add-files.fetchaccountsgroup') }}",
                    type: "POST",
                    data: {
                        effecton: effecton,
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    success: function(result) {
                        $("#accountsgroup").html(result);
                        console.log("Account Fetched");
                    }
                });
            });
        });
    </script>
@endsection
