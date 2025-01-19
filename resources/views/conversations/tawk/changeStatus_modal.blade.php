<!--begin::Modal content-->
<div class="modal-content" xmlns="http://www.w3.org/1999/html">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_changeStatus_header">
        <!--begin::Modal title-->
        <h2 class="fw-bold">Change tawk status</h2>
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
    <div class="modal-body scroll-y mx-5 my-7">
        <!--begin::Form-->
        <!--begin::Scroll-->
        <form id="kt_modal_changeStatus_form" class="form"
              action="{{ route('conversations.tawk.changeStatus', ['tawk' => $tawk->id]) }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_changeStatus_scroll"
                 data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                 data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_changeStatus_header"
                 data-kt-scroll-wrappers="#kt_modal_add_changeStatus_scroll" data-kt-scroll-offset="300px">
                <!--begin::Input group-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2"> Message</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <span type="text"  class="form-control mb-3 mb-lg-0">
                                   {{ isset($tawk) ? $tawk->message_msg : '' }}"</span>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Visit Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="visit_name" class="form-control mb-3 mb-lg-0"
                                   value="{{ isset($tawk) ? $tawk->visit_name : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Visit Telephone</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="telephone" class="form-control mb-3 mb-lg-0"
                                   value="{{ isset($tawk) ? $tawk->telephone : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Visit Email</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="visit_email" class="form-control mb-3 mb-lg-0"
                                   value="{{ isset($tawk) ? $tawk->visit_email : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>


                    <div class="col-md-12">
                        <!--begin::Label-->
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2"
                                   data-input-name="Tawk Status">Tawk Status</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    id="tawk_status" name="status_id" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($tawkStatuses as $status)
                                    <option value="{{ $status->id }}"
                                    @isset($tawk)
                                        @selected($tawk->status_id == $status->id)
                                        @endisset>
                                        {{ $status->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                            <!--end::Input-->
                        </div>
                    </div>


                </div>

                <!--end::Input group-->
                <!--end::Input group-->
                <!--begin::Input group-->
            </div>
            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-changeStatus-modal-action="cancel"
                        data-bs-dismiss="modal">Discard
                </button>
                <button type="submit" class="btn btn-primary" data-kt-changeStatus-modal-action="submit">
                    <span class="indicator-label">Submit</span>
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
