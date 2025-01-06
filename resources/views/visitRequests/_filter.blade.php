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
                        <label class="form-label fw-semibold">{{__('Telephone')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div>
                            <input class="form-input form-control datatable-input"
                                   type="text" data-placeholder="Select option" data-col-index="telephone"
                                   data-dropdown-parent="#kt_menu_64ca1a18f399e" data-allow-clear="true" value="">

                        </div>
                        <!--end::Input-->
                    </div>
                </div>

                <!--end::Input group-->


                <!--end::Input group-->


                <!--end::Input group-->


                <div class="col-md-3">
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('Status')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div>
                            <select class="form-select form-select-solid datatable-input filter-selectpicker"
                                    data-kt-select2="true" multiple data-col-index="status"
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
                        <label class="form-label fw-semibold">{{__('Category')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div>
                            <select class="form-select form-select-solid datatable-input filter-selectpicker"
                                    data-kt-select2="true" multiple data-col-index="category"
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





                <div class="col-md-3">
                    <div class="mb-10 ">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('Create Date')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="">
                            <input class="form-control form-control-solid datatable-input " data-col-index="created_at"
                                   data-bs-focus="false" placeholder="Pick date" id="kt_datepicker_8"/>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-md-3">
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('Employee')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div>
                            <select class="form-select form-select-solid datatable-input filter-selectpicker"
                                    data-kt-select2="true" multiple data-col-index="employee_id" data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_64ca1a18f399e" data-allow-clear="true">
                                <option></option>
                                @foreach ($EMPLOYEES as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input-->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">{{__('Employee Project')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div>
                            <select class="form-select form-select-solid datatable-input filter-selectpicker"
                                    data-kt-select2="true" data-col-index="project_id" multiple data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_64ca1a18f399e" data-allow-clear="true">
                                <option></option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input-->
                    </div>
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
            $("#kt_datepicker_7").flatpickr({
                altInput: true,
                altFormat: "Y-m-d",
                dateFormat: "Y-m-d",
                mode: "range",
                static: true
            });

            $("#kt_datepicker_8").flatpickr({
                altInput: true,
                altFormat: "Y-m-d",
                dateFormat: "Y-m-d",
                mode: "range",
                static: true
            });
        });
    </script>
@endpush
