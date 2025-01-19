<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_menu_header">
        <!--begin::Modal title-->
        <h2 class="fw-bold">{{ isset($menu) ? 'Edit Menu WebSite' : 'Create Menu WebSite' }}</h2>
        <!--end::Modal title-->
        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <span class="svg-icon svg-icon-1">
                <!-- SVG icon for close -->
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                </svg>
            </span>
        </div>
        <!--end::Close-->
    </div>
    <!--end::Modal header-->

    <!--begin::Modal body-->
    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <!--begin::Form-->
        <form id="kt_modal_add_edit_menu_form" class="form"
              action="{{ isset($menu) ? route('menuWebsite.update', ['menu' => $menu->id]) : route('menuWebsite.store') }}"
              method="POST">
            @csrf
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_menu_scroll" data-kt-scroll="true"
                 data-kt-scroll-max-height="auto" data-kt-scroll-wrappers="#kt_modal_add_menu_scroll"
                 data-kt-scroll-offset="300px">

                <!-- Order Field -->
                <div class="fv-row mb-7">
                    <label class="required fw-semibold fs-6 mb-2">Order</label>
                    <input type="number" min="0" name="order" class="form-control form-control-solid mb-3 mb-lg-0"
                           value="{{ isset($menu) ? $menu->order : '' }}" />
                </div>

                <!-- Name (ar) Field -->
                <div class="fv-row mb-7">
                    <label class="required fw-semibold fs-6 mb-2">Menu WebSite Name (ar)</label>
                    <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                           value="{{ isset($menu) ? $menu->name : '' }}" />
                </div>

                <!-- Name (en) Field -->
                <div class="fv-row mb-7">
                    <label class="required fw-semibold fs-6 mb-2">Menu WebSite Name (en)</label>
                    <input type="text" name="name_en" class="form-control form-control-solid mb-3 mb-lg-0"
                           value="{{ isset($menu) ? $menu->name_en : '' }}" />
                </div>

                <!-- Name (he) Field -->
                <div class="fv-row mb-7">
                    <label class="required fw-semibold fs-6 mb-2">Menu WebSite Name (he)</label>
                    <input type="text" name="name_he" class="form-control form-control-solid mb-3 mb-lg-0"
                           value="{{ isset($menu) ? $menu->name_he : '' }}" />
                </div>

                <!-- Parent Menu Field -->
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">Menu WebSite Parent</label>
                    <select class="form-select form-select-solid" id="parent_id" name="parent_id"
                            data-placeholder="Select an option">
                        <option></option>
                        @foreach ($menus as $menuItem)
                            <option value="{{ $menuItem->id }}"
                                {{ isset($menu) && $menu->parent_id == $menuItem->id ? 'selected="selected"' : '' }}>
                                {{ $menuItem->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- SVG Icon Field -->
                <div class="fv-row mb-7">
                    <label class="required fw-semibold fs-6 mb-2">SVG Icon</label>
                    <textarea name="icon_svg" rows="4" class="form-control form-control-solid mb-3 mb-lg-0">{{ isset($menu) ? $menu->icon_svg : '' }}</textarea>
                </div>
            </div>
            <!--end::Scroll-->

            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">{{ isset($menu) ? 'Update Menu WebSite' : 'Create Menu WebSite' }}</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->
