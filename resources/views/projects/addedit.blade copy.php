@php
    // dd($item_model);
    use App\Models\Project;
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
                        <span class="me-3">{{ t('Client Name') }}: <span
                                class="text-primary text-decoration-underline">{{ $item_model->contract->client_trillion->name ?? 'NA' }}</span></span>
                        <span class="me-3">{{ t('Contract ID') }}: <span
                                class="text-primary text-decoration-underline">{{ $item_model->contract_id ?? 'NA' }}</span></span>
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
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        renderValidate('#{{ $item_model::ui['s_lcf'] }}_form',
            '[data-kt-{{ $item_model::ui['s_lcf'] }}-action="submit"]');
    </script>

    <script>
        $(function() {
            // Initialize the contract start date picker
            initFlatpickr("input[name='start_date']", {
                minDate: "today"
            });
        });
    </script>


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
    {{-- Employee workflow script draggable --}}
    @if ($item_model->exists)
        <script>
            $(document).ready(function() {
                function makeDraggable() {
                    $('#allEmployees li').not('.ui-draggable').draggable({
                        helper: 'clone',
                        revert: 'invalid',
                        cursor: 'move',
                        connectToSortable: '#selectedEmployees'
                    });
                }

                function destroyDraggable(element) {
                    if (element.hasClass('ui-draggable')) {
                        try {
                            element.draggable('destroy');
                        } catch (e) {
                            console.warn('Error destroying draggable:', e);
                        }
                    }
                }

                function applyItemStyle(item) {
                    item.addClass('list-group-item').css({
                        'cursor': 'move',
                        'background-color': '#fff',
                        'border': '1px solid rgba(0, 0, 0, .125)',
                        'padding': '.75rem 1.25rem',
                        'margin-bottom': '-1px'
                    });
                }

                // Function to fetch selected employees
                function fetchSelectedEmployees() {
                    $.ajax({
                        url: "{{ route($item_model::ui['route'] . '.' . ProjectEmployee::ui['route'] . '.getSelectedEmployees', [$item_model::ui['s_lcf'] => $item_model->id]) }}",
                        method: 'GET',
                        success: function(response) {
                            populateSelectedEmployees(response.selectedEmployees);
                        },
                        error: handleAjaxErrors
                    });
                }

                // Function to populate selected employees
                function populateSelectedEmployees(selectedEmployees) {
                    $('#selectedEmployees').empty();
                    selectedEmployees.forEach(function(employee) {
                        var item = $(`<li data-id="${employee.id}">${employee.name}</li>`);
                        applyItemStyle(item);
                        $('#selectedEmployees').append(item);
                        $(`#allEmployees li[data-id="${employee.id}"]`).remove();
                    });
                    makeDraggable();
                }

                makeDraggable();
                fetchSelectedEmployees(); // Fetch selected employees when page loads

                $('#selectedEmployees').sortable({
                    receive: function(event, ui) {
                        var draggedItem = ui.item;
                        var originalItem = draggedItem.clone();

                        // Remove the original item from the left list
                        $('#allEmployees').find(`li[data-id="${draggedItem.data('id')}"]`).remove();

                        // Remove any existing duplicate in the right list
                        $('#selectedEmployees').find(`li[data-id="${draggedItem.data('id')}"]`).remove();

                        originalItem.removeAttr('style').removeClass('ui-draggable ui-draggable-handle');
                        applyItemStyle(originalItem);
                        $('#selectedEmployees').append(originalItem);

                        destroyDraggable(originalItem);
                    },
                    update: function() {
                        $('#selectedEmployees li').each(function() {
                            destroyDraggable($(this));
                            applyItemStyle($(this));
                        });
                    }
                });

                $('#allEmployees').droppable({
                    accept: '#selectedEmployees li',
                    drop: function(event, ui) {
                        var item = ui.draggable;
                        var originalItem = item.clone();

                        // Remove any existing duplicate in the left list
                        $('#allEmployees').find(`li[data-id="${item.data('id')}"]`).remove();

                        originalItem.removeAttr('style').removeClass('ui-draggable ui-draggable-handle');
                        applyItemStyle(originalItem);
                        $('#allEmployees').append(originalItem);
                        item.remove();
                        makeDraggable();
                    }
                });

                // Button click handlers
                $('#moveRight').on('click', function(e) {
                    e.preventDefault();
                    var selectedItem = $('#allEmployees li:first');
                    if (selectedItem.length) {
                        var clonedItem = selectedItem.clone().removeAttr('style').removeClass(
                            'ui-draggable ui-draggable-handle');
                        applyItemStyle(clonedItem);
                        $('#selectedEmployees').append(clonedItem);
                        destroyDraggable(clonedItem);
                        selectedItem.remove();
                    }
                });

                $('#moveLeft').on('click', function(e) {
                    e.preventDefault();
                    var selectedItem = $('#selectedEmployees li:last');
                    if (selectedItem.length) {
                        var clonedItem = selectedItem.clone().removeAttr('style');
                        applyItemStyle(clonedItem);
                        $('#allEmployees').append(clonedItem);
                        selectedItem.remove();
                        makeDraggable();
                    }
                });

                // Move up and down functionality
                $('#moveUp, #moveDown').on('click', function(e) {
                    e.preventDefault();
                    var selected = $('#selectedEmployees li.selected');
                    if (selected.length) {
                        if ($(this).attr('id') === 'moveUp' && !selected.is(':first-child')) {
                            selected.insertBefore(selected.prev());
                        } else if ($(this).attr('id') === 'moveDown' && !selected.is(':last-child')) {
                            selected.insertAfter(selected.next());
                        }
                    }
                });

                // Item selection in the right box
                $('#selectedEmployees').on('click', 'li', function() {
                    $(this).toggleClass('selected').siblings().removeClass('selected');
                });

                // Search functionality
                function filterList(inputId, listId) {
                    $(inputId).on('keyup', function() {
                        var value = $(this).val().toLowerCase();
                        $(listId + ' li').filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                }

                filterList('#searchAllEmployees', '#allEmployees');
                filterList('#searchSelectedEmployees', '#selectedEmployees');

                // Initial styling
                $('#allEmployees li, #selectedEmployees li').each(function() {
                    applyItemStyle($(this));
                });

                // Function to collect selected employee IDs
                function getSelectedEmployeeIds() {
                    return $('#selectedEmployees li').map(function() {
                        return $(this).data('id');
                    }).get();
                }

                // Add a button to trigger sending data to the backend
                $('<button>', {
                    text: '{{ t('Save Selected Employees') }}',
                    class: 'btn btn-primary mt-3',
                    click: function(e) {
                        e.preventDefault();
                        var selectedIds = getSelectedEmployeeIds();
                        sendSelectedEmployeesToBackend(selectedIds);
                    }
                }).insertAfter('#selectedEmployees');

                // Function to send data to the backend
                function sendSelectedEmployeesToBackend(selectedIds) {
                    $.ajax({
                        url: "{{ route($item_model::ui['route'] . '.' . ProjectEmployee::ui['route'] . '.saveSelectedEmployees', [$item_model::ui['s_lcf'] => $item_model->id]) }}",
                        method: 'POST',
                        data: JSON.stringify({
                            selectedEmployees: selectedIds
                        }),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            console.log(response);
                        },
                        error: handleAjaxErrors
                    });
                }
            });
        </script>
    @endif
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


        // Then modify your renderCommentFiles function
        function renderCommentFiles(attachments) {
            if (!attachments?.length) return '';

            return `
                <div class="comment-files">
                    ${attachments.map(attachment => `
                                                                                                                                                                                            <a href="${baseUrl}${attachment.file_path}" class="file-item" target="_blank">
                                                                                                                                                                                                <i class="fas fa-file"></i>
                                                                                                                                                                                                ${attachment.file_name}
                                                                                                                                                                                            </a>
                                                                                                                                                                                            `).join('')}
                </div>
                `;
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
