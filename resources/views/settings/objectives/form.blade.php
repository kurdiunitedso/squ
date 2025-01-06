<div class="card mb-5 mb-xl-10">

    <!--begin::Card body-->
    <div class="card-body p-9">
        <div class="row">

            <div class="col-md-4">
                <div class="fv-row mb-7">
                    @foreach ([['name' => 'is_active', 'label' => 'Active']] as $checkbox)
                        @php
                            $checked =
                                old($checkbox['name'], $item_model->{$checkbox['name']} == 1) == true ? 'checked' : '';
                            // dd($checked);
                        @endphp
                        <div class="align-items-center d-flex flex-row me-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="{{ $checkbox['name'] }}"
                                    name="{{ $checkbox['name'] }}" {{ $checked }}>
                                <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                                    for="{{ $checkbox['name'] }}">
                                    {{ t($checkbox['label']) }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


        </div>

        <div class="row">

            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class=" fw-semibold fs-6 mb-2">{{ t('Name') }}
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input name="name" class="form-control form-control-solid mb-3 mb-lg-0 validate-required"
                        placeholder="" value="{{ isset($item_model) ? $item_model->name : '' }}" />
                    <!--end::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-4">
                    <!--begin::Label-->
                    <label class=" fw-semibold fs-6 mb-2">{{ t('Objective  Type') }}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select form-select-solid mb-3 mb-lg-0 validate-required" data-control="select2"
                        name="objective_type_id" data-placeholder="Select an option"
                        data-model-class="{{ $item_model::class }}" data-model-id="{{ $item_model->id }}">

                        >
                        <option></option>
                        @foreach ($objective_types ?? [] as $t)
                            <option value="{{ $t->id }}"
                                @if (isset($item_model)) @selected($item_model->objective_type_id == $t->id) @endif>
                                {{ $t->name }}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>
            </div>

        </div>




    </div>

</div>
