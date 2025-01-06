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
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                  height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                  fill="currentColor"/>
                                            <path
                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                fill="currentColor"/>
                                        </svg>
                                    </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-items-table-filter="search"
                               class="form-control form-control-solid w-250px ps-14"
                               placeholder="Search Items"/>
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-items-table-toolbar="base">
                        <!--begin::Filter-->
                        <!--begin::claims 1-->
                        <!--end::claims 1-->
                        <!--end::Filter-->
                        <!--begin::Add claims-->
                        <a href="#" class="btn btn-primary" id="AddItemModal">
                                        <span class="indicator-label">
                                            <span class="svg-icon svg-icon-2">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="11.364" y="20.364" width="16"
                                                          height="2" rx="1"
                                                          transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                                    <rect x="4.36396" y="11.364" width="16" height="2"
                                                          rx="1" fill="currentColor"/>
                                                </svg>
                                            </span>
                                            {{__('Add')}}
                                        </span>
                            <span class="indicator-progress">
                                            Please wait... <span
                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                        </a>
                        <!--end::Add claims-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Modal - Add task-->

                    <!--end::Modal - Add task-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->

            <div class="card-body py-4">
                <!--begin::Table-->
                <div class="row">
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Discount') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="discount" style="font-size: 40px;color: red; text-align: center"
                                   id="total_discount" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($claim) ? $claim->discount : 0 }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Total Cost') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="cost" id="claim_total_cost"
                                   class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" style="font-size: 40px;color: blue; text-align: center"
                                   value="{{ isset($claim) ? $claim->cost : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __(' Currency') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control=""
                                    name="currency" id="currency" style="font-size: 40px;color: green; text-align: center"
                                    data-placeholder="Select an option">
                                <option></option>
                                @foreach ($currencies as $s)
                                    <option value="{{ $s->id }}"
                                    @isset($claim)
                                        @selected($claim->currency == $s->id)
                                        @endisset>
                                        {{ $s->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5"
                           id="kt_table_items">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="mw-40px all">{{__('ID')}}</th>
                            <th class="min-w-125px all">{{__('Description')}}</th>
                            <th class="min-w-125px all">{{__('Notes')}}</th>
                            <th class="min-w-125px all">{{__('Cost')}}</th>
                            <th class="min-w-125px all">{{__('Qty')}}</th>
                            <th class="min-w-125px all">{{__('Discount')}}</th>
                            <th class="min-w-125px all">{{__('Total Cost')}}</th>
                            <th class="min-w-125px all">{{__('Month')}}</th>
                            <th class="min-w-125px all">{{__('Year')}}</th>
                            <th class="text-end mw-100px all">{{__('Actions')}}</th>
                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>

@push('scripts')

    @isset($claim)

        <script>
            var datatableItem;
            var initItems = (function () {


                return function () {


                    executed = true;
                    const columnDefs = [{
                        data: 'id',
                        name: 'id',
                    },
                        {
                            data: 'description',
                            name: 'description',
                        },
                        {
                            data: 'notes',
                            name: 'notes',
                        },
                        {
                            data: 'cost',
                            name: 'cost',
                        },
                        {
                            data: 'qty',
                            name: 'qty',
                        },
                        {
                            data: 'discount',
                            name: 'discount',
                        },
                        {
                            data: 'total_cost',
                            name: 'total_cost',
                        },
                        {
                            data: function (row, type, set) {
                                if (type === 'display') {
                                    if (row.month)
                                        return row.monthy.name;
                                }
                                return '';
                            },
                            name: 'monthy.name',
                        },
                        {
                            data: 'year',
                            name: 'year',
                        },

                        {
                            data: 'action',
                            name: 'action',
                            className: 'text-end',
                            orderable: false,
                            searchable: false
                        }
                    ];
                    datatableItem = createDataTable('#kt_table_items', columnDefs,
                        "{{ route('claims.items.index', ['claim' => isset($claim)?$claim->id:0]) }}",
                        [
                            [0, "ASC"]
                        ]);
                    datatableItem.on('xhr', function (e, settings, json) {

                        let c = parseInt(json['claim_total_cost']);
                        let d = parseInt($('#total_discount').val()) ? parseInt($('#total_discount').val()) : 0;
                        console.log(c);
                        console.log(d);
                        $('#claim_total_cost').val(c - d);


                    });

                };
            })();
        </script>
        <script>
            const filterSearchItems = document.querySelector('[data-kt-items-table-filter="search"]');
            filterSearchItems.onkeydown = debounce(keyPressCallback, 400);

            function keyPressCallback() {
                datatableItem.columns(1).search(filterSearchItems.value).draw();
            }
        </script>

        <script>
            $(function () {


                const validatorItemFields = {
                    'discount': {
                        validators: {
                            notEmpty: {
                                message: 'Fill To '
                            }
                        }
                    },
                    'cost': {
                        validators: {
                            notEmpty: {
                                message: 'Fill To '
                            }
                        }
                    },
                    'description': {
                        validators: {
                            notEmpty: {
                                message: 'Fill To '
                            }
                        }
                    },

                };
                const RequiredInputListItem = {
                    'discount': 'input',
                    'cost': 'input',
                    'qty': 'input',
                    'description': 'select',


                }
                const kt_modal_add_item = document.getElementById('kt_modal_add_item');
                const modal_kt_modal_add_item = new bootstrap.Modal(kt_modal_add_item);

                $(document).on('click', '#AddItemModal', function (e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    renderAModal(
                        "{{ route('claims.items.add', ['claim_id' => isset($claim) ? $claim->id : '' ]) }}",
                        $(this), '#kt_modal_add_item',
                        modal_kt_modal_add_item,
                        validatorItemFields,
                        '#kt_modal_add_item_form',
                        datatableItem,
                        '[data-kt-items-modal-action="submit"]', RequiredInputListItem);
                });


                $(document).on('click', '.btnUpdateItem', function (e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    const editURl = $(this).attr('href');

                    globalRenderModal(editURl,
                        $(this), '#kt_modal_add_item',
                        modal_kt_modal_add_item,
                        validatorItemFields,
                        '#kt_modal_add_item_form',
                        datatableItem,
                        '[data-kt-items-modal-action="submit"]', RequiredInputListItem);
                });


                $(document).on('click', '.btnDeleteItem', function (e) {
                    e.preventDefault();
                    const URL = $(this).attr('href');
                    const itemName = $(this).attr('data-item-name');
                    Swal.fire({
                        text: "Are you sure you want to delete " + itemName + "?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            $.ajax({
                                type: "DELETE",
                                url: URL,
                                dataType: "json",
                                success: function (response) {
                                    datatableItem.ajax.reload(null, false);
                                    Swal.fire({
                                        text: response.message,
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                },
                                complete: function () {
                                },
                                error: function (response, textStatus,
                                                 errorThrown) {
                                    toastr.error(response
                                        .responseJSON
                                        .message);
                                },
                            });

                        } else if (result.dismiss === 'cancel') {
                        }

                    });
                });


            });
        </script>
        <script>
            $(function () {
                initItems();
            });
            $(document).on('change', '[name="discount"]', function (e) {
                /* let c= parseInt($('#claim_total_cost').val());
                 let d =parseInt($(this).val());
                 $('#claim_total_cost').val(c-d);*/
                datatableItem.columns(1).search(filterSearchItems.value).draw();
            });
        </script>
    @endisset

@endpush
