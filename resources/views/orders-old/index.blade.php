@extends('metronic.index')

@section('title', 'Orders')
@section('subpageTitle', 'Orders')

@section('content')
    <!--begin::Content container-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                          rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-col-index="name_code"
                                   data-kt-orders-table-filter="search"
                                   class="form-control datatable-input form-control-solid w-250px ps-14"
                                   placeholder="Search Orders"/>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-orders-table-toolbar="base">
                            <!--begin::Filter-->
                            <!--begin::orders 1-->
                            <!--end::orders 1-->
                            @include('orders._filter')


                            <a target="_blank" id="exportBtn" href="#"
                               data-export-url="{{ route('orders.export') }}" class="btn btn-primary me-3">
                                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span
                                        class="path2"></span></i> {{__('Export')}}
                            </a>
                            <!--end::Filter-->
                            <!--begin::Add orders-->
                            <button link="{{ route('orders.create') }}" type="button" class="btn btn-primary addOrder"
                                    id="addOrder">
                                <span class="indicator-label">
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                  rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                  fill="currentColor"/>
                                        </svg>
                                    </span>
                                    {{__('Add Order')}}
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <!--end::Add orders-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_orders" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">

                            </div>
                            <!--end::Modal dialog-->
                        </div>
                        <!--end::Modal - Add task-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_orders">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="all">{{__('SN')}}</th>
                            <th class="all">{{__('Date')}}</th>
                            <th class="all">{{__('Time')}}</th>
                            <th class="all">{{__('Since')}}</th>
                            <th class="all">{{__('Order Number')}}</th>
                            <th class="all">{{__('Restaurant')}}</th>
                            <th class="all">{{__('Telephone')}}</th>

                            <th class="all">{{__('City')}}</th>
                            <th class="all">{{__('Shipping Address')}}</th>
                            <th class="all">{{__('Type')}}</th>

                            <th class="all">{{__('Status')}}</th>
                            <th class="all">{{__('Action')}}</th>
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
    <div class="modal fade" id="kt_modal_orders" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>
    @include('orders.order_drawer')
    @include('orders.order_drawer2')
    @include('orders.order_drawer3')
@endsection


@push('scripts')
    <script>
        function renderModal(url, button, modalId, modalBootstrap) {


            $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json",
                    success: function (response) {
                        $(modalId).find('.modal-dialog').html(response.createView);
                        modalBootstrap.show();
                        KTScroll.createInstances();
                        KTImageInput.createInstances();
                    },
                    complete: function () {
                        if (button) {
                            button.removeAttr('data-kt-indicator');
                        }
                        $(document).on('click', '.cityB', function (e) {
                            e.preventDefault();
                            $(modalId).find('.CityName').html($(this).attr('value'));
                            $('.CurrentAddress').append($(this).attr('value') + '-');
                            $(modalId).find('.AllCity').addClass('d-none', 5000, "easeInOutQuad");
                            $(modalId).find('.Branch').removeClass('d-none', 5000, "easeInOutQuad");
                        });
                        $(document).on('click', '.branchB', function (e) {
                            e.preventDefault();
                            $(modalId).find('.BranchName').html($(this).attr('value'));
                            $(modalId).find('.Branch').addClass('d-none', 5000, "easeInOutQuad");
                            $(modalId).find('.Address').removeAttr('disabled');
                            $(modalId).find('.Address').removeClass('disabled');
                            $('.CurrentAddress').append($(this).attr('value') + '-');
                            $(modalId).find('.Save').removeClass('disabled');
                        });
                        $(document).on('click', '.Save', function (e) {


                            e.preventDefault();
                            /*  const url = $(this).attr('link');
                              var drawerElement = document.querySelector("#kt_drawer_showOrders3");
                              drawerElement.style.right = "40%";
                              var drawer = KTDrawer.getInstance(drawerElement);
                              drawer.show();
                              refreshOrders3(url);*/

                            $('.CurrentAddress').append($(modalId).find('.Address').val());
                            modalBootstrap.hide();
                        });

                    }
                }
            )
            ;
        }

    </script>
    <script>


        const columnDefs = [{
            data: 'id',
            name: 'id',
        },
            {
                data: 'order_date',
                name: 'order_date ',
            },
            {
                data: 'order_time',
                name: 'order_time',
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
                data: 'order_number',
                name: ' order_number',
            },
            {
                data: 'order_name',
                name: ' order_name',
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
                data: 'shipping_address',
                name: 'shipping_address',
            },
            {
                data: 'order_types.name',
                name: 'order_types.name',
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
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ];
        var datatable = createDataTable('#kt_table_orders', columnDefs, "{{ route('orders.index') }}", [
            [0, "ASC"]
        ]);
        datatable.on('draw', function () {
            KTMenu.createInstances();
        });
        datatable.on('responsive-display', function () {
            KTMenu.createInstances();
        });
    </script>

    <script>

        var orders_card = document.querySelector(".orders_card");
        var blockUI_orders_card = new KTBlockUI(orders_card, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
        });

        function refreshOrders(url) {
            $(orders_card).find('.card-body').html('');

            blockUI_orders_card.block();

            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $(orders_card).find('.card-title span').text(response
                        .captinName);
                    $(orders_card).find('.card-body').html(response.createView);

                },
                complete: function () {
                    blockUI_orders_card.release();
                }

            });

        }

        $(document).ready(function () {
            $(document).on('click', '.addOrder', function (e) {
                e.preventDefault();
                const url = $(this).attr('link');
                var drawerElement = document.querySelector("#kt_drawer_showOrders");
                var drawer = KTDrawer.getInstance(drawerElement);
                drawer.show();
                refreshOrders(url);
            });
        });


    </script>
    <script>

        var orders_card2 = document.querySelector(".orders_card2");
        var blockUI_orders_card2 = new KTBlockUI(orders_card2, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
        });

        function refreshOrders2(url) {
            $(orders_card2).find('.card-body').html('');

            blockUI_orders_card2.block();

            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $(orders_card2).find('.card-title span').text(response
                        .captinName);
                    $(orders_card2).find('.card-body').html(response.createView);

                },
                complete: function () {
                    blockUI_orders_card2.release();
                }

            });

        }

        $(document).ready(function () {
            $(document).on('click', '.createOrder', function (e) {
                e.preventDefault();
                const url = $(this).attr('link');
                var drawerElement = document.querySelector("#kt_drawer_showOrders2");
                drawerElement.style.right = "20%";
                var drawer = KTDrawer.getInstance(drawerElement);
                drawer.show();
                refreshOrders2(url);
            });
            $(document).on('click', '#kt_drawer_showOrders2_close', function (e) {
                e.preventDefault();
                const url = $(this).attr('link');
                var drawerElement = document.querySelector("#kt_drawer_showOrders2");
                drawerElement.style.right = "0";

            });
        });


    </script>
    <script>
        $(document).on('click', '#kt_drawer_showOrders3_close', function (e) {
            e.preventDefault();
            const url = $(this).attr('link');
            var drawerElement = document.querySelector("#kt_drawer_showOrders3");
            drawerElement.style.right = "0";

        });
        var orders_card3 = document.querySelector(".orders_card3");
        var blockUI_orders_card3 = new KTBlockUI(orders_card3, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
        });

        function refreshOrders3(url) {
            $(orders_card3).find('.card-body').html('');

            blockUI_orders_card3.block();

            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $(orders_card3).find('.card-title span').text(response
                        .captinName);
                    $(orders_card3).find('.card-body').html(response.createView);

                },
                complete: function () {
                    blockUI_orders_card3.release();
                }

            });

        }

        $(document).on('click', '.Save', function (e) {


            e.preventDefault();
            const url = $(this).attr('link');
            var drawerElement = document.querySelector("#kt_drawer_showOrders3");
            drawerElement.style.right = "40%";
            var drawer = KTDrawer.getInstance(drawerElement);
            drawer.show();
            refreshOrders3(url);
        });
    </script>
    {{--    <script>

            var orders_card3 = document.querySelector(".orders_card3");
            var blockUI_orders_card3 = new KTBlockUI(orders_card3, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
            });

            function refreshOrders3(url) {
                $(orders_card3).find('.card-body').html('');

                blockUI_orders_card3.block();

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        $(orders_card3).find('.card-title span').text(response
                            .captinName);
                        $(orders_card3).find('.card-body').html(response.createView);

                    },
                    complete: function () {
                        blockUI_orders_card3.release();
                    }

                });

            }

            $(document).ready(function () {
                $(document).on('click', '.createOrder3', function (e) {
                    e.preventDefault();
                    const url = $(this).attr('link');
                    var drawerElement = document.querySelector("#kt_drawer_showOrders3");
                    drawerElement.style.right = "40%";
                    var drawer = KTDrawer.getInstance(drawerElement);
                    drawer.show();
                    refreshOrders2(url);
                });
                $(document).on('click', '#kt_drawer_showOrders3_close', function (e) {
                    e.preventDefault();
                    const url = $(this).attr('link');
                    var drawerElement = document.querySelector("#kt_drawer_showOrders3");
                    drawerElement.style.right = "0";

                });
            });


        </script>--}}

    <script>
        const kt_modal_orders = document.getElementById('kt_modal_orders');
        const modal_kt_modal_orders = new bootstrap.Modal(kt_modal_orders);


        $(document).on('click', '.deliverOrder', function (e) {
            e.preventDefault();
            $(this).addClass("btn-success");
            $('.handOrder').addClass("d-none");
            $(this).attr("data-kt-indicator", "on");
            $('.CurrentAddress').html('');
            var url = $(this).attr("link");
            renderModal(
                url,
                $(this), '#kt_modal_orders',
                modal_kt_modal_orders);
        });


    </script>

@endpush
