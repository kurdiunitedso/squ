<div class="row">


    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('Email')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="email"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder="" value="{{ isset($facility) ? $facility->email : '' }}"/>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('Telephone')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="telephone"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder="" value="{{ isset($facility) ? $facility->telephone : '' }}"/>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('Whatsapp')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="whatsapp"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder="" value="{{ isset($facility) ? $facility->whatsapp : '' }}"/>
            <!--end::Input-->
        </div>
    </div>






</div>
