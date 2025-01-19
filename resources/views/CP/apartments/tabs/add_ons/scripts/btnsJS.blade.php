@php
    use App\Models\Apartment;
    use App\Models\AddOn;
    use App\Models\ApartmentAddOn;
@endphp

<script>
    $(document).ready(function() {
        const $totalDiscountInput = $('#apartment_total_discount');
        const $totalCostDisplay = $('#add_ons_total_cost');

        function handleTotalDiscountChange() {
            const newDiscount = $totalDiscountInput.val();
            console.log('Total discount changed to:', newDiscount);

            $.ajax({
                url: "{{ route(Apartment::ui['route'] . '.' . ApartmentAddOn::ui['route'] . '.updateTotalDiscount', ['apartment' => $_model->id]) }}",
                type: 'POST',
                data: {
                    total_discount: newDiscount
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('AJAX request successful:', response);

                    // Update total cost display
                    $totalCostDisplay.val(response.total_cost);

                    // Show appropriate toastr message
                    switch (response.color) {
                        case 'success':
                            toastr.success(response.message);
                            break;
                        case 'info':
                            toastr.info(response.message);
                            break;
                        case 'warning':
                            toastr.warning(response.message);
                            break;
                        case 'error':
                            toastr.error(response.message);
                            break;
                        default:
                            toastr.info(response.message);
                    }

                    // If the update was not successful, revert the input to the old value
                    if (!response.status) {
                        $totalDiscountInput.val(response.total_cost - response.old_total_cost);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', error);
                    toastr.error('Failed to update total discount. Please try again.');
                }
            });
        }


        // Debounced version of handleTotalDiscountChange
        const debouncedHandleTotalDiscountChange = debounce(handleTotalDiscountChange, 400);

        // Attach the debounced function to the input event
        $totalDiscountInput.on('input', debouncedHandleTotalDiscountChange);

        // console.log('Total discount input listener initialized with debounce');
    });
</script>
<script>
    $(document).on('click', "#add_{{ ApartmentAddOn::ui['s_lcf'] }}_modal", function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');
        ModalRenderer.render({
            url: url,
            button: button,
            modalId: '#kt_modal_general',
            modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
            formId: '#{{ ApartmentAddOn::ui['s_lcf'] }}_modal_form',
            dataTableId: datatableAddOn,
            submitButtonName: "[data-kt-modal-action='submit{{ ApartmentAddOn::ui['s_lcf'] }}']",
            onFormSuccessCallBack: onFormSuccessCallBack,
            callBackFunction: totalCostCallBack
        });
    });
</script>
<script>
    $(document).on('click', ".btn_update_{{ ApartmentAddOn::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');
        ModalRenderer.render({
            url: url,
            button: button,
            modalId: '#kt_modal_general',
            modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
            formId: '#{{ ApartmentAddOn::ui['s_lcf'] }}_modal_form',
            dataTableId: datatableAddOn,
            submitButtonName: "[data-kt-modal-action='submit{{ ApartmentAddOn::ui['s_lcf'] }}']",
            onFormSuccessCallBack: onFormSuccessCallBack,
            callBackFunction: totalCostCallBack
        });
    });
</script>


<script>
    $(document).on('click', '.btn_delete_' + "{{ ApartmentAddOn::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const itemModelName = $(this).attr('data-' + "{{ ApartmentAddOn::ui['s_lcf'] }}" + '-name');
        Swal.fire({
            html: "Are you sure you want to delete " + itemModelName + "?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: URL,
                    dataType: "json",
                    success: function(response) {
                        datatableAddOn.ajax.reload(null, false);
                        Swal.fire({
                            text: response.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },

                    success: function(response) {
                        // Update total cost display
                        const $totalCostDisplay = $('#add_ons_total_cost');
                        $totalCostDisplay.val(response.total_cost);
                        const $apartment_total_discount = $(
                            '#apartment_total_discount');
                        $apartment_total_discount.val(response
                            .apartment_total_discount);

                        datatableAddOn.ajax.reload(null, false);
                        Swal.fire({
                            text: response.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },



                    complete: function() {},
                    error: function(response, textStatus,
                        errorThrown) {
                        toastr.error(response
                            .responseJSON
                            .message);
                    },
                });

            } else if (result.dismiss === 'cancel') {}

        });
    });
</script>

<script>
    // Wait for the DOM to be fully loaded
    const totalCostCallBack = function() {
        // Get all the input elements
        const qtyInput = document.querySelector('input[name="{{ ApartmentAddOn::ui['s_lcf'] }}_qty"]');
        const costInput = document.querySelector(
            'input[name="{{ ApartmentAddOn::ui['s_lcf'] }}_cost"]');
        const discountInput = document.querySelector(
            'input[name="{{ ApartmentAddOn::ui['s_lcf'] }}_discount"]');
        const totalCostElement = document.getElementById(
            '{{ ApartmentAddOn::ui['s_lcf'] }}_total_cost');
        const totalCostElementH1 = document.getElementById(
            '{{ ApartmentAddOn::ui['s_lcf'] }}_total_cost_h1');

        // Function to calculate and update the total cost
        function updateTotalCost() {
            // Get the current values
            const qty = parseFloat(qtyInput.value) || 0;
            const cost = parseFloat(costInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;

            // Calculate the total cost
            const totalCost = (qty * cost) - discount;

            // Update the total cost display
            totalCostElement.value = totalCost.toFixed(2);
            totalCostElementH1.textContent = totalCost.toFixed(2);

            // Log the calculation for debugging
            console.log(`Calculation: (${qty} * ${cost}) - ${discount} = ${totalCost}`);
        }

        // Add event listeners to the input fields
        qtyInput.addEventListener('input', updateTotalCost);
        costInput.addEventListener('input', updateTotalCost);
        discountInput.addEventListener('input', updateTotalCost);

        // Initial calculation
        updateTotalCost();

        console.log('Total cost calculation initialized');
    }
    const onFormSuccessCallBack = function(response, form, modalBootstrap, dataTableId) {
        console.log('Starting form success callback', response);



        // Step 2: Display appropriate message
        console.log('Step 2: Displaying message');
        if (response.message) {
            switch (response.color) {
                case 'success':
                    toastr.success(response.message);
                    break;
                case 'warning':
                    toastr.warning(response.message);
                    break;
                case 'error':
                    toastr.error(response.message);
                    break;
                default:
                    toastr.info(response.message);
            }
            console.log(`Message displayed: ${response.message} (${response.color})`);
        } else {
            console.warn('No message provided in the response');
        }

        // Step 3: Handle form based on response status
        console.log('Step 3: Handling form');
        if (response.status) {
            // Step 1: Update contract total cost
            console.log('Step 1: Updating contract total cost');
            const contractTotalCostElement = $('#add_ons_total_cost');
            if (contractTotalCostElement.length && response.add_ons_total_cost !== undefined) {
                contractTotalCostElement.val(response.add_ons_total_cost);
                $('.apartment_total_cost').html(response.total_cost);
                console.log(`Contract total cost updated to: ${response.add_ons_total_cost}`);
            } else {
                console.warn(
                    'contract_total_cost element not found or add_ons_total_cost not provided in response');
            }

            if (form && typeof form.reset === 'function') {
                form.reset();
                console.log('Form reset completed');
            } else {
                console.warn('Form object is not available or does not have a reset method');
            }

            // Step 4: Hide modal if response is successful
            console.log('Step 4: Hiding modal');
            if (modalBootstrap && typeof modalBootstrap.hide === 'function') {
                modalBootstrap.hide();
                console.log('Modal hidden');
            } else {
                console.warn('modalBootstrap object is not available or does not have a hide method');
            }

            // Step 5: Reload DataTable if response is successful
            console.log('Step 5: Reloading DataTable');
            if (dataTableId && typeof dataTableId.ajax === 'object' && typeof dataTableId.ajax.reload ===
                'function') {
                dataTableId.ajax.reload(null, false);
                console.log('DataTable reloaded');
            } else {
                console.warn('dataTableId is not available or does not have an ajax.reload method');
            }
        } else {
            console.log('Form submission was not successful, keeping form and modal open');
        }

        console.log('Form success callback completed');
    };
</script>
