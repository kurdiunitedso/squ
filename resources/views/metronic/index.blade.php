<!DOCTYPE html>
@if (app()->getLocale() == 'en')
    <html lang="{{ app()->getLocale() }}">
@elseif (app()->getLocale() == 'ar' || app()->getLocale() == 'he')
    <html direction="rtl" dir="rtl" style="direction: rtl" lang="{{ app()->getLocale() }}">
@endif

<!--begin::Head-->

<head>
    {{-- <base href="" /> --}}
    <title>{{ env('APP_NAME') }} - @yield('title', 'Home')</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ env('APP_NAME') }} " />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/easy-autocomplete.min.css">
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
    @if (app()->getLocale() == 'ar' || app()->getLocale() == 'he')
        <style>
            .select2-container .select2-selection__clear {
                right: 5px !important;
            }

            .select2-container--bootstrap5 .select2-dropdown .select2-results__option.select2-results__option--selected::after {
                left: 1.25rem !important;
                right: auto;
                !important;
            }
        </style>
        <style>
            table thead tr th {
                text-align: center !important;
                font-weight: bolder;
                font-size: 14px !important;
            }

            table thead tr {
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                /* Shadow effect */
            }
        </style>
        <style>
            @media (min-width: 992px) {
                [data-kt-app-sidebar-minimize=on][data-kt-app-sidebar-hoverable=true] .app-sidebar:not(:hover) .app-sidebar-menu input {
                    opacity: 0;
                    transition: opacity 0.3s ease !important;
                }
            }
        </style>
    @endif
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on"
    data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true"
    data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">
    <input type="hidden" id="details_for_name" value="{{ __('Details for: ') }}">
    <!--layout-partial:partials/theme-mode/_init.html-->
    @include('metronic.partials.theme-mode._init')
    <!--layout-partial:layout/partials/_page-loader.html-->
    @include('metronic.layout.partials._page-loader')
    <!--layout-partial:layout/_default.html-->
    @include('metronic.layout._default')
    @include('metronic.partials._scrolltop')
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js"></script>
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
        if (document.querySelector('table').classList.contains('table')) {
            // Reset the classes to 'table table-striped table-row-bordered gy-5 gs-7'
            document.querySelector('table').className = ' table-striped table table-bordered  gy-5 gs-7';

        }
        if (document.querySelector('tr').classList.contains('text-muted')) {
            // Reset the classes to 'table table-striped table-row-bordered gy-5 gs-7'
            document.querySelector('tr').className = 'text-center  fs-11 text-uppercase';
        }

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
                        params[i] += /*'|' +*/ $(this).val();
                    } else {
                        params[i] = $(this).val();
                    }
                }
            });
            console.log('Datatable Collected filter parameters:', params);
            return params;
        }
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

            setInterval(function() {

                $.ajax({
                    url: '{{ route('employees.employeewhour.checkcheckout') }}',
                    success: function(response) {
                        if (response.mdata != '0') {
                            $('.btnCheckInOut').removeClass('text-success');
                            $('.btnCheckInOut').addClass('text-danger');
                            $('.btnCheckInOut').text('Check Out - Checked @' + response.mdata);
                            $('.btnCheckInOut').attr('href',
                                '{{ route('employees.employeewhour.checkout') }}');
                        } else {
                            $('.btnCheckInOut').removeClass('text-danger');
                            $('.btnCheckInOut').addClass('text-success');
                            $('.btnCheckInOut').text('Check In');
                            $('.btnCheckInOut').attr('href',
                                '{{ route('employees.employeewhour.checkin') }}');
                        }

                    },
                    beforeSend: function() {


                    },
                    complete: function() {

                    },

                });

            }, 10000);
            $(document).on('click', '.btnCheckInOut', function(e) {
                e.preventDefault();
                const URL = $(this).attr('href');
                const action = $(this).attr('data-action');
                Swal.fire({
                    html: "Are you sure you want to  Check In/Out?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            type: "GET",
                            url: URL,
                            dataType: "json",
                            success: function(response) {
                                // datatable.ajax.reload(null, false);

                                if (response.mdata == '0') {
                                    $('.btnCheckInOut').removeClass('text-danger');
                                    $('.btnCheckInOut').addClass('text-success');
                                    $('.btnCheckInOut').text('Check In');
                                    $('.btnCheckInOut').attr('href',
                                        '{{ route('employees.employeewhour.checkin') }}'
                                    );
                                } else {
                                    $('.btnCheckInOut').removeClass('text-success');
                                    $('.btnCheckInOut').addClass('text-danger');
                                    $('.btnCheckInOut').text('Check Out Checked @' +
                                        response.mdata);
                                    $('.btnCheckInOut').attr('href',
                                        '{{ route('employees.employeewhour.checkout') }}'
                                    );
                                }
                                Swal.fire({
                                    text: response.message,
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            },
                            complete: function() {


                            },
                            error: function(response, textStatus,
                                errorThrown) {
                                toastr.error(response
                                    .responseJSON
                                    .message);
                            },
                        });

                    } else if (result.dismiss === 'cancel') {}

                });
            });
        });
    </script>
    {{-- added another refactored function in metronic/customeJS.blade.php file  --}}
    {{-- <script>
        function globalRenderModal(url, button, modalId, modalBootstrap, validatorFields, formId, dataTableId,
            submitButtonName, RequiredInputList = null, onFormSuccessCallBack = null) {


            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    $(modalId).find('.modal-dialog').html(response.createView);
                    modalBootstrap.show();
                    KTScroll.createInstances();
                    KTImageInput.createInstances();

                    const form = document.querySelector(formId);
                    console.log('hhhh');

                    if (document.querySelector(formId) != null) {
                        var validator = FormValidation.formValidation(
                            form, {
                                fields: validatorFields,
                                plugins: {
                                    trigger: new FormValidation.plugins.Trigger(),
                                    bootstrap: new FormValidation.plugins.Bootstrap5({
                                        rowSelector: '.fv-row',
                                        eleInvalidClass: '',
                                        eleValidClass: ''
                                    })
                                }
                            }
                        );
                    } else
                        var validator = null;
                    if (document.querySelector(formId) != null) {
                        var appointmentDate = $(form.querySelector('.date-flatpickr'));
                        appointmentDate.flatpickr({
                            enableTime: false,
                            dateFormat: "Y-m-d",
                            allowInput: true,
                            minDate: "today"
                        });
                        var appointmentDate2 = $(form.querySelector('.date-flatpickr2'));
                        appointmentDate2.flatpickr({
                            enableTime: false,
                            dateFormat: "Y-m-d",
                            allowInput: true,

                        });
                        var appointmentDate22 = $(form.querySelector('.date-flatpickr22'));
                        appointmentDate22.flatpickr({
                            enableTime: false,
                            dateFormat: "Y-m-d",
                            allowInput: true,
                            minDate: appointmentDate2.val()
                        });
                        var appointmentDasssted = $(form.querySelector('.date-flatpickr-dob-24'));
                        appointmentDasssted.flatpickr({
                            enableTime: false,
                            dateFormat: "Y-m-d",
                            allowInput: true,
                            maxDate: "today",
                            minDate: new Date().fp_incr(-8700)
                        });
                        var payment_date = $(form.querySelector('[name="payment_date"]'));
                        payment_date.flatpickr({
                            enableTime: false,
                            dateFormat: "Y-m-d",
                            allowInput: true,
                        });
                        var submit_date = $(form.querySelector('[name="submit_date"]'));
                        submit_date.flatpickr({
                            enableTime: false,
                            dateFormat: "Y-m-d",
                            allowInput: true,
                        });
                        var appointmentTime = $(form.querySelector('.time-flatpickr'));
                        appointmentTime.flatpickr({
                            allowInput: true,
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i",
                            time_24hr: true
                        });
                        var appointmentTime2 = $(form.querySelector('.time-flatpickr2'));
                        appointmentTime2.flatpickr({
                            allowInput: true,
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i",
                            time_24hr: true
                        });
                        var appointmentDateTime1 = $(form.querySelector('.datetime-flatpickr'));
                        appointmentDateTime1.flatpickr({
                            allowInput: true,
                            time_24hr: true,
                            enableTime: true,
                            dateFormat: "Y-m-d H:i",
                        });
                        var appointmentDate44 = $(form.querySelector('.date-flatpickr44'));
                        appointmentDate44.flatpickr({
                            enableTime: false,
                            dateFormat: "Y-m-d",
                            allowInput: true,
                        });
                        var appointmentDateTime2 = $(form.querySelector('.datetime-flatpickr2'));
                        appointmentDateTime2.flatpickr({
                            allowInput: true,
                            time_24hr: true,
                            enableTime: true,
                            dateFormat: "Y-m-d H:i",
                            minDate: appointmentDateTime1.val()
                        });

                        if (RequiredInputList != null) {
                            for (var key in RequiredInputList) {
                                // console.log("key " + key + " has value " + RequiredInputList[key]);
                                var fieldName = $(RequiredInputList[key] + ["[name=" + key + "]"]).closest(
                                        ".fv-row")
                                    .find(
                                        "label[data-input-name]").attr('data-input-name');

                                const NameValidators = {
                                    validators: {
                                        notEmpty: {
                                            message: fieldName + ' is required',
                                        },
                                    },
                                };

                                validator.addField(key, NameValidators);
                                // validator.addField($(this).find('.constantNames').attr('name'),
                                //                         NameValidators);
                            }

                        }

                        // Submit button handler
                        const submitButton = document.querySelector(submitButtonName);
                        submitButton.addEventListener('click', function(e) {
                            // Prevent default button action
                            e.preventDefault();

                            // const form = document.querySelector(formId);

                            // Validate form before submit
                            if (validator) {
                                validator.validate().then(function(status) {
                                    console.log('validated!');

                                    if (onFormSuccessCallBack == null) {
                                        onFormSuccessCallBack = function(response) {
                                            toastr.success(response.message);
                                            form.reset();
                                            modalBootstrap.hide();
                                            if (dataTableId != '')
                                                dataTableId.ajax.reload(null,
                                                    false);
                                        };
                                    }
                                    if (status == 'Valid') {
                                        // Show loading indication
                                        submitButton.setAttribute('data-kt-indicator', 'on');

                                        // Disable button to avoid multiple clicks
                                        submitButton.disabled = true;

                                        let data = $(form).serialize();

                                        $.ajax({
                                            type: 'POST',
                                            url: $(form).attr('action'),
                                            data: data,
                                            success: onFormSuccessCallBack,
                                            complete: function() {
                                                // Release button
                                                submitButton.removeAttribute(
                                                    'data-kt-indicator');

                                                // Re-enable button
                                                submitButton.disabled = false;
                                            },
                                            error: function(response, textStatus,
                                                errorThrown) {
                                                toastr.error(response.responseJSON
                                                    .message);
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            text: "Sorry, looks like there are some errors detected, please try again.",
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }

                    $('[data-control="select2"]').select2({
                        dropdownParent: $(modalId),
                        allowClear: true,
                    });
                },
                complete: function() {
                    if (button) {
                        button.removeAttr('data-kt-indicator');

                    }
                }
            });
        }
    </script> --}}
    <script>
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

    {{-- <script>
        function filterParameters() {
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
            return params;
        }
    </script> --}}
    @include('metronic.customJS')
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
    {{-- <script src="{{ asset('js/widgets.bundle.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/custom/widgets.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/custom/apps/chat/chat.js') }}"></script>
        <script src="{{ asset('js/custom/utilities/modals/upgrade-plan.js') }}"></script>
        <script src="{{ asset('js/custom/utilities/modals/users-search.js') }}"></script> --}}
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
