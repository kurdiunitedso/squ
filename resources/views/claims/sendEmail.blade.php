
@php
    $qty=0;
    $cost=0;
    $types='';
                    foreach (explode(',',$claim->types) as $k=>$v)
                        $types.=(\App\Models\Constant::find($v)?\App\Models\Constant::find($v)->name:'').",";

                    $types= rtrim($types,',');
                         $processing = \App\Models\Constant::where('module', \App\Enums\Modules::CLAIM)->Where('field', \App\Enums\DropDownFields::status)->where('name', 'processing')->get()->first();
        $processing = isset($processing) ? $processing->id : 0;

@endphp<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_email_header">
        <!--begin::Modal preparation_time-->
        <h2 class="fw-bold">{{ __('Add email') }}</h2>
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
    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <!--begin::Form-->

        <!--begin::Scroll-->
        <form id="kt_modal_add_email_form" class="form"

              action="{{route('claims.sendEmailTo')}}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_email_scroll" data-kt-scroll="true"
                 data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                 data-kt-scroll-dependencies="#kt_modal_add_email_header"
                 data-kt-scroll-wrappers="#kt_modal_add_email_scroll" data-kt-scroll-offset="300px">

                <input type="hidden" name="claim_id" value="{{$claim->id}}">
                <div class="mb-5 row">

                    <div class="col-lg-1">

                        <label class="  fw-semibold fs-6 mb-2"
                               data-input-name="{{__('To')}}">{{ __('To') }}
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <div class="fv-row mb-7">
                            <input type="text" name="to" class="form-control form-control-solid mb-3 mb-lg-0"

                                   placeholder="" value="{{ isset($claim) ? ($claim->client?$claim->client->email:'') : '' }}"/>
                        </div>
                    </div>
                </div>
                <div class="mb-5 row">

                    <div class="col-lg-1">

                        <label class="  fw-semibold fs-6 mb-2"
                               data-input-name="CC">{{ __('CC') }}
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <div class="fv-row mb-7">
                            <input type="text" name="cc" class="form-control form-control-solid mb-3 mb-lg-0"

                                   placeholder="" value="ceo@trillionz.ps;d.kilani@trillionz.ps;saleemmalki@trillionz.ps"/>
                        </div>
                    </div>
                </div>
                <div class="mb-5 row">

                    <div class="col-lg-1">

                        <label class="required  fw-semibold fs-6 mb-2"
                               data-input-name="Subject">{{ __('Subject') }}
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <div class="fv-row mb-7">
                            <input type="text" name="subject" class="form-control form-control-solid mb-3 mb-lg-0"

                                   placeholder="" value="{{ $types }}"/>
                        </div>
                    </div>
                </div>
                <div class="mb-5 row">

                    <div class="col-lg-1">

                        <label class="required fw-semibold fs-6 mb-2"
                               data-input-name="Name">{{ __('Text') }}
                        </label>
                    </div>
                    <div class="col-lg-12">
                        <div class="fv-row mb-7">
                            <textarea type="text" name="text" class="form-control form-control-solid mb-3 mb-lg-0">

                            </textarea>


                        </div>
                    </div>
                </div>


                <!--end::Input group-->
            </div>
            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-emails-modal-action="cancel"
                        data-bs-dismiss="modal">{{ __('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-emails-modal-action="submit">
                    <span class="indicator-label">{{ __('Submit') }}</span>
                    <span class="indicator-progress">{{ __('Please wait...') }}
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

