@php
    use App\Models\Program;
    use App\Models\ProgramPageQuestion;
@endphp

<script>
    var selectedItemsModelsRows = [];
    var selectedItemModelsData = [];
    const columnDefsProgramPageQuestions = [{
            data: function(row, type) {
                if (type === 'display') {
                    return row.question?.en || 'NA';
                }
                return '';
            },
            name: 'question->en',
        },
        {
            data: function(row, type) {
                if (type === 'display') {
                    return row.question?.ar || 'NA';
                }
                return '';
            },
            name: 'question->ar',
        },
        {
            data: 'order',
            name: 'order'
        },
        {
            data: 'order',
            name: 'order'
        },
        {
            data: 'order',
            name: 'order'
        },
        {
            data: 'order',
            name: 'order'
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
    var datatableProgramPageQuestion = createDataTable('#kt_table_{{ ProgramPageQuestion::ui['s_lcf'] }}',
        columnDefsProgramPageQuestions,
        "{{ route(Program::ui['route'] . '.' . ProgramPageQuestion::ui['route'] . '.index', ['program' => $_model->id]) }}",
        [
            [0, "ASC"]
        ]);
    datatableProgramPageQuestion.on('draw', function() {
        KTMenu.createInstances();
    });
    datatableProgramPageQuestion.on('responsive-display', function() {
        KTMenu.createInstances();
    });





    // Restore selected rows when page changes
    datatableProgramPageQuestion.on('draw.dt', function() {
        datatableProgramPageQuestion.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var rowData = this.data();
            if (selectedItemsModelsRows.includes(rowData.id)) {
                this.select();
            }
        });
    });
    const filterSearchProgramPageQuestion = document.querySelector(
        '[data-kt-{{ ProgramPageQuestion::ui['s_lcf'] }}-table-filter="search"]');
    filterSearchProgramPageQuestion.onkeydown = debounce(keyPressCallback, 400);

    function keyPressCallback() {
        datatableProgramPageQuestion.draw();
    }
</script>
