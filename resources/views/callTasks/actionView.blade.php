<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_showCalls_header">
        <!--begin::Modal preparation_time-->
        <h2 class="fw-bold">{{ __('Call Task') }}</h2>
        <!--end::Modal preparation_time-->
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
    <div class="modal-body scroll-y ">
        <form id="kt_modal_ActionCall_form" class="form"
              data-editMode="{{ isset($call) ? 'enabled' : 'disabled' }}"
              action="{{ isset($call) ? route('call_tasks.storeAction', ['call' => $call->id]) : "#" }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_AssignCall_scroll" data-kt-scroll="true"
                 data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                 data-kt-scroll-dependencies="#kt_modal_AssignCall_header"
                 data-kt-scroll-wrappers="#kt_modal_AssignCall_scroll" data-kt-scroll-offset="300px">

                @if(isset($call))
                    <input type="hidden" name="id" value="{{$call->id}}">
                @endif
                <!--begin::Input group-->
                <div class="row">

                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="task_statuss">
                                Assign Status
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="task_status" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($task_statuss as $c)
                                    <option value="{{ $c->id }}"
                                    @isset($call)
                                        @selected($call->task_status == $c->id)
                                        @endisset>
                                        {{ $c->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Notes</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea class="form-control form-control-solid mb-3 mb-lg-0"
                                      name="task_notes">{{ isset($call) ? $call->task_notes : '' }}</textarea>
                            <!--end::Input-->
                        </div>

                    </div>
                </div>

                <!--end::Input group-->
            </div>
            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-ActionCall-modal-action="cancel"
                        data-bs-dismiss="modal">{{ __('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-ActionCall-modal-action="submit">
                    <span class="indicator-label">{{ __('Submit') }}</span>
                    <span class="indicator-progress">Please wait...
                          <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Actions-->
        </form>
    </div>
    <!--end::Modal body-->
</div>



