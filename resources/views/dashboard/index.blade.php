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
                {{--<div class="card-body">


                </div>--}}

            </div>
        </div>
        @if(auth()->user()->can('employee_access'))
            <div class="col-xxl-12 order-2 order-xxl-1">
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 py-5">
                        <form id="filterEmp">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Employee In/Out Today</span>
                            </h3>


                        </form>


                    </div>

                    <div class="card-toolbar">

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0 pb-3">
                        <div class="tab-content">
                            <!--begin::Table-->
                            <div class="table1">
                                <div class="spinner spinner-primary spinner-lg spinner-center"></div>
                                <br>
                                <br>
                                <br>
                            </div>

                            <!--end::Table-->
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        @endif
    </div>
@endsection
@push('scripts')
    <script>
        jQuery(document).ready(function () {

            jQuery('.table1').load('{{route('dashboard.employee')}}' + "?" + $('#filterTable1').serialize());
            jQuery(document).on('change', '#filterTable1', function () {
                jQuery('.table1').html('<div class="spinner spinner-primary spinner-lg spinner-center"></div><br><br>');
                jQuery('.table1').load('{{route('dashboard.employee')}}' + "?" + $('#filterTable1').serialize());
            });

        });
    </script>
@endpush
