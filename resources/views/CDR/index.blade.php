@extends('metronic.index')

@section('title', 'CDR')
@section('subpageTitle', 'CDR')

@section('content')
    <!--begin::Content container-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                          rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-CDR-table-filter="search"
                                   class="form-control form-control-solid w-250px ps-14" placeholder="Search CDR"/>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <!--end::Toolbar-->
                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_CDR" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">

                            </div>
                            <!--end::Modal dialog-->
                        </div>
                        <!--end::Modal - Add task-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_CDR">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Name</th>
                            <th class="all"></th>
                            <th class="min-w-125px">Date</th>
                            <th class="min-w-125px">From</th>
                            <th class="min-w-125px">To</th>
                            <th class="min-w-125px">Duration (SEC)</th>
                            <th class="min-w-125px">Status</th>
                            <th class="min-w-125px">Type</th>
                            <th class="min-w-125px">Record</th>
                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content container-->
    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_CDR" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->
@endsection


@push('scripts')
    <script>
        const columnDefs =
            [
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    className: 'dt-row',
                    orderable: false,
                    target: -1,
                    data: null,
                    render: function (data, type, row, meta) {
                        return '<a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px"><span class="la la-list-ul"></span></a>';

                    }
                },
                {
                    data: {
                        _: 'date.display',
                        sort: 'date.timestamp',
                    },
                    name: 'date',
                    searchable: false,
                },
                {
                    data: 'from',
                    name: 'from',
                },
                {
                    data: 'to',
                    name: 'to',
                },
                {
                    data: 'duration',
                    name: 'duration',
                },
                {
                    data: 'call_status',
                    name: 'call_status',
                },
                {
                    data: 'call_type',
                    name: 'call_type',
                },
                {
                    data: 'record_file_name',
                    name: 'record_file_name',
                },
            ];
        var datatable = createDataTable('#kt_table_CDR', columnDefs, "{{ route('cdr.index') }}", [
            [1, "DESC"]
        ]);
    </script>
    <script>
        const filterSearch = document.querySelector('[data-kt-CDR-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.columns(1).search(filterSearch.value).draw();
        }
    </script>
@endpush
