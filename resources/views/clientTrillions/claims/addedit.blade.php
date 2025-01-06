<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_claim_header">
        <!--begin::Modal title-->
        <h2 class="fw-bold">{{ __('Add Claim') }}</h2>
        <!--end::Modal title-->
        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                      <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="currentColor"/>
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
        <form id="kt_modal_add_claim_form" class="form"
              data-editMode="{{ isset($claim) ? 'enabled' : 'disabled' }}"
              action="{{ isset($claim) ? route('clientTrillions.claims.update', ['claim' => $claim->id]) : route('clientTrillions.claims.store') }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_claim_scroll" data-kt-scroll="true"
                 data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                 data-kt-scroll-dependencies="#kt_modal_add_claim_header"
                 data-kt-scroll-wrappers="#kt_modal_add_claim_scroll" data-kt-scroll-offset="300px">
                <input type="hidden" name="client_trillion_id" value="{{$clientTrillion->id}}">
                @if(isset($claim))
                    <input type="hidden" name="claim_id" value="{{$claim->id}}">
                @endif
                <!--begin::Input group-->
                <div class="row">
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Claim Title') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="title" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($claim) ? $claim->title : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Claim No') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="claim_no" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($claim) ? $claim->claim_no : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2"
                                   data-input-name="Type">{{ __('Service Type') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="type"
                                    data-placeholder="Select an option">
                                <option></option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}"
                                    @isset($claim)
                                        @selected($claim->type == $type->id)
                                        @endisset>
                                        {{ $type->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2"
                                   data-input-name="Type">{{ __('Project') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="project_id"
                                    data-placeholder="Select an option">
                                <option></option>
                                @foreach ($projects as $p)
                                    <option value="{{ $p->id }}"
                                    @isset($claim)
                                        @selected($claim->project_id == $p->id)
                                        @endisset>
                                        {{ $p->address }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Cost') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="cost" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($claim) ? $claim->cost : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Notes">{{ __('Notes') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea type="text" name="notes" class="form-control form-control-solid mb-3 mb-lg-0"
                                      placeholder="">{{ isset($claim) ? $claim->notes : '' }}</textarea>
                            <!--end::Input-->
                        </div>
                    </div>



                </div>

                <!--end::Input group-->
            </div>
            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-claims-modal-action="cancel"
                        data-bs-dismiss="modal">{{ __('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-claims-modal-action="submit">
                    <span class="indicator-label">{{ __('Submit') }}</span>
                    <span class="indicator-progress">Please wait...
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
