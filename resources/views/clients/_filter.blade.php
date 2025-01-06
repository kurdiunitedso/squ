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

                <!--end::Input group-->

                <div class="col-md-3">
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('City')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div>
                            <select class="form-select form-select-solid datatable-input filter-selectpicker"
                                    data-kt-select2="true" data-col-index="city_id" multiple data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_64ca1a18f399e" data-allow-clear="true">
                                <option></option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input-->
                    </div>
                </div>
                <!--end::Input group-->

                <div class="col-md-3">
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('Category')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div>
                            <select class="form-select form-select-solid multiple datatable-input filter-selectpicker"
                                    data-kt-select2="true" data-col-index="category" multiple
                                    data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_64ca1a18f399e" data-allow-clear="true">
                                <option></option>
                                @foreach ($category  as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!--end::Input-->
                    </div>
                </div>
                <!--end::Input group-->
                <div class="col-md-3">
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('Status')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div>
                            <select class="form-select form-select-solid multiple datatable-input filter-selectpicker"
                                    data-kt-select2="true" data-col-index="status" multiple
                                    data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_64ca1a18f399e" data-allow-clear="true">
                                <option></option>
                                @foreach ($status  as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
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
                            <select class="form-select form-select-solid multiple datatable-input filter-selectpicker"
                                    data-kt-select2="true" data-col-index="type_id" multiple
                                    data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_64ca1a18f399e" data-allow-clear="true">
                                <option></option>
                                @foreach ($client_types  as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!--end::Input-->
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('Active')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div>
                            <select class="form-select form-select-solid datatable-input filter-selectpicker"
                                    data-kt-select2="true" data-col-index="is_active" data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_64ca1a18f399e" data-allow-clear="true">
                                <option></option>
                                <option value="YES">YES</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <!--end::Input-->
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-10 ">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('Last order Bot')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="">
                            <input class="form-control form-control-solid datatable-input "
                                   data-col-index="last_orders_bot"
                                   data-bs-focus="false" placeholder="Pick date" id="last_orders_bot"/>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>


                <div class="col-md-3">
                    <div class="mb-10 ">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('Last order Box')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="">
                            <input class="form-control form-control-solid datatable-input "
                                   data-col-index="last_orders_box"
                                   data-bs-focus="false" placeholder="Pick date" id="last_orders_box"/>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-md-3">
                    <div class="mb-10 ">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('Last order Now')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="">
                            <input class="form-control form-control-solid datatable-input "
                                   data-col-index="last_orders_now"
                                   data-bs-focus="false" placeholder="Pick date" id="last_orders_now"/>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="separator m-10"></div>
                <div class="col-md-2">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold fs-6 mb-2" ata-col-index="Mobile">{{__('Min Orders Bot')}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" data-col-index="orders_bot_min" class="form-control form-control-solid datatable-input"
                               placeholder="" value=""/>
                        <!--end::Input-->
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold fs-6 mb-2" ata-col-index="Mobile">{{__('Max Orders Bot')}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" data-col-index="orders_bot_max" class="form-control form-control-solid datatable-input"
                               placeholder="" value=""/>
                        <!--end::Input-->
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold fs-6 mb-2" ata-col-index="Mobile">{{__('Min Orders Box')}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" data-col-index="orders_box_min" class="form-control form-control-solid datatable-input"
                               placeholder="" value=""/>
                        <!--end::Input-->
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold fs-6 mb-2" ata-col-index="Mobile">{{__('Max Orders Box')}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" data-col-index="orders_box_max" class="form-control form-control-solid datatable-input"
                               placeholder="" value=""/>
                        <!--end::Input-->
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold fs-6 mb-2" ata-col-index="Mobile">{{__('Min Orders Now')}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" data-col-index="orders_now_min" class="form-control form-control-solid datatable-input"
                               placeholder="" value=""/>
                        <!--end::Input-->
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold fs-6 mb-2" ata-col-index="Mobile">{{__('Max Orders Now')}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" data-col-index="orders_now_max" class="form-control form-control-solid datatable-input"
                               placeholder="" value=""/>
                        <!--end::Input-->
                    </div>
                </div>


                <!--end::Input group-->

            </div>
            <!--begin::Actions-->

            <div class="d-flex justify-content-end">
                <button type="reset" id="resetFilterBtn"
                        class="btn btn-sm btn-light btn-active-light-primary me-2"
                        data-kt-menu-dismiss="true">Reset
                </button>

                <button type="submit" id="filterBtn" class="btn btn-sm btn-primary"
                        data-kt-menu-dismiss="true">Apply
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
            $("#last_orders_now").flatpickr({
                altInput: true,
                altFormat: "Y-m-d",
                dateFormat: "Y-m-d",
                mode: "range",
                static: true
            });

            $("#last_orders_bot").flatpickr({
                altInput: true,
                altFormat: "Y-m-d",
                dateFormat: "Y-m-d",
                mode: "range",
                static: true
            });
            $("#last_orders_box").flatpickr({
                altInput: true,
                altFormat: "Y-m-d",
                dateFormat: "Y-m-d",
                mode: "range",
                static: true
            });
        });
    </script>
@endpush
