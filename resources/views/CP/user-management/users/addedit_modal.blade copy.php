  <!--begin::Modal content-->
  <div class="modal-content">
      <!--begin::Modal header-->
      <div class="modal-header" id="kt_modal_add_user_header">
          <!--begin::Modal title-->
          <h2 class="fw-bold">Add User</h2>
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
      <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
          <!--begin::Form-->

          <!--begin::Scroll-->
          <form id="kt_modal_add_user_form" class="form" data-editMode="{{ isset($user) ? 'enabled' : 'disabled' }}"
              action="{{ isset($user) ? route('user-management.users.update', ['user' => $user->id]) : route('user-management.users.store') }}">
              <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true"
                  data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                  data-kt-scroll-dependencies="#kt_modal_add_user_header"
                  data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                  <!--begin::Input group-->
                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                      <!--end::Label-->
                      <!--begin::Image placeholder-->
                      <style>
                          .image-input-placeholder {
                              background-image: url("{{ asset('media/svg/files/blank-image.svg') }}");
                          }

                          [data-bs-theme="dark"] .image-input-placeholder {
                              background-image: url("{{ asset('media/svg/files/blank-image-dark.svg') }}");
                          }
                      </style>
                      <!--end::Image placeholder-->
                      <!--begin::Image input-->
                      <div class="image-input image-input-outline image-input-placeholder ms-5"
                          data-kt-image-input="true">
                          <!--begin::Preview existing avatar-->
                          <div class="image-input-wrapper w-125px h-125px"
                              style="background-image: url('{{ isset($user) ? ($user->avatar != null ? asset('images/' . $user->avatar) : asset('media/avatars/blank.png')) : asset('media/avatars/blank.png') }}')">
                          </div>
                          <!--end::Preview existing avatar-->
                          <!--begin::Label-->
                          <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                              data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                              <i class="bi bi-pencil-fill fs-7"></i>
                              <!--begin::Inputs-->
                              <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                              <input type="hidden" name="avatar_remove" />
                              <!--end::Inputs-->
                          </label>
                          <!--end::Label-->
                          <!--begin::Cancel-->
                          <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                              data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                              <i class="bi bi-x fs-2"></i>
                          </span>
                          <!--end::Cancel-->
                          <!--begin::Remove-->
                          <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                              data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                              <i class="bi bi-x fs-2"></i>
                          </span>
                          <!--end::Remove-->
                      </div>
                      <!--end::Image input-->
                      <!--begin::Hint-->
                      <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                      <!--end::Hint-->
                  </div>

                  <!--begin::Input group-->
                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="required fw-semibold fs-6 mb-2">Active Status</label>
                      <div class="form-check form-switch form-check-custom form-check-solid">
                          <input class="form-check-input" type="checkbox" value="true" id="flexSwitchDefault"
                              {{ isset($user->active) ? ($user->active == true ? 'checked="checked"' : '') : '' }}
                              name="user_active" />
                          <label class="form-check-label" for="flexSwitchDefault">
                          </label>
                      </div>
                      <!--end::Input-->
                  </div>

                  <!--end::Input group-->
                  <!--begin::Input group-->
                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="required fw-semibold fs-6 mb-2">Full Name</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input type="text" name="user_name" class="form-control form-control-solid mb-3 mb-lg-0"
                          placeholder="Full name" value="{{ isset($user) ? $user->name : '' }}" />
                      <!--end::Input-->
                  </div>

                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="required fw-semibold fs-6 mb-2">Password</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input type="text" name="user_password" class="form-control form-control-solid mb-3 mb-lg-0"
                          placeholder="Password" value="" />
                      <!--end::Input-->
                  </div>
                  <!--end::Input group-->
                  <!--begin::Input group-->
                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="required fw-semibold fs-6 mb-2">Email</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input type="email" name="user_email" class="form-control form-control-solid mb-3 mb-lg-0"
                          placeholder="example@domain.com" value="{{ isset($user) ? $user->email : '' }}" />
                      <!--end::Input-->
                  </div>
                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="required fw-semibold fs-6 mb-2">Mobile</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input type="text" name="user_mobile" class="form-control form-control-solid mb-3 mb-lg-0"
                          placeholder="" value="{{ isset($user) ? $user->mobile : '' }}" />
                      <!--end::Input-->
                  </div>

                  <!--end::Input group-->
                  <!--begin::Input group-->
                  <div class="mb-7">
                      <!--begin::Label-->
                      <label class="required fw-semibold fs-6 mb-5">Role</label>
                      <a href="#" id="resetRole" class="btn btn-sm btn-light"
                          style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Uncheck
                          Role</a>
                      <!--end::Label-->
                      <!--begin::Roles-->
                      <!--begin::Input row-->

                      @foreach ($roles as $role)
                          <div class="fv-row">
                              <div class="d-flex">
                                  <!--begin::Radio-->
                                  <div class="form-check form-check-custom form-check-solid">
                                      <!--begin::Input-->
                                      <input class="form-check-input me-3" name="role_name" type="radio"
                                          value="{{ $role->name }}"
                                          {{ in_array($role->name, $earnedRole) ? 'checked="checked"' : '' }}
                                          data-permission-list="[{{ implode(', ', $role->permissions->pluck('name')->toArray()) }}]"
                                          id="kt_modal_update_role_option_{{ $loop->index }}" />
                                      <!--end::Input-->
                                      <!--begin::Label-->
                                      <label class="form-check-label cursor-pointer"
                                          for="kt_modal_update_role_option_{{ $loop->index }}">
                                          <div class="fw-bold text-gray-800">{{ $role->name }}
                                          </div>
                                      </label>
                                      <!--end::Label-->
                                  </div>
                                  <!--end::Radio-->
                              </div>
                          </div>
                          @if (!$loop->last)
                              <div class='separator separator-dashed my-5'></div>
                          @endif
                      @endforeach
                      <!--end::Roles-->
                  </div>

                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="required fw-semibold fs-6 mb-2">Custom Permissions</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <select class="form-select form-select-solid" id="custom_permissions" data-control="select2"
                          name="custom_permissions[]" placeholder="Select one or many permission"
                          multiple="multiple">
                          @foreach ($permissions as $permission)
                              <option value="{{ $permission->name }}"
                                  {{ in_array($permission->name, $earnedPermissions) ? 'selected="selected"' : '' }}>
                                  {{ $permission->name }}</option>
                          @endforeach
                      </select>
                      <!--end::Input-->
                  </div>
                  <!--end::Input group-->
              </div>
              <!--end::Scroll-->
              <!--begin::Actions-->
              <div class="text-center pt-15">
                  <button type="reset" class="btn btn-light me-3" data-kt-modal-action="cancel"
                      data-bs-dismiss="modal">
                      {{ t('Discard') }}
                  </button>
                  <button type="submit" class="btn btn-primary"
                      data-kt-modal-action="submit{{ $_model::ui['s_lcf'] }}">
                      <span class="indicator-label">{{ t('Submit') }}</span>
                      <span class="indicator-progress">
                          {{ t('Please wait...') }}
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
