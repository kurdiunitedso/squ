@extends('metronic.indexEmpty')

@section('css')

@stop
@push('scripts')
    {{-- <script src="cp/js/helper.js" type="text/javascript"></script>--}}
    <script>
        setInterval(function () {

            var mobile = $("#chat_mobile").val();
            var sender = $("#chat_sender").val();
            var patient = $("#chat_patient").val();
            var thisDiv = jQuery('.scrollWhatApp');
            $.ajax({
                url: '/getWhatsAppMessage?mobile=' + mobile + "&patient=" + patient + "&sender=" + sender + "&limit=10",
                success: function (data) {
                    thisDiv.find('.messagesWhatApp').append(data);
                },
                beforeSend: function () {


                },
                complete: function () {
                    let a = parseFloat(($('.scrollWhatApp').prop("scrollHeight"))) - parseFloat($('.scrollWhatApp').scrollTop());
                    console.log(a);
                    if (a < 900) {
                        $('.scrollWhatApp').scrollTop($('.scrollWhatApp').prop("scrollHeight"));
                    } else {

                    }

                },
                dataType: 'html'
            });

        }, 5000);
        $("#AddAttachmentModal").attr('link', 'dashbaord/createAtt?sender={{$sender}}&mobile={{$mobile}}');
        $(".searchWhatClickChat").on('click', function () {
            jQuery('.messagesWhatApp').html('<div class="spinner spinner-primary spinner-lg spinner-center"></div><br><br>');
            var mobile = $("#chat_mobile").val();
            var sender = $("#chat_sender").val();
            var patient = $("#chat_patient").val();
            var thisDiv = jQuery('.scrollWhatApp');
            var searchinput = jQuery('.searchinputWhatChat').val();
            $.ajax({
                url: 'crm/general/getWhatsAppMessage?mobile=' + mobile + "&patient=" + patient + "&search=1&sender=" + sender + "&inputsearch="+searchinput,
                success: function (data) {
                    thisDiv.find('.messagesWhatApp').html(data);
                },
                beforeSend: function () {


                },
                complete: function () {


                },
                dataType: 'html'
            });
        });

        $(".searchWhatCloseChat").on('click', function () {
            jQuery('.messagesWhatApp').html('<div class="spinner spinner-primary spinner-lg spinner-center"></div><br><br>');
            var mobile = $("#chat_mobile").val();
            var sender = $("#chat_sender").val();
            var patient = $("#chat_patient").val();
            var thisDiv = jQuery('.scrollWhatApp');
            var searchinput = '';
            $.ajax({
                url: 'crm/general/getWhatsAppMessage?mobile=' + mobile + "&patient=" + patient + "&sender=" + sender + "&search=1&inputsearch="+searchinput,
                success: function (data) {
                    thisDiv.find('.messagesWhatApp').html(data);
                },
                beforeSend: function () {


                },
                complete: function () {


                },
                dataType: 'html'
            });

        });



        $('.scrollWhatApp').scrollTop($('.scrollWhatApp').prop("scrollHeight"));
    </script>

    <script>
        const element = document.getElementById('kt_modal_add_attachment');
        const modal = new bootstrap.Modal(element);

        function renderModal(url, button) {
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    $('#kt_modal_add_attachment').find('.modal-dialog').html(response.createView);
                    // $('#AddEditModal').modal('show');
                    modal.show();
                    KTScroll.createInstances();
                    KTImageInput.createInstances();

                    const form = element.querySelector('#kt_modal_add_attachment_form');

                    var validator = FormValidation.formValidation(
                        form, {
                            fields: {
                                'attachment_type_id': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Attachment type is required'
                                        }
                                    }
                                },
                                'attachment_file': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Attachment file is required'
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
                    const submitButton = element.querySelector('[data-kt-attachments-modal-action="submit"]');
                    submitButton.addEventListener('click', function(e) {
                        // Prevent default button action
                        e.preventDefault();

                        var formAddEdit = $("#kt_modal_add_attachment_form");
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
                                    var attachment_file = $(form).find(
                                        'input[type="file"]');

                                    var formData = new FormData();

                                    $.each(formAddEdit.serializeArray(), function(i,
                                                                                  field) {
                                        formData.append(field.name, field.value);
                                    });

                                    formData.append('attachment_file', attachment_file[0].files[
                                        0]);

                                    console.log(formData);
                                    $.ajax({
                                        type: 'POST',
                                        url: formAddEdit.attr('action'),
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        success: function(response) {
                                            toastr.success(response.message);
                                            form.reset();
                                            modal.hide();
                                            datatable.ajax.reload(null, false);
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


                    $('#attachment_type_id').select2({
                        dropdownParent: $('#kt_modal_add_attachment')
                    });

                },
                complete: function() {
                    if (button)
                        button.removeAttr('data-kt-indicator');
                }

            });
        }



        $(document).on('click', '#AddAttachmentModal', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            renderModal("{{ route('dashboard.createAtt') }}?sender={{$sender}}&mobile={{$mobile}}", $(this));
        });
    </script>
@endpush
@section('content')

    <div class="" datatable="datatable" item_id="0" id="wa_chat_modal"
         role="dialog"
         data-backdrop="false">
        <div class="modal-dialog-centered" role="document">
            <div class="modal-content">
                <!--begin::Card-->
                <div class="card card-custom">
                    <!--begin::Header-->
                    <div class="card-header align-items-center px-4 py-3">

                        <div class="text-center flex-grow-1">
                            <div class="text-dark-75 font-weight-bold font-size-h5 whatsAppTtile">
                                <i class="la la-whatsapp text-success icon icon-xl"></i> Whatsapp {{$mobile}}
                                -{{$patient}}
                            </div>
                            {{--<div>
                                <span class="label label-dot label-success"></span>
                                <span class="font-weight-bold text-muted font-size-sm">Active</span>
                            </div>--}}
                        </div>

                        <div data-kt-search-element="form" class="w-100 position-relative mb-5"
                             autocomplete="off">
                            <!--begin::Hidden input(Added to disable form autocomplete)-->
                            <input type="hidden" wfd-invisible="true">
                            <!--end::Hidden input-->

                            <!--begin::Icon-->
                            <i class="ki-duotone searchWhatClickChat ki-magnifier fs-2 fs-lg-1 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"><span
                                    class="path1"></span><span class="path2"></span></i>
                            <!--end::Icon-->

                            <!--begin::Input-->
                            <input type="text"
                                   class="form-control searchinputWhatChat form-control-lg form-control-solid px-15"
                                   name="inputsearchWhat" value="" placeholder="Search "
                                   data-kt-search-element="input">
                            <!--end::Input-->

                            <!--begin::Spinner-->
                            <span class="position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none"
                                  data-kt-search-element="spinner" wfd-invisible="true">
                        <span class="spinner-border h-15px w-15px align-middle text-gray-500"></span>
                    </span>
                            <!--end::Spinner-->

                            <!--begin::Reset-->
                            <span
                                class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 searchWhatCloseChat"
                                data-kt-search-element="clear" wfd-invisible="true">
                        <i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0"><span class="path1"></span><span
                                class="path2"></span></i>                    </span>
                            <!--end::Reset-->

                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Scroll-->
                        <div class="scrollWhatApp scroll scroll-pull">
                            <div class="messages messagesWhatApp">


                                @for($i=(count($messages)-1);$i>=0;$i-- )
                                    @php
                                        $m=$messages[$i];
                                        $time=date('Y-m-d H:i',$m->time);
                                        if ($m->type != 'chat' && $m->type != 'interactive' && $m->type != 'chat')  {
                                                                               $body = '<a href="' . $m->body . '" target="_blank"> click here ' . $m->caption . '</a>';
                                                                           } else {
                                                                               $body =  $m->body ;
                                                                           }
                                    @endphp
                                    @if($m->fromMe==0)
                                        <div class="d-flex flex-column mb-5 align-items-start">
                                            <div class="d-flex align-items-center">

                                                <div>
                                                    <a href="#"
                                                       class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">{{$patient}}</a>
                                                    <span class="text-muted font-size-sm">{{$time}}</span>
                                                </div>
                                            </div>
                                            <div
                                                class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                                                {!! $body !!}
                                            </div>
                                        </div>
                                    @endif
                                    @if($m->fromMe==1)
                                        <div class="d-flex flex-column mb-5 align-items-end">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <span class="text-muted font-size-sm">{{$time}}</span>
                                                    <a href="#"
                                                       class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">{{$sender}}</a>
                                                </div>

                                            </div>
                                            <div
                                                class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
                                                {!! $body !!}
                                            </div>
                                        </div>
                                    @endif
                                @endfor


                            </div>
                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <form id="fromWhatsApp">
                        <div class="card-footer align-items-center">
                            <!--begin::Compose-->
                            <input type="hidden" name="mobile" id="chat_mobile" value="{{$mobile}}">
                            <input type="hidden" name="sender" id="chat_sender" value="{{$sender}}">
                            <input type="hidden" name="patient" id="chat_patient" value="{{$patient}}">
                            <textarea class="form-control border-0 p-0" rows="2" id="chat_message"
                                      name="message"
                                      placeholder="Type a message">{{$message}}</textarea>
                            <div class="d-flex align-items-center justify-content-between mt-5">

                                <div class="mr-3">
                                    <a href="#" class="btn btn-sm btn-success ms-5" id="AddAttachmentModal">
                            <span class="indicator-label">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                              rx="10" fill="currentColor" />
                                        <rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                              transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                        <rect x="6.01041" y="10.9247" width="12" height="2" rx="1"
                                              fill="currentColor" />
                                    </svg>
                                </span>
                                Add New Attachment</span>
                                        <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                                    </a>
                                </div>
                                <div>
                                    <button type="button"
                                            class="btn btn-primary btn-md text-uppercase font-weight-bold whatsApp-send py-2 px-6">
                                        Send
                                    </button>
                                </div>
                            </div>
                            <!--begin::Compose-->
                        </div>
                    </form>
                    <!--end::Footer-->
                </div>
                <!--end::Card-->
            </div>
        </div>
    </div>
    <div class="modal fade" id="kt_modal_add_attachment" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>
@stop

