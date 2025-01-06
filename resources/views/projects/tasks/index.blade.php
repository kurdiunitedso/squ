@php
    use App\Models\Project;
    use App\Models\Task;
    use App\Models\TaskAssignment;
    use App\Models\TaskProcess;
@endphp
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <!-- SVG for search icon -->
                        </span>
                        <input type="text" data-kt-{{ Task::ui['s_lcf'] }}-table-filter="search"
                            class="form-control form-control-solid w-250px ps-14"
                            placeholder="Search {{ Task::ui['p_ucf'] }}" />
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-items-table-toolbar="base">
                        @include(Project::ui['route'] . '.' . Task::ui['route'] . '._filter')
                        <button id="refresh_tasks_button" class="btn btn-light-primary me-3">
                            <span class="svg-icon svg-icon-2">
                                <!-- SVG for refresh icon -->
                            </span>
                            {{ t('Refresh Tasks') }}
                        </button>
                        <a href="#" class="btn btn-primary" id="add_{{ Task::ui['s_lcf'] }}_modal">
                            <span class="svg-icon svg-icon-2">
                                <!-- SVG for add icon -->
                            </span>
                            {{ t('Assign ' . Task::ui['p_ucf']) }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body py-4">
                <div class="task-board">
                    <div class="task-board-container" id="taskBoardContainer">
                        <!-- Existing content -->
                    </div>
                    <div id="taskBoardSpinner" class="d-none">
                        <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Previous styles remain the same -->

@if ($item_model->exists)
    @push('scripts')
        <script>
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

            class TaskBoardElements {
                constructor() {
                    this.modal = document.getElementById('kt_modal_general');
                    this.refreshButton = document.getElementById('refresh_tasks_button');
                    this.container = document.getElementById('taskBoardContainer');
                    this.searchInput = document.querySelector('input[data-kt-task-table-filter="search"]');
                    this.addButton = document.getElementById('add_task_modal');
                    this.spinner = document.getElementById('taskBoardSpinner');
                    this.taskboardFilterBtn = document.getElementById('taskboardFilterBtn');
                    this.taskboardResetFilterBtn = document.getElementById('taskboardResetFilterBtn');

                    Logger.log(Logger.levels.DEBUG, 'TaskBoardElements', 'Elements initialized');
                }
            }

            class TaskBoardConfig {
                constructor(projectId, assetUrl, routes) {
                    this.projectId = projectId;
                    this.assetUrl = assetUrl;
                    this.routes = routes;

                    Logger.log(Logger.levels.DEBUG, 'TaskBoardConfig', 'Configuration initialized', {
                        projectId
                    });
                }
            }

            class FilterManager {
                constructor() {
                    Logger.log(Logger.levels.DEBUG, 'FilterManager', 'Initializing filter manager');
                }

                initializeFilters() {
                    Logger.log(Logger.levels.INFO, 'FilterManager', 'Setting up filters');

                    try {
                        // Initialize date picker with default range
                        const firstDay = new Date(new Date().getFullYear(), new Date().getMonth(), 1);
                        const lastDay = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0);

                        $("#kt_datepicker_8").flatpickr({
                            mode: "range",
                            dateFormat: "Y-m-d",
                            // defaultDate: [firstDay, lastDay],
                            altInput: true,
                            altFormat: "Y-m-d",
                            static: true
                        });

                        // Initialize Select2
                        $('.datatable-input[data-kt-select2="true"]').select2({
                            dropdownParent: $("#kt_menu_64ca1a18f399e")
                        });

                        Logger.log(Logger.levels.INFO, 'FilterManager', 'Filters initialized successfully');
                    } catch (error) {
                        Logger.log(Logger.levels.ERROR, 'FilterManager', 'Error initializing filters', {
                            error: error.message
                        });
                    }
                }

                collectFilterValues() {
                    Logger.log(Logger.levels.DEBUG, 'FilterManager', 'Collecting filter values');

                    const filters = {};
                    try {
                        document.querySelectorAll('.datatable-input').forEach(input => {
                            const columnIndex = input.dataset.colIndex;
                            let value = input.value;

                            if (input.multiple) {
                                value = $(input).val();
                            }

                            if (value && value.length) {
                                filters[columnIndex] = value;
                            }
                        });

                        Logger.log(Logger.levels.DEBUG, 'FilterManager', 'Filter values collected', {
                            filters
                        });
                        return filters;
                    } catch (error) {
                        Logger.log(Logger.levels.ERROR, 'FilterManager', 'Error collecting filter values', {
                            error: error.message
                        });
                        return {};
                    }
                }

                resetFilters() {
                    Logger.log(Logger.levels.INFO, 'FilterManager', 'Resetting filters');

                    try {
                        // Reset Select2 dropdowns
                        $('.datatable-input[data-kt-select2="true"]').each(function() {
                            const select2Instance = $(this).data('select2');
                            if (select2Instance) {
                                $(this).val(null).trigger('change');
                            }
                        });

                        // Reset regular select elements
                        $('select.datatable-input').not('[data-kt-select2="true"]').each(function() {
                            $(this).val('').trigger('change');
                        });

                        // Reset Flatpickr date input
                        const dateInput = $("#kt_datepicker_8");
                        if (dateInput.length && dateInput[0]._flatpickr) {
                            const workDatePicker = dateInput[0]._flatpickr;
                            const firstDay = new Date(new Date().getFullYear(), new Date().getMonth(), 1);
                            const lastDay = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0);
                            // workDatePicker.setDate([firstDay, lastDay], true);
                        }

                        // Reset the filter form
                        const filterForm = document.getElementById('filter-form');
                        if (filterForm) {
                            filterForm.reset();
                        }

                        Logger.log(Logger.levels.INFO, 'FilterManager', 'Filters reset successfully');
                        return true;
                    } catch (error) {
                        Logger.log(Logger.levels.ERROR, 'FilterManager', 'Error resetting filters', {
                            error: error.message
                        });
                        return false;
                    }
                }
            }

            class TaskBoard {
                constructor(projectId, assetUrl, routes) {
                    this.elements = new TaskBoardElements();
                    this.config = new TaskBoardConfig(projectId, assetUrl, routes);
                    this.fileManager = new FileManager(this.config);
                    this.filterManager = new FilterManager();
                    this.modal = null;
                    this.currentTaskData = null;

                    Logger.log(Logger.levels.INFO, 'TaskBoard', 'TaskBoard instance created', {
                        projectId
                    });
                }

                init() {
                    Logger.log(Logger.levels.INFO, 'TaskBoard', 'Initializing TaskBoard');

                    this.modal = new bootstrap.Modal(this.elements.modal);
                    this.filterManager.initializeFilters();
                    this.bindEvents();
                    this.refreshBoard();
                    this.initializeCallbacks();

                    Logger.log(Logger.levels.INFO, 'TaskBoard', 'TaskBoard initialized successfully');
                }
                bindEvents() {
                    Logger.log(Logger.levels.DEBUG, 'TaskBoard', 'Binding events');

                    // Add Button Event
                    this.elements.addButton?.addEventListener('click', (e) => {
                        e.preventDefault();
                        this.assignTasks();
                    });

                    // Reset Filter Button Event
                    this.elements.taskboardResetFilterBtn?.addEventListener('click', (e) => {
                        e.preventDefault();
                        if (this.filterManager.resetFilters()) {
                            this.refreshBoard();
                        }
                    });

                    // Filter Button Event
                    this.elements.taskboardFilterBtn?.addEventListener('click', (e) => {
                        e.preventDefault();
                        const filters = this.filterManager.collectFilterValues();
                        this.refreshBoard(this.elements.searchInput?.value, filters);
                    });

                    // Search Input Event
                    this.elements.searchInput?.addEventListener('input', this.debounce(() => {
                        const filters = this.filterManager.collectFilterValues();
                        this.refreshBoard(this.elements.searchInput.value, filters);
                    }, 300));

                    // Refresh Button Event
                    this.elements.refreshButton?.addEventListener('click', (e) => {
                        e.preventDefault();
                        const filters = this.filterManager.collectFilterValues();
                        this.refreshBoard(this.elements.searchInput?.value, filters);
                    });

                    this.elements.container?.addEventListener('click', (e) => {
                        // Ignore clicks on the timeline button
                        if (e.target.closest('.view-timeline-btn')) {
                            return;
                        }

                        const taskCard = e.target.closest('.task-card');
                        if (taskCard) {
                            this.handleTaskCardClick(taskCard);
                        }
                    });
                    // Add event delegation for delete attachment buttons
                    document.addEventListener('click', (e) => {
                        const deleteBtn = e.target.closest('.delete-attachment');
                        if (deleteBtn) {
                            e.preventDefault();
                            const attachmentId = deleteBtn.dataset.attachmentId;
                            if (attachmentId && this.fileManager) {
                                Logger.log(Logger.levels.DEBUG, 'TaskBoard', 'Delete attachment button clicked', {
                                    attachmentId
                                });
                                this.fileManager.removeFile(attachmentId);
                            }
                        }
                    });

                    Logger.log(Logger.levels.DEBUG, 'TaskBoard', 'Events bound successfully');
                }

                handleTaskCardClick(taskCard) {
                    Logger.log(Logger.levels.INFO, 'TaskBoard', 'Task card clicked', {
                        taskCard: taskCard.dataset
                    });

                    const taskAssignmentId = taskCard.dataset.taskAssignmentId;
                    const taskId = taskCard.dataset.taskId;

                    if (!taskAssignmentId || !taskId) {
                        Logger.log(Logger.levels.ERROR, 'TaskBoard', 'Missing task data attributes');
                        return;
                    }

                    // Store current task data
                    this.currentTaskData = {
                        taskAssignmentId,
                        taskId
                    };

                    const url = this.config.routes.addEditTaskAssignment
                        .replace(':projectId', this.config.projectId)
                        .replace(':taskId', taskId)
                        .replace(':taskAssignmentId', taskAssignmentId);

                    Logger.log(Logger.levels.DEBUG, 'TaskBoard', 'Opening task modal', {
                        taskAssignmentId,
                        taskId,
                        url
                    });

                    // Render the modal
                    globalRenderModal(
                        url,
                        $(taskCard),
                        '#kt_modal_general',
                        this.modal, {},
                        '#kt_modal_add_task_assignment_form',
                        null,
                        '[data-kt-task_assignment-modal-action="submit"]', {},
                        this.onFormSuccessCallBack.bind(this),
                        null,
                        () => {
                            this.updateFormAttributes();
                            this.initializeModalComponents();
                            // Add cancel button handler
                            const cancelButton = document.querySelector(
                                '[data-kt-task_assignment-modal-action="cancel"]');
                            if (cancelButton) {
                                cancelButton.addEventListener('click', () => {
                                    this.modal.hide();
                                });
                            }
                        }
                    );
                }

                updateFormAttributes() {
                    Logger.log(Logger.levels.DEBUG, 'TaskBoard', 'Updating form attributes');

                    const form = document.querySelector('#kt_modal_add_task_assignment_form');
                    if (!form || !this.currentTaskData) {
                        Logger.log(Logger.levels.ERROR, 'TaskBoard', 'Form or task data not found');
                        return;
                    }

                    form.setAttribute('data-project-id', this.config.projectId);
                    form.setAttribute('data-task-assignment-id', this.currentTaskData.taskAssignmentId);
                }

                initializeModalComponents() {
                    Logger.log(Logger.levels.INFO, 'TaskBoard', 'Initializing modal components');

                    this.initDatePickers();
                    this.initSelect2();
                    this.fileManager.initDropzone(this.currentTaskData.taskAssignmentId);
                    this.fileManager.loadExistingAttachments(this.currentTaskData.taskAssignmentId);
                }

                initDatePickers() {
                    Logger.log(Logger.levels.DEBUG, 'TaskBoard', 'Initializing date pickers');

                    const startDatePicker = flatpickr("input[name='task_assignment_start_date']", {
                        minDate: 'today',
                        onChange: (selectedDates, dateStr, instance) => {
                            // Update end date min date when start date changes
                            const endDatePicker = document.querySelector(
                                "input[name='task_assignment_end_date']")._flatpickr;
                            if (endDatePicker) {
                                endDatePicker.set('minDate', dateStr);
                            }
                        }
                    });

                    flatpickr("input[name='task_assignment_end_date']", {
                        minDate: 'today'
                    });
                }

                initSelect2() {
                    Logger.log(Logger.levels.DEBUG, 'TaskBoard', 'Initializing Select2');

                    const statusSelect = document.querySelector('select[name="status_id"]');
                    if (statusSelect) {
                        $(statusSelect).select2({
                            dropdownParent: $('#kt_modal_general')
                        });
                    }
                }

                onFormSuccessCallBack(response, form, modalBootstrap) {
                    Logger.log(Logger.levels.INFO, 'TaskBoard', 'Form submitted successfully', {
                        response
                    });

                    this.refreshBoard();
                    toastr.success(response.message);

                    // Clean up
                    if (this.fileManager.dropzone) {
                        this.fileManager.dropzone.destroy();
                        this.fileManager.dropzone = null;
                    }
                    this.currentTaskData = null;

                    form.reset();
                    modalBootstrap.hide();
                }

                initializeCallbacks() {
                    Logger.log(Logger.levels.DEBUG, 'TaskBoard', 'Initializing callbacks');

                    // Add your callback initializations here
                }

                debounce(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }

                toggleBoardLoading(show) {
                    this.elements.container.classList.toggle('d-none', show);
                    this.elements.spinner.classList.toggle('d-none', !show);
                    Logger.log(Logger.levels.DEBUG, 'TaskBoard', 'Toggle board loading', {
                        show
                    });
                }

                async assignTasks() {
                    Logger.log(Logger.levels.INFO, 'TaskBoard', 'Assigning tasks');

                    try {
                        const response = await fetch(this.config.routes.assignTasks, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        const data = await response.json();
                        if (data.status) {
                            toastr.success(data.message);
                            this.refreshBoard();
                            Logger.log(Logger.levels.INFO, 'TaskBoard', 'Tasks assigned successfully');
                        } else {
                            toastr.error(data.message);
                            Logger.log(Logger.levels.WARN, 'TaskBoard', 'Failed to assign tasks', {
                                message: data.message
                            });
                        }
                    } catch (error) {
                        Logger.log(Logger.levels.ERROR, 'TaskBoard', 'Error assigning tasks', {
                            error: error.message
                        });
                        toastr.error('An error occurred while assigning tasks');
                    }
                }

                async refreshBoard(searchTerm = '', filters = null) {
                    Logger.log(Logger.levels.INFO, 'TaskBoard', 'Refreshing board', {
                        searchTerm,
                        filters
                    });

                    try {
                        this.toggleBoardLoading(true);
                        const params = new URLSearchParams();

                        if (searchTerm) {
                            params.append('search', searchTerm);
                        }

                        if (filters) {
                            Object.entries(filters).forEach(([key, value]) => {
                                if (Array.isArray(value)) {
                                    value.forEach(v => params.append(`${key}[]`, v));
                                } else {
                                    params.append(key, value);
                                }
                            });
                        }

                        const url = this.config.routes.getTaskBoard
                            .replace(':projectId', this.config.projectId) +
                            (params.toString() ? `?${params.toString()}` : '');

                        const response = await fetch(url);
                        const data = await response.json();

                        // if (data.status && data.createView) {
                        this.elements.container.innerHTML = data.createView;
                        Logger.log(Logger.levels.INFO, 'TaskBoard', 'Board refreshed successfully');
                        // } else {
                        //     Logger.log(Logger.levels.ERROR, 'TaskBoard', 'Failed to refresh board', {
                        //         data
                        //     });
                        //     toastr.error('Failed to refresh task board');
                        // }
                    } catch (error) {
                        Logger.log(Logger.levels.ERROR, 'TaskBoard', 'Error refreshing board', {
                            error: error.message
                        });
                        toastr.error('An error occurred while refreshing the board');
                    } finally {
                        this.toggleBoardLoading(false);
                    }
                }

                static initialize(projectId, assetUrl, routes) {
                    document.addEventListener('DOMContentLoaded', () => {
                        window.taskBoard = new TaskBoard(projectId, assetUrl, routes);
                        window.taskBoard.init();
                    });
                }
            }
            class FileManager {
                constructor(config) {
                    this.config = config;
                    this.dropzone = null;

                    Logger.log(Logger.levels.DEBUG, 'FileManager', 'Initializing file manager', {
                        projectId: config.projectId
                    });
                }

                addFileToList(attachment) {
                    Logger.log(Logger.levels.INFO, 'FileManager', 'Adding file to list', {
                        attachment
                    });

                    const filesList = document.querySelector('.existing-files-list');
                    if (!filesList) {
                        Logger.log(Logger.levels.WARN, 'FileManager', 'Files list element not found');
                        return;
                    }

                    const fileItem = document.createElement('div');
                    fileItem.className = 'existing-file-item d-flex align-items-center p-2 fade-in';
                    fileItem.id = `attachment-${attachment.id}`;

                    const filePath = attachment.file_path.startsWith('http') ?
                        attachment.file_path :
                        `${this.config.assetUrl.replace(/\/$/, '')}/${attachment.file_path.replace(/^\//, '')}`;

                    fileItem.innerHTML = `
                            <i class="fas fa-file me-2 text-primary"></i>
                            <span class="file-name flex-grow-1">${attachment.file_name}</span>
                            <div class="file-actions">
                                <a href="${filePath}" class="btn btn-icon btn-sm btn-light me-2" target="_blank" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button type="button" class="btn btn-icon btn-sm btn-light-danger delete-attachment"
                                        data-attachment-id="${attachment.id}" title="Delete">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;

                    filesList.insertBefore(fileItem, filesList.firstChild);

                    setTimeout(() => {
                        fileItem.classList.remove('fade-in');
                    }, 500);

                    Logger.log(Logger.levels.INFO, 'FileManager', 'File added successfully', {
                        attachmentId: attachment.id
                    });
                }

                async loadExistingAttachments(taskAssignmentId) {
                    Logger.log(Logger.levels.INFO, 'FileManager', 'Loading existing attachments', {
                        taskAssignmentId
                    });

                    if (!taskAssignmentId) {
                        Logger.log(Logger.levels.ERROR, 'FileManager',
                            'Task assignment ID required for loading attachments');
                        return;
                    }

                    try {
                        const url = this.config.routes.getAttachments
                            .replace(':projectId', this.config.projectId)
                            .replace(':taskAssignmentId', taskAssignmentId);

                        const response = await fetch(url, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        if (data.success && data.attachments) {
                            const filesList = document.querySelector('.existing-files-list');
                            if (filesList) {
                                filesList.innerHTML = '';
                                data.attachments.forEach(attachment => {
                                    this.addFileToList(attachment);
                                });
                            }
                            Logger.log(Logger.levels.INFO, 'FileManager', 'Attachments loaded successfully', {
                                count: data.attachments.length
                            });
                        }
                    } catch (error) {
                        Logger.log(Logger.levels.ERROR, 'FileManager', 'Error loading attachments', {
                            error: error.message
                        });
                        toastr.error('Failed to load existing attachments');
                    }
                }

                async removeFile(attachmentId) {
                    Logger.log(Logger.levels.INFO, 'FileManager', 'Removing file', {
                        attachmentId
                    });

                    try {
                        const result = await Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, cancel!',
                            customClass: {
                                confirmButton: "btn btn-danger",
                                cancelButton: "btn btn-active-light"
                            },
                            buttonsStyling: false
                        });

                        if (!result.isConfirmed) {
                            Logger.log(Logger.levels.INFO, 'FileManager', 'File deletion cancelled by user');
                            return;
                        }

                        // Show loading state
                        Swal.fire({
                            text: "Deleting...",
                            icon: "info",
                            buttonsStyling: false,
                            showConfirmButton: false,
                            timer: 0,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        const fileItem = document.getElementById(`attachment-${attachmentId}`);
                        if (fileItem) {
                            fileItem.classList.add('fade-out');
                        }

                        const url = this.config.routes.removeAttachment
                            .replace(':projectId', this.config.projectId)
                            .replace(':attachmentId', attachmentId);

                        const response = await fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            if (fileItem) {
                                setTimeout(() => {
                                    fileItem.remove();
                                }, 300);
                            }

                            Swal.fire({
                                text: "File has been deleted!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });

                            Logger.log(Logger.levels.INFO, 'FileManager', 'File removed successfully', {
                                attachmentId
                            });
                        } else {
                            if (fileItem) {
                                fileItem.classList.remove('fade-out');
                            }

                            Swal.fire({
                                text: data.message || "Failed to delete file",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });

                            Logger.log(Logger.levels.ERROR, 'FileManager', 'Failed to remove file', {
                                attachmentId,
                                message: data.message
                            });
                        }
                    } catch (error) {
                        Logger.log(Logger.levels.ERROR, 'FileManager', 'Error removing file', {
                            attachmentId,
                            error: error.message
                        });

                        Swal.fire({
                            text: "An error occurred while deleting the file",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                }

                initDropzone(taskAssignmentId) {
                    Logger.log(Logger.levels.INFO, 'FileManager', 'Initializing Dropzone', {
                        taskAssignmentId
                    });

                    if (this.dropzone) {
                        this.dropzone.destroy();
                    }

                    const dropzoneElement = document.querySelector('#taskAttachmentDropzone');
                    if (!dropzoneElement) {
                        Logger.log(Logger.levels.ERROR, 'FileManager', 'Dropzone element not found');
                        return;
                    }

                    const uploadUrl = this.config.routes.uploadAttachment
                        .replace(':projectId', this.config.projectId);

                    this.dropzone = new Dropzone(dropzoneElement, {
                        url: uploadUrl,
                        paramName: "file",
                        maxFiles: 10,
                        maxFilesize: 10,
                        acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt",
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        params: {
                            task_assignment_id: taskAssignmentId
                        },
                        previewsContainer: false,
                        addRemoveLinks: false
                    });

                    this.initDropzoneEvents(taskAssignmentId);
                    Logger.log(Logger.levels.INFO, 'FileManager', 'Dropzone initialized successfully');
                }

                initDropzoneEvents(taskAssignmentId) {
                    if (!this.dropzone) return;

                    this.dropzone.on("sending", (file) => {
                        Logger.log(Logger.levels.DEBUG, 'FileManager', 'Sending file', {
                            fileName: file.name
                        });

                        const filesList = document.querySelector('.existing-files-list');
                        if (filesList) {
                            const progressItem = document.createElement('div');
                            progressItem.className = 'existing-file-item d-flex align-items-center p-2';
                            progressItem.id = `upload-${file.upload.uuid}`;
                            progressItem.innerHTML = `
                    <i class="fas fa-spinner fa-spin me-2 text-primary"></i>
                    <span class="file-name flex-grow-1">${file.name}</span>
                    <span class="upload-progress">Uploading...</span>
                `;
                            filesList.insertBefore(progressItem, filesList.firstChild);
                        }
                    });

                    this.dropzone.on("success", (file, response) => {
                        Logger.log(Logger.levels.DEBUG, 'FileManager', 'File upload success', {
                            fileName: file.name,
                            response
                        });

                        const progressItem = document.getElementById(`upload-${file.upload.uuid}`);
                        if (progressItem) {
                            progressItem.remove();
                        }

                        if (response.success) {
                            this.addFileToList(response.attachment);
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message || 'Upload failed');
                        }

                        this.dropzone.removeFile(file);
                    });

                    this.dropzone.on("error", (file, errorMessage) => {
                        Logger.log(Logger.levels.ERROR, 'FileManager', 'File upload error', {
                            fileName: file.name,
                            error: errorMessage
                        });

                        const progressItem = document.getElementById(`upload-${file.upload.uuid}`);
                        if (progressItem) {
                            progressItem.remove();
                        }

                        const message = typeof errorMessage === 'string' ? errorMessage :
                            (errorMessage.message || 'Upload failed');
                        toastr.error(message);
                        this.dropzone.removeFile(file);
                    });
                }
            }

            // Usage
            TaskBoard.initialize(
                "{{ $item_model->id }}",
                "{{ asset('') }}", {
                    assignTasks: "{{ route(Project::ui['route'] . '.' . Task::ui['route'] . '.assign_tasks', [Project::ui['s_lcf'] => $item_model->id]) }}",
                    getTaskBoard: "{{ route(Project::ui['route'] . '.' . Task::ui['route'] . '.getTaskBoard', [Project::ui['s_lcf'] => ':projectId']) }}",
                    addEditTaskAssignment: "{{ route(Project::ui['route'] . '.' . Task::ui['route'] . '.addEditTaskAssignment', [Project::ui['s_lcf'] => ':projectId', Task::ui['s_lcf'] => ':taskId', TaskAssignment::ui['s_lcf'] => ':taskAssignmentId']) }}",
                    uploadAttachment: "{{ route(Project::ui['route'] . '.' . Task::ui['route'] . '.upload-attachment', [Project::ui['s_lcf'] => ':projectId']) }}",
                    removeAttachment: "{{ route(Project::ui['route'] . '.' . Task::ui['route'] . '.remove-attachment', [Project::ui['s_lcf'] => ':projectId', 'attachment' => ':attachmentId']) }}",
                    getAttachments: "{{ route(Project::ui['route'] . '.' . Task::ui['route'] . '.get-attachments', [Project::ui['s_lcf'] => ':projectId', 'taskAssignment' => ':taskAssignmentId']) }}"
                }
            );
        </script>
        <script>
            class TaskTimelineModal {
                constructor(config) {
                    this.config = config;
                    this.modal = null;
                    this.currentTaskId = null;
                    this.modalElement = null;
                    this.generalModal = new bootstrap.Modal(document.getElementById('kt_modal_general'));
                    this.initializeModal();
                    this.bindEvents();
                }

                initializeModal() {
                    // Create modal element if it doesn't exist
                    if (!document.getElementById('taskTimelineModal')) {
                        const modalHtml = `
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
                </div>`;

                        document.body.insertAdjacentHTML('beforeend', modalHtml);
                    }

                    this.modalElement = document.getElementById('taskTimelineModal');
                    this.modal = new bootstrap.Modal(this.modalElement);

                    // Add required styles
                    const styleElement = document.createElement('style');
                    styleElement.textContent = `
                                        .timeline-window-container {
                                            background-color: white;
                                            height: 100%;
                                        }
                                        .timeline-container {
                                            margin-top: 20px;
                                            overflow-x: auto;
                                        }
                                        .workflow-container {
                                            padding: 20px;
                                            min-width: 1000px;
                                        }
                                        .workflow-title {
                                            margin-bottom: 30px;
                                            font-size: 1.25rem;
                                            font-weight: 600;
                                            color: #181C32;
                                        }
                                        .timeline-dates {
                                            display: flex;
                                            margin-bottom: 20px;
                                            padding: 10px 0;
                                            border-bottom: 1px solid #EFF2F5;
                                        }
                                        .date {
                                            text-align: center;
                                            flex: 1;
                                            padding: 5px;
                                            font-size: 0.85rem;
                                            color: #7E8299;
                                            font-weight: 500;
                                        }
                                        .workflow-row {
                                            display: grid;
                                            grid-template-columns: 200px 1fr;
                                            margin-bottom: 15px;
                                            border-radius: 6px;
                                            border: 1px solid #EFF2F5;
                                        }
                                        .role-name {
                                            padding: 12px 16px;
                                            font-weight: 500;
                                            color: #3F4254;
                                            background: #F5F8FA;
                                            border-right: 1px solid #EFF2F5;
                                            display: flex;
                                            align-items: center;
                                        }
                                        .timeline-content {
                                            position: relative;
                                            height: 60px;
                                            background: #fff;
                                        }
                                        .timeline-item {
                                            position: absolute;
                                            padding: 6px 12px;
                                            border-radius: 6px;
                                            font-size: 0.875rem;
                                            white-space: nowrap;
                                            top: 50%;
                                            transform: translateY(-50%);
                                            z-index: 1;
                                            transition: all 0.3s ease;
                                        }
                                        .stats-container {
                                            background: #F5F8FA;
                                            border-radius: 6px;
                                            padding: 16px;
                                            margin: 24px;
                                        }
                                        .stats-item {
                                            display: inline-flex;
                                            align-items: center;
                                            padding: 8px 16px;
                                            border-radius: 6px;
                                            background: white;
                                            margin-right: 16px;
                                            border: 1px solid #EFF2F5;
                                        }
                                        .stats-item strong {
                                            color: #3F4254;
                                            margin-right: 8px;
                                        }
                                        .task-assignment {
                                            background-color: #E1F0FF;
                                            border: 1px solid #E1F0FF;
                                            color: #009EF7;
                                        }
                                        .completed-item {
                                            background-color: #E8FFF3;
                                            border: 1px solid #E8FFF3;
                                            color: #50CD89;
                                        }
                                        .processing-item {
                                            background-color: #FFF8DD;
                                            border: 1px solid #FFF8DD;
                                            color: #FFC700;
                                        }
                                        .pending-item {
                                            background-color: #FFF5F8;
                                            border: 1px solid #FFF5F8;
                                            color: #F1416C;
                                        }
                                        .not-started-item {
                                            background-color: #F5F8FA;
                                            border: 1px solid #EFF2F5;
                                            color: #7E8299;
                                        }
                                        .final-step {
                                            background-color: #F8F5FF;
                                            border: 1px solid #F8F5FF;
                                            color: #7239EA;
                                        }`;

                    document.head.appendChild(styleElement);
                }

                bindEvents() {
                    $(document).on('click', '.view-timeline-btn', (e) => {
                        e.preventDefault();
                        const button = $(e.currentTarget);
                        const taskId = button.data('task-id');
                        const taskTitle = button.data('task-title');
                        this.openTimelineModal(taskId, taskTitle);
                    });
                    // Handle clickable assignments within the timeline
                    $(this.modalElement).on('click', '.clickable-assignment', (e) => {
                        e.preventDefault();
                        e.stopPropagation();

                        const taskId = $(e.currentTarget).data('task-id');
                        const taskAssignmentId = $(e.currentTarget).data('task-assignment-id');

                        if (taskId && taskAssignmentId) {
                            this.showAssignmentDetailsModal(taskId, taskAssignmentId);
                        }
                    });
                }

                showAssignmentDetailsModal(taskId, taskAssignmentId) {
                    const url = this.config.routes.addEditTaskAssignment
                        .replace(':projectId', this.config.projectId)
                        .replace(':taskId', taskId)
                        .replace(':taskAssignmentId', taskAssignmentId);

                    globalRenderModal(
                        url,
                        null,
                        '#kt_modal_general',
                        this.generalModal, {}, // validatorFields
                        '#kt_modal_add_task_assignment_form',
                        null, // dataTableId
                        '[data-kt-task_assignment-modal-action="submit"]', {}, // RequiredInputList
                        (response, form, modalBootstrap) => {
                            // Success callback
                            if (response.status) {
                                toastr.success(response.message);
                                modalBootstrap.hide();
                                this.refreshTimeline(taskId);
                            } else {
                                toastr.error(response.message || 'An error occurred');
                            }
                        },
                        null, // fillSelectListFromAjaxData
                        () => {
                            // Callback after modal is shown
                            this.initializeDetailsModalComponents();

                            // Set form attributes if needed
                            const form = document.querySelector('#kt_modal_add_task_assignment_form');
                            if (form) {
                                form.setAttribute('data-project-id', this.config.projectId);
                                form.setAttribute('data-task-assignment-id', taskAssignmentId);
                            }
                        }
                    );
                }

                initializeDetailsModalComponents() {
                    // Initialize date pickers
                    const startDatePicker = flatpickr("input[name='task_assignment_start_date']", {
                        minDate: 'today',
                        onChange: (selectedDates, dateStr, instance) => {
                            const endDatePicker = document.querySelector(
                                "input[name='task_assignment_end_date']")?._flatpickr;
                            if (endDatePicker) {
                                endDatePicker.set('minDate', dateStr);
                            }
                        }
                    });

                    flatpickr("input[name='task_assignment_end_date']", {
                        minDate: 'today'
                    });

                    // Initialize Select2
                    const statusSelect = document.querySelector('select[name="status_id"]');
                    if (statusSelect) {
                        $(statusSelect).select2({
                            dropdownParent: $('#kt_modal_general')
                        });
                    }
                }

                openTimelineModal(taskId, taskTitle) {
                    this.currentTaskId = taskId;

                    // Update modal title
                    const modalTitle = this.modalElement.querySelector('.modal-title');
                    modalTitle.textContent = `Task Timeline: ${taskTitle}`;

                    // Show loading state
                    const timelineContent = this.modalElement.querySelector('#timelineContent');
                    timelineContent.innerHTML = `
                                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>`;

                    // Show the modal
                    this.modal.show();
                    this.initializeScrollSync();


                    // Fetch timeline data
                    const timelineUrl = this.config.routes.getTaskTimeline
                        .replace(':projectId', this.config.projectId)
                        .replace(':taskId', taskId);

                    $.ajax({
                        url: timelineUrl,
                        method: 'GET',
                        success: (response) => {
                            if (response.status) {
                                // Update stats
                                const statsContainer = this.modalElement.querySelector('.stats-container');
                                statsContainer.classList.remove('d-none');
                                statsContainer.innerHTML = `
                                            <div class="stats-item">
                                                <strong>Total:</strong> ${response.stats.total_assignments}
                                            </div>
                                            <div class="stats-item">
                                                <strong>Completed:</strong> ${response.stats.completed_assignments}
                                            </div>
                                            <div class="stats-item">
                                                <strong>Processing:</strong> ${response.stats.processing_assignments}
                                            </div>
                                            <div class="stats-item">
                                                <strong>Customer Approval:</strong> ${response.stats.customer_approval_assignments}
                                            </div>
                                            <div class="stats-item">
                                                <strong>Art Manager Approval:</strong> ${response.stats.art_manager_approval_assignments}
                                            </div>`;

                                // Update timeline content
                                timelineContent.innerHTML = response.timelineHtml;
                            } else {
                                timelineContent.innerHTML =
                                    '<div class="alert alert-danger">Failed to load timeline data</div>';
                            }
                        },
                        error: () => {
                            timelineContent.innerHTML =
                                '<div class="alert alert-danger">Failed to load timeline data</div>';
                        }
                    });
                }
                initializeScrollSync() {
                    const datesWrapper = document.querySelector('.timeline-dates-wrapper');
                    const contentWrapper = document.querySelector('.timeline-content-wrapper');

                    if (!datesWrapper || !contentWrapper) return;

                    // Sync scroll from content to dates
                    contentWrapper.addEventListener('scroll', () => {
                        if (datesWrapper.scrollLeft !== contentWrapper.scrollLeft) {
                            datesWrapper.scrollLeft = contentWrapper.scrollLeft;
                        }
                    });

                    // Sync scroll from dates to content
                    datesWrapper.addEventListener('scroll', () => {
                        if (contentWrapper.scrollLeft !== datesWrapper.scrollLeft) {
                            contentWrapper.scrollLeft = datesWrapper.scrollLeft;
                        }
                    });

                    // Handle scroll button clicks
                    const scrollButtons = document.querySelectorAll('.scroll-button');
                    scrollButtons.forEach(button => {
                        button.addEventListener('click', (e) => {
                            const direction = e.currentTarget.getAttribute('data-direction');
                            const scrollAmount = direction === 'left' ? -200 : 200;

                            contentWrapper.scrollBy({
                                left: scrollAmount,
                                behavior: 'smooth'
                            });
                        });
                    });
                }

                refreshTimeline(taskId) {
                    if (this.modal && this.modal._isShown && this.currentTaskId === taskId) {
                        this.openTimelineModal(taskId, this.modalElement.querySelector('.modal-title').textContent.replace(
                            'Task Timeline: ', ''));
                    }
                }
            }

            // Initialize the timeline modal handler
            $(document).ready(() => {
                window.taskTimelineModal = new TaskTimelineModal({
                    projectId: "{{ $item_model->id }}",
                    assetUrl: "{{ asset('') }}",
                    routes: {
                        getTaskTimeline: "{{ route(Project::ui['route'] . '.' . Task::ui['route'] . '.getTaskTimeline', [Project::ui['s_lcf'] => ':projectId', Task::ui['s_lcf'] => ':taskId']) }}",
                        getTimelineFilters: "{{ route(Project::ui['route'] . '.' . Task::ui['route'] . '.getTimelineFilters', [Project::ui['s_lcf'] => ':projectId', Task::ui['s_lcf'] => ':taskId']) }}",
                        addEditTaskAssignment: "{{ route(Project::ui['route'] . '.' . Task::ui['route'] . '.addEditTaskAssignment', [Project::ui['s_lcf'] => ':projectId', Task::ui['s_lcf'] => ':taskId', TaskAssignment::ui['s_lcf'] => ':taskAssignmentId']) }}"
                    }
                });
            });
        </script>
    @endpush
@endif
