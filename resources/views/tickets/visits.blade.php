<div class="row table-responsive">

    <div class="col-md-12">

        <table class="table table-bordered align-middle table-row-dashed table-responsive" id="kt_table_visitHistory">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th><input type="checkbox" id="select-all"></th>
                <th class="min-w-100px all">{{__('SN')}}</th>
                <th class="min-w-100px all">{{__('Max Visit Date')}}</th>
                <th class="min-w-100px all">{{__('Date')}}</th>
                <th class="min-w-100px all">{{__('Time')}}</th>
                <th class="min-w-100px all">{{__('Since')}}</th>
                <th class="min-w-100px all">{{__('Visit Number')}}</th>
                <th class="min-w-100px all">{{__('Type')}}</th>
                <th class="min-w-100px all">{{__('Name')}}</th>
                <th class="min-w-100px all">{{__('Telephone')}}</th>

                <th class="min-w-100px all">{{__('City')}}</th>
                <th class="min-w-100px all">{{__('Period')}}</th>
                <th class="min-w-100px all">{{__('Category')}}</th>
                <th class="min-w-100px all">{{__('Employee')}}</th>
                <th class="min-w-100px all">{{__('Rating_Company')}}</th>
                <th class="min-w-100px all">{{__('Rating_Captin')}}</th>

            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->

        </table>

    </div>

</div>


<script>
    var selectedVisitsRows = $('[name="selectedVisit"]').val().split(',');
    var selectedVisitsData = [];
    var columnDefsVisitSelected =
        [
            {
                data: 'id',
                name: 'id',
            },
            {
                data: 'last_date',
                name: 'last_date ',
            },
            {
                data: 'visit_date',
                name: 'visit_date ',
            },
            {
                data: 'visit_time',
                name: 'visit_time',
                orderable: false,
                searchable: false
            },

            {
                data: 'visit_number',
                name: ' visit_number',
            },
            {
                data: 'visit_types.name',
                name: ' visit_types.name',
                orderable: false,
                searchable: false
            },
            {
                data: 'visit_name',
                name: ' visit_name',
            },


            {
                data: 'telephone',
                name: 'telephone',
            },


            {
                data: 'cities.name',
                name: 'cities.name',
                orderable: false,
                searchable: false
            },

            {

                data: 'periods.name',
                name: 'periods.name',
                orderable: false,
                searchable: false
            },
            {

                data: 'categories.name',
                name: 'categories.name',
                orderable: false,
                searchable: false
            },

            {
                data: 'employees.name',
                name: 'employees.name',
            },
            {
                data: 'rate_company',
                name: 'rate_company',

            },
            {
                data: 'rate_captin',
                name: 'rate_captin',

            },


        ];
    var telephone = $('[name="telephone"]').val();

    console.log(selectedVisitsRows);
    var columnDefsVisits =
        [
            {
                data: null,
                render: function (data, type, row, meta) {
                    var isChecked = selectedVisitsRows.includes(row.id.toString()) ? 'checked' : '';
                    return '<input type="checkbox" class="row-checkbox" ' + isChecked + '>';
                },
                orderable: false,

            },
            {
                data: 'id',
                name: 'id',
            },
            {
                data: 'last_date',
                name: 'last_date ',
            },
            {
                data: 'visit_date',
                name: 'visit_date ',
            },
            {
                data: 'visit_time',
                name: 'visit_time',
                orderable: false,
                searchable: false
            },
            {
                data: 'since',
                name: 'since',
                orderable: false,
                searchable: false
            },
            {
                data: 'visit_number',
                name: ' visit_number',
            },
            {
                data: 'visit_types.name',
                name: ' visit_types.name',
                orderable: false,
                searchable: false
            },
            {
                data: 'visit_name',
                name: ' visit_name',
            },


            {
                data: 'telephone',
                name: 'telephone',
            },


            {
                data: 'cities.name',
                name: 'cities.name',
                orderable: false,
                searchable: false
            },

            {

                data: 'periods.name',
                name: 'periods.name',
                orderable: false,
                searchable: false
            },
            {

                data: 'categories.name',
                name: 'categories.name',
                orderable: false,
                searchable: false
            },

            {
                data: 'employee_name',
                name: 'employee_name',
            },
            {
                data: 'rate_company',
                name: 'rate_company',

            },
            {
                data: 'rate_captin',
                name: 'rate_captin',

            },



        ];
    var datatableVisits = createDataTable('#kt_table_visitHistory', columnDefsVisits, "{{ route('visits.indexByPhone') }}?telephone=" + telephone, [
        [0, "ASC"]
    ]);

</script>
@if(isset($ticket))
    <script>
        var datatableVisitsSelected = $('#kt_table_visitHistory_selected').DataTable({
            responsive: true,
            processing: true,
            searching: true,

            searchDelay: 1050,
            pageLength: 10,
            lengthMenu: [10, 50, 100],

            ajax: {
                url: '/tickets/{{$ticket->id}}/edit?typeGetData=1&dataType=visits',
                type: "GET",
                data: function (d) {
                    d.params = filterParameters();
                }
            },

            columns: columnDefsVisitSelected

        });
    </script>
@else
    <script>
        var datatableVisitsSelected = $('#kt_table_visitHistory_selected').DataTable({
            responsive: true,
            processing: true,
            searching: true,

            searchDelay: 1050,
            pageLength: 10,
            lengthMenu: [10, 50, 100],

            data: [],

            columns: columnDefsVisitSelected,

        });
    </script>
@endif
<script>

    datatableVisits.on('draw', function () {
        KTMenu.createInstances();
        $('#visitCount').html(datatableVisits.data().count());
    });
    datatableVisits.on('responsive-display', function () {
        KTMenu.createInstances();
    });


    $('#kt_table_visitHistory').find('#select-all').on('click', function () {
        $('#kt_table_visitHistory').find('.row-checkbox').click();
    });

    $('#kt_table_visitHistory tbody').on('click', '.row-checkbox', function () {
        selectedVisitsRows=selectedVisitsRows.map(Number);
        var $row = $(this).closest('tr');
        var rowData = datatableVisits.row($row).data();
        var rowIndex = selectedVisitsRows.indexOf(rowData.id);

        if (this.checked && rowIndex === -1) {
            selectedVisitsRows.push(rowData.id);
            datatableVisitsSelected.row.add(rowData).draw(false);
        } else if (!this.checked && rowIndex !== -1) {
            //console.log(data);
            selectedVisitsRows.splice(rowIndex, 1);
            datatableVisitsSelected.rows(function (idx, data, node) {
                console.log(data);
                console.log(rowData);
                return data['id'] === rowData.id;
            })
                .remove()
                .draw(false);
        }

        $row.toggleClass('selected');
        datatableVisits.row($row).select(this.checked);
        /*       if (selectedVisitsRows.length == 0)
                   $('#selectedVisitsRowsCount').html("");
               else
                   $('#selectedVisitsRowsCount').html("(" + selectedVisitsRows.length + ")");*/

        // console.log(rowData);
        //console.log(selectedVisitsRows.length);
        if (selectedVisitsRows.length > 0) {
            $('#selectVisits').removeClass('d-none')


        } else {
            $('#selectVisits').addClass('d-none')
            datatableVisitsSelected.rows().remove();
        }
        $('[name="selectedVisit"]').val(selectedVisitsRows.join(','));
    });

    // Restore selected rows when page changes
    datatableVisits.on('draw.dt', function () {
        datatableVisits.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var rowData = this.data();
            if (selectedVisitsRows.includes(rowData.id)) {
                this.select();
            }
        });
    });

</script>






