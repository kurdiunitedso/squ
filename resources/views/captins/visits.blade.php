<div class="col-md-12">

    <table class="table table-bordered align-middle table-row-dashed table-responsive" id="kt_table_visitHistory">
        <!--begin::Table head-->
        <thead>
        <!--begin::Table row-->
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
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
            <th class="min-w-100px all">{{__('Purpose')}}</th>
            <th class="min-w-100px all">{{__('Employee')}}</th>
            <th class="min-w-100px all">{{__('Rating_Company')}}</th>
            <th class="min-w-100px all">{{__('Rating_Captin')}}</th>
            <th class="min-w-200px all all">{{__('Details')}}</th>
            <th class="min-w-100px all all">{{__('Source')}}</th>

        </tr>
        <!--end::Table row-->
        </thead>
        <!--end::Table head-->

    </table>

</div>



@push('scripts')
    <script>

        var columnDefsVisits =
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

                    data: function (row, type, set) {
                        if (type === 'display') {
                            if (row.periods)
                                return row.periods.name;
                        }
                        return '';
                    },
                    name: 'periods.name',
                    orderable: false,
                    searchable: false
                },
                {

                    data: function (row, type, set) {
                        if (type === 'display') {
                            if (row.categories)
                                return row.categories.name;
                        }
                        return '';
                    },
                    name: 'categories.name',
                    orderable: false,
                    searchable: false
                },
                {

                    data: function (row, type, set) {
                        if (type === 'display') {
                            if (row.pruposes)
                                return row.pruposes.name;
                        }
                        return '';
                    },
                    name: 'pruposes.name',
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
                {
                    data: 'details',
                    name: 'details',

                },
                {
                    data: 'source',
                    name: 'source',

                },



            ];
        @isset($captin)
        var telephone = '{{$captin->mobile1}}';

        @else
        var telephone = $('[name="mobile1"]').val();

        @endisset

        var datatableVisits = createDataTable('#kt_table_visitHistory', columnDefsVisits, "{{ route('visits.indexByPhone') }}?telephone=" + telephone, [
            [0, "ASC"]
        ]);


        datatableVisits.on('draw', function () {
            KTMenu.createInstances();
            $('#visitCount').html(datatableVisits.data().count());
        });
        datatableVisits.on('responsive-display', function () {
            KTMenu.createInstances();
        });


    </script>
@endpush






