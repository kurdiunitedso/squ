<div class="me-3">
    <!--begin::Menu toggle-->
    <a href="#" class="btn btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click"
       data-kt-menu-placement="bottom-end">
        <i class="ki-duotone ki-filter fs-6 text-muted me-1"><span class="path1"></span><span class="path2"></span></i>
        {{__('Filter')}}
    </a>
    <!--end::Menu toggle-->


    <!--begin::Menu 1-->
    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-800px" data-kt-menu="true" id="kt_menu_64ca1a18f399e">
        <!--begin::Header-->
        <div class="px-7 py-5">
            <div class="fs-5 text-dark fw-bold">{{__('Filter Options')}}</div>
        </div>
        <!--end::Header-->

        <!--begin::Menu separator-->
        <div class="separator border-gray-200"></div>
        <!--end::Menu separator-->


        <!--begin::Form-->
        <form id="filter-form" class="px-7 py-5">
            <!--begin::Input group-->
            <div class="row">

                <div class="col-md-3">
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('Status')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div>
                            <select class="form-select form-select-solid datatable-input filter-selectpicker"
                                    data-kt-select2="true" multiple data-col-index="status_id" data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_64ca1a18f399e" data-allow-clear="true">
                                <option></option>
                                @foreach ($statuss as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input-->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('Type')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div>
                            <select class="form-select form-select-solid datatable-input filter-selectpicker"
                                    data-kt-select2="true" multiple data-col-index="type_id" data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_64ca1a18f399e" data-allow-clear="true">
                                <option></option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input-->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-10 ">
                        <!--begin::Label-->
                        <label  class="form-label fw-semibold">{{__('Vacation Date')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="">
                            <input  class="datatable-input  form-control date-flatpickr form-control-solid mb-3 mb-lg-0" data-col-index="from_date"
                            />
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            <!--begin::Actions-->

            <div class="d-flex justify-content-end">
                <button type="reset" id="resetFilterBtn"
                        class="btn btn-sm btn-light btn-active-light-primary me-2"
                        data-kt-menu-dismiss="true">{{__('Reset')}}
                </button>

                <button type="submit" id="filterBtn" class="btn btn-sm btn-primary"
                        data-kt-menu-dismiss="true">{{__('Apply')}}
                </button>
            </div>


            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Menu 1-->
</div>
@push('scripts')
    <script>
        $(function () {
            $(".date-flatpickr").flatpickr({
                altInput: true,
                altFormat: "Y-m-d",
                dateFormat: "Y-m-d",
                mode: "range",
                static: true
            });
            $(".time-flatpickr").flatpickr({
                allowInput: true,
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });
            $(".date-time-flatpickr").flatpickr({
                altInput: true,
                altFormat: "Y-m-d H:i",
                dateFormat: "Y-m-d H:i",
                mode: "range",
                enableTime: true,
                static: true
            });

        });
    </script>
@endpush
