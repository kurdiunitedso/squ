<script>
    const columnDefs = [{
            data: 'id',
            name: 'id',
            render: function(data, type, row) {
                return data || 'NA';
            }
        },
        {
            data: function(row, type, set) {
                if (type === 'display') {
                    if (row.name && row.name['en']) {
                        return row.name['en'];
                    } else {
                        return 'NA'; // Placeholder text if the value is missing
                    }
                }
                return '';
            },
            name: `name->${'en'}`, // Use template literals for dynamic values
            // name: `name->${'en'}`, // Use template literals for dynamic values
        },
        {
            data: function(row, type, set) {
                if (type === 'display') {
                    if (row.name && row.name['ar']) {
                        return row.name['ar'];
                    } else {
                        return 'NA'; // Placeholder text if the value is missing
                    }
                }
                return '';
            },
            name: `name->${'ar'}`, // Use template literals for dynamic values
            // name: `name->${'en'}`, // Use template literals for dynamic values
        },
        {
            data: function(row, type, set) {
                if (type === 'display') {
                    if (row.description && row.description[currentLocale]) {
                        return row.description[currentLocale];
                    } else {
                        return 'NA'; // Placeholder text if the value is missing
                    }
                }
                return '';
            },
            name: `description->${currentLocale}`, // Use template literals for dynamic values
        },
        {
            data: 'type.name',
            name: 'type.name',
            render: function(data, type, row) {
                return row.type?.name[currentLocale] || 'NA';
            }
        },
        {
            data: 'order',
            name: 'order',
            render: function(data, type, row) {
                return data || 'NA';
            }
        },
        {
            data: 'active',
            name: 'active',
            render: function(data, type, row) {
                if (type === 'display') {
                    return data ?
                        '<span class="badge badge-light-success">Active</span>' :
                        '<span class="badge badge-light-danger">Inactive</span>';
                }
                return data;
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
    var datatable = createDataTable('#kt_table_{{ $_model::ui['s_lcf'] }}', columnDefs,
        "{{ route($_model::ui['route'] . '.index') }}", [
            [0, "ASC"]
        ]);
    datatable.on('draw', function() {
        KTMenu.createInstances();
    });
    datatable.on('responsive-display', function() {
        KTMenu.createInstances();
    });



    const filterSearch = document.querySelector('[data-kt-table-filter="search"]');
    filterSearch.onkeydown = debounce(keyPressCallback, 400);

    function keyPressCallback() {
        datatable.draw();
    }
</script>
