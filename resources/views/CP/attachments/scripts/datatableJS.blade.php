{{-- @dd($_model::class) --}}

<script>
    // In your blade template
    const model = @json($_model::class);
    console.log('attachment model type', model);

    var selectedItemsModelsRows = [];
    var selectedItemModelsData = [];

    const columnDefs = [{
            data: 'id',
            name: 'id',
        },
        {
            // className: 'd-flex align-items-center',
            data: 'title',
            name: 'title',
        },

        {
            data: 'attachment_type.name',
            name: 'attachment_type.name',
            render: function(data, type, row) {
                return row.attachment_type?.name[currentLocale] || 'NA';
            }
        },
        // {
        //     data: 'source',
        //     name: 'source',
        // },
        {
            data: {
                _: 'created_at.display',
                sort: 'created_at.timestamp',
            },
            name: 'created_at',
            visible: true,
            searchable: false
        },
        {
            data: 'action',
            name: 'action',
            className: 'text-end',
            orderable: false,
            searchable: false
        }
    ];
    const params = {
        model: model,
        model_id: "{{ $_model->id }}",
    };
    var datatable = createDataTable("#kt_table_{{ $_model::ui['s_lcf'] }}", columnDefs,
        "{{ route('attachments.index') }}", [
            [0, "ASC"]
        ], params);
    datatable.on('draw', function() {
        KTMenu.createInstances();
    });
    datatable.on('responsive-display', function() {
        KTMenu.createInstances();
    });


    $('#kt_table_items_model').find('#select-all').on('click', function() {
        $('#kt_table_items_model').find('.row-checkbox').click();
    });

    $('#kt_table_items_model tbody').on('click', '.row-checkbox', function() {
        var $row = $(this).closest('tr');
        var rowData = datatable.row($row).data();
        var rowIndex = selectedItemsModelsRows.indexOf(rowData.id);

        if (this.checked && rowIndex === -1) {
            selectedItemsModelsRows.push(rowData.id);
        } else if (!this.checked && rowIndex !== -1) {
            //console.log(data);
            selectedItemsModelsRows.splice(rowIndex, 1);

        }

        $row.toggleClass('selected');
        datatable.row($row).select(this.checked);
        if (selectedItemsModelsRows.length == 0)
            $('#selectedItemsModelsRowsCount').html("");
        else
            $('#selectedItemsModelsRowsCount').html("(" + selectedItemsModelsRows.length + ")");


        $('[name="selectedCaptin"]').val(selectedItemsModelsRows.join(','));

    });

    // Restore selected rows when page changes
    datatable.on('draw.dt', function() {
        datatable.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var rowData = this.data();
            if (selectedItemsModelsRows.includes(rowData.id)) {
                this.select();
            }
        });
    });
    const filterSearch = document.querySelector('[data-kt-table-filter="search"]');
    filterSearch.onkeydown = debounce(keyPressCallback, 400);

    function keyPressCallback() {
        datatable.draw();
    }
</script>


<script>
    $(document).on('click', '#filterBtn', function(e) {
        e.preventDefault();
        datatable.ajax.reload();
    });

    $(document).on('click', '#resetFilterBtn', function(e) {
        e.preventDefault();
        $('#filter-form').trigger('reset');
        $('.datatable-input').each(function() {
            if ($(this).hasClass('filter-selectpicker')) {
                $(this).val('');
                $(this).trigger('change');
            }
            if ($(this).hasClass('flatpickr-input')) {
                const fp = $(this)[0]._flatpickr;
                fp.clear();
            }
        });
        datatable.ajax.reload();
    });

    $(document).on('click', '#exportBtn', function(e) {
        e.preventDefault();
        const url = $(this).data('export-url');
        console.log(url);
        const myUrlWithParams = new URL(url);

        const parameters = filterParameters();
        //myUrlWithParams.searchParams.append('params',JSON.stringify( parameters))
        Object.keys(parameters).map((key) => {
            myUrlWithParams.searchParams.append(key, parameters[key]);
        });
        console.log(myUrlWithParams);
        window.open(myUrlWithParams, "_blank");

    });
</script>
