<!DOCTYPE html>
@if (app()->getLocale() == 'en')
    <html lang="{{ app()->getLocale() }}">
@elseif (app()->getLocale() == 'ar' || app()->getLocale() == 'he')
    <html direction="rtl" dir="rtl" style="direction: rtl" lang="{{ app()->getLocale() }}">
@endif

<!--begin::Head-->

<head>
    {{-- <base href="" /> --}}
    <title>{{ env('APP_NAME') }} CRM - @yield('title', 'Home')</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ env('APP_NAME') }} CRM " />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&family=Tajawal:wght@300;500&display=swap"
        rel="stylesheet">
    @if (app()->getLocale() == 'en')
        <!--begin::Fonts(mandatory for all pages)-->
        <!--end::Fonts-->
        <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css?v=1') }}" rel="stylesheet"
            type="text/css" />
        <!--end::Vendor Stylesheets-->
        <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
        <link href="{{ asset('plugins/global/plugins.bundle.css?v=1') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/style.bundle.css?v=1') }}" rel="stylesheet" type="text/css" />
    @elseif (app()->getLocale() == 'ar' || app()->getLocale() == 'he')
        <!--begin::Fonts(mandatory for all pages)-->
        <!--end::Fonts-->
        <link href="{{ asset('plugins/custom/datatables/datatables.bundle.rtl.css?v=1') }}" rel="stylesheet"
            type="text/css" />
        <!--end::Vendor Stylesheets-->
        <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
        <link href="{{ asset('plugins/global/plugins.bundle.rtl.css?v=1') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/style.bundle.rtl.css?v=1') }}" rel="stylesheet" type="text/css" />
    @endif
    @if (app()->getLocale() == 'he')
        <link href="{{ asset('css/custom.css?v=1') }}" rel="stylesheet" type="text/css" />
    @endif

    @stack('styles')
    <style>
        @media (min-width: 992px) {
            [data-kt-app-sidebar-minimize=on][data-kt-app-sidebar-hoverable=true] .app-sidebar:not(:hover) .app-sidebar-menu input {
                opacity: 0;
                transition: opacity 0.3s ease !important;
            }
        }

        .w-fit-content {
            width: fit-content;
            max-width: 80%;
        }

        .chat-messages-container {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }

        #messageInputBox {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 1rem;
            border-top: 1px solid #eff2f5;
        }

        .input-group {
            position: relative;
        }

        .form-control-solid {
            background-color: #f5f8fa;
            border-color: #f5f8fa;
            color: #5e6278;
            transition: color .2s ease, background-color .2s ease;
        }
    </style>
    <style>
        .pagination-message {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
        }

        .white-space-pre-line {
            white-space: pre-line;
        }

        .btn-light-primary {
            background-color: #e8f0fe;
            color: #3699ff;
            border: none;
        }

        .btn-light-primary:hover {
            background-color: #d4e4fd;
            color: #1877f2;
        }
    </style>
    <style>
        .apartment-list {
            width: 100%;
        }

        .apartments-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 0.75rem;
        }

        .apartment-item {
            transition: all 0.2s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .section-title {
            color: #5E6278;
        }

        /* RTL Support */
        [dir="rtl"] .apartment-list {
            text-align: right;
        }

        /* Responsive */
        @media (min-width: 768px) {
            .apartments-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <style>
        .confirmation-message {
            width: 100%;
            max-width: 600px;
        }

        .detail-row {
            padding: 8px 0;
        }

        .detail-row:last-child {
            border-bottom: none !important;
        }

        [dir="rtl"] .confirmation-message {
            text-align: right;
        }

        [dir="rtl"] .detail-row {
            flex-direction: row-reverse;
        }
    </style>

    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on"
    data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true"
    data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">
    <!--layout-partial:partials/theme-mode/_init.html-->
    @include('metronic.partials.theme-mode._init')
    <!--layout-partial:layout/partials/_page-loader.html-->
    @include('metronic.layout.partials._page-loader')
    <!--layout-partial:layout/_default.html-->
    @include('metronic.layout._default')
    @include('metronic.partials._scrolltop')
    @include('metronic.layout.partials._chat')
    <div class="modal fade" id="kt_modal_general" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- Status Change Modal -->
    <div class="modal fade" id="kt_modal_general_sm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <!-- Modal content will be loaded here via AJAX -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="kt_modal_add_attachment" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>

    <!--layout-partial:partials/_scrolltop.html-->
    <!--begin::Modals-->
    <!--layout-partial:partials/modals/_upgrade-plan.html-->
    <!--layout-partial:partials/modals/_view-users.html-->
    <!--layout-partial:partials/modals/users-search/_main.html-->
    <!--layout-partial:partials/modals/_invite-friends.html-->
    <!--end::Modals-->
    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->

    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    {{-- <script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script> --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


    <script>
        function debounce_menu(cb, interval, immediate) {
            var timeout;

            return function() {
                var context = this,
                    args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) cb.apply(context, args);
                };

                var callNow = immediate && !timeout;

                clearTimeout(timeout);
                timeout = setTimeout(later, interval);

                if (callNow) cb.apply(context, args);
            };
        };

        function MenukeyPressCallback() {
            var searchTerm = $('#menu-filter').val().toLowerCase();
            var noResultsElement = $('.menu-noResult');
            // noResultsElement.addClass('d-none');
            var hasVisibleItems = false;

            $('.app-sidebar-menu .menu-item').each(function() {
                var menuItem = $(this);
                var menuItemText = menuItem.find('.menu-title').text().toLowerCase();
                var isAccordion = menuItem.hasClass('menu-accordion');
                var isHere = menuItem.hasClass('here');
                if (searchTerm === '') {
                    // Clear input, show all menu items
                    menuItem.show();
                    // if (isAccordion && !menuItem.hasClass('show')) {
                    //     menuItem.removeClass('show');
                    // }
                    hasVisibleItems = true;
                    if (isHere) {
                        menuItem.addClass('show');
                        // hasVisibleItems = true;
                    } else {
                        menuItem.removeClass('show');
                    }
                } else if (menuItemText.indexOf(searchTerm) === -1) {
                    // Hide menu item
                    menuItem.hide();
                } else {
                    // Show menu item
                    menuItem.show();
                    hasVisibleItems = true;
                    // Add "show" class to menu-accordion items if not already present
                    if (isAccordion && !menuItem.hasClass('show')) {
                        menuItem.addClass('show');
                    }
                }
            });
            // Show or hide the "No results found" element
            if (!hasVisibleItems) {
                noResultsElement.removeClass('d-none');
            } else {
                noResultsElement.addClass('d-none');
            }
        }

        $(function() {
            const filterSearchMenu = document.querySelector('#menu-filter');
            filterSearchMenu.onkeydown = debounce_menu(MenukeyPressCallback, 300);
            // Filter the menu items as you type
            // $('#menu-filter').on('input', function() {
            //     var searchTerm = $(this).val().toLowerCase();

            // });
        });
    </script>
    <script>
        $(function() {
            $(document).on('show.bs.modal', '.modal', function() {
                const zIndex = 1040 + 10 * $('.modal:visible').length;
                $(this).css('z-index', zIndex);
                setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1)
                    .addClass('modal-stack'));
            });
        });
    </script>



    <script>
        function createDataTable(tableSelector, columnDefs, ajaxUrl, order, additionalParams = {}) {
            // console.log('Starting DataTable creation process.');
            // console.log(`Table Selector: ${tableSelector}`);
            // console.log('Column Definitions:', columnDefs);
            // console.log('AJAX URL:', ajaxUrl);
            // console.log('Order:', order);
            // console.log('Additional Parameters:', additionalParams);

            var table = document.querySelector(tableSelector);
            if (!table) {
                console.error(`Table with selector ${tableSelector} not found.`);
                return;
            }
            // console.log('Table element found:', table);

            console.log('Initializing DataTable configuration...');
            return $(table).DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 1,
                        display: DataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                var textt = $('#details_for_name').val();
                                // console.log('Generating modal header for row:', data);
                                return textt + data['name'];
                            }
                        }),
                        renderer: function(api, rowIdx, columns) {
                            // console.log(`Rendering responsive details for row index: ${rowIdx}`);
                            var data = $.map(columns, function(col, i) {
                                if (col.columnIndex != 0 && col.columnIndex != 1 && col.columnIndex != -
                                    1) {
                                    // console.log(
                                    //     `Processing column: index=${col.columnIndex}, title=${col.title}`
                                    // );
                                    return datatable.column(i).visible() ?
                                        '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col
                                        .columnIndex + '">' +
                                        "<td>" + col.title + ":" + "</td> " + "<td>" + col.data +
                                        "</td>" +
                                        "</tr>" :
                                        "";
                                }
                            }).join("");
                            // console.log('Rendered responsive details:', data);
                            return data ? $("<table class='table table-bordered'/>").append(data) : false;
                        },
                    }
                },
                processing: true,
                serverSide: true,
                searching: true,
                searchDelay: 1050,
                pageLength: 10,
                lengthMenu: [10, 50, 100],
                ajax: {
                    url: ajaxUrl,
                    type: "POST",
                    data: function(d) {
                        // console.log('Preparing AJAX request data...');
                        // console.log('Initial data:', d);
                        var filterParams = filterParameters();
                        // console.log('Filter parameters:', filterParams);
                        d.params = $.extend({}, filterParams, additionalParams);
                        // console.log('Final AJAX request data:', d);
                        return d;
                    },
                    error: function(xhr, error, thrown) {
                        console.error('AJAX request failed:', error);
                        console.error('Error details:', thrown);
                        handleAjaxErrors(xhr, error, thrown);
                    },
                },
                columns: columnDefs,
                order: order,
                drawCallback: function(settings) {
                    // console.log('DataTable draw complete. Settings:', settings);
                },
                initComplete: function(settings, json) {
                    // console.log('DataTable initialization complete. Settings:', settings);
                    // console.log('Initial JSON data:', json);
                }
            });
        }

        function filterParameters() {
            console.log('Datatable Collecting filter parameters...');
            var params = {};
            $('.datatable-input').each(function() {
                var i = $(this).data('col-index');
                if ($(this).is(':checkbox')) {
                    params[i] = $(this).is(':checked') ? 'on' : 'off';
                } else {
                    if (params[i]) {
                        params[i] += '|' + $(this).val();
                    } else {
                        params[i] = $(this).val();
                    }
                }
            });
            console.log('Datatable Collected filter parameters:', params);
            return params;
        }

        function debounce(cb, interval, immediate) {
            var timeout;

            return function() {
                var context = this,
                    args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) cb.apply(context, args);
                };

                var callNow = immediate && !timeout;

                clearTimeout(timeout);
                timeout = setTimeout(later, interval);

                if (callNow) cb.apply(context, args);
            };
        };
    </script>
    @include('metronic.CustomJS.indexJS')

    @stack('scripts')

    <script>
        KTToggle.createInstances();
        var toggleElement = document.querySelector("#kt_app_sidebar_toggle");
        var toggle = KTToggle.getInstance(toggleElement);
        toggle.on("kt.toggle.changed", function() {
            localStorage.setItem("aside_toggle", toggle.isEnabled());
        });

        if (localStorage.getItem("aside_toggle") == 'true') {
            toggle.enable();
        } else {
            toggle.disable();
        }
    </script>
    @include('metronic.CustomJS.chat.index')
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
