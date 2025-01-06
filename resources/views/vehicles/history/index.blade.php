
    <div>
        <div class="card mb-5 mb-xl-10" id="kt_captin_attachments_details_view">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Captin Audit History</h3>
                </div>

                <!--begin::Toolbar-->
                <div class="card-toolbar m-0">
                    <!--begin::Tab nav-->
                    <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-bold" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a id="kt_captin_activity_tab"
                                class="nav-link justify-content-center text-active-gray-800 active" data-bs-toggle="tab"
                                role="tab" href="#kt_captin_activity">
                                Captin Logs
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a id="kt_captin_attachments_activity_tab"
                                class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab"
                                role="tab" href="#kt_captin_attachments_activity">
                                Attachments Logs
                            </a>
                        </li>
                    </ul>
                    <!--end::Tab nav-->
                </div>
                <!--end::Toolbar-->
            </div>


            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Tab panel-->
                <div class="tab-content">
                    <div id="kt_captin_activity" class="card-body p-0 tab-pane fade show active" role="tabpanel"
                        aria-labelledby="kt_captin_activity_tab">
                        <div class="timeline">
                            <!--begin::Timeline item-->

                            @foreach ($audits as $audit)
                                <div class="timeline-item">
                                    <!--begin::Timeline line-->
                                    <div class="timeline-line w-40px"></div>
                                    <!--end::Timeline line-->

                                    <!--begin::Timeline icon-->
                                    <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                        <div class="symbol-label bg-light">
                                            <i class="ki-duotone ki-message-text-2 fs-2 text-gray-500"><span
                                                    class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span></i>
                                        </div>
                                    </div>

                                    @php
                                        $metadata = $audit->getMetadata();
                                        $createdAt = $metadata['audit_created_at'];
                                        $formattedCreatedAt = \Carbon\Carbon::parse($createdAt)->format('Y-m-d H:i:s');

                                        // Update the 'audit_created_at' field in the metadata with the formatted value
                                        $metadata['audit_created_at'] = $formattedCreatedAt;
                                    @endphp

                                    <!--end::Timeline icon-->
                                    @if ($audit->event == 'updated')
                                        <!--begin::Timeline content-->
                                        <div class="timeline-content mb-10 mt-n1">
                                            <!--begin::Timeline heading-->
                                            <div class="pe-3 mb-5">
                                                <!--begin::Title-->
                                                <div class="fs-5 fw-semibold mb-2">
                                                    {{ ucfirst($audit->event) }} Captin Information</div>
                                                <!--end::Title-->

                                                <!--begin::Description-->
                                                <div class="d-flex align-items-center mt-1 fs-6">
                                                    <!--begin::Info-->
                                                    {{-- <div class="text-muted me-2 fs-7">Added at {{ $audit->created_at }} PM by
                                            {{ $audit->user->name }}</div> --}}



                                                    <div class="text-muted me-2 fs-7">@lang('captin.updated.metadata', $metadata)</div>
                                                    <!--end::Info-->

                                                    <!--begin::User-->
                                                    <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                                        data-bs-boundary="window" data-bs-placement="top"
                                                        aria-label="Nina Nilson" data-bs-original-title="Nina Nilson"
                                                        data-kt-initialized="1">
                                                        <img src="{{ $audit->user->avatar != null ? asset('images/' . $audit->user->avatar) : asset('media/avatars/blank.png') }}"
                                                            alt="img">
                                                    </div>
                                                    <!--end::User-->
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Timeline heading-->

                                            <!--begin::Timeline details-->
                                            <div class="overflow-auto pb-5">
                                                <!--begin::Record-->
                                                <ul class="list-group">
                                                    @foreach ($audit->getModified() as $attribute => $modified)
                                                        @if ($attribute == 'birth_date')
                                                            @php
                                                                $modified['new'] = \Carbon\Carbon::parse($modified['new'])->format('Y-m-d');
                                                                $modified['old'] = \Carbon\Carbon::parse($modified['old'])->format('Y-m-d');
                                                            @endphp
                                                        @endif
                                                        @if (
                                                            $attribute != 'sick_fund_id' &&
                                                                $attribute != 'id_type' &&
                                                                $attribute != 'marital_status_id' &&
                                                                $attribute != 'branch_id' &&
                                                                $attribute != 'city_id' &&
                                                                $attribute != 'membership_type' &&
                                                                $attribute != 'membership_subtype' &&
                                                                $attribute != 'relative_type_id')
                                                            <li class="list-group-item">@lang('captin.' . $audit->event . '.modified.' . $attribute, $modified)</li>
                                                        @endif
                                                    @endforeach
                                                </ul>

                                            </div>
                                            <!--end::Timeline details-->
                                        </div>
                                    @else
                                        <div class="timeline-content mb-10 mt-n1">
                                            <!--begin::Timeline heading-->
                                            <div class="pe-3 mb-5">
                                                <!--begin::Title-->
                                                <div class="fs-5 fw-semibold mb-2">
                                                    {{ ucfirst($audit->event) }} Captin</div>
                                                <!--end::Title-->

                                                <!--begin::Description-->
                                                <div class="d-flex align-items-center mt-1 fs-6">
                                                    <!--begin::Info-->
                                                    {{-- <div class="text-muted me-2 fs-7">Added at {{ $audit->created_at }} PM by
                                        {{ $audit->user->name }}</div> --}}



                                                    <div class="text-muted me-2 fs-7">@lang('captin.' . $audit->event . '.metadata', $metadata)</div>
                                                    <!--end::Info-->

                                                    <!--begin::User-->
                                                    <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                                        data-bs-boundary="window" data-bs-placement="top"
                                                        aria-label="Nina Nilson" data-bs-original-title="Nina Nilson"
                                                        data-kt-initialized="1">
                                                        <img src="{{ $audit->user->avatar != null ? asset('images/' . $audit->user->avatar) : asset('media/avatars/blank.png') }}"
                                                            alt="img">
                                                    </div>
                                                    <!--end::User-->
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Timeline heading-->
                                        </div>
                                    @endif

                                    <!--end::Timeline content-->
                                </div>
                            @endforeach
                        </div>
                        {{-- {{ $audits->links() }} --}}
                        @if (count($audits) == 0)
                            <p>@lang('captin.unavailable_audits')</p>
                        @endif
                    </div>

                    <div id="kt_captin_attachments_activity" class="card-body p-0 tab-pane fade" role="tabpanel"
                        aria-labelledby="kt_captin_attachments_activity_tab">
                        <div class="timeline">
                            <!--begin::Timeline item-->
                            @foreach ($attachmentAudits as $audit)
                                <div class="timeline-item">
                                    <!--begin::Timeline line-->
                                    <div class="timeline-line w-40px"></div>
                                    <!--end::Timeline line-->

                                    <!--begin::Timeline icon-->
                                    <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                        <div class="symbol-label bg-light">
                                            <i class="ki-duotone ki-message-text-2 fs-2 text-gray-500"><span
                                                    class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span></i>
                                        </div>
                                    </div>

                                    @php
                                        $metadata = $audit->getMetadata();
                                        $createdAt = $metadata['audit_created_at'];
                                        $formattedCreatedAt = \Carbon\Carbon::parse($createdAt)->format('Y-m-d H:i:s');

                                        // Update the 'audit_created_at' field in the metadata with the formatted value
                                        $metadata['audit_created_at'] = $formattedCreatedAt;
                                    @endphp

                                    <!--end::Timeline icon-->
                                    @if ($audit->event == 'updated')
                                        <!--begin::Timeline content-->
                                        <div class="timeline-content mb-10 mt-n1">
                                            <!--begin::Timeline heading-->
                                            <div class="pe-3 mb-5">
                                                <!--begin::Title-->
                                                <div class="fs-5 fw-semibold mb-2">
                                                    {{ ucfirst($audit->event) }} Captin Attachment</div>
                                                <!--end::Title-->

                                                <!--begin::Description-->
                                                <div class="d-flex align-items-center mt-1 fs-6">
                                                    <!--begin::Info-->
                                                    {{-- <div class="text-muted me-2 fs-7">Added at {{ $audit->created_at }} PM by
                                            {{ $audit->user->name }}</div> --}}



                                                    <div class="text-muted me-2 fs-7">@lang('captin.updated.metadata', $metadata)</div>
                                                    <!--end::Info-->

                                                    <!--begin::User-->
                                                    <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                                        data-bs-boundary="window" data-bs-placement="top"
                                                        aria-label="Nina Nilson" data-bs-original-title="Nina Nilson"
                                                        data-kt-initialized="1">
                                                        <img src="{{ $audit->user->avatar != null ? asset('images/' . $audit->user->avatar) : asset('media/avatars/blank.png') }}"
                                                            alt="img">
                                                    </div>
                                                    <!--end::User-->
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Timeline heading-->

                                            <!--begin::Timeline details-->
                                            <div class="overflow-auto pb-5">
                                                <!--begin::Record-->
                                                <ul class="list-group">
                                                    @foreach ($audit->getModified() as $attribute => $modified)
                                                        @if ($attribute == 'birth_date')
                                                            @php
                                                                $modified['new'] = \Carbon\Carbon::parse($modified['new'])->format('Y-m-d');
                                                                $modified['old'] = \Carbon\Carbon::parse($modified['old'])->format('Y-m-d');
                                                            @endphp
                                                        @endif
                                                        <li class="list-group-item">@lang('captin.' . $audit->event . '.modified.' . $attribute, $modified)</li>
                                                    @endforeach
                                                </ul>

                                            </div>
                                            <!--end::Timeline details-->
                                        </div>
                                    @else
                                        <div class="timeline-content mb-10 mt-n1">
                                            <!--begin::Timeline heading-->
                                            <div class="pe-3 mb-5">
                                                <!--begin::Title-->
                                                <div class="fs-5 fw-semibold mb-2">
                                                    {{ ucfirst($audit->event) }} Attachment</div>
                                                <!--end::Title-->

                                                <!--begin::Description-->
                                                <div class="d-flex align-items-center mt-1 fs-6">
                                                    <!--begin::Info-->
                                                    {{-- <div class="text-muted me-2 fs-7">Added at {{ $audit->created_at }} PM by
                                        {{ $audit->user->name }}</div> --}}



                                                    <div class="text-muted me-2 fs-7">@lang('captin.' . $audit->event . '.metadata', $metadata)</div>
                                                    <!--end::Info-->

                                                    <!--begin::User-->
                                                    <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                                        data-bs-boundary="window" data-bs-placement="top"
                                                        aria-label="Nina Nilson" data-bs-original-title="Nina Nilson"
                                                        data-kt-initialized="1">
                                                        <img src="{{ $audit->user->avatar != null ? asset('images/' . $audit->user->avatar) : asset('media/avatars/blank.png') }}"
                                                            alt="img">
                                                    </div>
                                                    <!--end::User-->
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Timeline heading-->
                                        </div>
                                    @endif

                                    <!--end::Timeline content-->
                                </div>
                            @endforeach
                        </div>
                        {{-- {{ $attachmentAudits->links() }} --}}
                        @if (count($attachmentAudits) == 0)
                            <p>@lang('captin.unavailable_attachments_audits')</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_add_attachment" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->


