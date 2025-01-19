<script>
    $(document).on('click', '.btn_delete_' + "{{ $_model::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const itemModelName = $(this).attr('data-' + "{{ $_model::ui['s_ucf'] }}" + '-name');
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
                        datatable.ajax.reload(null, false);
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

<script>
    $(document).on('click', '.btn_request_priceOffer_' + "{{ $_model::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const itemModelName = $(this).attr('data-' + "{{ $_model::ui['s_ucf'] }}" + '-name');
        const button = $(this);

        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to generate a price offer for " + itemModelName + "?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, generate it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable button and show loading
                button.attr('data-kt-indicator', 'on');
                button.prop('disabled', true);

                $.ajax({
                    url: URL,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        toastr.success('Price offer has been generated successfully');

                        if (typeof datatable !== 'undefined') {
                            datatable.ajax.reload();
                        } else {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        handleAjaxErrors(xhr, status, error, {
                            submitButton: button
                        });
                    }
                });
            }
        });
    });
</script>


<script>
    // Status change click handler
    $(document).on('click', '.btnChangeStatus' + "{{ $_model::ui['s_ucf'] }}", function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');

        ModalRenderer.render({
            url: url,
            button: button,
            modalId: '#kt_modal_general_sm',
            modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general_sm')),
            formId: '#kt_modal_change_status_form',
            dataTableId: datatable,
            submitButtonName: '[data-kt-change-status-modal-action="submit"]',
        });


    });
</script>
