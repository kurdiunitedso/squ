@php
    use App\Models\Program;
    use App\Models\ProgramPage;
@endphp

<script>
    var selectedItemsModelsRows = [];
    var selectedItemModelsData = [];
    const columnDefsProgramPages = [{
            data: function(row, type) {
                if (type === 'display') {
                    return row.title?.en || 'NA';
                }
                return '';
            },
            name: 'title->en',
        },
        {
            data: function(row, type) {
                if (type === 'display') {
                    return row.title?.ar || 'NA';
                }
                return '';
            },
            name: 'title->ar',
        },
        {
            data: 'order',
            name: 'order'
        },
        {
            data: 'created_at',
            name: 'created_at',
            render: function(data, type, row) {
                return row.created_at?.display || 'NA';
            }
        },
        {
            data: 'action',
            name: 'action',
            className: 'text-end',
            orderable: false,
            searchable: false
        }
    ];
    var datatableProgramPage = createDataTable('#kt_table_{{ ProgramPage::ui['s_lcf'] }}', columnDefsProgramPages,
        "{{ route(Program::ui['route'] . '.' . ProgramPage::ui['route'] . '.index', ['program' => $_model->id]) }}",
        [
            [0, "ASC"]
        ]);
    datatableProgramPage.on('draw', function() {
        KTMenu.createInstances();
    });
    datatableProgramPage.on('responsive-display', function() {
        KTMenu.createInstances();
    });





    // Restore selected rows when page changes
    datatableProgramPage.on('draw.dt', function() {
        datatableProgramPage.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var rowData = this.data();
            if (selectedItemsModelsRows.includes(rowData.id)) {
                this.select();
            }
        });
    });
    const filterSearchProgramPage = document.querySelector(
        '[data-kt-{{ ProgramPage::ui['s_lcf'] }}-table-filter="search"]');
    filterSearchProgramPage.onkeydown = debounce(keyPressCallback, 400);

    function keyPressCallback() {
        datatableProgramPage.draw();
    }
</script>
