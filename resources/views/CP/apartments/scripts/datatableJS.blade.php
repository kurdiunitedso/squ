<script>
    var selectedItemsModelsRows = [];
    var selectedItemModelsData = [];

    const columnDefs = [{
            data: null,
            render: function(data, type, row, meta) {
                var isChecked = selectedItemsModelsRows.includes(row.id.toString()) ? 'checked' : '';
                return '<input type="checkbox" class="row-checkbox" ' + isChecked + '>';
            },
            orderable: false,

        },
        {
            className: 'dt-row',
            orderable: false,
            target: -1,
            data: null,
            render: function(data, type, row, meta) {
                return '<a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px"><span class="la la-list-ul"></span></a>';

            }
        },
        {
            data: 'id',
            name: 'id',
        },
        {
            data: 'name',
            name: 'name',
            render: function(data, type, row) {
                // Handle HTML in name field
                return data.replace(/<[^>]*>/g, '');
            }
        },

        {
            data: 'building.name',
            name: 'building.name',
            render: function(data, type, row) {
                // Access building name using the correct locale structure
                return row.building?.name?.en || row.building?.name?.ar || 'N/A';
            }
        },
        {
            data: 'floor_number',
            name: 'floor_number',
        },
        {
            data: 'apartment_type.name',
            name: 'apartment_type.name',
            defaultContent: 'N/A', // Add this
            render: function(data, type, row) {
                return row.apartment_type?.name?.en || row.apartment_type?.name?.ar || 'N/A';
            }
        },
        {
            data: 'price',
            name: 'price',
        },
        {
            data: row => row.status || 'NA',
            name: `status.name->${currentLocale}`
        },
        {
            data: 'action',
            name: 'action',
            className: 'text-end',
            orderable: false,
            searchable: false
        },

    ];
    var datatable = createDataTable('#kt_table_items_model', columnDefs,
        "{{ route($_model::ui['route'] . '.index') }}", [
            [0, "ASC"]
        ]);
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
