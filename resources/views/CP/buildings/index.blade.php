@php
    use App\Models\Contract;
@endphp
@extends('metronic.index')

@section('title', $_model::ui['p_ucf'])
@section('subpageTitle', $_model::ui['p_ucf'])

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
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-col-index="search" data-kt-table-filter="search"
                                class="form-control datatable-input form-control-solid w-250px ps-14"
                                placeholder="{{ t('Search ' . $_model::ui['s_ucf']) }}" />
                            <input type="hidden" name="selectedCaptin">
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-departments-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::captins 1-->
                            <!--end::captins 1-->
                            @include($_model::ui['view'] . '_filter')

                            <a target="_blank" id="exportBtn" href="#"
                                data-export-url="{{ route($_model::ui['route'] . '.export') }}"
                                class="btn btn-primary me-3">
                                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                        class="path2"></span></i> {{ __('Export') }}
                            </a>
                            <!--end::Filter-->
                            <!--begin::Add captins-->
                            <a href="{{ route($_model::ui['route'] . '.create') }}" class="btn btn-primary"
                                id="add_{{ $_model::ui['s_lcf'] }}_modal">
                                <span class="indicator-label">
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    {{ t('Add ' . $_model::ui['s_ucf']) }}
                                </span>
                                <span class="indicator-progress">
                                    {{ t('Please wait...') }} <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </a>
                            <!--end::Add captins-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_captins" tabindex="-1" aria-hidden="true">
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
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_items_model">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-25px all"><input type="checkbox" id="select-all"></th>
                                <th class="all"></th>
                                <th class="min-w-100px bold all">{{ __('SN') }}</th>
                                <th class="min-w-100px bold all">{{ t('Name') }}</th>
                                <th class="min-w-200px bold all">{{ t('Code') }}</th>
                                <th class="min-w-100px bold all">{{ t('City') }}</th>
                                <th class="min-w-100px bold all">{{ t('address') }}</th>
                                <th class="min-w-100px bold all">{{ t('floors_number') }}</th>
                                <th class="min-w-100px bold all">{{ t('apartments_number') }}</th>
                                <th class="min-w-200px bold all">{{ __('Actions') }}</th>

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







    {{-- @include('calls.call_drawer')
    @include('calls.questionnaire_logs_drawer')

    @include('sms.sms_drawer') --}}

@endsection


@push('scripts')
    <script>
        var selectedItemsModelsRows = [];
        var selectedItemModelsData = [];

        const columnDefs = [{
                data: null,
                render: function(data, type, row, meta) {
                    var isChecked = selectedItemsModelsRows.includes(row.id.toString()) ? 'checked' : '';
                    return '<input type="checkbox" class="row-checkbox" ' + isChecked + '>';
                },
                orderable: false,

            },
            {
                className: 'dt-row',
                orderable: false,
                target: -1,
                data: null,
                render: function(data, type, row, meta) {
                    return '<a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px"><span class="la la-list-ul"></span></a>';

                }
            },
            {
                data: 'id',
                name: 'id',
            },
            {
                data: 'name',
                name: 'name',
            },



            {
                data: 'code',
                name: 'code',
            },

            {
                data: 'city.name',
                name: 'city.name',
                defaultContent: 'N/A', // Add this
                render: function(data, type, row) {
                    return row.city?.name || 'N/A';
                }
            }, {
                data: 'address',
                name: 'address',
            },
            {
                data: 'floors_number',
                name: 'floors_number',
            },
            {
                data: 'apartments_number',
                name: 'apartments_number',
            },
            {
                data: 'action',
                name: 'action',
                className: 'text-end',
                orderable: false,
                searchable: false
            },

        ];
        var datatable = createDataTable('#kt_table_items_model', columnDefs,
            "{{ route($_model::ui['route'] . '.index') }}", [
                [0, "ASC"]
            ]);
        datatable.on('draw', function() {
            KTMenu.createInstances();
        });
        datatable.on('responsive-display', function() {
            KTMenu.createInstances();
        });


        $('#kt_table_items_model').find('#select-all').on('click', function() {
            $('#kt_table_items_model').find('.row-checkbox').click();
        });

        $('#kt_table_items_model tbody').on('click', '.row-checkbox', function() {
            var $row = $(this).closest('tr');
            var rowData = datatable.row($row).data();
            var rowIndex = selectedItemsModelsRows.indexOf(rowData.id);

            if (this.checked && rowIndex === -1) {
                selectedItemsModelsRows.push(rowData.id);
            } else if (!this.checked && rowIndex !== -1) {
                //console.log(data);
                selectedItemsModelsRows.splice(rowIndex, 1);

            }

            $row.toggleClass('selected');
            datatable.row($row).select(this.checked);
            if (selectedItemsModelsRows.length == 0)
                $('#selectedItemsModelsRowsCount').html("");
            else
                $('#selectedItemsModelsRowsCount').html("(" + selectedItemsModelsRows.length + ")");


            $('[name="selectedCaptin"]').val(selectedItemsModelsRows.join(','));

        });

        // Restore selected rows when page changes
        datatable.on('draw.dt', function() {
            datatable.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var rowData = this.data();
                if (selectedItemsModelsRows.includes(rowData.id)) {
                    this.select();
                }
            });
        });
    </script>
    <script>
        const filterSearch = document.querySelector('[data-kt-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);

        function keyPressCallback() {
            datatable.draw();
        }
    </script>

    <script>
        $(document).on('click', '.btn_delete_' + "{{ $_model::ui['s_lcf'] }}", function(e) {
            e.preventDefault();
            const URL = $(this).attr('href');
            const itemModelName = $(this).attr('data-' + "{{ $_model::ui['s_ucf'] }}" + '-name');
            Swal.fire({
                html: "Are you sure you want to delete " + itemModelName + "?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: URL,
                        dataType: "json",
                        success: function(response) {
                            datatable.ajax.reload(null, false);
                            Swal.fire({
                                text: response.message,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        complete: function() {},
                        error: function(response, textStatus,
                            errorThrown) {
                            toastr.error(response
                                .responseJSON
                                .message);
                        },
                    });

                } else if (result.dismiss === 'cancel') {}

            });
        });
    </script>
    <script>
        $(document).on('click', '#filterBtn', function(e) {
            e.preventDefault();
            datatable.ajax.reload();
        });

        $(document).on('click', '#resetFilterBtn', function(e) {
            e.preventDefault();
            $('#filter-form').trigger('reset');
            $('.datatable-input').each(function() {
                if ($(this).hasClass('filter-selectpicker')) {
                    $(this).val('');
                    $(this).trigger('change');
                }
                if ($(this).hasClass('flatpickr-input')) {
                    const fp = $(this)[0]._flatpickr;
                    fp.clear();
                }
            });
            datatable.ajax.reload();
        });

        $(document).on('click', '#exportBtn', function(e) {
            e.preventDefault();
            const url = $(this).data('export-url');
            console.log(url);
            const myUrlWithParams = new URL(url);

            const parameters = filterParameters();
            //myUrlWithParams.searchParams.append('params',JSON.stringify( parameters))
            Object.keys(parameters).map((key) => {
                myUrlWithParams.searchParams.append(key, parameters[key]);
            });
            console.log(myUrlWithParams);
            window.open(myUrlWithParams, "_blank");

        });
    </script>
@endpush
