<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_order_header">
        <!--begin::Modal title-->
        <h2 class="fw-bold">{{__('Add Order')}}
            <a href="https://wheels.delivery/Login" class="btn btn-light-success font-weight-bold mr-2">

                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Devices/LTE1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / Devices / LTE1</title>
    <desc>Created with Sketch.</desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M15.4508979,17.4029496 L14.1784978,15.8599014 C15.324501,14.9149052 16,13.5137472 16,12 C16,10.4912085 15.3289582,9.09418404 14.1893841,8.14910121 L15.466112,6.60963188 C17.0590936,7.93073905 18,9.88958759 18,12 C18,14.1173586 17.0528606,16.0819686 15.4508979,17.4029496 Z M18.0211112,20.4681628 L16.7438102,18.929169 C18.7927036,17.2286725 20,14.7140097 20,12 C20,9.28974232 18.7960666,6.77820732 16.7520315,5.07766256 L18.031149,3.54017812 C20.5271817,5.61676443 22,8.68922234 22,12 C22,15.3153667 20.523074,18.3916375 18.0211112,20.4681628 Z M8.54910207,17.4029496 C6.94713944,16.0819686 6,14.1173586 6,12 C6,9.88958759 6.94090645,7.93073905 8.53388797,6.60963188 L9.81061588,8.14910121 C8.67104182,9.09418404 8,10.4912085 8,12 C8,13.5137472 8.67549895,14.9149052 9.82150222,15.8599014 L8.54910207,17.4029496 Z M5.9788888,20.4681628 C3.47692603,18.3916375 2,15.3153667 2,12 C2,8.68922234 3.47281829,5.61676443 5.96885102,3.54017812 L7.24796852,5.07766256 C5.20393339,6.77820732 4,9.28974232 4,12 C4,14.7140097 5.20729644,17.2286725 7.25618985,18.929169 L5.9788888,20.4681628 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <circle fill="#000000" cx="12" cy="12" r="2"/>
    </g>
</svg><!--end::Svg Icon--></span>
               {{__('Complete Order From Wheels')}}
            </a>
        </h2>
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
    <div class="modal-body scroll-y mx-5 my-7">
        <!--begin::Form-->

        <!--begin::Scroll-->
        <form id="kt_modal_add_order_form" class="form"
              data-editMode="{{ isset($order) ? 'enabled' : 'disabled' }}"
              action="{{ isset($order) ? route('orders.update', ['order' => $order->id]) : route('orders.store') }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_order_scroll"
                 data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                 data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_order_header"
                 data-kt-scroll-wrappers="#kt_modal_add_order_scroll" data-kt-scroll-offset="300px">
                <!--begin::Input group-->
                <div class="row">
                    <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Telephone')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="telephone"
                                       data-allow-clear="true" value="{{isset($order)?$order->telephone:''}}">

                            </div>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Restaurant Name')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="restaurant_name"
                                       data-allow-clear="true" value="{{isset($order)?$order->restaurant_name:''}}">
                            </div>


                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Restaurant Branch')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="branch_name"
                                       data-allow-clear="true" value="{{isset($order)?$order->branch_name:''}}">
                            </div>


                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Order No')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="order_no"
                                       data-allow-clear="true" value="{{isset($order)?$order->order_no:''}}">
                            </div>


                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Client Name')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="client_name"
                                       data-allow-clear="true" value="{{isset($order)?$order->client_name:''}}">
                            </div>


                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Client Mobile')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="client_mobile1"
                                       data-allow-clear="true" value="{{isset($order)?$order->client_mobile1:''}}">
                            </div>


                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Client Mobile')}} 2:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="client_mobile2"
                                       data-allow-clear="true" value="{{isset($order)?$order->client_mobile2:''}}">
                            </div>


                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('City')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="city"
                                       data-allow-clear="true" value="{{isset($order)?$order->city:''}}">
                            </div>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Sub Destination')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="sub_destination"
                                       data-allow-clear="true" value="{{isset($order)?$order->sub_destination:''}}">
                            </div>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Delivery Type')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="delivery_type"
                                       data-allow-clear="true" value="{{isset($order)?$order->delivery_type:''}}">
                            </div>


                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Payment Type')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="payment_type"
                                       data-allow-clear="true" value="{{isset($order)?$order->payment_type:''}}">
                            </div>


                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Visit Date">{{__('Order Date')}}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="position-relative d-flex align-items-center">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                  d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                                  fill="currentColor"></path>
                                            <path
                                                d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Datepicker-->
                                <input type="text" name="order_create_date" id="order_create_date"
                                       class="form-control form-control-solid ps-12 date-flatpickr flatpickr-input mb-3 mb-lg-0"
                                       autocomplete="off" placeholder=""
                                       value="{{ isset($order)
                                            ? ($order->visit_date
                                                ? \Carbon\Carbon::parse($order->order_create_date)->format('Y-m-d')
                                                : old('order_create_date'))
                                            : \Carbon\Carbon::now()->format('Y-m-d') }}"/>
                                <!--end::Datepicker-->
                            </div>

                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Visit time">{{__('Order Time')}}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="position-relative d-flex align-items-center">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                  d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                                  fill="currentColor"></path>
                                            <path
                                                d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Datepicker-->
                                <input type="text" name="order_create_time" id="order_create_time"
                                       class="form-control form-control-solid ps-12 time-flatpickr flatpickr-input mb-3 mb-lg-0"
                                       autocomplete="off" placeholder=""
                                       value="{{ isset($order)
                                            ? ($order->order_create_time
                                                ? \Carbon\Carbon::parse($order->order_create_time)->format('H:i')
                                                : old('order_create_time'))
                                            : \Carbon\Carbon::now()->format('H:i') }}"/>
                                <!--end::Datepicker-->
                            </div>
                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Visit Date">{{__('Pickup Time')}}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="position-relative d-flex align-items-center">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                  d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                                  fill="currentColor"></path>
                                            <path
                                                d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Datepicker-->
                                <input type="text" name="pickup_time" id="pickup_time"
                                       class="form-control form-control-solid ps-12 date-flatpickr flatpickr-input mb-3 mb-lg-0"
                                       autocomplete="off" placeholder=""
                                       value="{{ isset($order)
                                            ? ($order->pickup_time
                                                ? \Carbon\Carbon::parse($order->pickup_time)->format('Y-m-d H:i')
                                                : old('pickup_time'))
                                            : \Carbon\Carbon::now()->format('Y-m-d H:i') }}"/>
                                <!--end::Datepicker-->
                            </div>

                            <!--end::Input-->
                        </div>
                    </div>











                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Visit time">{{__('Exp Prep Time')}}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="number" name="expected_prep_time"
                                       data-allow-clear="true" value="{{isset($order)?$order->expected_prep_time:''}}">
                            </div>
                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Captin Name')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="captin_name"
                                       data-allow-clear="true" value="{{isset($order)?$order->captin_name:''}}">
                            </div>


                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Captin Mobile')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="captin_mobile"
                                       data-allow-clear="true" value="{{isset($order)?$order->captin_mobile:''}}">
                            </div>


                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">{{__('Delivery Status')}}:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-solid mb-3 mb-lg-0"
                                       type="text" name="delivery_status"
                                       data-allow-clear="true" value="{{isset($order)?$order->delivery_status:''}}">
                            </div>


                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{__('Details')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="details" class="form-control form-control-solid mb-3 mb-lg-0"
                                      placeholder="{{__('Details')}}"
                            >{{ isset($order) ? $order->details : '' }}</textarea>
                            <!--end::Input-->
                        </div>
                    </div>

                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
            </div>


            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-order-modal-action="cancel"
                        data-bs-dismiss="modal">{{__('Discard')}}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-order-modal-action="submit">
                    <span class="indicator-label">{{__('Submit')}}</span>
                    <span class="indicator-progress">{{__('Please wait...')}}
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
