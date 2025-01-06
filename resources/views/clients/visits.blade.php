<div class="col-md-12">

    <table class="table table-bordered align-middle table-row-dashed table-responsive" id="kt_table_visitHistory">
        <!--begin::Table head-->
        <thead>
        <!--begin::Table row-->
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
          <th class="min-w-100px  bold all">{{__('SN')}}</th>
          <th class="min-w-100px  bold all">{{__('Max Visit Date')}}</th>
          <th class="min-w-100px  bold all">{{__('Date')}}</th>
          <th class="min-w-100px  bold all">{{__('Time')}}</th>
          <th class="min-w-100px  bold all">{{__('Since')}}</th>
          <th class="min-w-100px  bold all">{{__('Visit Number')}}</th>
          <th class="min-w-100px  bold all">{{__('Type')}}</th>
          <th class="min-w-100px  bold all">{{__('Name')}}</th>
          <th class="min-w-100px  bold all">{{__('Telephone')}}</th>

          <th class="min-w-100px  bold all">{{__('City')}}</th>
          <th class="min-w-100px  bold all">{{__('Period')}}</th>
          <th class="min-w-100px  bold all">{{__('Category')}}</th>
          <th class="min-w-100px  bold all">{{__('Employee')}}</th>
          <th class="min-w-100px  bold all">{{__('Rating_Company')}}</th>
          <th class="min-w-100px  bold all">{{__('Rating_Captin')}}</th>
            <th class="min-w-100px  bold all">{{__('Details')}}</th>

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
                    data: function (row, type, set) {
                        if (type === 'display') {
                            if (row.visit_types)
                                return row.visit_types.name;
                        }
                        return '';
                    },
                    name: 'visit_types.name',
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
                    data: function (row, type, set) {
                        if (type === 'display') {
                            if (row.cities)
                                return row.cities.name;
                        }
                        return '';
                    },
                    name: 'cities.name',
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
                },



                {
                    data: function (row, type, set) {
                        if (type === 'display') {
                            if (row.employees)
                                return row.employees.name;
                        }
                        return '';
                    },
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
                {
                    data: 'details',
                    name: 'details',

                },



            ];
        var telephone = $('[name="telephone"]').val();


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






