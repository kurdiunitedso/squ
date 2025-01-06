<span></span>{{__('Tickets')}}</a>
<div class="row table-responsive">

    <div class="col-md-12">

        <table class="table table-bordered align-middle table-row-dashed table-responsive" id="kt_table_ticketHistory">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-100px all"><input type="checkbox" id="select-all"></th>
                <th class="min-w-100px all">{{__('SN')}}</th>
                <th class="min-w-100px all">{{__('Date')}}</th>
                <th class="min-w-100px all">{{__('Time')}}</th>

                <th class="min-w-100px all">{{__('Ticket Number')}}</th>
                <th class="min-w-100px all">{{__('Department')}}</th>
                <th class="min-w-100px all">{{__('Name')}}</th>
                <th class="min-w-100px all">{{__('Telephone')}}</th>

                <th class="min-w-100px all">{{__('City')}}</th>
                <th class="min-w-100px all">{{__('Purpose')}}</th>

                <th class="min-w-100px all">{{__('Employee')}}</th>
                <th class="min-w-100px all">{{__('Priority')}}</th>
                <th class="min-w-100px all">{{__('Status')}}</th>

            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->

        </table>

    </div>

</div>


<script>
    var selectedTicketsRows = $('[name="selectedTicket"]').val().split(',');
    var selectedTicketsData = [];
    var columnDefsTicketSelected =
        [

            {
                data: 'id',
                name: 'id',
            },
            {
                data: 'ticket_date',
                name: 'ticket_date ',
            },


            {
                data: 'ticket_number',
                name: 'ticket_number',
            },

            {
                data: 'request_name',
                name: 'request_name',
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

                data: 'purposes.name',
                name: 'purposes.name',
                orderable: false,
                searchable: false
            },


            {
                data: 'priorities.name',
                name: 'priorities.name',
                orderable: false,
                searchable: false
            },
            {
                data: 'statuses.name',
                name: 'statuses.name',
                orderable: false,
                searchable: false
            }


        ];
    var telephone = $('[name="telephone"]').val();

    var columnDefsTicket =
        [
            {
                data: null,
                render: function (data, type, row, meta) {
                    var isChecked = selectedTicketsRows.includes(row.id.toString()) ? 'checked' : '';
                    return '<input type="checkbox" class="row-checkbox" ' + isChecked + '>';
                },
                orderable: false,

            },
            {
                data: 'id',
                name: 'id',
            },
            {
                data: 'ticket_date',
                name: 'ticket_date ',
            },
            {
                data: 'ticket_time',
                name: 'ticket_time',
                orderable: false,
                searchable: false
            },

            {
                data: 'ticket_number',
                name: ' ticket_number',
            },
            {
                data: 'ticket_types.name',
                name: ' ticket_types.name',
                orderable: false,
                searchable: false
            },
            {
                data: 'request_name',
                name: ' request_name',
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

                data: 'purposes.name',
                name: 'purposes.name',
                orderable: false,
                searchable: false
            },


            {
                data: 'employee_name',
                name: 'employee_name',
            },
            {
                data: 'priorities.name',
                name: 'priorities.name',
                orderable: false,
                searchable: false
            },
            {
                data: 'statuses.name',
                name: 'statuses.name',
                orderable: false,
                searchable: false
            },


        ];
    var datatableTickets = createDataTable('#kt_table_ticketHistory', columnDefsTicket, "{{ route('tickets.indexByPhone') }}?telephone=" + telephone, [
        [0, "ASC"]
    ]);
</script>
@if(isset($ticket))
    <script>

        var datatableTicketsSelected = $('#kt_table_ticketHistory_selected').DataTable({
            responsive: true,
            processing: true,

            searching: true,
            searchDelay: 1050,
            pageLength: 10,
            lengthMenu: [10, 50, 100],

            ajax: {
                url: '/tickets/{{$ticket->id}}/edit?typeGetData=1&dataType=tickets',
                type: "GET",
                data: function (d) {
                    d.params = filterParameters();
                }
            },


            columns: columnDefsTicketSelected

        });
    </script>
@else
    <script>
        var datatableTicketsSelected = $('#kt_table_ticketHistory_selected').DataTable({
            responsive: true,
            processing: true,

            searching: true,
            searchDelay: 1050,
            pageLength: 10,
            lengthMenu: [10, 50, 100],

            data: [],


            columns: columnDefsTicketSelected

        });
    </script>
@endif
<script>
    datatableTickets.on('draw', function () {
        KTMenu.createInstances();
        $('#ticketsCount').html(datatableTickets.data().count());
    });
    datatableTickets.on('responsive-display', function () {
        KTMenu.createInstances();
    });


    $('#kt_table_ticketHistory').find('#select-all').on('click', function () {
        $('#kt_table_ticketHistory').find('.row-checkbox').click();
    });

    $('#kt_table_ticketHistory tbody').on('click', '.row-checkbox', function () {
        selectedTicketsRows=selectedTicketsRows.map(Number);
        var $row = $(this).closest('tr');
        var rowData = datatableTickets.row($row).data();
        var rowIndex = selectedTicketsRows.indexOf(rowData.id);

        if (this.checked && rowIndex === -1) {
            selectedTicketsRows.push(rowData.id);
            datatableTicketsSelected.row.add(rowData).draw(false);
        } else if (!this.checked && rowIndex !== -1) {
            //console.log(data);
            selectedTicketsRows.splice(rowIndex, 1);
            datatableTicketsSelected.rows(function (idx, data, node) {
                console.log(data);
                console.log(rowData);
                return data['id'] === rowData.id;
            })
                .remove()
                .draw(false);
        }

        $row.toggleClass('selected');
        datatableTickets.row($row).select(this.checked);
        /*if (selectedTicketsRows.length == 0)
            $('#selectedTicketsRowsCount').html("");
        else
            $('#selectedTicketsRowsCount').html("(" + selectedTicketsRows.length + ")");*/

        // console.log(rowData);
        //console.log(selectedTicketsRows.length);
        if (selectedTicketsRows.length > 0) {
            $('#selectTicket').removeClass('d-none')


        } else {
            $('#selectTicket').addClass('d-none')
            datatableTicketsSelected.rows().remove();
        }

        $('[name="selectedTicket"]').val(selectedTicketsRows.join(','));

    });

    // Restore selected rows when page changes
    datatableTickets.on('draw.dt', function () {
        datatableTickets.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var rowData = this.data();
            if (selectedTicketsRows.includes(rowData.id)) {
                this.select();
            }
        });
    });


</script>






