@extends('layouts.layout')
@section('title')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Welcome</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Welcome</li>
                </ol>
            </div>

        </div>
    </div>
</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Column with Data Labels</h4>

                    <div id="column_chart_datalabel" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
            <!--end card-->
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Bar Chart</h4>

                    <div id="bar_chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
            <!--end card-->
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Line, Column & Area Chart</h4>

                    <div id="mixed_chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
            <!--end card-->
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Radial Chart</h4>

                    <div id="radial_chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
            <!--end card-->

        </div>

    </div> <!-- end row -->
@endsection

@section('script')
    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- apexcharts init -->
    <script src="{{ asset('assets/js/pages/apexcharts.init.js') }}"></script>
@endsection
