<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header">
        <!--begin::Modal title-->
        <h2 class="fw-bold">{{ isset($role) ? 'Edit ' . $role->name : __('layout.roles.add_role') }} </h2>
        <!--end::Modal title-->
        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Close-->
    </div>
    <!--end::Modal header-->
    <!--begin::Modal body-->
    <div class="modal-body scroll-y mx-lg-5 my-7">
        <!--begin::Form-->
        <form id="kt_modal_add_role_form" data-editMode="{{ isset($role) ? 'enabled' : 'disabled' }}"
            action="{{ isset($role) ? route('user-management.roles.update', ['role' => $role->id]) : route('user-management.roles.store') }}"
            method="POST" class="form">
            <!--begin::Scroll-->
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll" data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                data-kt-scroll-dependencies="#kt_modal_add_role_header"
                data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="fs-5 fw-bold form-label mb-2">
                        <span class="required">{{ __('layout.roles.role_name') }}</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input class="form-control form-control-solid" placeholder="Enter a role name" name="role_name"
                        value="{{ isset($role) ? $role->name : '' }}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Permissions-->
                <div class="fv-row">
                    <!--begin::Label-->
                    <label class="fs-5 fw-bold form-label mb-2">{{ __('layout.roles.roles_permissions') }}</label>
                    <!--end::Label-->
                    <!--begin::Table wrapper-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5">
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!--begin::Table row-->
                                <tr>
                                    <td class="text-gray-800">{{ __('layout.roles.administrator_access') }}
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                            title="Allows a full access to the system"></i>
                                    </td>
                                    <td>
                                        <!--begin::Checkbox-->
                                        <label class="form-check form-check-custom form-check-solid me-9">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="kt_roles_select_all" />
                                            <span class="form-check-label"
                                                for="kt_roles_select_all">{{ __('layout.select_all') }}</span>
                                        </label>
                                        <!--end::Checkbox-->
                                    </td>
                                </tr>
                                <!--end::Table row-->

                                @foreach ($permissions as $groupName => $permission)
                                    <tr>
                                        <td class="text-gray-800"> {{ $groupName }}</td>
                                        <td>
                                            <div class="d-flex">
                                                @foreach ($permission as $item)
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="permissions[]"
                                                            {{ in_array($item['permission'], $earnedPermissions) ? 'checked="checked"' : '' }}
                                                            value="{{ $item['permission'] }}" />
                                                        <span class="form-check-label">
                                                            {{ $item['name'] }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table wrapper-->
                </div>
                <!--end::Permissions-->
            </div>
            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->
