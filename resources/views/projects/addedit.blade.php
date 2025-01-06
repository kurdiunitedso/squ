@php
    // dd($item_model);
    use App\Models\Project;
    use App\Models\Contract;
    use App\Models\ClientTrillion;
    use App\Models\ContractItem;
    use App\Models\ProjectEmployee;
    use App\Models\Task;
    // dd();
@endphp
@extends('metronic.index')


@section('subpageTitle', $item_model::ui['p_ucf'])

@section('title', t($item_model::ui['s_ucf'] . '- Add new ' . $item_model::ui['s_ucf']))
@section('subpageTitle', $item_model::ui['s_ucf'])
@section('subpageName', 'Add new ' . $item_model::ui['s_ucf'])
@push('styles')
    <link href="{{ asset('css/custom.css?v=1') }}" rel="stylesheet" type="text/css" />
@endpush


@section('content')
    @php
        $alertTypes = [
            'error' => [
                'class' => 'alert-danger',
                'icon' =>
                    '<i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>',
                'title' => t('Something went wrong!'),
                'message' => t('Please check your inputs, the error messages are:'),
            ],
            'success' => [
                'class' => 'alert-success',
                'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                    <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor" />
                </svg>',
                'title' => t('Success!'),
                'message' => '',
            ],
        ];
    @endphp

    @foreach (['error', 'success'] as $alertType)
        @if ($alertType === 'error' && ($errors->any() || session('error')))
            <div class="alert {{ $alertTypes[$alertType]['class'] }} d-flex align-items-center p-5 mb-10">
                {!! $alertTypes[$alertType]['icon'] !!}
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-{{ $alertType }}">{{ $alertTypes[$alertType]['title'] }}</h4>
                    <span>{{ $alertTypes[$alertType]['message'] }}</span>
                    <ul>
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endif
                        @if (session('error'))
                            <li>{{ session('error') }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        @elseif($alertType === 'success' && session('status'))
            <div class="alert {{ $alertTypes[$alertType]['class'] }} d-flex align-items-center p-5">
                <span class="svg-icon svg-icon-2hx svg-icon-{{ $alertType }} me-3">
                    {!! $alertTypes[$alertType]['icon'] !!}
                </span>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-{{ $alertType }}">{{ session('status') }}</h4>
                </div>
            </div>
        @endif
    @endforeach
    <!--begin::Content container-->
    <div class="card mb-5 mb-xl-5" id="kt_department_form_tabs">
        <div class="card-body pt-0 pb-0">
            <div class="d-flex flex-column flex-lg-row justify-content-between">
                <!--begin::Navs-->
                <ul id="myTab"
                    class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold order-lg-1 order-2">

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 active" data-bs-toggle="tab"
                            data-bs-target="#kt_tab_pane_1" href="#kt_tab_pane_1">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t($item_model::ui['s_ucf']) }}
                        </a>
                    </li>

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5
                        {{ app()->request->active == 'workflow' ? 'active' : '' }}"
                            @disabled(!$item_model->exists) data-bs-toggle="tab" data-bs-target="#kt_tab_pane_2"
                            href="#kt_tab_pane_2">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t('Workflow') }}
                        </a>
                    </li>

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6  px-2 py-5
                          {{ app()->request->active == Task::ui['route'] ? 'active' : '' }}   "
                            @disabled(!$item_model->exists) @disabled($item_model->projectEmployees->count() == 0) data-bs-toggle="tab" id="items"
                            data-bs-target="#kt_tab_pane_3" href="#kt_tab_pane_3">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{ t(Task::ui['s_ucf']) }}
                        </a>
                    </li>


                    <!--end::Nav item-->
                    <!--begin::Nav item-->


                    {{-- <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($item_model) ? '' : 'disabled' }}"
                            data-bs-toggle="tab" data-bs-target="#kt_tab_pane_7" href="#kt_tab_pane_7">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{ __('Attachments') }} </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($item_model) ? '' : 'disabled' }}"
                            data-bs-toggle="tab" data-bs-target="#kt_tab_pane_history" href="#kt_tab_pane_history">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{ __('History') }} </a>
                    </li> --}}


                    <!--end::Nav item-->
                    <!--begin::Nav item-->

                </ul>


            </div>
            <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center my-4">
                @if ($item_model->exists)
                    <h3 class="fw-bold mb-3 mb-md-0 text-break">
                        <span class="me-3">{{ t('Client Name') }}: <span class="text-primary text-decoration-underline">

                                @php
                                    $client_trillion = $item_model->contract->client_trillion ?? null;
                                    $client_trillion_name = isset($client_trillion) ? $client_trillion->name : null;
                                @endphp
                                @if (isset($client_trillion_name))
                                    <a target="_blank"
                                        href="{{ route(ClientTrillion::ui['route'] . '.edit', $client_trillion->id) }}">{{ $client_trillion_name }}</a>
                                @else
                                    NA
                                @endif


                            </span></span>
                        <span class="me-3">{{ t('Contract ID') }}: <span class="text-primary text-decoration-underline">
                                @php
                                    $contract_id = $item_model->contract_id;
                                @endphp
                                @if (isset($contract_id))
                                    <a target="_blank"
                                        href="{{ route(Contract::ui['route'] . '.edit', $contract_id) }}">{{ $contract_id }}</a>
                                @else
                                    NA
                                @endif
                            </span></span>
                        <span class="me-3">{{ t('Contract Duration') }}: <span
                                class="text-primary text-decoration-underline">
                                @php
                                    $contract_duration = optional($item_model->contract)->duration;
                                @endphp
                                @if (isset($contract_duration))
                                    <a target="_blank"
                                        href="{{ route(Contract::ui['route'] . '.edit', $contract_duration) }}">{{ $contract_duration }}</a>
                                @else
                                    NA
                                @endif
                            </span></span>
                        <span>{{ t('Service') }}: <span
                                class="text-primary text-decoration-underline">{{ $item_model->item->description ?? 'NA' }}</span></span>
                    </h3>
                @endif
                <div class="d-flex @if (!$item_model->exists) w-100 justify-content-end @endif">
                    <a href="{{ route($item_model::ui['route'] . '.index') }}" class="btn btn-sm btn-light me-2"
                        id="kt_user_follow_button">
                        <span class="svg-icon svg-icon-2">
                            <!-- SVG content remains unchanged -->
                        </span>
                        {{ __('Exit') }}
                    </a>
                    <a href="#" class="btn btn-sm btn-primary"
                        data-kt-{{ $item_model::ui['s_lcf'] }}-action="submit">
                        <span class="indicator-label">
                            <span class="svg-icon svg-icon-2">
                                <!-- SVG content remains unchanged -->
                            </span>
                            {{ __('Save Form') }}
                        </span>
                        <span class="indicator-progress">
                            {{ __('Please wait...') }} <span
                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </a>
                </div>
            </div>
            <!--begin::Navs-->
        </div>
    </div>
    <!--end::Content container-->
    <!--begin::Modal - Add task-->

    <form class="tab-content" id="{{ $item_model::ui['s_lcf'] }}_form" method="post"
        action="{{ route($item_model::ui['route'] . '.addedit') }}">
        @csrf
        @if ($item_model->exists)
            <input type="hidden" name="{{ $item_model::ui['_id'] }}" value="{{ $item_model->id }}">
        @endif
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{ t($item_model::ui['s_ucf'] . ' Details') }}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                @include($item_model::ui['route'] . '.form')



                <!--end::Card body-->
            </div>

        </div>
        <div class="tab-pane fade show
        {{ app()->request->active == 'workflow' ? 'active' : '' }}"
            id="kt_tab_pane_2" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        {{-- <h3 class="fw-bold m-0">{{ t('Workflow') }}</h3> --}}
                        <h2 class="mb-4">{{ t('Drag and drop the team members into selected fields') }}</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                @if ($item_model->exists)
                    @include($item_model::ui['route'] . '.workflow')
                @endif

                <!--end::Card body-->
            </div>

        </div>
        <div class="tab-pane fade
        {{ app()->request->active == Task::ui['route'] ? 'active' : '' }}"
            id="kt_tab_pane_3" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_itemes_details_view">
                <!--begin::Card header-->
                @if ($item_model->exists && $item_model->projectEmployees->count() > 0)
                    @include($item_model::ui['p_lcf'] . '.' . Task::ui['p_lcf'] . '.index')
                @endif
                <!--end::Card body-->
            </div>
        </div>
        {{-- <div class="tab-pane fade" id="kt_tab_pane_7" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_attachments_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        attachments
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @if (isset($item_model))
                        @include($item_model::ui['route'] . '.attachments.index')
                    @endif

                </div>
                <!--end::Card body-->
            </div>
        </div>


        <div class="tab-pane fade" id="kt_tab_pane_history" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_history_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        History
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">


                    @include($item_model::ui['route'] . '.history.index')


                </div>
                <!--end::Card body-->
            </div>
        </div> --}}

    </form>

    <div class="modal fade" id="kt_modal_general" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>


    <!-- Comments Modal -->
    <div class="modal fade" id="processCommentsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ t('Comments') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="commentsContainer" class="comments-container mb-4"></div>

                    <!-- Comment Form -->
                    <form id="commentForm" class="comment-form">
                        <div class="mb-3">
                            <textarea class="form-control" id="commentContent" rows="3" placeholder="{{ t('Add a comment...') }}"></textarea>
                        </div>

                        <!-- File Upload Area -->
                        <div class="file-upload-area mb-3">
                            <div class="dropzone" id="commentFileDropzone">
                                <div class="dz-message">
                                    {{ t('Drop files here or click to upload') }}
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ t('Post Comment') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- objectives tags input --}}
    <script>
        $(document).ready(function() {
            // Initialize main page objectives select
            const mainObjectivesSelect = initializeObjectivesSelect('#objectives-select');
        });
    </script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- renderValidate --}}
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        renderValidate('#{{ $item_model::ui['s_lcf'] }}_form',
            '[data-kt-{{ $item_model::ui['s_lcf'] }}-action="submit"]');
    </script>

    {{-- // Initialize the contract start date picker --}}
    <script>
        $(function() {
            initFlatpickr("input[name='start_date']", {
                minDate: "today"
            });
        });
    </script>

    {{-- contractItemModel --}}
    <script>
        $(document).ready(function() {
            // Step 1: Initialize constants and variables
            console.log('Step 1: Initializing constants and variables');
            const contractItemModel = "App\\Models\\ContractItem";
            const contractItemSelectName = '[name="{{ ContractItem::ui['_id'] }}"]';
            const contractItemPlaceholder = "Select {{ ContractItem::ui['s_ucf'] }}";
            const contractIdSelectName = '[name="contract_id"]';

            // Step 2: Parse item_model from PHP and get old input values
            console.log('Step 2: Parsing item_model from PHP and getting old input values');
            const itemModelJson = `@json($item_model->exists ? $item_model : null)`;
            const item_model = JSON.parse(itemModelJson);
            const oldContractId = '{{ old('contract_id', $item_model->contract_id ?? '') }}';
            const oldItemId = '{{ old(ContractItem::ui['_id'], $item_model->contract_item_id ?? '') }}';
            console.log('Parsed item_model:', item_model);
            console.log('Old contract ID:', oldContractId);
            console.log('Old item ID:', oldItemId);

            // Step 3: Define fetchAndSelectContractItems function
            console.log('Step 3: Defining fetchAndSelectContractItems function');

            function fetchAndSelectContractItems(contractId, selectedContractItemId = null) {
                console.log('Fetching contract items for contract ID:', contractId);

                return getSelect2WithoutSearchOrPaginate(contractItemModel, contractItemSelectName,
                        contractItemPlaceholder, contractId)
                    .then(() => {
                        if (selectedContractItemId) {
                            console.log('Selecting contract item:', selectedContractItemId);
                            $(contractItemSelectName).val(selectedContractItemId).trigger('change');
                        }
                    })
                    .catch((error) => {
                        console.error('Error fetching contract items:', error);
                    });
            }

            // Step 4: Set up event listener for contract_id change
            console.log('Step 4: Setting up event listener for contract_id change');
            $(contractIdSelectName).on('change', function() {
                const contractId = $(this).val();
                console.log('Contract ID changed:', contractId);

                const selectedContractItemId = oldItemId || (item_model && item_model.contract_id &&
                    item_model.item_id ? item_model.item_id : null);
                fetchAndSelectContractItems(contractId, selectedContractItemId);
            });

            // Step 5: Initial fetch on page load if old values or item_model exists
            console.log('Step 5: Checking for initial fetch on page load');
            if (oldContractId) {
                $(contractIdSelectName).val(oldContractId).trigger('change');
            } else if (item_model && item_model.contract_id) {
                fetchAndSelectContractItems(item_model.contract_id, oldItemId || item_model.item_id || null);
            }
        });
    </script>
    <script>
        function getSelect2WithoutSearchOrPaginate(model, selector, placeholder = 'Select an option', parent_id = null) {
            console.log('............... getSelect2WithoutSearchOrPaginate ...............');
            return new Promise((resolve, reject) => {
                console.log('Fetching items for selector:', selector);
                console.log('Model:', model);
                console.log('Parent ID:', parent_id);

                $.ajax({
                    url: "{{ route('getSelect2WithoutSearchOrPaginate') }}",
                    type: 'GET',
                    data: {
                        model: model,
                        parent_id: parent_id
                    },
                    success: function(data) {
                        // After fetching the data
                        console.log('Items fetched successfully:', data);



                        // Call the function with your data
                        updateDurationValidation(data);


                        // Clear current items
                        $(selector).empty();

                        // Append an empty option for placeholder
                        $(selector).append('<option></option>');

                        // Append new items to the dropdown
                        $.each(data, function(key, model) {
                            $(selector).append('<option value="' + model.id + '">' + model
                                .current_local_name + '</option>');
                        });

                        // Trigger change event to update select2
                        $(selector).trigger('change');
                        // console.log('Model dropdown updated successfully');

                        // Resolve the promise indicating the success
                        resolve();
                    },
                    error: function(xhr, status, error) {
                        // Use handleAjaxErrors function for error handling
                        handleAjaxErrors(xhr, status, error);
                        // Reject the promise with the error
                        reject(xhr);
                    }
                });
            });
        }
        // Function to update duration field validation



        function updateDurationValidation(data) {
            console.log('Updating duration validation with data:', data);

            const durationInput = $('input[name="duration"]');

            // Clear existing validation messages
            durationInput.closest('form').find('.fv-plugins-message-container').remove();

            if (data && Array.isArray(data) && data.length > 0) {
                const firstItem = data[0];

                if (firstItem.contract_duration != null && firstItem.contract_duration > 0) {
                    console.log('Contract duration found:', firstItem.contract_duration);

                    // Remove existing max validation classes
                    durationInput.removeClass(function(index, className) {
                        return (className.match(/(^|\s)validate-max-\S+/g) || []).join(' ');
                    });

                    // Add new max validation
                    durationInput.addClass(`validate-max-${firstItem.contract_duration}`);

                    // Re-render validation with new rules
                    setTimeout(() => {
                        renderValidate(
                            '#{{ $item_model::ui['s_lcf'] }}_form',
                            '[data-kt-{{ $item_model::ui['s_lcf'] }}-action="submit"]'
                        );
                    }, 0);

                } else {
                    console.error('Contract duration is null or invalid');
                    Swal.fire({
                        text: "Contract duration is not defined!",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            } else {
                console.error('Invalid data structure or empty data');
                Swal.fire({
                    text: "No data available or invalid data structure",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        }
    </script>
    {{-- openProcessComments --}}
    <script>
        let currentProcessId = null;
        let commentDropzone = null;

        function openProcessComments(processId) {
            currentProcessId = processId;

            // Initialize Dropzone if not already initialized
            if (!commentDropzone) {
                commentDropzone = new Dropzone("#commentFileDropzone", {
                    url: "{{ route('projects.store_task_process_comments') }}",
                    autoProcessQueue: false,
                    addRemoveLinks: true,
                    maxFiles: 5,
                    acceptedFiles: 'image/*,.pdf,.doc,.docx,.xls,.xlsx',
                    dictDefaultMessage: 'Drop files here or click to upload'
                });
            }

            // Load comments
            loadProcessComments(processId);

            // Show modal
            $('#processCommentsModal').modal('show');
        }

        function loadProcessComments(processId) {
            $.ajax({
                url: "{{ route('projects.task_process_comments', ['task_process' => ':processId']) }}".replace(
                    ':processId', processId),
                method: 'GET',
                success: function(response) {
                    const commentsHtml = response.comments.map(comment => `
                    <div class="comment-item">
                        <div class="d-flex justify-content-between">
                            <strong>${comment.user.name}</strong>
                            <small>${moment(comment.created_at).fromNow()}</small>
                        </div>
                        <div>${comment.notes}</div>
                        ${renderCommentFiles(comment.attachments)}
                    </div>
                `).join('');

                    $('#commentsContainer').html(commentsHtml);
                }
            });
        }


        // Modify the renderCommentFiles function to include the delete button
        function renderCommentFiles(attachments) {
            if (!attachments?.length) return '';
            // return '';
            return `
                       <div class="tsk-file-previews">
            ${attachments.map(attachment => `
                                                                                                                                                                                        <div class="tsk-file-preview" id="attachment-${attachment.id}">
                                                                                                                                                                                            <div class="tsk-file-preview-header">
                                                                                                                                                                                                <div class="tsk-file-preview-icon">
                                                                                                                                                                                                    <i class="ki-duotone ki-file fs-2">
                                                                                                                                                                                                        <span class="path1"></span>
                                                                                                                                                                                                        <span class="path2"></span>
                                                                                                                                                                                                    </i>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                <div class="tsk-file-preview-info">
                                                                                                                                                                                                    <div class="tsk-file-preview-name" title="${attachment.file_name}">
                                                                                                                                                                                                        ${attachment.file_name}
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                    <div class="tsk-file-preview-size">
                                                                                                                                                                                                        ${formatFileSize(attachment.file_size)}
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <div class="tsk-file-preview-actions">
                                                                                                                                                                                                <a href="${baseUrl}${attachment.file_path}"
                                                                                                                                                                                                    class="btn btn-icon btn-sm btn-light-primary me-2"
                                                                                                                                                                                                    target="_blank"
                                                                                                                                                                                                    title="Download file">
                                                                                                                                                                                                    <i class="ki-duotone ki-arrow-down fs-2">
                                                                                                                                                                                                        <span class="path1"></span>
                                                                                                                                                                                                        <span class="path2"></span>
                                                                                                                                                                                                    </i>
                                                                                                                                                                                                </a>
                                                                                                                                                                                                <button type="button"
                                                                                                                                                                                                        class="btn btn-icon btn-sm btn-light-danger"
                                                                                                                                                                                                        onclick="deleteCommentFile(${attachment.id})"
                                                                                                                                                                                                        title="Delete file">
                                                                                                                                                                                                    <i class="ki-duotone ki-trash fs-2">
                                                                                                                                                                                                        <span class="path1"></span>
                                                                                                                                                                                                        <span class="path2"></span>
                                                                                                                                                                                                        <span class="path3"></span>
                                                                                                                                                                                                        <span class="path4"></span>
                                                                                                                                                                                                        <span class="path5"></span>
                                                                                                                                                                                                    </i>
                                                                                                                                                                                                </button>
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    `).join('')}
                    </div>
                            `;
        }

        // Delete function using the existing route
        function deleteCommentFile(attachmentId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                showLoaderOnConfirm: true,
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-active-light"
                },
                buttonsStyling: false,
                preConfirm: () => {
                    const projectId = '{{ $item_model->id }}';
                    const url = "{{ route('projects.tasks.remove-attachment', [':project', ':attachment']) }}"
                        .replace(':project', projectId)
                        .replace(':attachment', attachmentId);

                    return $.ajax({
                        url: url,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error.responseJSON?.message || 'Unknown error'}`
                        );
                    });
                }
            }).then((result) => {
                if (result.isConfirmed && result.value.success) {
                    // Remove the attachment element with animation
                    const attachmentElement = $(`#attachment-${attachmentId}`);
                    attachmentElement.addClass('fade-out');

                    setTimeout(() => {
                        attachmentElement.remove();

                        // If no more attachments, remove the container
                        const filePreviewsContainer = $('.tsk-file-previews');
                        if (filePreviewsContainer.children().length === 0) {
                            filePreviewsContainer.remove();
                        }

                        // Show success message
                        Swal.fire({
                            text: result.value.message || 'File has been deleted!',
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }, 300);
                }
            });
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }


        // Handle comment form submission
        $('#commentForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('content', $('#commentContent').val());
            formData.append('task_process_id', currentProcessId);
            formData.append('_token', '{{ csrf_token() }}');

            // Add files from Dropzone
            if (commentDropzone?.files?.length) {
                commentDropzone.files.forEach((file, index) => {
                    formData.append(`files[${index}]`, file);
                });
            }

            $.ajax({
                url: "{{ route('projects.store_task_process_comments') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success('{{ t('Comment added successfully') }}');
                        $('#commentContent').val('');
                        commentDropzone.removeAllFiles();
                        loadProcessComments(currentProcessId);
                    } else {
                        toastr.error('{{ t('Failed to add comment') }}');
                    }
                },
                error: function(xhr) {
                    toastr.error('{{ t('An error occurred while adding the comment') }}');
                    console.error('Error:', xhr);
                }
            });
        });

        // Initialize Dropzone
        function initDropzone(processId) {
            return new Dropzone("#commentFileDropzone", {
                url: "{{ route('projects.store_task_process_comments') }}",
                autoProcessQueue: false,
                addRemoveLinks: true,
                maxFiles: 5,
                acceptedFiles: 'image/*,.pdf,.doc,.docx,.xls,.xlsx',
                dictDefaultMessage: 'Drop files here or click to upload'
            });
        }
    </script>
@endpush
@if ($item_model->exists)
    @push('scripts')
        <script>
            $(document).ready(function() {
                let rowCounter = 0;
                const $repeater = $('#workflow-repeater');

                // Initialize sortable
                $repeater.sortable({
                    cursor: 'move',
                    axis: 'y',
                    items: '.wf-row',
                    containment: 'parent',
                    placeholder: 'wf-row-placeholder',
                    tolerance: 'pointer',
                    start: function(e, ui) {
                        // Disable Select2 during drag
                        ui.item.find('select').select2('destroy');
                        ui.placeholder.height(ui.item.outerHeight());
                    },
                    stop: function(e, ui) {
                        // Re-initialize Select2 after drag
                        initializeSelect2(ui.item.find('select'));
                    }
                });

                // Prevent drag initiation from form controls
                $repeater.on('mousedown', '.form-select, .wf-delete-btn, .select2-container', function(e) {
                    e.stopPropagation();
                });

                // Modify initializeSelect2 function
                function initializeSelect2($select) {
                    $select.select2({
                        width: '100%',
                        dropdownParent: $select.closest('.wf-row'),
                        placeholder: $select.find('option:first').text(),
                        allowClear: true
                    }).on('select2:opening', function(e) {
                        // Temporarily disable dragging when select2 is open
                        $repeater.sortable('disable');
                    }).on('select2:close', function(e) {
                        // Re-enable dragging when select2 is closed
                        setTimeout(() => $repeater.sortable('enable'), 100);
                    });
                }

                // Add new row function
                function addRow(data = null) {
                    const template = $('#workflow-row-template').html();
                    const newRow = template.replace(/{index}/g, rowCounter++);
                    const $row = $(newRow);

                    // Initialize Select2 for new selects
                    $row.find('select').each(function() {
                        initializeSelect2($(this));
                    });

                    // Set values if data provided
                    if (data) {
                        $row.find('.employee-select').val(data.employee_id).trigger('change');
                        $row.find('.position-select').val(data.position_id).trigger('change');
                    }

                    // Add with animation
                    $row.css('opacity', 0);
                    $repeater.append($row);
                    $row.animate({
                        opacity: 1
                    }, 300);

                    return $row;
                }

                // Add row button click
                $('#add-workflow-row').on('click', function() {
                    addRow();
                    // Scroll to new row
                    $('html, body').animate({
                        scrollTop: $repeater.find('.wf-row:last').offset().top - 100
                    }, 500);
                });

                // Remove row button click (delegated)
                $repeater.on('click', '.remove-row', function(e) {
                    e.stopPropagation(); // Prevent row drag when clicking delete
                    const $row = $(this).closest('.wf-row');

                    $row.animate({
                        opacity: 0,
                        height: 0,
                        marginBottom: 0,
                        padding: 0
                    }, 300, function() {
                        $(this).remove();
                        if ($repeater.children().length === 0) {
                            addRow();
                        }
                    });
                });

                // Load existing data
                @if (isset($item_model) && $item_model->exists)
                    const existingWorkflow = @json($item_model->projectEmployees);
                    if (existingWorkflow && existingWorkflow.length) {
                        existingWorkflow.forEach(item => addRow(item));
                    }
                @endif

                // Save workflow
                $('#save-workflow').on('click', function() {
                    const $button = $(this);
                    const workflow = [];
                    let hasErrors = false;

                    // Disable button and show loading
                    $button.prop('disabled', true);

                    // Collect data from rows
                    $('.wf-row').each(function(index) {
                        const $row = $(this);
                        const employeeId = $row.find('.employee-select').val();
                        const positionId = $row.find('.position-select').val();

                        // Clear previous errors
                        $row.find('.select2-container').removeClass('is-invalid');

                        // Validate fields
                        if (!employeeId || !positionId) {
                            hasErrors = true;
                            if (!employeeId) {
                                $row.find('.employee-select').next('.select2-container').addClass(
                                    'is-invalid');
                            }
                            if (!positionId) {
                                $row.find('.position-select').next('.select2-container').addClass(
                                    'is-invalid');
                            }
                        }

                        workflow.push({
                            employee_id: employeeId,
                            position_id: positionId,
                            order: index
                        });
                    });

                    // Validation checks
                    if (workflow.length === 0) {
                        toastr.error("{{ t('Please add at least one employee to the workflow') }}");
                        $button.prop('disabled', false);
                        return;
                    }

                    if (hasErrors) {
                        toastr.error("{{ t('Please fix all errors before saving') }}");
                        $button.prop('disabled', false);
                        return;
                    }

                    // Save via AJAX
                    $.ajax({
                        url: "{{ route($item_model::ui['route'] . '.' . ProjectEmployee::ui['route'] . '.saveWorkflow', $item_model->id) }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            workflow: workflow
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success("{{ t('Workflow saved successfully') }}");
                                $('.select2-container').removeClass('is-invalid');
                            } else {
                                toastr.error(response.message ||
                                    "{{ t('Error saving workflow') }}");
                            }
                        },
                        error: function(xhr) {
                            toastr.error("{{ t('Error saving workflow') }}");
                            console.error('Error:', xhr);
                        },
                        complete: function() {
                            $button.prop('disabled', false);
                        }
                    });
                });

                // Handle select change to remove error state
                $repeater.on('change', 'select', function() {
                    if ($(this).val()) {
                        $(this).next('.select2-container').removeClass('is-invalid');
                    }
                });

                // Add initial row if empty
                if ($repeater.children().length === 0) {
                    addRow();
                }
            });
        </script>
    @endpush
@endif
