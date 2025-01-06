<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_sms_header">
        <!--begin::Modal title-->
        <h2 class="fw-bold">{{__('Send SMS')}}</h2>
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
        @if(isset($callTask))
            <form id="kt_modal_add_sms_form" class="form" data-editMode="{{ isset($sms) ? 'enabled' : 'disabled' }}"
                  action="{{ route('sms.captin.store', ['captin' => $callTask->id]) }}">
                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_sms_scroll" data-kt-scroll="true"
                     data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                     data-kt-scroll-dependencies="#kt_modal_add_sms_header"
                     data-kt-scroll-wrappers="#kt_modal_add_sms_scroll" data-kt-scroll-offset="300px">
                    <!--begin::Input group-->

                    <div class="fv-row mb-4">
                        <!--begin::Label-->
                        <label class="fw-semibold fs-6 mb-2">{{__('Captin')}}:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" disabled class="form-control mb-3 mb-lg-0" value="{{ $callTask->name }}"/>
                        <!--end::Input-->
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{__('Channel')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                        name="channel" id="channel" data-placeholder="Select an option">
                                    <option></option>

                                    <option value="SMS"
                                    @if (isset($sms))
                                        @selected($sms->channel =='SMS')
                                        @endif>
                                        SMS
                                    </option>
                                    <option value="WhatsApp"
                                    @if (isset($sms))
                                        @selected($sms->channel =='WhatsApp')
                                        @endif>
                                        WhatsApp
                                    </option>

                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{__('Message Type')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                        name="type_id" id="type_id" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($SHORT_MESSAGE_TYPES as $SHORT_MESSAGE_TYPES_ITEM)
                                        <option value="{{ $SHORT_MESSAGE_TYPES_ITEM->id }}"
                                        @if (isset($sms))
                                            @selected($sms->type_id ==$SHORT_MESSAGE_TYPES_ITEM->id)
                                            @endif>
                                            {{ $SHORT_MESSAGE_TYPES_ITEM->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fv-row mb-4">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">{{__('To')}} :</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="to" class="form-control form-control-solid mb-3 mb-lg-0"
                                       placeholder="Mobile Number"
                                       value="{{ isset($sms) ? $sms->to : $callTask->mobile1 }}"/>
                                <!--end::Input-->
                            </div>
                        </div>
                    </div>

                    <div class="fv-row">
                        <!--begin::Label-->
                        <label class="fw-semibold fs-6 mb-2">{{__('Text')}}</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="mb-3">
                            <textarea name="text" id="text" rows="4"
                                      class="form-control form-control-solid mb-3 mb-lg-0">{{ isset($sms) ? $sms->text : '' }}</textarea>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--end::Input group-->
                    <!--begin::Input group-->
                </div>
                <!--end::Scroll-->
                <!--begin::Actions-->
                <div class="text-center pt-15">
                    <button type="reset" class="btn btn-light me-3" data-kt-sms-modal-action="cancel"
                            data-bs-dismiss="modal">Discard
                    </button>
                    <button type="submit" class="btn btn-primary" data-kt-sms-modal-action="submit">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                          <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
        @endif
        <!--end::Form-->
    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->
@if(isset($callTask))
    <script>
        $(function () {

            var templates = @json($SHORT_MESSAGE_TEMPLATE);
            var local_captin_name_ar = '{{ $callTask->name }}';
            $('#type_id').on('select2:select', function (e) {
                var selectedData = e.params.data;
                var template = templates.find(el => el.value == selectedData.text.trim());
                let result = template.name.replace("<captin>", local_captin_name_ar);
                $('#text').text(result);
            });

        })
    </script>
@endif
