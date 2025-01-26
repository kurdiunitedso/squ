@php
    use App\Models\ProgramPageQuestion;
    use App\Models\Program;
@endphp



{{-- add BTN --}}
<script>
    $(document).on('click', "#add_{{ ProgramPageQuestion::ui['s_lcf'] }}_modal", function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');
        ModalRenderer.render({
            url: url,
            button: button,
            modalId: '#kt_modal_general',
            modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
            formId: '#{{ ProgramPageQuestion::ui['s_lcf'] }}_modal_form',
            dataTableId: datatableProgramPageQuestion,
            submitButtonName: "[data-kt-modal-action='submit_{{ ProgramPageQuestion::ui['s_lcf'] }}']",
            // onFormSuccessCallBack: onFormSuccessCallBack,
            callBackFunction: function() {
                // ProgramQuestionHandlers.init();
            }
        });
    });
</script>
{{-- Update BTN --}}
<script>
    $(document).on('click', ".btn_update_{{ ProgramPageQuestion::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');
        ModalRenderer.render({
            url: url,
            button: button,
            modalId: '#kt_modal_general',
            modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
            formId: '#{{ ProgramPageQuestion::ui['s_lcf'] }}_modal_form',
            dataTableId: datatableProgramPageQuestion,
            submitButtonName: "[data-kt-modal-action='submit_{{ ProgramPageQuestion::ui['s_lcf'] }}']",
            // onFormSuccessCallBack: onFormSuccessCallBack,
            // callBackFunction: function() {
            //     totalCostCallBack(); // Your existing callback
            //     handleAddOnSelectChange(); // New callback for add-on select
            // }
        });
    });
</script>

{{-- Delete BTN --}}
<script>
    $(document).on('click', '.btn_delete_' + "{{ ProgramPageQuestion::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const itemModelName = $(this).attr('data-' + "{{ ProgramPageQuestion::ui['s_lcf'] }}" + '-name');
        Swal.fire({
            html: "Are you sure you want to delete " + itemModelName + "?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: URL,
                    dataType: "json",
                    success: function(response) {
                        datatableProgramPageQuestion.ajax.reload(null, false);
                        Swal.fire({
                            text: response.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },




                    complete: function() {},
                    error: function(response, textStatus,
                        errorThrown) {
                        toastr.error(response
                            .responseJSON
                            .message);
                    },
                });

            } else if (result.dismiss === 'cancel') {}

        });
    });
</script>
