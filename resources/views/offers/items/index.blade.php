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
                        <input type="text" data-kt-items-table-filter="search"
                            class="form-control form-control-solid w-250px ps-14" placeholder="Search Items" />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-items-table-toolbar="base">
                        <!--begin::Filter-->
                        <!--begin::offers 1-->
                        <!--end::offers 1-->
                        <!--end::Filter-->
                        <!--begin::Add offers-->
                        <a href="#" class="btn btn-primary" id="AddItemModal">
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
                                {{ __('Add') }}
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </a>
                        <!--end::Add offers-->
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
                    <div class="col-md-8">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Notes') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="notes" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="">{{ isset($offer) ? $offer->notes : '' }}</textarea>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class=" fw-semibold fs-6 mb-2">{{ __('Is Vat') }}</label>
                            <div class="align-items-center d-flex flex-row me-4">

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="vat"
                                        name="vat_c"
                                        @isset($offer)
                                        @checked($offer->vat == 1)

                                        @endisset>
                                    <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                                        for="status"> {{ __('VAT') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{ __('Status') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                name="status_id" id="status" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($status as $t)
                                    <option value="{{ $t->id }}"
                                        @if (isset($offer)) @selected($offer->status_id == $t->id) @endif>
                                        {{ $t->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{ __('Offer Type') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                name="type_id" id="category" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($TYPES as $t)
                                    <option value="{{ $t->id }}"
                                        @if (isset($offer)) @selected($offer->type_id == $t->id) @endif>
                                        {{ $t->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Duration') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="duration" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="" value="{{ isset($offer) ? $offer->duration : '' }}" />
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Discount') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="discount"
                                style="font-size: 40px;color: red; text-align: center" id="total_discount"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                value="{{ isset($offer) ? $offer->discount : 0 }}" />
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Total Cost') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="total_cost" id="offer_total_cost"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder=""
                                style="font-size: 40px;color: blue; text-align: center"
                                value="{{ isset($offer) ? $offer->total_cost : '' }}" />
                            <!--end::Input-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_items">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="mw-40px">{{ __('ID') }}</th>
                                <th class="min-w-125px">{{ __('Description') }}</th>
                                <th class="min-w-125px">{{ __('Notes') }}</th>
                                <th class="min-w-125px">{{ __('Cost') }}</th>
                                <th class="min-w-125px">{{ __('Qty') }}</th>
                                <th class="min-w-125px">{{ __('Discount') }}</th>
                                <th class="min-w-125px">{{ __('Total Cost') }}</th>
                                <th class="text-end mw-100px">{{ __('Actions') }}</th>
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

    @isset($offer)
        <script>
            var datatableItem;
            var initItems = (function() {


                return function() {


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
                            data: 'action',
                            name: 'action',
                            className: 'text-end',
                            orderable: false,
                            searchable: false
                        }
                    ];
                    datatableItem = createDataTable('#kt_table_items', columnDefs,
                        "{{ route('offers.items.index', ['offer' => isset($offer) ? $offer->id : 0]) }}",
                        [
                            [0, "ASC"]
                        ]);
                    datatableItem.on('xhr', function(e, settings, json) {

                        let c = parseInt(json['offer_total_cost']);
                        let d = parseInt($('#total_discount').val()) ? parseInt($('#total_discount')
                            .val()) : 0;
                        console.log(c);
                        console.log(d);
                        $('#offer_total_cost').val(c - d);


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
            $(function() {


                const validatorItemFields = {};
                const RequiredInputListItem = {
                    'address': 'input',
                    'telephone': 'input',
                    'city_id': 'select',
                    'floor': 'select',
                    'fax': 'input',

                }

                const kt_modal_add_item = document.getElementById('kt_modal_add_item');
                const modal_kt_modal_add_item = new bootstrap.Modal(kt_modal_add_item);

                $(document).on('click', '#AddItemModal', function(e) {
                    e.preventDefault();
                    $(this).attr("data-kt-indicator", "on");
                    renderAModal(
                        "{{ route('offers.items.add', ['offer_id' => isset($offer) ? $offer->id : '']) }}",
                        $(this), '#kt_modal_add_item',
                        modal_kt_modal_add_item,
                        validatorItemFields,
                        '#kt_modal_add_item_form',
                        datatableItem,
                        '[data-kt-items-modal-action="submit"]', RequiredInputListItem);
                });


                $(document).on('click', '.btnUpdateItem', function(e) {
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


                $(document).on('click', '.btnDeleteItem', function(e) {
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
                    }).then(function(result) {
                        if (result.value) {
                            $.ajax({
                                type: "DELETE",
                                url: URL,
                                dataType: "json",
                                success: function(response) {
                                    datatableItem.ajax.reload(null, false);
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


            });
        </script>
        <script>
            $(function() {
                initItems();
            });
            $(document).on('change', '[name="discount"]', function(e) {
                /* let c= parseInt($('#offer_total_cost').val());
                 let d =parseInt($(this).val());
                 $('#offer_total_cost').val(c-d);*/
                datatableItem.columns(1).search(filterSearchItems.value).draw();
            });
        </script>
    @endisset

@endpush
