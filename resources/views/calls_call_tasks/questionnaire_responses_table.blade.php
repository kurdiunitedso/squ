<div class="d-flex flex-row mb-3">
    <span class="svg-icon svg-icon-2 svg-icon-primary">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.3"
                d="M18 22C19.7 22 21 20.7 21 19C21 18.5 20.9 18.1 20.7 17.7L15.3 6.30005C15.1 5.90005 15 5.5 15 5C15 3.3 16.3 2 18 2H6C4.3 2 3 3.3 3 5C3 5.5 3.1 5.90005 3.3 6.30005L8.7 17.7C8.9 18.1 9 18.5 9 19C9 20.7 7.7 22 6 22H18Z"
                fill="currentColor" />
            <path d="M18 2C19.7 2 21 3.3 21 5H9C9 3.3 7.7 2 6 2H18Z" fill="currentColor" />
            <path d="M9 19C9 20.7 7.7 22 6 22C4.3 22 3 20.7 3 19H9Z" fill="currentColor" />
        </svg>
    </span>
    <h4 class="ms-3 text-primary">
        {{ $questionnaire->title }}
    </h4>
</div>
<!--begin::Accordion-->
<div class="accordion accordion-icon-toggle" id="kt_accordion_2">
    <!--begin::Item-->
    <div class="mb-5">
        <!--begin::Header-->
        <div class="accordion-header py-3 d-flex collapsed" data-bs-toggle="collapse"
            data-bs-target="#kt_accordion_2_item_1">
            <span class="accordion-icon">
                <span class="svg-icon svg-icon-muted svg-icon-2"><svg width="24" height="24" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                            transform="rotate(-180 18 13)" fill="currentColor" />
                        <path
                            d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                            fill="currentColor" />
                    </svg>
                </span>
            </span>
            <h3 class="fs-4 fw-semibold mb-0 ms-4">Call Details</h3>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div id="kt_accordion_2_item_1" class="fs-6 collapse ps-10" data-bs-parent="#kt_accordion_2">
       {{--     <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Call Action</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $call->callAction->name }}</span>
                </div>
                <!--end::Col-->
            </div>--}}
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">CallTask Action</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $call->callTaskAction->name }}</span>
                </div>
                <!--end::Col-->
            </div>
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Employee</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $call->user->name }}</span>
                </div>
                <!--end::Col-->
            </div>
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Next Call</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $call->next_call->format('d/m/Y') }}</span>
                </div>
                <!--end::Col-->
            </div>
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Notes</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $call->notes }}</span>
                </div>
                <!--end::Col-->
            </div>
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Created at</label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $call->created_at->format('d/m/Y h:i:s A') }}</span>
                </div>
                <!--end::Col-->
            </div>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Item-->

</div>
<!--end::Accordion-->
<ul class="list-group">
    @foreach ($responses as $response)
        @if ($response->question)
            <li class="list-group-item">
                <div class="d-flex align-items-center">
                    <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                        <div class="symbol-label bg-light">

                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z"
                                    fill="currentColor" />
                                <path
                                    d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z"
                                    fill="currentColor" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-primary fw-bold">
                        {{ $response->question->text }}
                    </div>
                </div>
                <ul class="list-group p-3 ms-13">
                    <li class="list-group-item">
                        {{ $response->answer }}
                    </li>
                </ul>
            </li>
        @endif
    @endforeach
</ul>
