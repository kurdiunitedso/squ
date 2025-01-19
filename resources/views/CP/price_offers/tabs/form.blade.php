<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ t($_model::ui['s_ucf'] . ' Details') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Card body-->

    <div class="card mb-5 mb-xl-10">
        <div class="card-body p-9">
            <div class="row">
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Price') }}</label>
                        <input type="number" name="price"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-min-0 @error('price') is-invalid @enderror"
                            placeholder="{{ t('Enter Price') }}" value="{{ old('price', $_model->price ?? '') }}" />
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Down Payment') }}</label>
                        <input type="number" name="down_payment"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-min-0 @error('down_payment') is-invalid @enderror"
                            placeholder="{{ t('Enter Down Payment') }}"
                            value="{{ old('down_payment', $_model->down_payment ?? '') }}" />
                        @error('down_payment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <!-- Notes Field -->
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Notes') }}</label>
                        <textarea name="notes" class="form-control form-control-solid mb-3 mb-lg-0 @error('notes') is-invalid @enderror"
                            rows="4" placeholder="{{ t('Enter notes') }}">{{ old('notes', $_model->notes ?? '') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--end::Card body-->
</div>
