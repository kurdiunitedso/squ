@extends('metronic.index')

@section('title', 'Calls Calendar')
@section('subpageTitle', 'Calls Calendar')

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

                        <!--end::Search-->
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-user-table-filter="search"
                                class="form-control form-control-solid w-250px ps-14" placeholder="Search Employee" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->

                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="mw-40px">ID</th>
                                <th class="min-w-125px">Employee Name</th>

                                <th class="min-w-125px">Mobile Number</th>
                                <th class="min-w-125px">Role</th>
                                <th class="min-w-125px">Last Login</th>
                                <th class="text-end mw-100px">Actions</th>
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
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10 d-none">
        <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <!--begin::Card-->
            <div class="card" id="calendarCard">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        Calendar for
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->

                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <div id="kt_calendar_app"></div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>

    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_view_call_schedule" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">

        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->

    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_addedit_appointment" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">

        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->

@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}">
    <style>
        .flatpickr-day {
            color: var(--bs-text-dark);
            font-weight: 600 !important;
        }
    </style>
@endpush
@push('scripts')
    <script>
        var doctorId;
        var doctorScheduleUrl;
        var initCalendarApp;
        var calendar;
    </script>
    <script>
        const columnDefs = [{
                data: 'id',
                name: 'id',
                visible: false,
                searchable: false
            },
            {
                className: 'd-flex align-items-center',
                data: 'fullname',
                name: 'users.name',
            },
            {
                data: 'mobile',
                name: 'mobile',
            },

            {
                data: 'permissions',
                name: 'permissions.name',
                searchable: true,
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        var template = '';
                        // console.log(row);

                        if (Array.isArray(row.roles) && row.roles.length > 0) {
                            console.log(row.roles);
                            row.roles.forEach(element => {
                                template +=
                                    '<span class="badge badge-light-success fs-7 m-1"">' +
                                    element
                                    .name + '</span>';
                            });
                        }

                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(element => {
                                template +=
                                    '<span class="badge badge-light-primary fs-7 m-1"">' +
                                    element
                                    .name + '</span>';
                            });
                        }

                        return template;
                    }
                    return data;
                },
            },
            {
                data: 'last_login_at',
                name: 'last_login_at',
                render: function(data, type) {
                    if (type === 'display') {
                        return '<div class="badge badge-light fw-bold">' + data + '</div>'
                    }
                    return data;
                }
            },
            {
                data: 'action',
                name: 'action',
                className: 'text-end',
                orderable: false,
                searchable: false
            }
        ];
        // var datatable = createDataTable('#kt_table_users', columnDefs, "{{ route('doctors.getDoctors') }}", [
        //     [0, "ASC"]
        // ]);
        var tableDOM = document.querySelector('#kt_table_users');
        var params = null;
        var table = $(tableDOM).DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            searchDelay: 1050,
            pageLength: 5,
            lengthMenu: [5, 10, 50],
            ajax: {
                url: "{{ route('callschedule.index') }}",
                type: "POST",
                data: function(d) {
                    d.params = params;
                },
            },
            columns: columnDefs,
            order: [
                [0, "ASC"]
            ]
        });
        $('#kt_table_users tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            }

        });
    </script>
    <script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>

    <script>
        // const kt_modal_view_call_schedule = document.getElementById('kt_modal_view_call_schedule');
        // const modal_kt_modal_view_call_schedule = new bootstrap.Modal(kt_modal_view_call_schedule);

        function formatDateCustom(date) {
            var year = date.getFullYear();
            var month = String(date.getMonth() + 1).padStart(2,
                '0');
            var day = String(date.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        }

        function refreshDoctorWorkingDayNames(url, inputId, onChange, onComplete) {

            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    var allowedDays = data.allowedDays
                    var disabledDates = data.offDays;
                    console.log(inputId);
                    $(inputId).flatpickr({
                        disable: [
                            function(date) {
                                // Get the day name of the current date
                                var dayName = date.toLocaleDateString('en-US', {
                                    weekday: 'long'
                                });

                                // Check if the day name is in the allowedDays array
                                if (!allowedDays.includes(dayName)) {
                                    return true; // Disable days not in the allowedDays array
                                }
                                // Get the date in yyyy-mm-dd format using local time zone
                                var dateString = formatDateCustom(date);

                                // Check if the date is in the disabledDates array
                                return disabledDates.includes(dateString);
                            }
                        ],
                        onReady: function(selectedDates, dateStr, instance) {
                            // var calendar = instance.calendarContainer;
                            // console.log(instance.calendarContainer);
                            // Loop through each date in the calendar
                            instance.calendarContainer.querySelectorAll(
                                '.flatpickr-day').forEach(function(day) {
                                var date = day.dateObj;
                                var dayName = date.toLocaleDateString('en-US', {
                                    weekday: 'long'
                                });

                                var dateString = formatDateCustom(date);
                                if (disabledDates.includes(dateString)) {
                                    day.classList.add('bg-light-danger');
                                    day.classList.add(
                                        'text-decoration-line-through');
                                }

                            });
                        },
                        onMonthChange: function(selectedDates, dateStr, instance) {
                            // var calendar = instance.calendarContainer;
                            // Loop through each date in the calendar
                            instance.calendarContainer.querySelectorAll(
                                '.flatpickr-day').forEach(function(day) {
                                var date = day.dateObj;
                                var dayName = date.toLocaleDateString('en-US', {
                                    weekday: 'long'
                                });

                                var dateString = formatDateCustom(date);
                                if (disabledDates.includes(dateString)) {
                                    day.classList.add('bg-light-danger');
                                    day.classList.add(
                                        'text-decoration-line-through');
                                }

                            });
                        },
                        enableTime: false,
                        dateFormat: "Y-m-d",
                        onChange: onChange,
                        // time_24hr: true,
                    });
                },
                error: function(response, textStatus,
                    errorThrown) {
                    toastr.error(response
                        .responseJSON
                        .message);
                },
                complete: onComplete
            });
        }

        const element = document.getElementById('kt_modal_view_call_schedule');
        const modal = new bootstrap.Modal(element);



        function renderModal(url, button) {
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    $('#kt_modal_view_call_schedule').find('.modal-dialog').html(response.createView);
                    // $('#AddEditModal').modal('show');
                    modal.show();
                    KTScroll.createInstances();

                    const form = element.querySelector('#kt_modal_add_call_form');

                    var validator = FormValidation.formValidation(
                        form, {
                            fields: {
                                'next_call': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Next call date is required'
                                        }
                                    }
                                },
                                'sick_fund_id': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Sick fund is required'
                                        }
                                    }
                                },
                                'patient_clinic_id': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Patient Clinic is required'
                                        }
                                    }
                                },
                                'validation_date': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Validation date is required'
                                        }
                                    }
                                },
                                'call_action_id': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Call Action is required'
                                        }
                                    }
                                },
                                'debit_action_id': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Debit Action is required'
                                        }
                                    }
                                },
                                'user_id': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Employee is required'
                                        }
                                    }
                                },
                                'notes': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Notes is required'
                                        }
                                    }
                                },
                            },

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

                    // Submit button handler
                    const submitButton = element.querySelector('[data-kt-call-modal-action="submit"]');
                    submitButton.addEventListener('click', function(e) {
                        // Prevent default button action
                        e.preventDefault();

                        const formAdd = document.getElementById('kt_modal_add_call_form');
                        // Validate form before submit
                        if (validator) {
                            validator.validate().then(function(status) {
                                console.log('validated!');

                                if (status == 'Valid') {
                                    // Show loading indication
                                    submitButton.setAttribute('data-kt-indicator',
                                        'on');
                                    // Disable button to avoid multiple click
                                    submitButton.disabled = true;

                                    let data = $(formAdd).serialize();

                                    $.ajax({
                                        type: 'POST',
                                        url: $(formAdd).attr('action'),
                                        data: data,
                                        success: function(response) {
                                            toastr.success(response.message);
                                            form.reset();
                                            modal.hide();
                                        },
                                        complete: function() {
                                            // KTUtil.btnRelease(btn);
                                            submitButton.removeAttribute(
                                                'data-kt-indicator');
                                            // Disable button to avoid multiple click
                                            submitButton.disabled = false;
                                        },
                                        error: function(response, textStatus,
                                            errorThrown) {
                                            toastr.error(response.responseJSON
                                                .message);
                                        },
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

                    $('[data-control="select2"]').select2({
                        dropdownParent: $('#kt_modal_view_call_schedule'),
                        allowClear: true,
                    });

                    var target_blockUIQuestions = document.querySelector("#kt_block_ui_4_target");
                    var blockUIQuestions = new KTBlockUI(target_blockUIQuestions, {
                        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
                    });

                    $('#call_questionnaire_id').on('select2:clear', function(e) {
                        $(".questions_list").each(function(i, e) {
                            validator.removeField($(this).attr('name'));
                        });
                        $('#questionnaire-questions-container').html('');
                    });

                    $('#call_questionnaire_id').on('change', function(e) {

                        $(".questions_list").each(function(i, e) {
                            validator.removeField($(this).attr('name'));
                        });

                        var url = $(this).val();
                        console.log($(this).val());
                        e.preventDefault();
                        blockUIQuestions.block();
                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: "json",
                            success: function(response) {
                                $('#questionnaire-questions-container').html(response
                                    .questionsList);

                                // Validate Questions


                                const ResponseValidators = {
                                    validators: {
                                        notEmpty: {
                                            message: 'Response is required',
                                        },
                                    },
                                };


                                $(".questions_list").each(function(i, e) {
                                    validator.addField($(this).attr('name'),
                                        ResponseValidators)
                                });
                            },
                            complete: function() {
                                blockUIQuestions.release();
                            }
                        });
                    });


                    var dueDate = $(form.querySelector('[name="next_call"]'));
                    dueDate.flatpickr({
                        enableTime: false,
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        allowInput: true,
                    });

                    var validaionDate = $(form.querySelector('[name="validation_date"]'));
                    validaionDate.flatpickr({
                        enableTime: false,
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        allowInput: true,
                    });


                },
                complete: function() {
                    if (button)
                        button.removeAttr('data-kt-indicator');
                }

            });
        }

        $(function() {

            var calendarElTarget = document.querySelector("#kt_calendar_app");
            var CalendarblockUI = new KTBlockUI(calendarElTarget);

            initCalendarApp = function() {
                // Define variables
                var calendarEl = document.getElementById('kt_calendar_app');
                var todayDate = moment().startOf('day');
                var TODAY = todayDate.format('YYYY-MM-DD');

                // Init calendar --- more info: https://fullcalendar.io/docs/initialize-globals
                calendar = new FullCalendar.Calendar(calendarEl, {
                    //locale: 'es', // Set local --- more info: https://fullcalendar.io/docs/locale
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'listWeek'
                    },
                    initialDate: TODAY,
                    navLinks: true, // can click day/week names to navigate views
                    selectable: false,
                    selectMirror: true,
                    eventOverlap: false,
                    initialView: "listWeek",
                    allDaySlot: true,
                    // locale: 'en',
                    slotMinTime: "07:00:00",
                    // slotMaxTime: "18:00:00",
                    select: function(arg) {
                        //   handleNewEvent();

                        var startStr = arg.startStr;
                        var endStr = arg.endStr;
                        var apptDate = moment(startStr).format("YYYY-MM-DD");
                        const startTime = moment(startStr).format('HH:mm');
                        const endTime = moment(endStr).format('HH:mm');
                        window.handleNewEvent(doctorId, apptDate, startTime, endTime);
                    },
                    loading: function(isLoading) {
                        // console.log(isLoading);
                        isLoading ? CalendarblockUI.block() : CalendarblockUI.release();
                    },
                    // Click event --- more info: https://fullcalendar.io/docs/eventClick
                    eventClick: function(arg) {
                        // console.log('eventClick', arg.event);
                        // console.log('extendedProps', arg.event.extendedProps);
                        // if (Object.keys(arg.event.extendedProps).length == 0) {
                        //     var startStr = arg.event.startStr;
                        //     var endStr = arg.event.endStr;
                        //     var apptDate = moment(startStr).format("YYYY-MM-DD");
                        //     const startTime = moment(startStr).format('HH:mm');
                        //     const endTime = moment(endStr).format('HH:mm');

                        //     window.handleNewEvent(doctorId, apptDate, startTime,
                        //         endTime);
                        // } else {
                        //     window.handleViewEvent(arg.event.extendedProps.id);
                        // }
                        // arg.event.extendedProps.id
                        // console.log(arg.event);
                        // const modalId = "#kt_modal_view_call_schedule";
                        // $.ajax({
                        //     type: "GET",
                        //     url: arg.event.extendedProps.url,
                        //     dataType: "json",
                        //     success: function(response) {
                        //         $(modalId).find('.modal-dialog').html(response
                        //             .createView);

                        //         KTScroll.createInstances();
                        //         modal_kt_modal_view_call_schedule.show();

                        //     },
                        //     complete: function() {

                        //     }
                        // });
                        const url = arg.event.extendedProps.url;
                        renderModal(url, '');

                    },
                    //   eventDragStop: function(info) {
                    //       console.log('eventDragStop', info.event.start);
                    //   },


                    selectOverlap: false,
                    editable: false,
                    dayMaxEvents: true, // allow "more" link when too many events
                    slotDuration: '00:05',
                    eventMinHeight: 30,
                    eventShortHeight: 50,
                    slotEventOverlap: false,
                    timeZone: 'Asia/Jerusalem',
                    // aspectRatio: 2,
                    views: {
                        listWeek: { // Allow only the listWeek view
                            type: 'listWeek',
                            buttonText: 'List'
                        },
                    },
                    // refetchResourcesOnNavigate: true,
                    events: function(info, successCallback, failureCallback) {
                        // totalProcessingAppointemntsBlockUI.block();
                        // totalBookedAppointemntsBlockUI.block();
                        // totalCanceledAppointemntsBlockUI.block();

                        // var ckshowAvailableSessions = $('#ckshowAvailableSessions').is(":checked");
                        // var ckshowOffDays = $('#ckshowOffDays').is(":checked");
                        var url = doctorScheduleUrl;
                        $.ajax({
                            url: url,
                            data: {
                                start: info.startStr.valueOf(),
                                end: info.endStr.valueOf(),
                            },
                            type: 'GET',
                            success: function(response) {

                                var events = [];

                                for (var i = 0; i < response.events.length; i++) {
                                    var eventData = response.events[i];
                                    var event = {};

                                    for (var key in eventData) {
                                        if (eventData.hasOwnProperty(key)) {
                                            event[key] = eventData[key];
                                        }
                                    }

                                    events.push(event);
                                }
                                //   console.log(response);
                                successCallback(events);
                            },
                            error: function(xhr, status, error) {
                                // Handle the error condition
                                console.error(error);
                                failureCallback(error);
                            },
                            complete: function() {}
                        });
                    },

                    // Handle changing calendar views --- more info: https://fullcalendar.io/docs/datesSet
                    datesSet: function(dateInfo) {},
                    eventDidMount: function(info) {
                        if (info.event.textColor) {
                            info.el.style.color = info.event.textColor;
                        }
                    },
                    viewDidMount: function(view, el) {
                        console.log(view, el);
                        //   calendar.updateSize();
                        //   calendar.refetchEvents();
                    }
                });

                calendar.render();

                //   setTimeout(() => {
                //       calendar.updateSize();
                //   }, 200);


            }


            // initCalendarApp();



            // $(document).on('click', "#ckshowAvailableSessions", function(e) {
            //     calendar.refetchEvents();
            // })


            // $(document).on('click', "#ckshowOffDays", function(e) {
            //     calendar.refetchEvents();
            // })

            // Get the day heading elements in the list view
            $(document).on('click', '.fc-list-day-side-text, .fc-list-day-text', function(e) {
                // Get the date from the data-date attribute
                var clickedDate = $(this).text();

                // alert(clickedDate);
                // Redirect to your desired page with the clicked date
                window.location.href = "{{ route('marketing_calls.index') }}?date=" + clickedDate;
            });
        });
    </script>
    {{-- @include('internalAppointments.popup.scripts') --}}

    <script>
        $(function() {


            const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
            filterSearch.onkeydown = debounce(keyPressCallback, 400);

            function keyPressCallback() {
                table.column(1).search(filterSearch.value).draw();
            }

            $(document).on('click', '.btnSelectDoctor', function(e) {
                e.preventDefault();

                $("#calendarCard").parents('.row').removeClass('d-none');




                table.$('tr.selected').removeClass('selected');
                $(this).parents('tr').addClass('selected');
                doctorId = $(this).attr('data-doctor-id');
                employeeName = $(this).attr('data-emp-name');
                doctorScheduleUrl = $(this).attr('href');

                $("#calendarCard").find('.card-title').text('Calendar for ' + employeeName);


                if (typeof calendar == "object")
                    calendar.refetchEvents();
                else
                    initCalendarApp();

                $('html, body').animate({
                    scrollTop: $("#calendarCard").offset().top
                }, 500);
            })
        });
    </script>
@endpush
