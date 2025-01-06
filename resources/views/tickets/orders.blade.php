<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <!--begin::Col-->
    <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->

            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_orderHistory">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-100px all"><input type="checkbox" id="select-all"></th>
                        <th class="min-w-100px all">{{__('SN')}}</th>
                        <th class="min-w-100px all">{{__('Employee Name')}}</th>
                        <th class="min-w-100px all">{{__('Restaurant Name')}}</th>
                        <th class="min-w-100px all">{{__('Branch Name')}}</th>
                        <th class="min-w-100px all">{{__('Order #')}}</th>
                        <th class="min-w-100px all">{{__('Client Name')}}</th>
                        <th class="min-w-100px all">{{__('Client Mobile # 1')}}</th>
                        <th class="min-w-100px all">{{__('Client Mobile 2')}}</th>
                        <th class="min-w-100px all">{{__('City')}}</th>
                        <th class="min-w-100px all">{{__('Sub Destination')}}</th>
                        <th class="min-w-100px all">{{__('Delivery Type')}}</th>
                        <th class="min-w-100px all">{{__('Payment Type')}}</th>
                        <th class="min-w-100px all">{{__('Order Create Date')}}</th>
                        <th class="min-w-100px all">{{__('Order Create Time')}}</th>
                        <th class="min-w-100px all">{{__('Expected Prep Time')}}</th>
                        <th class="min-w-100px all">{{__('Captain Pickup Time')}}</th>
                        <th class="min-w-200px all all">{{__('Captain Name')}}</th>
                        <th class="min-w-200px  all">{{__('Mobile')}}</th>
                        <th class="min-w-200px all ">{{__('Details')}}</th>
                        <th class="min-w-100px  all">{{__('Delivery Status')}}</th>

                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->

                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Content container-->




<script>
    var selectedOrdersRows = $('[name="selectedOrder"]').val().split(',');
    var selectedOrdersData = [];
    var columnDefsOrderSelected =
        [
            {
                data: 'id',
                name: 'id',
            },

            {
                data: function (row, type, set) {
                    if (type === 'display') {
                        if (row.employee)
                            return row.employee.name;
                    }
                    return '';
                },
                name: 'employee.name ',
            },
            {
                data: 'restaurant_name',
                name: 'restaurant_name ',
            },
            {
                data: 'branch_name',
                name: 'branch_name',

            },
            {
                data: 'order_no',
                name: 'order_no',

            },
            {
                data: 'client_name',
                name: 'client_name',

            },
            {
                data: 'client_mobile1',
                name: 'client_mobile1',

            },
            {
                data: 'client_mobile2',
                name: 'client_mobile2',

            },
            {
                data: function (row, type, set) {
                    if (type === 'display') {
                        if (row.city)
                            return row.city.name;
                    }
                    return '';
                },
                name: 'city_id',

            },
            {
                data: 'sub_destination',
                name: 'sub_destination',

            },
            {
                data: 'delivery_type',
                name: 'delivery_type',

            },
            {
                data: 'payment_type',
                name: 'payment_type',

            },
            {
                data: 'order_create_date',
                name: 'order_create_date',

            },
            {
                data: 'order_create_time',
                name: 'order_create_time',

            },
            {
                data: 'expected_prep_time',
                name: 'expected_prep_time',

            },
            {
                data: 'pickup_time',
                name: 'pickup_time',

            },

            {
                data: 'captin_name',
                name: 'captin_name',

            },
            {
                data: 'captin_mobile',
                name: 'captin_mobile',

            },
            {
                data: 'details',
                name: 'details',

            },
            {
                data: 'delivery_status',
                name: 'delivery_status',

            },



        ];
    var telephone = $('[name="telephone"]').val();

    console.log(selectedOrdersRows);
    var columnDefsOrders =
        [
            {
                data: null,
                render: function (data, type, row, meta) {
                    var isChecked = selectedOrdersRows.includes(row.id.toString()) ? 'checked' : '';
                    return '<input type="checkbox" class="row-checkbox" ' + isChecked + '>';
                },
                orderable: false,

            },
            {
                data: 'id',
                name: 'id',
            },

            {
                data: function (row, type, set) {
                    if (type === 'display') {
                        if (row.employee)
                            return row.employee.name;
                    }
                    return '';
                },
                name: 'employee.name ',
            },
            {
                data: 'restaurant_name',
                name: 'restaurant_name ',
            },
            {
                data: 'branch_name',
                name: 'branch_name',

            },
            {
                data: 'order_no',
                name: 'order_no',

            },
            {
                data: 'client_name',
                name: 'client_name',

            },
            {
                data: 'client_mobile1',
                name: 'client_mobile1',

            },
            {
                data: 'client_mobile2',
                name: 'client_mobile2',

            },
            {
                data: function (row, type, set) {
                    if (type === 'display') {
                        if (row.city)
                            return row.city.name;
                    }
                    return '';
                },
                name: 'city_id',

            },
            {
                data: 'sub_destination',
                name: 'sub_destination',

            },
            {
                data: 'delivery_type',
                name: 'delivery_type',

            },
            {
                data: 'payment_type',
                name: 'payment_type',

            },
            {
                data: 'order_create_date',
                name: 'order_create_date',

            },
            {
                data: 'order_create_time',
                name: 'order_create_time',

            },
            {
                data: 'expected_prep_time',
                name: 'expected_prep_time',

            },
            {
                data: 'pickup_time',
                name: 'pickup_time',

            },

            {
                data: 'captin_name',
                name: 'captin_name',

            },
            {
                data: 'captin_mobile',
                name: 'captin_mobile',

            },
            {
                data: 'details',
                name: 'details',

            },
            {
                data: 'delivery_status',
                name: 'delivery_status',

            },


        ];
    var datatableOrders = createDataTable('#kt_table_orderHistory', columnDefsOrders, "{{ route('orders.indexByPhone') }}?telephone=" + telephone, [
        [0, "ASC"]
    ]);

</script>
@if(isset($ticket))
    <script>
        var datatableOrdersSelected = $('#kt_table_orderHistory_selected').DataTable({
            responsive: true,
            processing: true,
            searching: true,

            searchDelay: 1050,
            pageLength: 10,
            lengthMenu: [10, 50, 100],

            ajax: {
                url: '/tickets/{{$ticket->id}}/edit?typeGetData=1&dataType=orders',
                type: "GET",
                data: function (d) {
                    d.params = filterParameters();
                }
            },

            columns: columnDefsOrderSelected

        });
    </script>
@else
    <script>
        var datatableOrdersSelected = $('#kt_table_orderHistory_selected').DataTable({
            responsive: true,
            processing: true,
            searching: true,

            searchDelay: 1050,
            pageLength: 10,
            lengthMenu: [10, 50, 100],

            data: [],

            columns: columnDefsOrderSelected,

        });
    </script>
@endif
<script>

    datatableOrders.on('draw', function () {
        KTMenu.createInstances();
        $('#ordersCount').html(datatableOrders.data().count());
    });
    datatableOrders.on('responsive-display', function () {
        KTMenu.createInstances();
    });


    $('#kt_table_orderHistory').find('#select-all').on('click', function () {
        $('#kt_table_orderHistory').find('.row-checkbox').click();
    });

    $('#kt_table_orderHistory tbody').on('click', '.row-checkbox', function () {
        console.log('mahm');
        selectedOrdersRows=selectedOrdersRows.map(Number);
        var $row = $(this).closest('tr');
        var rowData = datatableOrders.row($row).data();
        var rowIndex = selectedOrdersRows.indexOf(rowData.id);

        if (this.checked && rowIndex === -1) {
            selectedOrdersRows.push(rowData.id);
            datatableOrdersSelected.row.add(rowData).draw(false);
        } else if (!this.checked && rowIndex !== -1) {
            //console.log(data);
            selectedOrdersRows.splice(rowIndex, 1);
            datatableOrdersSelected.rows(function (idx, data, node) {
                console.log(data);
                console.log(rowData);
                return data['id'] === rowData.id;
            })
                .remove()
                .draw(false);
        }

        $row.toggleClass('selected');
        datatableOrders.row($row).select(this.checked);
        /*       if (selectedOrdersRows.length == 0)
                   $('#selectedOrdersRowsCount').html("");
               else
                   $('#selectedOrdersRowsCount').html("(" + selectedOrdersRows.length + ")");*/

        // console.log(rowData);
        //console.log(selectedOrdersRows.length);
        if (selectedOrdersRows.length > 0) {
            $('#selectOrder').removeClass('d-none')


        } else {
            $('#selectOrder').addClass('d-none')
            datatableOrdersSelected.rows().remove();
        }
        $('[name="selectedOrder"]').val(selectedOrdersRows.join(','));
    });

    // Restore selected rows when page changes
    datatableOrders.on('draw.dt', function () {
        datatableOrders.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var rowData = this.data();
            if (selectedOrdersRows.includes(rowData.id)) {
                this.select();
            }
        });
    });

</script>























