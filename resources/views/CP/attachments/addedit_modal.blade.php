@php
    use App\Models\Attachment;
@endphp

<div class="modal-content">
    {{-- Modal Header --}}
    <div class="modal-header">
        <h2 class="fw-bold">{{ t('Add ' . $_model::ui['p_ucf']) }}</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <span class="svg-icon svg-icon-1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                </svg>
            </span>
        </div>
    </div>

    {{-- Modal Body --}}
    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <form id="{{ $_model::ui['s_lcf'] }}_modal_form" class="form"
            data-editMode="{{ isset($_model) ? 'enabled' : 'disabled' }}"
            action="{{ route($_model::ui['route'] . '.addedit') }}">
            @csrf
            <input type="hidden" name="model" value="{{ $model }}">
            <input type="hidden" name="model_id" value="{{ $model_id }}">
            @if (isset($_model))
                <input type="hidden" name="{{ $_model::ui['_id'] }}" value="{{ $_model->id }}">
            @endif

            {{-- Form Content --}}
            <div class="row">
                <div class="col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">{{ t('Attachment Type') }}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-solid  validate-required" id="attachment_type_id"
                            name="attachment_type_id" data-placeholder="Select an option">
                            <option></option>
                            @foreach ($attachment_type_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    @isset($_model)
                                      @selected($_model->attachment_type_id == $item->id)
                                  @endisset>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                        <!--end::Input-->
                    </div>
                </div>
            </div>

            <div class="fv-row">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2" for="formFile">{{ __('Attachment') }}</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mb-3">
                    <input class="form-control" type="file" id="formFile" name="attachment_file">
                </div>
                <!--end::Input-->
            </div>

            {{-- Form Actions --}}
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3"
                    data-kt-modal-action="cancel{{ $_model::ui['s_ucf'] }}" data-bs-dismiss="modal">
                    {{ __('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary"
                    data-kt-modal-action="submit{{ Attachment::ui['s_lcf'] }}">
                    <span class="indicator-label">{{ __('Submit') }}</span>
                    <span class="indicator-progress">
                        {{ __('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
