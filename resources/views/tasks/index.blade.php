@php
    use App\Enums\DropDownFields;
    use App\Enums\Modules;
    use App\Models\Project;
    use App\Models\Task;
    use App\Models\TaskAssignment;
    use App\Models\TaskProcess;
@endphp
@extends('metronic.index')

@section('title', Task::ui['p_ucf'])
@section('subpageTitle', Task::ui['p_ucf'])
@push('styles')
    <link href="{{ asset('css/custom.css?v=1') }}" rel="stylesheet" type="text/css" />
    {{-- @include(Task::ui['route'] . '.partials._styles') --}}

    <style>
        .note-modal-backdrop {
            display: none;
        }

        /* Quill Editor Custom Styles */
        .ql-editor {
            min-height: 120px;
        }

        .ql-container {
            font-size: 14px;
        }
    </style>
@endpush

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
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-col-index="search" data-kt-table-filter="search"
                                class="form-control datatable-input form-control-solid w-250px ps-14"
                                placeholder="{{ t('Search ' . Task::ui['s_ucf']) }}" />
                            <input type="hidden" name="selectedCaptin">
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-departments-table-toolbar="base">
                            @include(Task::ui['route'] . '.partials._filter')
                            <!--end::Add captins-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_captins" tabindex="-1" aria-hidden="true">
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


                    <div class="container-fluid">
                        <h1 class="my-4">Task Assignment Board</h1>
                        <div class="board tsk-board tsk-loading">
                            {{-- @foreach ($status_list as $status)
                                <div class="list tsk-list">
                                    <div class="list-header tsk-list-header">
                                        <div class="tsk-list-header-title">
                                            {{ $status->name }}
                                            <span
                                                class="badge tsk-status-badge">{{ ($tasks_assigned[$status->id] ?? collect())->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="list-cards tsk-list-cards" id="{{ $status->value }}"
                                        data-status-id="{{ $status->id }}">
                                        @if (isset($tasks_assigned[$status->id]))
                                            @foreach ($tasks_assigned[$status->id] as $task_assigned)
                                                <div class="card task-card tsk-card" data-id="{{ $task_assigned->id }}"
                                                    data-current-status-id="{{ $status->id }}"
                                                    data-employee-id="{{ $task_assigned->employee_id }}"
                                                    style="--status-color: {{ $status->color }}">

                                                    <!-- Add badges container at the top -->
                                                    <div class="tsk-card-badges">
                                                        <!-- Status badge -->
                                                        <span class="tsk-card-status"
                                                            style="background-color: {{ $status->color }}15; color: {{ $status->color }}">
                                                            <i class="fas fa-circle fs-8"></i>
                                                            {{ $status->name }}
                                                        </span>
                                                        <!-- Active flag -->
                                                        <span
                                                            class="tsk-card-active-flag {{ $task_assigned->active ? 'active' : 'inactive' }}">
                                                            <i
                                                                class="fas {{ $task_assigned->active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                            {{ $task_assigned->active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </div>

                                                    <div class="tsk-card-title">{{ $task_assigned->title }}</div>
                                                    <div class="tsk-card-description">
                                                        {{ Str::limit($task_assigned->description, 50) }}
                                                    </div>
                                                    <div class="tsk-card-meta">
                                                        <div class="tsk-card-dates">
                                                            @if ($task_assigned->start_date)
                                                                <div class="tsk-card-date">
                                                                    <i class="ki-duotone ki-calendar fs-6"></i>
                                                                    <span>Start:
                                                                        {{ $task_assigned->start_date->format('M d, Y') }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="tsk-card-actions mt-2">
                                                            <button type="button"
                                                                class="btn btn-sm btn-light-primary view-timeline-btn"
                                                                data-task-id="{{ $task_assigned->task->id }}"
                                                                data-task-title="{{ $task_assigned->task->title }}">
                                                                <i class="fas fa-stream"></i>
                                                                {{ t('View Timeline') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach --}}
                        </div>
                    </div>

                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content container-->

    <!-- Timeline Modal -->
    <div class="modal fade" id="taskTimelineModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Task Timeline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="timeline-window-container">
                        <div class="stats-container d-none">
                            <!-- Stats will be injected here -->
                        </div>
                        <div id="timelineContent" class="timeline-container">
                            <!-- Timeline content will be injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_general" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>



    <!-- Comments Modal -->
    <div class="modal fade tsk-comments-modal" id="processCommentsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bolder fs-1">{{ t('Comments') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="commentsContainer" class="tsk-comments-container">
                        <!-- Comments will be inserted here -->
                    </div>

                    <form id="commentForm" class="tsk-comment-form">
                        <div class="mb-5">
                            <textarea class="form-control tsk-comment-input" id="commentContent" rows="3"
                                placeholder="{{ t('Add a comment...') }}"></textarea>
                        </div>

                        <div class="mb-5">
                            <div class="tsk-dropzone" id="commentFileDropzone">
                                <div class="dz-message">
                                    <i class="ki-duotone ki-cloud-upload fs-2x text-primary"></i>
                                    <div class="text-gray-600 fs-5">{{ t('Drop files here or click to upload') }}</div>
                                    <div class="text-gray-400 fs-7 mt-1">{{ t('Maximum 5 files allowed') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-6">
                                <i class="ki-duotone ki-send-up fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ t('Post Comment') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>



    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script> --}}


    <!-- Summernote -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script> --}}



    <script>
        class TaskModalInitializer {
            static initializeTaskModal(taskAssignmentId, config) {
                return {
                    success: () => {
                        // Initialize Quill editor
                        const quill = new Quill('#taskCommentEditor', {
                            theme: 'snow',
                            placeholder: 'Write your comment here...',
                            modules: {
                                toolbar: [
                                    ['bold', 'italic', 'underline'],
                                    [{
                                        'list': 'ordered'
                                    }, {
                                        'list': 'bullet'
                                    }],
                                    ['link'],
                                    ['clean']
                                ]
                            }
                        });

                        // Initialize Dropzone
                        const dropzone = new Dropzone("#taskCommentDropzone", {
                            url: config.routes.uploadAttachments.replace(':taskAssignmentId',
                                taskAssignmentId),
                            autoProcessQueue: false,
                            addRemoveLinks: true,
                            maxFiles: 5,
                            maxFilesize: 10,
                            acceptedFiles: 'image/*,.pdf,.doc,.docx,.xls,.xlsx',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        // Load existing comments
                        TaskModalInitializer.loadComments(taskAssignmentId, config);

                        // Handle form submission
                        TaskModalInitializer.handleFormSubmission(taskAssignmentId, quill, dropzone, config);
                    }
                };
            }

            static async loadComments(taskAssignmentId, config) {
                try {
                    const response = await $.ajax({
                        url: config.routes.getComments.replace(':taskAssignmentId', taskAssignmentId),
                        method: 'GET'
                    });

                    if (response.success) {
                        $('#taskCommentsList').html(response.html);
                    }
                } catch (error) {
                    console.error('Error loading comments:', error);
                    toastr.error('Failed to load comments');
                }
            }

            static handleFormSubmission(taskAssignmentId, quill, dropzone, config) {
                $('#taskCommentForm').on('submit', async (e) => {
                    e.preventDefault();
                    const $submitBtn = $('#submitComment');

                    $submitBtn.attr('data-kt-indicator', 'on');
                    $submitBtn.prop('disabled', true);

                    try {
                        const formData = new FormData();
                        formData.append('content', quill.root.innerHTML);
                        formData.append('task_assignment_id', taskAssignmentId);
                        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                        dropzone.files.forEach((file) => {
                            formData.append('attachments[]', file);
                        });

                        const response = await $.ajax({
                            url: config.routes.storeComment.replace(':taskAssignmentId',
                                taskAssignmentId),
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false
                        });

                        if (response.success) {
                            toastr.success('Comment added successfully');
                            quill.setText('');
                            dropzone.removeAllFiles();
                            TaskModalInitializer.loadComments(taskAssignmentId, config);
                        }
                    } catch (error) {
                        console.error('Error posting comment:', error);
                        toastr.error('Failed to add comment');
                    } finally {
                        $submitBtn.removeAttr('data-kt-indicator');
                        $submitBtn.prop('disabled', false);
                    }
                });
            }
        }

        // Comment Manager Class
        class CommentManager {
            constructor(config = {}) {
                this.config = {
                    commentFormId: '#taskCommentForm',
                    commentContentId: '#taskCommentContent',
                    dropzoneId: '#taskCommentDropzone',
                    commentsListId: '#taskCommentsList',
                    taskAssignmentIdField: '#task_assignment_id',
                    ...config
                };

                this.quill = null;
                this.dropzone = null;
                this.initialize();
            }

            initialize() {
                this.initializeQuill();
                this.initializeDropzone();
                this.bindEvents();
                this.loadComments();
            }

            initializeQuill() {
                // Initialize Quill with Snow theme
                this.quill = new Quill(this.config.commentContentId, {
                    theme: 'snow',
                    placeholder: 'Write your comment here...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });
            }

            initializeDropzone() {
                if (this.dropzone) {
                    this.dropzone.destroy();
                }

                this.dropzone = new Dropzone(this.config.dropzoneId, {
                    url: this.config.routes.uploadAttachments,
                    autoProcessQueue: false,
                    addRemoveLinks: true,
                    parallelUploads: 5,
                    maxFiles: 5,
                    maxFilesize: 10,
                    acceptedFiles: 'image/*,.pdf,.doc,.docx,.xls,.xlsx',
                    dictDefaultMessage: "Drop files here or click to upload",
                    dictRemoveFile: "Remove file",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }

            bindEvents() {
                $(this.config.commentFormId).on('submit', (e) => this.handleCommentSubmit(e));
            }

            async handleCommentSubmit(e) {
                e.preventDefault();
                const $submitBtn = $('#submitComment');
                const taskAssignmentId = $('#task_assignment_id').val();

                if (!taskAssignmentId) {
                    toastr.error('Task assignment ID is missing');
                    return;
                }

                // Show loading state
                $submitBtn.attr('data-kt-indicator', 'on');
                $submitBtn.prop('disabled', true);

                try {
                    const formData = new FormData();
                    formData.append('content', quill.root.innerHTML);
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                    // Add files from Dropzone
                    if (dropzone.files.length > 0) {
                        dropzone.files.forEach((file, index) => {
                            formData.append(`attachments[]`, file);
                        });
                    }

                    // Note the URL change here - using the task_assignment ID in the URL
                    const response = await $.ajax({
                        url: `/tasks/comments/${taskAssignmentId}`, // Update this path according to your routes
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false
                    });

                    if (response.success) {
                        toastr.success(response.message || 'Comment added successfully');
                        quill.setText('');
                        dropzone.removeAllFiles();
                        await loadComments(taskAssignmentId);
                    } else {
                        toastr.error(response.message || 'Failed to add comment');
                    }
                } catch (error) {
                    console.error('Error posting comment:', error);
                    toastr.error('Failed to add comment');
                } finally {
                    // Reset button state
                    $submitBtn.removeAttr('data-kt-indicator');
                    $submitBtn.prop('disabled', false);
                }
            }
            async loadComments() {
                try {
                    const taskId = $(this.config.taskAssignmentIdField).val();
                    const response = await $.ajax({
                        url: this.config.routes.getComments.replace(':taskAssignmentId', taskId),
                        method: 'GET'
                    });

                    if (response.success) {
                        $(this.config.commentsListId).html(response.comments.map(comment => this.renderComment(comment))
                            .join(''));
                    }
                } catch (error) {
                    console.error('Error loading comments:', error);
                    toastr.error('Failed to load comments');
                }
            }

            renderComment(comment) {
                return `
                            <div class="comment mb-5">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="symbol symbol-35px me-3">
                                        <div class="symbol-label bg-light-primary">
                                            ${comment.user.name.charAt(0)}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-grow-1">
                                        <span class="text-gray-800 fs-4 fw-bold">${comment.user.name}</span>
                                        <span class="text-gray-600 fs-6">${moment(comment.created_at).fromNow()}</span>
                                    </div>
                                </div>
                                <div class="comment-content ms-8 ps-5">
                                    <div class="text-gray-800 mb-4">${comment.content}</div>
                                    ${this.renderAttachments(comment.attachments)}
                                </div>
                            </div>
                        `;
            }

            renderAttachments(attachments) {
                if (!attachments?.length) return '';

                return `
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    ${attachments.map(attachment => `
                                                                                                                                                                                                                                                                                                                                        <a href="${attachment.file_path}"
                                                                                                                                                                                                                                                                                                                                        class="d-flex align-items-center bg-light rounded p-2 text-primary"
                                                                                                                                                                                                                                                                                                                                        target="_blank">
                                                                                                                                                                                                                                                                                                                                            <i class="ki-duotone ki-file fs-2 me-2"></i>
                                                                                                                                                                                                                                                                                                                                            <span class="fs-7 fw-bold">${attachment.file_name}</span>
                                                                                                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                                                                                                    `).join('')}
                                </div>
                            `;
            }

            static initialize(config) {
                return new CommentManager(config);
            }
        }
        // Core Logger Class
        class Logger {
            static levels = {
                INFO: 'INFO',
                WARN: 'WARN',
                ERROR: 'ERROR',
                DEBUG: 'DEBUG'
            };

            static log(level, component, message, data = null) {
                const timestamp = new Date().toISOString();
                const logEntry = {
                    timestamp,
                    level,
                    component,
                    message,
                    data
                };
                console.log(JSON.stringify(logEntry));
            }
        }

        // Add these lines at the top of your script, outside any class or ready handler
        const kt_modal_general = document.getElementById('kt_modal_general');
        let modal_kt_modal_general = null;

        // Create a Modal Manager Class to handle all modal operations
        class ModalManager {
            static initialize() {
                modal_kt_modal_general = new bootstrap.Modal(kt_modal_general);
            }

            static show(modalInstance) {
                if (modalInstance) {
                    modalInstance.show();
                }
            }

            static hide(modalInstance) {
                if (modalInstance) {
                    modalInstance.hide();
                }
            }

            static getGeneralModal() {
                return modal_kt_modal_general;
            }
        }


        // Filter Manager Class
        class FilterManager {
            constructor(options = {}) {
                this.options = {
                    datePickerId: '#kt_datepicker_8',
                    filterFormId: '#filter-form',
                    searchInputSelector: 'input[data-kt-table-filter="search"]',
                    selectPickerClass: '.filter-selectpicker',
                    menuParentId: '#kt_menu_64ca1a18f399e',
                    ...options
                };

                this.initialize();
                Logger.log(Logger.levels.DEBUG, 'FilterManager', 'Filter manager initialized');
            }

            initialize() {
                this.initializeDatePicker();
                this.initializeSelect2();
                this.bindEvents();
            }

            initializeDatePicker() {
                $(this.options.datePickerId).flatpickr({
                    mode: "range",
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: "Y-m-d",
                    static: true
                });
            }

            initializeSelect2() {
                $(this.options.selectPickerClass).each(function() {
                    $(this).select2({
                        allowClear: true,
                        dropdownParent: $("#kt_menu_64ca1a18f399e")
                    });
                });
            }

            bindEvents() {
                $('#taskboardFilterBtn').on('click', (e) => this.handleFilterClick(e));
                $('#taskboardResetFilterBtn').on('click', (e) => this.handleResetClick(e));
                $(this.options.searchInputSelector).on('keyup',
                    this.debounce(() => this.handleSearch(), 500)
                );
            }

            collectFilters() {
                const filters = {};

                // Collect all filter values from inputs
                $('.datatable-input').each((index, element) => {
                    const $element = $(element);
                    const columnIndex = $element.data('col-index');
                    let value = $element.val();

                    if (value && value.length) {
                        filters[columnIndex] = value;
                    }
                });

                return filters;
            }

            handleFilterClick(e) {
                e.preventDefault();
                const filters = this.collectFilters();
                const searchTerm = $(this.options.searchInputSelector).val();
                window.taskBoard?.refreshBoard(searchTerm, filters);
            }

            handleResetClick(e) {
                e.preventDefault();

                // Reset Select2 dropdowns
                $(this.options.selectPickerClass).each(function() {
                    $(this).val(null).trigger('change');
                });

                // Reset date picker
                const datePicker = $(this.options.datePickerId)[0]?._flatpickr;
                if (datePicker) datePicker.clear();

                // Reset search input
                $(this.options.searchInputSelector).val('');

                // Reset form
                $(this.options.filterFormId)[0].reset();

                // Refresh board without filters
                window.taskBoard?.refreshBoard();
            }

            handleSearch() {
                const searchTerm = $(this.options.searchInputSelector).val();
                const filters = this.collectFilters();
                window.taskBoard?.refreshBoard(searchTerm, filters);
            }

            debounce(func, wait) {
                let timeout;
                return (...args) => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }
        }

        // Permission Manager Class -
        class PermissionManager {
            constructor(userRoles, statuses) {
                this.userRoles = userRoles;
                this.statuses = statuses;
                this.lastErrorMessage = null;
            }

            validateMovement(to, from, dragEl) {
                const newStatusId = Number($(to.el).attr('data-status-id'));
                const oldStatusId = Number($(from.el).attr('data-status-id'));
                const assignedEmployeeId = $(dragEl).data('employee-id');

                if (this.userRoles.isAdmin ||
                    this.userRoles.isTrillionzGM ||
                    this.userRoles.isArtManager

                ) {
                    return true;
                }

                if (this.userRoles.isEmployee) {
                    return this.validateEmployeeMovement(newStatusId, oldStatusId, assignedEmployeeId);
                }

                this.showError('You do not have permission to move tasks');
                return false;
            }

            validateEmployeeMovement(newStatusId, oldStatusId, assignedEmployeeId) {
                const allowedTransitions = {
                    [this.statuses.PROCESSING]: [this.statuses.ART_MANAGER_APPROVAL],
                    [this.statuses.ART_MANAGER_APPROVAL]: [this.statuses.PROCESSING]
                };

                if (!allowedTransitions[oldStatusId]?.includes(newStatusId)) {
                    this.showError(
                        'As an employee, you can only move tasks between Processing and Art Manager Approval states'
                    );
                    return false;
                }

                if (assignedEmployeeId !== this.userRoles.currentEmployeeId) {
                    this.showError('You can only move tasks assigned to you');
                    return false;
                }

                return true;
            }

            showError(message) {
                if (this.lastErrorMessage === message) return;

                this.lastErrorMessage = message;
                toastr.error(message);

                setTimeout(() => {
                    this.lastErrorMessage = null;
                }, 1000);
            }
        }

        // UI Manager Class
        class UIManager {
            static updateTaskUI($card, taskData) {
                if (!taskData.status) return;

                // Update card border color
                $card.css('--status-color', taskData.status.color);

                // Update status badge
                const $statusBadge = $card.find('.tsk-card-status');
                if ($statusBadge.length) {
                    $statusBadge
                        .css({
                            'background-color': `${taskData.status.color}15`,
                            'color': taskData.status.color
                        })
                        .html(`
                        <i class="fas fa-circle fs-8"></i>
                        ${taskData.status.name}
                    `);
                }

                // Update title and description
                if (taskData.title) {
                    $card.find('.tsk-card-title').text(taskData.title);
                }
                if (taskData.description) {
                    $card.find('.tsk-card-description').text(taskData.description);
                }

                // Update active status
                if (typeof taskData.active !== 'undefined') {
                    const $activeFlag = $card.find('.tsk-card-active-flag');
                    if ($activeFlag.length) {
                        $activeFlag
                            .removeClass('active inactive')
                            .addClass(taskData.active ? 'active' : 'inactive')
                            .html(`
                            <i class="fas ${taskData.active ? 'fa-check-circle' : 'fa-times-circle'}"></i>
                            ${taskData.active ? 'Active' : 'Inactive'}
                        `);
                    }
                }

                // Update data attributes
                $card.attr('data-current-status-id', taskData.status.id);
            }

            static showLoading($element) {
                $element.addClass('tsk-loading');
            }

            static hideLoading($element) {
                $element.removeClass('tsk-loading');
            }
        }
        // Add this class definition before TaskBoard class
        class TaskTimelineModal {
            constructor(config) {
                this.config = config;
                this.modal = null;
                this.currentTaskId = null;
                this.modalElement = document.getElementById('taskTimelineModal');
                this.initializeModal();
            }

            initializeModal() {
                if (!this.modalElement) {
                    Logger.log(Logger.levels.ERROR, 'TaskTimelineModal', 'Timeline modal element not found');
                    return;
                }
                this.modal = new bootstrap.Modal(this.modalElement);
                Logger.log(Logger.levels.INFO, 'TaskTimelineModal', 'Timeline modal initialized');
            }

            openTimelineModal(taskId, taskTitle) {
                if (!this.modal) {
                    Logger.log(Logger.levels.ERROR, 'TaskTimelineModal', 'Timeline modal not initialized');
                    return;
                }

                this.currentTaskId = taskId;

                // Update modal title
                const modalTitle = this.modalElement.querySelector('.modal-title');
                if (modalTitle) {
                    modalTitle.textContent = `Task Timeline: ${taskTitle}`;
                }

                // Show loading state
                const timelineContent = this.modalElement.querySelector('#timelineContent');
                if (timelineContent) {
                    timelineContent.innerHTML = `
                      <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                          <div class="spinner-border text-primary" role="status">
                              <span class="visually-hidden">Loading...</span>
                          </div>
                      </div>`;
                }

                // Show the modal
                this.modal.show();

                // Fetch timeline data
                this.loadTimelineData(taskId);
            }

            async loadTimelineData(taskId) {
                try {
                    const response = await $.ajax({
                        url: this.config.routes.getTaskTimeline.replace(':taskId', taskId),
                        method: 'GET'
                    });

                    if (response.status) {
                        // Update stats
                        const statsContainer = this.modalElement.querySelector('.stats-container');
                        if (statsContainer) {
                            statsContainer.classList.remove('d-none');
                            statsContainer.innerHTML = this.renderStats(response.stats);
                        }

                        // Update timeline content
                        const timelineContent = this.modalElement.querySelector('#timelineContent');
                        if (timelineContent) {
                            timelineContent.innerHTML = response.timelineHtml;
                            this.initializeScrollSync();
                        }

                        Logger.log(Logger.levels.INFO, 'TaskTimelineModal', 'Timeline data loaded successfully');
                    } else {
                        this.showError('Failed to load timeline data');
                    }
                } catch (error) {
                    Logger.log(Logger.levels.ERROR, 'TaskTimelineModal', 'Error loading timeline', error);
                    this.showError('An error occurred while loading the timeline');
                }
            }

            renderStats(stats) {
                return `
                  <div class="stats-item">
                      <strong>Total Changes:</strong> ${stats.total_assignments}
                  </div>
                  <div class="stats-item">
                      <strong>Completed:</strong> ${stats.completed_assignments}
                  </div>
                  <div class="stats-item">
                      <strong>Processing:</strong> ${stats.processing_assignments}
                  </div>
                  <div class="stats-item">
                      <strong>Customer Approval:</strong> ${stats.customer_approval_assignments}
                  </div>
                  <div class="stats-item">
                      <strong>Art Manager Approval:</strong> ${stats.art_manager_approval_assignments}
                  </div>`;
            }

            initializeScrollSync() {
                const timelineContent = this.modalElement.querySelector('.timeline-content');
                if (timelineContent) {
                    timelineContent.addEventListener('scroll', (e) => {
                        // Add scroll synchronization logic if needed
                    });
                }

                // Add click handlers for timeline items
                $('.timeline-item').on('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();

                    const $taskAssignment = $(e.currentTarget);
                    const taskAssignmentId = $taskAssignment.data('task-assignment-id');

                    globalRenderModal(
                        this.config.routes.taskDetails.replace(':taskAssignmentId', taskAssignmentId),
                        $taskAssignment,
                        '#kt_modal_general',
                        ModalManager.getGeneralModal(),
                        null, // validatorFields
                        null, // formId
                        null, // dataTableId
                        null, // submitButtonName
                        null, // RequiredInputList
                        null, // RequiredInputList
                        null, // RequiredInputList
                        TaskModalInitializer.initializeTaskModal(taskAssignmentId, this.config).success
                    );
                });
            }

            showError(message) {
                const timelineContent = this.modalElement.querySelector('#timelineContent');
                if (timelineContent) {
                    timelineContent.innerHTML = `<div class="alert alert-danger">${message}</div>`;
                }
                Logger.log(Logger.levels.ERROR, 'TaskTimelineModal', message);
            }
        }

        // Main TaskBoard Class
        class TaskBoard {
            constructor(config) {
                this.config = config;
                this.permissionManager = new PermissionManager(config.userRoles, config.statuses);
                this.filterManager = new FilterManager();
                this.timelineModal = new TaskTimelineModal(config);
                this.setup();
            }

            setup() {
                // Load the board immediately when initialized
                this.refreshBoard();

                this.initializeSortable();
                this.bindCardEvents();
                Logger.log(Logger.levels.INFO, 'TaskBoard', 'TaskBoard initialized');
            }

            initializeSortable() {
                $('.list-cards').each((index, element) => {
                    new Sortable(element, {
                        group: {
                            name: 'shared',
                            pull: (to, from, dragEl) =>
                                this.permissionManager.validateMovement(to, from, dragEl)
                        },
                        animation: 150,
                        onEnd: (evt) => this.handleTaskMove(evt)
                    });
                });
            }

            bindCardEvents() {
                $('.list-cards').on('click', (e) => {
                    const $target = $(e.target);
                    const $taskCard = $target.closest('.task-card');
                    const $timelineBtn = $target.closest('.view-timeline-btn');

                    if ($timelineBtn.length > 0) {
                        this.handleTimelineButtonClick(e, $timelineBtn);
                    } else if ($taskCard.length > 0 && !$timelineBtn.length) {
                        this.handleTaskCardClick(e, $taskCard);
                    }
                });
            }

            handleTimelineButtonClick(e, $timelineBtn) {
                e.preventDefault();
                e.stopPropagation();

                const taskId = $timelineBtn.data('task-id');
                const taskTitle = $timelineBtn.data('task-title');

                this.timelineModal.openTimelineModal(taskId, taskTitle);
            }

            handleTaskMove(evt) {
                if (evt.from === evt.to) return;

                const $item = $(evt.item);
                const taskId = $item.data('id');
                const newStatusId = $(evt.to).data('status-id');
                const oldStatusId = $(evt.from).data('status-id');

                UIManager.showLoading($item);
                this.updateTaskStatus(taskId, newStatusId, oldStatusId, $item);
            }

            async updateTaskStatus(taskId, newStatusId, oldStatusId, $card) {
                try {
                    const response = await $.ajax({
                        url: this.config.routes.moveTask,
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            task_id: taskId,
                            new_status_id: newStatusId,
                            old_status_id: oldStatusId
                        }
                    });

                    if (response.success) {
                        toastr.success(response.message || 'Task moved successfully!');
                        if (response.task) {
                            UIManager.updateTaskUI($card, response.task);
                        }
                    } else {
                        this.handleMovementError($card, oldStatusId, response.message);
                    }
                } catch (error) {
                    this.handleMovementError($card, oldStatusId,
                        error.responseJSON?.message || 'An error occurred while moving the task');
                } finally {
                    UIManager.hideLoading($card);
                }
            }

            handleMovementError($card, originalStatusId, errorMessage) {
                toastr.error(errorMessage);
                const $originalList = $(`[data-status-id="${originalStatusId}"]`);
                if ($originalList.length) {
                    $card.appendTo($originalList);
                }
            }
            handleTaskCardClick(e, $taskCard) {
                e.preventDefault();
                const taskAssignmentId = $taskCard.data('id');

                const modalInstance = ModalManager.getGeneralModal();
                if (!modalInstance) {
                    Logger.log(Logger.levels.ERROR, 'TaskBoard', 'Modal instance not found');
                    return;
                }

                globalRenderModal(
                    this.config.routes.taskDetails.replace(':taskAssignmentId', taskAssignmentId),
                    $taskCard,
                    '#kt_modal_general',
                    modalInstance,
                    null, // validatorFields
                    null, // formId
                    null, // dataTableId
                    null, // submitButtonName
                    null, // RequiredInputList
                    null, // RequiredInputList
                    null, // RequiredInputList
                    TaskModalInitializer.initializeTaskModal(taskAssignmentId, this.config).success
                );
            }

            // Add this method to your TaskBoard class
            async loadComments(taskAssignmentId) {
                try {
                    const response = await $.ajax({
                        url: this.config.routes.getComments.replace(':taskAssignmentId', taskAssignmentId),
                        method: 'GET'
                    });

                    if (response.success) {
                        $('#taskCommentsList').html(response.html);
                    }
                } catch (error) {
                    console.error('Error loading comments:', error);
                    toastr.error('Failed to load comments');
                }
            }

            async refreshBoard(searchTerm = '', filters = null) {
                try {
                    UIManager.showLoading($('.tsk-board'));

                    const params = new URLSearchParams();
                    if (searchTerm) params.append('search', searchTerm);

                    if (filters) {
                        Object.entries(filters).forEach(([key, value]) => {
                            if (Array.isArray(value)) {
                                value.forEach(v => params.append(`${key}[]`, v));
                            } else {
                                params.append(key, value);
                            }
                        });
                    }

                    const response = await $.ajax({
                        url: `${this.config.routes.getTaskBoard}?${params.toString()}`,
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    if (response.success) {
                        $('.tsk-board').html(response.html);
                        this.initializeSortable();
                        this.bindCardEvents();
                        Logger.log(Logger.levels.INFO, 'TaskBoard', 'Board refreshed successfully');
                    } else {
                        toastr.error(response.message || 'Failed to refresh the board');
                    }
                } catch (error) {
                    Logger.log(Logger.levels.ERROR, 'TaskBoard', 'Error refreshing board', error);
                    toastr.error('Failed to refresh the board');

                    // Show error state in the board
                    $('.tsk-board').html(`
                        <div class="alert alert-danger">
                            Failed to load task board. Please try refreshing the page.
                        </div>
                                    `);
                } finally {
                    UIManager.hideLoading($('.tsk-board'));
                }
            }

            static initialize(config) {
                const instance = new TaskBoard(config);
                window.taskBoard = instance;
                return instance;
            }
        }

        class ProcessCommentManager {
            constructor() {
                this.currentProcessId = null;
                this.dropzone = null;
                this.quill = null;
                this.modalElement = document.getElementById('processCommentsModal');
                this.modal = new bootstrap.Modal(this.modalElement);

                this.initialize();
            }

            initialize() {
                this.initializeQuill();
                this.initializeDropzone();
                this.bindEvents();
            }

            initializeQuill() {
                // Initialize Quill editor
                this.quill = new Quill('#commentContent', {
                    theme: 'snow',
                    placeholder: 'Add your comment...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });
            }




            initializeDropzone() {
                if (this.dropzone) {
                    this.dropzone.destroy();
                }

                this.dropzone = new Dropzone("#commentFileDropzone", {
                    url: "{{ route('projects.store_task_process_comments') }}",
                    autoProcessQueue: false,
                    addRemoveLinks: true,
                    maxFiles: 5,
                    acceptedFiles: 'image/*,.pdf,.doc,.docx,.xls,.xlsx',
                    dictDefaultMessage: 'Drop files here or click to upload'
                });
            }

            bindEvents() {
                $('#commentForm').on('submit', (e) => this.handleCommentSubmit(e));
            }

            async openComments(processId) {
                this.currentProcessId = processId;
                await this.loadComments(processId);
                this.modal.show();
            }

            async loadComments(processId) {
                try {
                    const response = await $.ajax({
                        url: "{{ route('projects.task_process_comments', ['task_process' => ':processId']) }}"
                            .replace(':processId', processId),
                        method: 'GET'
                    });

                    const commentsHtml = response.comments.map(comment => this.renderComment(comment)).join('');
                    $('#commentsContainer').html(commentsHtml);
                } catch (error) {
                    Logger.log(Logger.levels.ERROR, 'ProcessCommentManager', 'Error loading comments', error);
                    toastr.error('Failed to load comments');
                }
            }

            renderComment(comment) {
                return `
                  <div class="tsk-comment">
                      <div class="tsk-comment-avatar">
                          ${comment.user.name.charAt(0)}
                      </div>
                      <div class="tsk-comment-content">
                          <div class="tsk-comment-header">
                              <span class="tsk-comment-user">${comment.user.name}</span>
                              <span class="tsk-comment-time">${moment(comment.created_at).fromNow()}</span>
                          </div>
                          <div class="tsk-comment-text">${comment.notes}</div>
                          ${this.renderCommentFiles(comment.attachments)}
                      </div>
                  </div>
              `;
            }

            renderCommentFiles(attachments) {
                if (!attachments?.length) return '';

                return `
                  <div class="tsk-file-previews">
                      ${attachments.map(attachment => this.renderFilePreview(attachment)).join('')}
                  </div>
              `;
            }

            renderFilePreview(attachment) {
                const baseUrl = '{{ asset('') }}';
                return `
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
                                  ${this.formatFileSize(attachment.file_size)}
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
                                  onclick="processCommentManager.deleteFile(${attachment.id})"
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
              `;
            }

            formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }



            async deleteFile(attachmentId) {
                try {
                    const result = await Swal.fire({
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
                        buttonsStyling: false
                    });

                    if (result.isConfirmed) {
                        const response = await $.ajax({
                            url: "{{ route('remove-attachment', [':attachment']) }}"
                                .replace(':attachment', attachmentId),
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        if (response.success) {
                            $(`#attachment-${attachmentId}`).fadeOut(300, function() {
                                $(this).remove();
                            });
                            toastr.success(response.message || 'File deleted successfully');
                            await this.loadComments(this.currentProcessId);
                        } else {
                            toastr.error(response.message || 'Failed to delete file');
                        }
                    }
                } catch (error) {
                    Logger.log(Logger.levels.ERROR, 'ProcessCommentManager', 'Error deleting file', error);
                    toastr.error('An error occurred while deleting the file');
                }
            }
        }



        // Make the TaskTimelineModal class available globally if needed
        window.TaskTimelineModal = TaskTimelineModal;

        // In your document ready handler
        $(document).ready(() => {
            ModalManager.initialize();

            const config = {
                userRoles: {
                    isAdmin: @json(auth()->user()->hasRole('super-admin')),
                    isTrillionzGM: @json(auth()->user()->hasRole('Trillionz GM')),
                    isArtManager: @json(auth()->user()->hasRole('Art Manager')),
                    isEmployee: @json(auth()->user()->hasRole('Trillionz Employees')),
                    currentEmployeeId: @json(auth()->user()->employee->id ?? null)
                },
                statuses: {
                    PROCESSING: @json(getConstant(Modules::task_assignments_module, DropDownFields::employee_task_assignment_status, 'processing')->id),
                    ART_MANAGER_APPROVAL: @json(getConstant(Modules::task_assignments_module,
                            DropDownFields::employee_task_assignment_status,
                            'art_manager_approval')->id),
                    CUSTOMER_APPROVAL: @json(getConstant(Modules::task_assignments_module, DropDownFields::employee_task_assignment_status, 'customer_approval')->id),
                    COMPLETED: @json(getConstant(Modules::task_assignments_module, DropDownFields::employee_task_assignment_status, 'completed')->id)
                },
                routes: {
                    getTaskTimeline: @json(route(Task::ui['route'] . '.timeline', [':taskId'])),
                    moveTask: @json(route(Task::ui['route'] . '.move')),
                    getTaskBoard: @json(route(Task::ui['route'] . '.getTaskBoard')),
                    taskDetails: @json(route(Task::ui['route'] . '.details', [TaskAssignment::ui['s_lcf'] => ':taskAssignmentId'])),

                    // Add new routes for comments
                    storeComment: @json(route(Task::ui['route'] . '.storeComment', [':taskAssignmentId'])),
                    getComments: @json(route(Task::ui['route'] . '.getComments', [':taskAssignmentId'])),
                    uploadAttachments: @json(route(Task::ui['route'] . '.uploadAttachments', [':taskAssignmentId']))

                }
            };

            // Initialize the TaskBoard
            const taskBoard = TaskBoard.initialize(config);


            // Initialize ProcessCommentManager
            try {
                window.processCommentManager = new ProcessCommentManager();

                // Define the global openProcessComments function
                window.openProcessComments = function(processId) {
                    if (window.processCommentManager) {
                        window.processCommentManager.openComments(processId);
                    } else {
                        console.error('ProcessCommentManager not initialized');
                    }
                };
            } catch (error) {
                console.error('Error initializing ProcessCommentManager:', error);
            }
        });
    </script>
@endpush
