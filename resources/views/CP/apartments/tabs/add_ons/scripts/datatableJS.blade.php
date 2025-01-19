@php
    use App\Models\Apartment;
    use App\Models\AddOn;
    use App\Models\ApartmentAddOn;
@endphp

<script>
    var selectedItemsModelsRows = [];
    var selectedItemModelsData = [];

    const columnDefsAddOn = [{
            data: 'id',
            name: 'id',
            render: function(data, type, row) {
                return data || 'NA';
            }
        },
        {
            data: function(row, type, set) {
                if (type === 'display') {
                    if (row.add_on && row.add_on.name && row.add_on.name[currentLocale]) {
                        return row.add_on.name[currentLocale];
                    } else {
                        return 'NA'; // Placeholder text if the value is missing
                    }
                }
                return '';
            },
            name: `add_on.name->${currentLocale}`, // Use template literals for dynamic values
            // name: `name->${'en'}`, // Use template literals for dynamic values
        },

        {
            data: 'notes',
            name: 'notes',
            render: function(data, type, row) {
                return data || 'NA';
            }
        },
        {
            data: 'cost',
            name: 'cost',
            render: function(data, type, row) {
                return data || 'NA';
            }
        },
        {
            data: 'qty',
            name: 'qty',
            render: function(data, type, row) {
                return data || 'NA';
            }
        },
        {
            data: 'discount',
            name: 'discount',
            render: function(data, type, row) {
                return data || 'NA';
            }
        },
        {
            data: 'total_cost',
            name: 'total_cost',
            render: function(data, type, row) {
                return data || 'NA';
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
    var datatableAddOn = createDataTable('#kt_table_{{ ApartmentAddOn::ui['s_lcf'] }}', columnDefsAddOn,
        "{{ route(Apartment::ui['route'] . '.' . ApartmentAddOn::ui['route'] . '.index', ['apartment' => $_model->id]) }}",
        [
            [0, "ASC"]
        ]);
    datatableAddOn.on('draw', function() {
        KTMenu.createInstances();
    });
    datatableAddOn.on('responsive-display', function() {
        KTMenu.createInstances();
    });





    // Restore selected rows when page changes
    datatableAddOn.on('draw.dt', function() {
        datatableAddOn.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var rowData = this.data();
            if (selectedItemsModelsRows.includes(rowData.id)) {
                this.select();
            }
        });
    });
    const filterSearchAddOn = document.querySelector('[data-kt-table-filter="search"]');
    filterSearchAddOn.onkeydown = debounce(keyPressCallback, 400);

    function keyPressCallback() {
        datatableAddOn.draw();
    }
</script>
