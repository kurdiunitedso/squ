
<div class="d-grid gap-2 col-12 mx-auto" style="margin-top:70%">
    <button link="{{ route('orders.address') }}" type="button" class="btn btn-primary deliverOrder "
            id="deliverOrder">
                                <span class="indicator-label">
                                    {{__('Delivery')}}
                                </span>
        <span class="indicator-progress">
                                    Please wait... <span
                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
    </button>

    <button link="{{ route('orders.address') }}" type="button" class="btn btn-dark handOrder"
            id="handOrder">
                                <span class="indicator-label">
                                    {{__('Handover')}}
                                </span>
        <span class="indicator-progress">
                                    Please wait... <span
                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
    </button>
    <h2 class="text-danger CurrentAddress"></h2>
</div>

