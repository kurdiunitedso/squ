<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_showCalls_header">
        <!--begin::Modal preparation_time-->
        <h2 class="fw-bold">{{ __('View Items') }}</h2>
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
        @include('restaurants.visitsP')


        <div class="text-center pt-15">
            <button type="reset" class="btn btn-light me-3" data-kt-branchs-modal-action="cancel"
                    data-bs-dismiss="modal">{{ __('Discard') }}
            </button>

        </div>
        <!--end::Actions-->


        <!--end::Form-->
    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->




