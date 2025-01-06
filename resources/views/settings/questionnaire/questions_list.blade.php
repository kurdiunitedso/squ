@foreach ($questionnaire->questions as $question)
    <div class="fv-row">
        <!--begin::Label-->
        <label class="required fw-semibold fs-6 mb-2">{{ $question->text }} :</label>
        <!--end::Label-->
        <!--begin::Input-->
        <div class="mb-3">
            <textarea name="call_questionnaire[{{ $questionnaire->id }}][questionId][{{ $question->id }}]" rows="4"
                class="form-control form-control-solid mb-3 mb-lg-0 questions_list"></textarea>
        </div>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
@endforeach
