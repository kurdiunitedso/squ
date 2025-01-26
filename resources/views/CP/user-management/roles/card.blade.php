<div class="col-md-4">
    <!--begin::Card-->
    <div class="card card-flush h-md-100">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>{{ $role->name }}</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-1">
            <!--begin::Users-->
            <div class="fw-bold text-gray-600 mb-5">Total permissions with this role: {{ $role->permissions->count() }}
            </div>
            <!--end::Users-->
            <!--begin::Permissions-->
            <div class="d-flex flex-column text-gray-600">
                @foreach ($role->permissions->take(5) as $permission)
                    <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>
                        {{ __('layout.permissions.' . $permission->name) }}
                    </div>
                @endforeach
                @if ($role->permissions->count() > 5)
                    <div class='d-flex align-items-center py-2'>
                        <span class='bullet bg-primary me-3'></span>
                        <em>and {{ $role->permissions->skip(5)->count() }} more...</em>
                    </div>
                @endif
            </div>
            <!--end::Permissions-->
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer flex-wrap pt-0">
            {{-- <a href="../../demo1/dist/apps/user-management/roles/view.html"
                class="btn btn-light btn-active-primary my-1 me-2">View Role</a> --}}
            <button data-url="{{ route('user-management.roles.edit', ['role' => $role->id]) }}" type="button"
                class="btn btn-light btn-active-light-primary my-1 me-2 btnUpdateRole">
                <span class="indicator-label">
                    Edit Role
                </span>
                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>

            <a href="{{ route('user-management.roles.delete', ['role' => $role->id]) }}"
                data-role-name="{{ $role->name }}" class="btn btn-light btn-active-danger my-1 btnDeleteRole">Delete
                Role</a>
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Card-->
</div>
