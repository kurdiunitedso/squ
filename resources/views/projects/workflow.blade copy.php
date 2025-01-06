@php
    use App\Models\Employee;
    $employees = Employee::get();
@endphp




<div class="card mb-5 mb-xl-10">
    <div class="card-body">
        <div class="row">
            <!-- Left box: All employees -->
            <div class="col-md-5">
                <div class="employee-list-container">
                    <div class="employee-list-header">
                        <h4 class="fw-semibold m-0">{{ t('All Employees') }}</h4>
                    </div>

                    <div class="employee-list-search">
                        <input type="text" class="form-control" id="searchAllEmployees"
                            placeholder="{{ t('Search...') }}">
                    </div>

                    <div class="employee-list-body">
                        <ul id="allEmployees" class="employee-list list-group list-group-flush">
                            @foreach ($employees as $employee)
                                <li class="list-group-item" data-id="{{ $employee->id }}">
                                    {{ $employee->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Middle: Drag controls -->
            <div class="col-md-2 d-flex flex-column justify-content-center align-items-center">
                <button class="btn btn-icon btn-light-primary mb-2" id="moveRight">
                    <i class="ki-duotone ki-arrow-right fs-2"><span class="path1"></span><span
                            class="path2"></span></i>
                </button>
                <button class="btn btn-icon btn-light-primary mb-2" id="moveLeft">
                    <i class="ki-duotone ki-arrow-left fs-2"><span class="path1"></span><span
                            class="path2"></span></i>
                </button>
            </div>

            <!-- Right box: Selected employees -->
            <div class="col-md-5">
                <h4 class="mb-3">{{ t('Selected Employees') }}</h4>
                <div class="mb-3">
                    <input type="text" class="form-control form-control-sm" id="searchSelectedEmployees"
                        placeholder="{{ t('Search...') }}">
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <ul id="selectedEmployees" class="list-group list-group-flush employee-list"
                            style="min-height: 40px">
                            <!-- Selected employees will be dynamically added here -->
                        </ul>
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <button class="btn btn-sm btn-light-primary" id="moveUp">
                        <i class="ki-duotone ki-arrow-up fs-2"><span class="path1"></span><span
                                class="path2"></span></i>
                    </button>
                    <button class="btn btn-sm btn-light-primary" id="moveDown">
                        <i class="ki-duotone ki-arrow-down fs-2"><span class="path1"></span><span
                                class="path2"></span></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
