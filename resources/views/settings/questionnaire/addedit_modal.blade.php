  <!--begin::Modal content-->
  <div class="modal-content">
      <!--begin::Modal header-->
      <div class="modal-header" id="kt_modal_add_questionnaire_header">
          <!--begin::Modal title-->
          <h2 class="fw-bold">Add Call Questionnaire</h2>
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
          <form id="kt_modal_add_questionnaire_form" class="form"
              data-editMode="{{ isset($questionnaire) ? 'enabled' : 'disabled' }}"
              action="{{ isset($questionnaire) ? route('settings.questionnaires.update', ['questionnaire' => $questionnaire->id]) : route('settings.questionnaires.store') }}">
              <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_questionnaire_scroll"
                  data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                  data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_questionnaire_header"
                  data-kt-scroll-wrappers="#kt_modal_add_questionnaire_scroll" data-kt-scroll-offset="300px">
                  <!--begin::Input group-->
                  <div class="row">
                      <div class="col-md-12">
                          <div class="fv-row mb-4">
                              <!--begin::Label-->
                              <label class="required fw-semibold fs-6 mb-2">Title</label>
                              <!--end::Label-->
                              <!--begin::Input-->
                              <input type="text" name="questionnaire_title"
                                  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Questionnaire Title"
                                  value="{{ isset($questionnaire) ? $questionnaire->title : '' }}" />
                              <!--end::Input-->
                          </div>

                      </div>
                      <div class="col-md-12">
                          <div class="fv-row mb-7">
                              <!--begin::Label-->
                              <label class="required fw-semibold fs-6 mb-2">Questionnaire type</label>
                              <!--end::Label-->
                              <!--begin::Input-->

                              <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                  name="questionnaire_type" data-placeholder="Select an option">
                                  <option></option>
                                  @foreach ($QUESTIONNAIRE_TYPE as $QUESTIONNAIRE_TYPE_ITEM)
                                      <option value="{{ $QUESTIONNAIRE_TYPE_ITEM->id }}"
                                          @if (isset($questionnaire)) @selected($questionnaire->type_id == $QUESTIONNAIRE_TYPE_ITEM->id) @endif>
                                          {{ $QUESTIONNAIRE_TYPE_ITEM->name }}</option>
                                  @endforeach
                              </select>
                              <!--end::Input-->
                          </div>
                      </div>
                  </div>
                  <div class="fv-row">
                      <!--begin::Label-->
                      <label class="fw-semibold fs-6 mb-2">Descrpition</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <div class="mb-3">
                          <textarea name="questionnaire_description" rows="4" class="form-control form-control-solid mb-3 mb-lg-0">{{ isset($questionnaire) ? $questionnaire->description : '' }}</textarea>
                      </div>
                      <!--end::Input-->
                  </div>
                  <!--end::Input group-->
                  <!--begin::Input group-->

                  <div class="separator separator-dashed my-4"></div>

                  <h3 class="mb-4">Questions :</h3>
                  <div id="kt_questionnaire_repeater">
                      <!--begin::Form group-->
                      <div class="form-group">
                          <div data-repeater-list="kt_questionnaire_repeater">
                              @if (isset($questionnaire))
                                  @foreach ($questionnaire->questions as $question)
                                      <div data-repeater-item data-question-id="{{ $question->id }}">
                                          <div class="form-group row mb-5">
                                              <input type="hidden" name="question_id" value="{{ $question->id }}">
                                              <div class="col-md-10">
                                                  <div class="fv-row">
                                                      <!--begin::Label-->
                                                      <label class="required fw-semibold fs-6 mb-2">Question
                                                          Text:</label>
                                                      <!--end::Label-->
                                                      <!--begin::Input-->
                                                      <input type="text"
                                                          class="form-control form-control-solid mb-3 mb-lg-0 questionnaireNames"
                                                          name="questionnaire_question_text"
                                                          value="{{ $question->text }}" />
                                                      <!--end::Input-->
                                                  </div>
                                              </div>

                                              <div class="col-md-2">
                                                  <a href="javascript:;" data-repeater-delete
                                                      class="btn btn-flex btn-sm btn-light-danger mt-3 mt-md-9">
                                                      <i class="ki-duotone ki-trash fs-3"><span
                                                              class="path1"></span><span class="path2"></span><span
                                                              class="path3"></span><span class="path4"></span><span
                                                              class="path5"></span></i>
                                                      Delete
                                                  </a>
                                              </div>
                                          </div>
                                      </div>
                                  @endforeach
                              @else
                                  <div data-repeater-item>
                                      <div class="form-group row mb-5">
                                          <div class="col-md-10">
                                              <div class="fv-row">
                                                  <!--begin::Label-->
                                                  <label class="required fw-semibold fs-6 mb-2">Question
                                                      Text:</label>
                                                  <!--end::Label-->
                                                  <!--begin::Input-->
                                                  <input type="text"
                                                      class="form-control form-control-solid mb-3 mb-lg-0 questionnaireNames"
                                                      name="questionnaire_question_text" value="" />
                                                  <!--end::Input-->
                                              </div>
                                          </div>

                                          <div class="col-md-2">
                                              <a href="javascript:;" data-repeater-delete
                                                  class="btn btn-flex btn-sm btn-light-danger mt-3 mt-md-9">
                                                  <i class="ki-duotone ki-trash fs-3"><span
                                                          class="path1"></span><span class="path2"></span><span
                                                          class="path3"></span><span class="path4"></span><span
                                                          class="path5"></span></i>
                                                  Delete
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                              @endif

                          </div>
                      </div>
                      <!--end::Form group-->

                      <!--begin::Form group-->
                      <div class="form-group">
                          <a href="javascript:;" data-repeater-create class="btn btn-flex btn-light-primary">
                              <i class="ki-duotone ki-plus fs-3"></i>
                              Add
                          </a>
                      </div>
                      <!--end::Form group-->
                  </div>

                  <!--end::Repeater-->
                  <div id="deleted_questions">
                  </div>


              </div>
              <!--end::Scroll-->
              <!--begin::Actions-->
              <div class="text-center pt-15">
                  <button type="reset" class="btn btn-light me-3" data-kt-questionnaire-modal-action="cancel"
                      data-bs-dismiss="modal">Discard</button>
                  <button type="submit" class="btn btn-primary" data-kt-questionnaire-modal-action="submit">
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
