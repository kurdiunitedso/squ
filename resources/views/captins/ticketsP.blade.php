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
            <th class="min-w-100px all">{{__('Type')}}</th>
            <th class="min-w-100px all">{{__('Name')}}</th>
            <th class="min-w-100px all">{{__('Telephone')}}</th>
            <th class="min-w-100px all">{{__('email')}}</th>
            <th class="min-w-100px all">{{__('City')}}</th>
            <th class="min-w-100px all">{{__('Purpose')}}</th>

            <th class="min-w-100px all">{{__('Employee')}}</th>
            <th class="min-w-300px all">{{__('Details')}}</th>
            <th class="min-w-300px all">{{__('Answer')}}</th>
            <th class="min-w-100px all">{{__('Priority')}}</th>
            <th class="min-w-100px all">{{__('Status')}}</th>

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
                data: 'request_name',
                name: ' request_name',
            },


            {
                data: 'telephone',
                name: 'telephone',
            },
            {
                data: 'email',
                name: 'email',
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
                data: 'details',
                name: 'details',
            },
            {
                data: 'ticket_answer',
                name: 'ticket_answer',
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
    @isset($captin)
    var telephone = '{{$captin->mobile1}}';

    @else
    var telephone = $('[name="mobile1"]').val();

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






