@php
    use App\Models\Program;
    use App\Models\ProgramPage;
    use App\Models\ProgramPageQuestion;
@endphp
{{-- functions --}}
<script>
    function filterByPage(pageId = null) {
        // Update active state
        $('.page-filter').removeClass('btn-primary').addClass('btn-light-primary');
        $(`[data-page-id="${(pageId == null?'all':pageId)}"]`).removeClass('btn-light-primary').addClass('btn-primary');
        let route =
            "{{ route(Program::ui['route'] . '.' . ProgramPageQuestion::ui['route'] . '.index', ['program' => $_model->id]) }}"

        if (pageId && pageId != '') {
            route += ('?page_id=' + pageId);
        }
        // Reload datatable with filter
        datatableProgramPageQuestion.ajax.url(route).load();
    }

    // Refresh filter function
    function refreshPageFilters() {
        $.get("{{ route(Program::ui['route'] . '.pages', ['program' => $_model->id]) }}",
            function(pages) {
                let html = `
                  <a class="btn btn-light-primary btn-sm page-filter" data-page-id="all"
                                onclick="filterByPage()">
                                {{ t('All Pages') }}
                            </a>`
                html += pages.map(page => `
            <a class="btn btn-light-primary btn-sm page-filter me-2"
                data-page-id="${page.id}"
                onclick="filterByPage(${page.id})">
                ${page.title[currentLocale]}
            </a>
        `).join('');

                $('#pageFilters').html(html);
            });
    }
</script>
{{-- btn_show_ questions --}}
<script>
    $(document).on('click', ".btn_show_{{ ProgramPageQuestion::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const button = $(this);
        const URL = $(this).attr('href');
        const pageId = $(this).attr('data-id');
        console.log('pageId', pageId);

        // Show tab
        $('a[data-bs-target="#kt_tab_pane_{{ ProgramPageQuestion::ui['s_lcf'] }}"]').tab('show');
        filterByPage(pageId)
    });
</script>

{{-- add BTN --}}
<script>
    $(document).on('click', "#add_{{ ProgramPage::ui['s_lcf'] }}_modal", function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');
        ModalRenderer.render({
            url: url,
            button: button,
            modalId: '#kt_modal_general',
            modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
            formId: '#{{ ProgramPage::ui['s_lcf'] }}_modal_form',
            dataTableId: datatableProgramPage,
            submitButtonName: "[data-kt-modal-action='submit_{{ ProgramPage::ui['s_lcf'] }}']",
            onFormSuccessCallBack: (response) => {
                refreshPageFilters();
                console.log('Extra actions completed');
            }
            // callBackFunction: function() {

            // }
        });
    });
</script>
{{-- Update BTN --}}
<script>
    $(document).on('click', ".btn_update_{{ ProgramPage::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');
        ModalRenderer.render({
            url: url,
            button: button,
            modalId: '#kt_modal_general',
            modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
            formId: '#{{ ProgramPage::ui['s_lcf'] }}_modal_form',
            dataTableId: datatableProgramPage,
            submitButtonName: "[data-kt-modal-action='submit_{{ ProgramPage::ui['s_lcf'] }}']",
            onFormSuccessCallBack: (response) => {
                refreshPageFilters();
                console.log('Extra actions completed');
            }
            // callBackFunction: function() {

            // }
        });
    });
</script>

{{-- Delete BTN --}}
<script>
    $(document).on('click', '.btn_delete_' + "{{ ProgramPage::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const itemModelName = $(this).attr('data-' + "{{ ProgramPage::ui['s_lcf'] }}" + '-name');
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
                        datatableProgramPage.ajax.reload(null, false);
                        datatableProgramPageQuestion.ajax.reload(null, false);

                        Swal.fire({
                            text: response.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },




                    complete: function() {

                        // datatableProgramPageQuestion.ajax.reload(null, false);
                        refreshPageFilters();

                    },
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
