<div class="card mb-5 mb-xl-10" id="kt_restaurant_details_view">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title m-0">


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
        <!--end::Card title-->
        <div class="card-toolbar">


        </div>
    </div>
    <!--begin::Card header-->

    <!--begin::Card body-->
    <div class="card-body p-9">

        <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_CDR">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-125px">Name</th>
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

    </div>

</div>

<!--end::Card body-->
@isset($restaurant)
    @push('scripts')
        <script>
            const columnDefs =
                [{
                    data: 'name',
                    name: 'name',
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
            var datatable = createDataTable('#kt_table_CDR', columnDefs, "{{ route('cdr.indexMobile',['mobile'=>$restaurant->telephone]) }}", [
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
@endisset


