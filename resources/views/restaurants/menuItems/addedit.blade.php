<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_menuItem_header">
        <!--begin::Modal preparation_time-->
        <h2 class="fw-bold"> {{ __('Add MenuItem') }}</h2>
        <!--end::Modal preparation_time-->
        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                      <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="currentColor"/>
                  </svg>
              </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Close-->
    </div>
    <!--end::Modal header-->
    <!--begin::Modal body-->
    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <!--begin::Form-->

        <!--begin::Scroll-->
        <form id="kt_modal_add_menuItem_form" class="form"
              data-editMode="{{ isset($menuItem) ? 'enabled' : 'disabled' }}"
              action="{{ isset($menuItem) ? route('restaurants.menuItems.update', ['menuItem' => $menuItem->id]) : route('restaurants.menuItems.store') }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_menuItem_scroll" data-kt-scroll="true"
                 data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                 data-kt-scroll-dependencies="#kt_modal_add_menuItem_header"
                 data-kt-scroll-wrappers="#kt_modal_add_menuItem_scroll" data-kt-scroll-offset="300px">
                <input type="hidden" name="restaurant_id" value="{{$restaurant->id}}">
                @if(isset($menuItem))
                    <input type="hidden" name="menuItem_id" value="{{$menuItem->id}}">
                @endif
                <!--begin::Input group-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Name">
                                {{ __('Name') }}
                              </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="item_name" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($menuItem) ? $menuItem->item_name : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Price">
                                {{ __('Price') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="price" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($menuItem) ? $menuItem->price : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Preparation_Time (Min)">
                                {{ __('Preparation_Time (Min)') }}

                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="preparation_time" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($menuItem) ? $menuItem->preparation_time : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Branch">
                                {{ __('Branch') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="restaurant_branch_id"
                                    data-placeholder="Select an option">
                                <option></option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                    @isset($menuItem)
                                        @selected($menuItem->restaurant_branch_id  == $branch->id)
                                        @endisset>
                                        {{ $branch->address }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Has_call_center">
                                {{ __('#  Has Call Center') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="has_call_center"
                                    data-placeholder="Select an option">
                                <option></option>
                                <option value="1"
                                @isset($restaurant)
                                    @selected($restaurant->has_call_center == '1')
                                    @endisset>
                                    {{ __('Yes') }}
                                </option>
                                <option value="0"
                                @isset($restaurant)
                                    @selected($restaurant->has_call_center == '0')
                                    @endisset>
                                    {{ __('NO') }}
                                </option>
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="status">
                                {{ __('Status') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="status"
                                    data-placeholder="Select an option">
                                <option></option>
                                <option value="1"
                                @isset($menuItem)
                                    @selected($menuItem->status >= '1')
                                    @endisset>
                                    {{ __('Yes') }}
                                </option>
                                <option value="0"
                                @isset($menuItem)
                                    @selected($menuItem->status == '0')
                                    @endisset>
                                    {{ __('NO') }}
                                </option>
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>


                </div>

                <!--end::Input group-->
            </div>
            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-menuItems-modal-action="cancel"
                        data-bs-dismiss="modal"> {{ __('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-menuItems-modal-action="submit">
                    <span class="indicator-label">{{ __('Submit') }}</span>
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
