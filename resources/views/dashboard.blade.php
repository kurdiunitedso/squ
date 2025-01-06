@extends('metronic.index')

@section('subpageTitle', 'Dashboard')

@section('content')
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">{{ env('APP_NAME') }}</h3>
                </div>
                <div class="card-body">
                    User and Permission Module
                    <br>
                    Dashboard Supports multi-Language (arabic, English)
                    <br>
                    using Metronic 8.1.7
                </div>
            </div>
        </div>
    </div>
@endsection
