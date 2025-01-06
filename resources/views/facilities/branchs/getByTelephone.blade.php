<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_branch_header">
        <!--begin::Modal preparation_time-->
        <h2 class="fw-bold">{{ __('View Branch') }}</h2>
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
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <!--begin::Card-->
                <div class="card">


                    <div class="card-body py-4">
                        <!--begin::Table-->
                        <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5"
                               id="kt_table_branchs">
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="mw-40px">{{__('ID')}}</th>
                                <th class="min-w-125px">{{__('Facility')}}</th>
                                <th class="min-w-125px">{{__('City')}}</th>
                                <th class="min-w-125px">{{__('Address')}}</th>
                                <th class="min-w-125px">{{__('Telephone')}}</th>
                            </tr>
                            <!--end::Table row-->
                            </thead>
                            @foreach($branches as $b)
                                <tr class="text-start fs-7  gs-0">
                                    <td>{{$b->id}}</td>
                                    <td><a href="{{route('facilities.edit', ['facility' => $b->facility->id])}}" target="_blank" > {{$b->facility->name}}</a></td>

                                    <td>{{$b->city->name}}</td>
                                    <td>{{$b->address}}</td>
                                    <td>
                                        {{$b->telephone}}</td>
                                </tr>
                            @endforeach
                            <!--end::Table head-->

                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
        </div>
        <div class="text-center pt-15">
            <button type="reset" class="btn btn-light me-3" data-kt-branchs-modal-action="cancel"
                    data-bs-dismiss="modal">{{ __('Discard') }}
            </button>

        </div>
        <!--end::Actions-->


        <!--end::Form-->
    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->


