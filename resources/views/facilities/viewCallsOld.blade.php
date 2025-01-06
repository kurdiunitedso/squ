<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_showCalls_header">
        <!--begin::Modal preparation_time-->
        <h2 class="fw-bold">{{ __('View Calls') }}</h2>
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
        <div class="row">
            <div class="col-md-8">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fw-semibold fs-6 mb-2" data-input-name="City">
                        {{ __('Select Brnach Please') }}</label>
                    <!--end::Label-->
                    <!--begin::Input-->

                    <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                            name="brnach" id="brnach"
                            data-placeholder="Select an option">
                        <option></option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}"
                                    link="{{route('facilities.branch_view_calls', ['branch' => $branch->id])}}">
                                {{ $branch->address }}

                            </option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>
            </div>
            <div class="col-md-12">
                <div class="Calls"></div>
            </div>
        </div>


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


<script>
    jQuery(document).ready(function () {


        jQuery(document).on('change', '#brnach', function () {
            id = $(this).val();
            console.log(id);
            jQuery('.Calls').html('<div class="spinner spinner-primary spinner-lg spinner-center"></div><br><br>');
            jQuery('.Calls').load($(this).find(':selected').attr('link'));
        });

    });
</script>

