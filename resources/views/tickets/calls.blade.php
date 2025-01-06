<div class="row table-responsive">

    <div class="col-md-12">

        <table class="table table-bordered align-middle table-row-dashed table-responsive" id="kt_table_callHistory">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th><input type="checkbox" id="select-all"></th>
                <th class="min-w-125px">{{__('ID')}}</th>
                <th class="min-w-125px">{{__('Date')}}</th>
                <th class="min-w-125px">{{__('From')}}</th>
                <th class="min-w-125px">{{__('To')}}</th>
                <th class="min-w-125px">{{__('Duration (SEC)')}}</th>
                <th class="min-w-125px">{{__('Status')}}</th>
                <th class="min-w-125px">{{__('Type')}}</th>
                <th class="min-w-125px">{{__('Record')}}</th>
            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->

        </table>

    </div>

</div>


<script>
    var selectedCallsRows = $('[name="selectedCalls"]').val().split(',');
    var selectedCallsData = [];
    var columnDefsCallSelected =
        [
            {
                data: 'id',
                name: 'id',
            },
            {
                data: {
                    _: 'date.display',
                    sort: 'date.timestamp',
                },
                name: 'date',
                searchable: false,
            },
            {
                data: 'from',
                name: 'from',
            },
            {
                data: 'to',
                name: 'to',
            },
            {
                data: 'duration',
                name: 'duration',
            },
            {
                data: 'call_status',
                name: 'call_status',
            },
            {
                data: 'call_type',
                name: 'call_type',
            },
            {
                data: 'record_file_name',
                name: 'record_file_name',
            },
        ];
    var telephone = $('[name="telephone"]').val();


    console.log(selectedCallsRows);
    var columnDefsCalls =
        [
            {
                data: null,
                render: function (data, type, row, meta) {
                    //console.log(row.id);

                    var isChecked = selectedCallsRows.includes(row.id.toString()) ? 'checked' : '';
                    return '<input type="checkbox" class="row-checkbox" ' + isChecked + '>';
                },
                orderable: false,

            },
            {
                data: 'id',
                name: 'id',
            },
            {
                data: {
                    _: 'date.display',
                    sort: 'date.timestamp',
                },
                name: 'date',
                searchable: false,
            },
            {
                data: 'from',
                name: 'from',
            },
            {
                data: 'to',
                name: 'to',
            },
            {
                data: 'duration',
                name: 'duration',
            },
            {
                data: 'call_status',
                name: 'call_status',
            },
            {
                data: 'call_type',
                name: 'call_type',
            },
            {
                data: 'record_file_name',
                name: 'record_file_name',
            },
        ];
    var datatableCalls = createDataTable('#kt_table_callHistory', columnDefsCalls, "{{ route('calls.indexByPhone') }}?telephone=" + telephone, [
        [1, "ASC"]
    ]);
</script>
<script>
    @if(isset($ticket))
    var datatableCallsSelected = $('#kt_table_callHistory_selected').DataTable({
        responsive: true,
        processing: true,
        searching: true,
        searchDelay: 1050,
        pageLength: 10,
        lengthMenu: [10, 50, 100],
        ajax: {
            url: '/tickets/{{$ticket->id}}/edit?typeGetData=1&dataType=calls',
            type: "GET",
            data: function (d) {
                d.params = filterParameters();
            }
        },

        columns: columnDefsCallSelected,
        order: [0, "ASC"]
    });
    @else
    var datatableCallsSelected = $('#kt_table_callHistory_selected').DataTable({
        responsive: true,
        processing: true,
        searching: true,
        searchDelay: 1050,
        pageLength: 10,
        lengthMenu: [10, 50, 100],
        data: [],

        columns: columnDefsCallSelected,
        order: [0, "ASC"]
    });
    @endif
</script>
<script>
    datatableCalls.on('draw', function () {
        KTMenu.createInstances();
        $('#callsCount').html(datatableCalls.data().count());

    });

    datatableCalls.on('responsive-display', function () {
        KTMenu.createInstances();
    });


    $('#kt_table_callHistory').find('#select-all').on('click', function () {
        $('#kt_table_callHistory').find('.row-checkbox').click();
    });

    $('#kt_table_callHistory tbody').on('click', '.row-checkbox', function () {
        selectedCallsRows=selectedCallsRows.map(Number);
        var $row = $(this).closest('tr');
        var rowData = datatableCalls.row($row).data();

        var rowIndex = selectedCallsRows.indexOf(rowData.id);


        if (this.checked && rowIndex === -1) {
            selectedCallsRows.push(rowData.id);
            datatableCallsSelected.row.add(rowData).draw(false);
        } else if (!this.checked && rowIndex !== -1) {
            //console.log(data);
            selectedCallsRows.splice(rowIndex, 1);
            datatableCallsSelected.rows(function (idx, data, node) {
                console.log(data);
                console.log(rowData);
                return data['id'] === rowData.id;
            })
                .remove()
                .draw(false);
        }

        $row.toggleClass('selected');
        datatableCalls.row($row).select(this.checked);
        /*   if (selectedCallsRows.length == 0)
               $('#selectedCallsRowsCount').html("");
           else
               $('#selectedCallsRowsCount').html("(" + selectedCallsRows.length + ")");
   */
        // console.log(rowData);
        //console.log(selectedCallsRows.length);
        if (selectedCallsRows.length > 0) {
            $('#selectCalls').removeClass('d-none')


        } else {
            $('#selectCalls').addClass('d-none')
            datatableCallsSelected.rows().remove();
        }
        $('[name="selectedCalls"]').val(selectedCallsRows.join(','));
    });

    // Restore selected rows when page changes
    datatableCalls.on('draw.dt', function () {
        datatableCalls.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var rowData = this.data();
            if (selectedCallsRows.includes(rowData.id)) {
                this.select();
            }
        });
    });
</script>






