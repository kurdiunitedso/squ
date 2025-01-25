@php
    use App\Models\Program;
    use App\Models\ProgramPage;
@endphp

<input type="hidden" id="update_structure_url"
    value="{{ route(Program::ui['route'] . '.' . ProgramPage::ui['route'] . '.update-structure', ['program' => $program->id, '_model' => $_model->id]) }}">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">{{ t('Form Generator') }}</h5>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <span class="svg-icon svg-icon-2x">{!! getSvgIcon('cross', '') !!}</span>
        </div>
    </div>
    <div class="modal-body">
        <input type="hidden" id="form-structure" value="{{ $_model->structure }}">
        <div id="form-generator-container"></div>
    </div>
</div>
