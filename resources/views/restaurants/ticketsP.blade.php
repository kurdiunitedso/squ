<div class="col-md-12">

    <table class="table table-bordered align-middle table-row-dashed table-responsive" id="kt_table_ticketHistory">
        <!--begin::Table head-->
        <thead>
        <!--begin::Table row-->
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            <th class="min-w-100px all">{{__('SN')}}</th>
            <th class="min-w-100px all">{{__('Date')}}</th>
            <th class="min-w-100px all">{{__('Time')}}</th>
            <th class="min-w-100px all">{{__('Since')}}</th>
            <th class="min-w-100px all">{{__('Ticket Number')}}</th>
            <th class="min-w-100px all">{{__('Department')}}</th>
            <th class="min-w-100px all">{{__('Employee')}}</th>
            <th class="min-w-100px all">{{__('Telephone')}}</th>
            <th class="min-w-100px all">{{__('City')}}</th>
            <th class="min-w-100px all">{{__('Category')}}</th>
            <th class="min-w-100px all">{{__('Name')}}</th>
            <th class="min-w-100px all">{{__('Purpose')}}</th>

            <th class="min-w-500px all">{{__('Details')}}</th>

            <th class="min-w-100px all">{{__('Priority')}}</th>
            <th class="min-w-100px all">{{__('Status')}}</th>
            <th class="min-w-100px all">{{__('Source')}}</th>

        </tr>
        <!--end::Table row-->
        </thead>
        <!--end::Table head-->

    </table>

</div>


<script>


    var columnDefsTickets =
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
                data: 'ticket_time',
                name: 'ticket_time',
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
                data: 'employee_name',
                name: 'employee_name',
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

                data: 'categories.name',
                name: 'categories.name',
                orderable: false,
                searchable: false
            },
            {
                data: 'request_name',
                name: ' request_name',
            },
            {

                data: 'purposes.name',
                name: 'purposes.name',
                orderable: false,
                searchable: false
            },


            {
                data: 'details',
                name: 'details',
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
            {
                data: 'source',
                name: 'source',

            },


        ];
    @isset($restaurant)
    var telephone = '{{$restaurant->telephone}}';

    @else
    var telephone = $('[name = "telephone"]').val();

    @endisset
    var datatableTickets = createDataTable('#kt_table_ticketHistory', columnDefsTickets, "{{ route('tickets.indexByPhone') }}?telephone=" + telephone, [
        [0, "ASC"]
    ]);


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


</script>
<script>

    $(document).on('click', '.btnUpdateticket', function (e) {
        e.preventDefault();
        $(this).attr("data-kt-indicator", "on");
        var data_id = $(this).attr("data-id");
        const editURl = $(this).attr('href');
        var size = $(this).attr("size");
        /*  $('#kt_modal_tickets').find('.modal-dialog').removeClass('modal-xl');
          $('#kt_modal_tickets').find('.modal-dialog').removeClass('modal-sm');
          $('#kt_modal_tickets').find('.modal-dialog').removeClass('modal-lg');
          $('#kt_modal_tickets').find('.modal-dialog').addClass(size);*/

        renderAModal(editURl,
            $(this), '#kt_modal_tickets',
            modal_kt_modal_tickets,
            [],
            '#kt_modal_add_ticket_form',
            datatableTickets,
            '[data-kt-ticket-modal-action="submit"]', data_id);
    });

</script>







