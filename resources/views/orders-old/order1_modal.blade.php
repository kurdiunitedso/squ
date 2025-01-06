<div class="row justify-content-center ">
    <div class="col-md-12 ">
        <h2 class="text-center text-primary w-100">{{__('New Order')}}</h2>
    </div>

    <div class="col-md-12 mt-5">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class=" fw-semibold fs-6 mb-2"
                   data-input-name="{{__('Restaurant')}}">{{__('Restaurant')}}</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                    name="restaurant_id"
                    data-placeholder="Select an option">
                <option></option>
                @foreach (\App\Models\Restaurant::all() as $r)
                    <option value="{{ $r->id }}">

                        {{ $r->name }}</option>
                @endforeach
            </select>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-12">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class=" fw-semibold fs-6 mb-2"
                   data-input-name="{{__('Telephone')}}">{{__('Telephone')}}</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="telephone" class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder="" value=""/>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-12">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class=" fw-semibold fs-6 mb-2"
                   data-input-name="{{__('Name')}}">{{__('Name')}}</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="telephone" class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder="" value=""/>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-12">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class=" fw-semibold fs-6 mb-2"
                   data-input-name="{{__('Telephone')}}">{{__('Another Telephone')}}</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="telephone2" class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder="" value=""/>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-12">
        <div class="d-grid gap-2 col-12 mx-auto">
            <button link="{{ route('orders.create2') }}" type="button" class="btn btn-success createOrder w-100"
                    id="createOrder">
                                <span class="indicator-label">
                                    {{__('Create Order')}}
                                </span>
                <span class="indicator-progress">
                                    Please wait... <span
                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
            </button>


            <button link="{{ route('orders.create2') }}" type="button" class="btn btn-warning createComplain w-100"
                    id="createComplain">
                                <span class="indicator-label">
                                    {{__('Create Complain')}}
                                </span>
                <span class="indicator-progress">
                                    Please wait... <span
                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
            </button>
        </div>
    </div>
</div>

