<div class="card mb-5 mb-xl-10" id="kt_department_details_view">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ isset($item_model) ? $item_model->name : __('Creating New Department') }} -
                {{ __('Details') }}</h3>
        </div>
        <!--end::Card title-->
        <div class="card-toolbar">
            <div class="align-items-center d-flex flex-row me-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="active" name="active_c"
                        @isset($item_model)
                        @checked($item_model->active == 1)

                        @endisset>
                    <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6" for="active">
                        {{ __('Active') }}</label>
                </div>
            </div>

        </div>
    </div>
    <!--begin::Card header-->

    <!--begin::Card body-->
    <div class="card-body p-9">
        <div class="row">
            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fw-semibold fs-6 mb-2"
                        data-input-name="{{ __('Name AR') }}">{{ __('Name AR') }}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                        placeholder="" value="{{ isset($item_model) ? $item_model->name : '' }}" />
                    <!--end::Input-->
                </div>
            </div>
            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fw-semibold fs-6 mb-2"
                        data-input-name="{{ __('Name EN') }}">{{ __('Name EN') }}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="name_en" class="form-control form-control-solid mb-3 mb-lg-0"
                        placeholder="" value="{{ isset($item_model) ? $item_model->name_en : '' }}" />
                    <!--end::Input-->
                </div>
            </div>







        </div>


    </div>

</div>

<!--end::Card body-->
