  <!--begin::Modal content-->
  <div class="modal-content">
      <!--begin::Modal header-->
      <div class="modal-header" id="kt_modal_add_attachment_header">
          <!--begin::Modal title-->
          <h2 class="fw-bold">{{__('Add Attachment')}}</h2>
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
      <div class="modal-body scroll-y mx-5 my-7">
          <!--begin::Form-->

          <!--begin::Scroll-->
          <form id="kt_modal_add_attachment_form" class="form"
              data-editMode="{{ isset($attachment) ? 'enabled' : 'disabled' }}"
              action="{{ isset($attachment) ? route('clients.attachments.update', ['client' => $client->id, 'attachment' => $attachment->id]) : route('clients.attachments.store', ['client' => $client->id]) }}">
              <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_attachment_scroll"
                  data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                  data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_attachment_header"
                  data-kt-scroll-wrappers="#kt_modal_add_attachment_scroll" data-kt-scroll-offset="300px">
                  <!--begin::Input group-->
                  <div class="row">
                      <div class="col-md-6">
                          <!--begin::Input group-->
                          <div class="fv-row mb-7">
                              <!--begin::Label-->
                              <label class="required fw-semibold fs-6 mb-2">{{__('Attachment Type')}}</label>
                              <!--end::Label-->
                              <!--begin::Input-->
                              <select class="form-select form-select-solid" id="attachment_type_id"
                                  name="attachment_type_id" data-placeholder="Select an option">
                                  <option></option>
                                  @foreach ($attachmentConstants as $attachmentConstant)
                                      <option value="{{ $attachmentConstant->id }}"
                                          @isset($attachment)
                                            @selected($attachment->attachment_type_id == $attachmentConstant->id)
                                        @endisset>
                                          {{ $attachmentConstant->name }}</option>
                                  @endforeach
                              </select>
                              <!--end::Input-->
                          </div>
                      </div>
                  </div>
                  @isset($attachment)
                      <div class="fv-row">
                          <!--begin::Label-->
                          <label class="fw-semibold fs-6 mb-2">{{__('Current attachment')}}: </label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <div class="mb-3">
                              <a target="_blank" href="{{ asset('attachments/' . $attachment->file_hash) }}"
                                  class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                  <span class="svg-icon svg-icon-3">
                                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                          xmlns="http://www.w3.org/2000/svg">
                                          <path
                                              d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z"
                                              fill="currentColor" />
                                          <path opacity="0.3"
                                              d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z"
                                              fill="currentColor" />
                                      </svg>
                                  </span>
                              </a>
                              <a target="_blank" href="{{ asset('attachments/' . $attachment->file_hash) }}">
                                  {{ $attachment->file_name }}
                              </a>
                          </div>
                          <!--end::Input-->
                      </div>
                  @endisset

                  <div class="fv-row">
                      <!--begin::Label-->
                      <label class="required fw-semibold fs-6 mb-2" for="formFile">{{__('Attachment')}}</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <div class="mb-3">
                          <input class="form-control" type="file" id="formFile" name="attachment_file">
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
                  <button type="reset" class="btn btn-light me-3" data-kt-attachments-modal-action="cancel"
                      data-bs-dismiss="modal">Discard</button>
                  <button type="submit" class="btn btn-primary" data-kt-attachments-modal-action="submit">
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
