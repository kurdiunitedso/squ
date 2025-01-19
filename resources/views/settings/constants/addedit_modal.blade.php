@php
    use App\Enums\DropDownFields;
    use App\Enums\Modules;

    $module = $constants->first()->module;
    $field = $constants->first()->field;
@endphp

<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_constant_header">
        <!--begin::Modal title-->
        <h2 class="fw-bold">{{ t('Edit Constant') }}</h2>
        <!--end::Modal title-->
        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Close-->
    </div>
    <!--end::Modal header-->
    <!--begin::Modal body-->
    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <!--begin::Form-->

        <!--begin::Scroll-->
        <form id="kt_modal_constant_form" class="form"
            action="{{ route('settings.constants.update', ['constant' => $constants->first()->field]) }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_constant_scroll" data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                data-kt-scroll-dependencies="#kt_modal_constant_header"
                data-kt-scroll-wrappers="#kt_modal_constant_scroll" data-kt-scroll-offset="300px">

                <input type="hidden" name="ModuleName" value="{{ $module ?? 'NA' }}">
                <input type="hidden" name="FieldName" value="{{ $field ?? 'NA' }}">
                <!--begin::Input group-->
                <!--begin::Input group-->
                <!--end::Input group-->
                <!--begin::Input group-->

                <div class="row">
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">{{ t('Module') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" disabled class="form-control form-control-transparent mb-3 mb-lg-0"
                                value="{{ isset($constants) ? $constants->first()->module : '' }}" />
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">{{ t('Field') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" disabled class="form-control form-control-transparent mb-3 mb-lg-0"
                                value="{{ isset($constants) ? $constants->first()->field : '' }}" />
                            <!--end::Input-->
                        </div>
                    </div>
                </div>
                <!--begin::Repeater-->
                <div id="kt_constant_repeater">
                    <!--begin::Form group-->
                    <div class="form-group">
                        <div data-repeater-list="kt_constant_repeater">
                            @foreach ($constants as $constant)
                                <div data-repeater-item data-constant-id="{{ $constant->id }}">
                                    <div class="form-group row mb-5">
                                        <input type="hidden" name="constant_id" value="{{ $constant->id }}">
                                        <div class="row">
                                            {{-- Translatable Name Fields --}}
                                            @php
                                                $name = isset($constant)
                                                    ? $constant->getTranslations()['name'] ?? []
                                                    : [];
                                            @endphp
                                            @foreach (config('app.locales') as $locale)
                                                <div class="col-md-4">
                                                    <div class="fv-row mb-7">
                                                        <label class="fw-semibold fs-6 mb-2"
                                                            data-input-name="name_{{ $locale }}">
                                                            {{ t('Name') }}
                                                            <small>({{ strtoupper($locale) }})</small>
                                                        </label>
                                                        <input type="text" name="name_{{ $locale }}"
                                                            class="form-control form-control-solid mb-3 mb-lg-0
                                                                                        validate-required
                                                                                        @error("name.$locale") is-invalid @enderror"
                                                            placeholder="{{ t('Enter name in ' . strtoupper($locale)) }}"
                                                            value="{{ old("name.$locale", isset($name[$locale]) ? $name[$locale] : '') }}" />
                                                        @error("name.$locale")
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endforeach


                                            <div class="col-md-4">
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class=" fw-semibold fs-6 mb-2" data-input-name="Parent">
                                                        {{ __('Parent') }}</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->

                                                    <select class="form-select form-select-solid mb-3 mb-lg-0"
                                                        data-control="select2" name="parent_id"
                                                        data-placeholder="Select an option">
                                                        <option></option>
                                                        @foreach (\App\Models\Constant::where('module', $constant->module)->get() as $m)
                                                            <option value="{{ $m->id }}"
                                                                @isset($constant)
                                                              @selected($constant->parent_id == $m->id)
                                                              @endisset>
                                                                {{ $m->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <!--end::Input-->
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="fv-row">
                                                    <!--begin::Label-->
                                                    <label
                                                        class="required fw-semibold fs-6 mb-2">{{ t('Value') }}</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text"
                                                        class="form-control form-control-solid mb-3 mb-lg-0 constantValues"
                                                        name="constant_value" value="{{ $constant->value }}" />
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="fv-row">
                                                    <!--begin::Label-->
                                                    <label
                                                        class="required fw-semibold fs-6 mb-2">{{ t('Color') }}</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text"
                                                        class="form-control form-control-solid mb-6 mb-lg-0 "
                                                        name="color" value="{{ $constant->color }}" />
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="fv-row">
                                                <!--begin::Label-->
                                                <label
                                                    class="required fw-semibold fs-6 mb-2">{{ t('English Description') }}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <textarea class="form-control form-control-solid mb-6 mb-lg-0 " name="description_en" id="description_en"
                                                    {{-- cols="15" rows="5" --}}>{{ $constant->description_en }}</textarea>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="fv-row">
                                                <!--begin::Label-->
                                                <label
                                                    class="required fw-semibold fs-6 mb-2">{{ t('Arabic Description') }}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <textarea class="form-control form-control-solid mb-6 mb-lg-0 " name="description_ar" id="description_ar"
                                                    {{-- cols="15" rows="5" --}}>{{ $constant->description_ar }}</textarea>
                                                <!--end::Input-->
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <a href="javascript:;" data-repeater-delete
                                                class="btn btn-flex btn-sm btn-light-danger mt-3 mt-md-9">
                                                <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                                        class="path2"></span><span class="path3"></span><span
                                                        class="path4"></span><span class="path5"></span></i>
                                                {{ t('Delete') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <!--end::Form group-->

                    <!--begin::Form group-->
                    <div class="form-group">
                        <a href="javascript:;" data-repeater-create class="btn btn-flex btn-light-primary">
                            <i class="ki-duotone ki-plus fs-3"></i>
                            {{ t('Add') }}
                        </a>
                    </div>
                    <!--end::Form group-->
                </div>
                <!--end::Repeater-->
                <div id="deleted_contants">
                </div>

            </div>
            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-constants-modal-action="cancel"
                    data-bs-dismiss="modal">Discard</button>
                <button type="submit" class="btn btn-primary" data-kt-constants-modal-action="submit">
                    <span class="indicator-label">{{ t('Submit') }}</span>
                    <span class="indicator-progress">{{ t('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Actions-->
        </form>

        <!--end::Form-->
    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->
