<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_team_header">
        <!--begin::Modal title-->
        <h2 class="fw-bold">{{ __('Add Team') }}</h2>
        <!--end::Modal title-->
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
        <form id="kt_modal_add_team_form" class="form"
              data-editMode="{{ isset($team) ? 'enabled' : 'disabled' }}"
              action="{{ isset($team) ? route('marketingAgencys.teams.update', ['team' => $team->id]) : route('marketingAgencys.teams.store') }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_team_scroll" data-kt-scroll="true"
                 data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                 data-kt-scroll-dependencies="#kt_modal_add_team_header"
                 data-kt-scroll-wrappers="#kt_modal_add_team_scroll" data-kt-scroll-offset="300px">
                <input type="hidden" name="marketing_agency_id" value="{{$marketingAgency->id}}">
                @if(isset($team))
                    <input type="hidden" name="team_id" value="{{$team->id}}">
                @endif
                <!--begin::Input group-->
                <div class="row">
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Name">
                                {{ __('Name') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($team) ? $team->name : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Mobile">
                                {{ __('Email') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($team) ? $team->email : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Mobile">
                                {{ __('Mobile') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="mobile" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($team) ? $team->mobile : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Mobile">
                                {{ __('Whatsapp') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="whatsapp" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($team) ? $team->whatsapp : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="title">
                                {{ __('Title') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="title"
                                    data-placeholder="Select an option">
                                <option></option>
                                @foreach ($titles as $title)
                                    <option value="{{ $title->id }}"
                                    @isset($team)
                                        @selected($team->title == $title->id)
                                        @endisset>
                                        {{ $title->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="City">
                                {{ __('City') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="city_id"
                                    data-placeholder="Select an option">
                                <option></option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                    @isset($team)
                                        @selected($team->city_id == $city->id)
                                        @endisset>
                                        {{ $city->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Branch">
                                {{ __('Branch') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0 " data-control="select2"
                                    name="branch_id"
                                    data-placeholder="Select an option">
                                <option></option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                    @isset($team)
                                        @selected($team->branch_id  == $branch->id)
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
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="address">
                                {{ __('Address') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="address" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($team) ? $team->address : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>



                </div>

                <!--end::Input group-->
            </div>
            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-teams-modal-action="cancel"
                        data-bs-dismiss="modal">{{ __('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-teams-modal-action="submit">
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
