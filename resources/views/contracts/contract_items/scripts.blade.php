@php
    use App\Models\Contract;
    use App\Models\ContractItem;
    use App\Models\Project;
@endphp
{{-- @dd($item_model->exists) --}}
@if ($item_model->exists)
    <script>
        var datatableContractItem;
        var initContractItems = (function() {
            return function() {
                executed = true;
                const columnDefs = [{
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'item.description',
                        name: 'item.description',
                    },
                    {
                        data: 'notes',
                        name: 'notes',
                    },
                    {
                        data: 'cost',
                        name: 'cost',
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                    },
                    {
                        data: 'discount',
                        name: 'discount',
                    },
                    {
                        data: 'total_cost',
                        name: 'total_cost',
                    },




                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-end',
                        orderable: false,
                        searchable: false
                    }
                ];
                datatableContractItem = createDataTable('#kt_table_items', columnDefs,
                    "{{ route(Contract::ui['route'] . '.' . ContractItem::ui['route'] . '.index', ['contract' => isset($item_model) ? $item_model->id : 0]) }}",
                    [
                        [0, "ASC"]
                    ]);


                const filterSearch = document.querySelector(
                    '[data-kt-{{ ContractItem::ui['s_lcf'] }}-table-filter="search"]');
                filterSearch.onkeydown = debounce(() => datatableContractItem.draw(), 400);
            };
        })();

        $(function() {
            initContractItems();
        });
    </script>

    <script>
        // Wait for the DOM to be fully loaded
        const totalCostCallBack = function() {
            // Get all the input elements
            const qtyInput = document.querySelector('input[name="{{ ContractItem::ui['s_lcf'] }}_qty"]');
            const costInput = document.querySelector(
                'input[name="{{ ContractItem::ui['s_lcf'] }}_cost"]');
            const discountInput = document.querySelector(
                'input[name="{{ ContractItem::ui['s_lcf'] }}_discount"]');
            const totalCostElement = document.getElementById(
                '{{ ContractItem::ui['s_lcf'] }}_total_cost');
            const totalCostElementH1 = document.getElementById(
                '{{ ContractItem::ui['s_lcf'] }}_total_cost_h1');

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
                const contractTotalCostElement = $('#contract_total_cost');
                if (contractTotalCostElement.length && response.total_cost !== undefined) {
                    contractTotalCostElement.val(response.total_cost);
                    console.log(`Contract total cost updated to: ${response.total_cost}`);
                } else {
                    console.warn('contract_total_cost element not found or total_cost not provided in response');
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

    <script>
        $(function() {



            const kt_modal_general = document.getElementById('kt_modal_general');
            const modal_kt_modal_general = new bootstrap.Modal(kt_modal_general);


            $(document).on('click', '#add_{{ ContractItem::ui['s_lcf'] }}_modal', function(e) {
                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                globalRenderModal(
                    "{{ route(Contract::ui['route'] . '.' . ContractItem::ui['route'] . '.add', [Contract::ui['s_lcf'] => isset($item_model) ? $item_model->id : '']) }}",
                    $(this), '#kt_modal_general',
                    modal_kt_modal_general, {},
                    '#kt_modal_add_{{ ContractItem::ui['s_lcf'] }}_form',
                    datatableContractItem,
                    '[data-kt-{{ ContractItem::ui['s_lcf'] }}-modal-action="submit"]',
                    null, onFormSuccessCallBack, null, totalCostCallBack);
            });




            $(document).on('click', '.btn_update_{{ ContractItem::ui['s_lcf'] }}', function(e) {
                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                const editURl = $(this).attr('href');
                console.log('editURl', editURl);

                globalRenderModal(editURl,
                    $(this), '#kt_modal_general',
                    modal_kt_modal_general, {},
                    '#kt_modal_add_{{ ContractItem::ui['s_lcf'] }}_form',
                    datatableContractItem,
                    '[data-kt-{{ ContractItem::ui['s_lcf'] }}-modal-action="submit"]',
                    null, onFormSuccessCallBack, null, totalCostCallBack);
            });
            $(document).on('click', '.btn_add_{{ Project::ui['s_lcf'] }}', function(e) {
                e.preventDefault();
                $(this).attr("data-kt-indicator", "on");
                const editURl = $(this).attr('href');
                console.log('editURl', editURl);

                globalRenderModal(editURl,
                    $(this), '#kt_modal_general',
                    modal_kt_modal_general, {},
                    '#kt_modal_add_{{ Project::ui['s_lcf'] }}_form',
                    datatableContractItem,
                    '[data-kt-{{ Project::ui['s_lcf'] }}-modal-action="submit"]', null, null, null,
                    initializeModalObjectives)
            });



            $(document).on('click', '.btn_delete_{{ ContractItem::ui['s_lcf'] }}', function(e) {
                e.preventDefault();
                const URL = $(this).attr('href');
                const Name = $(this).attr('data-item-name');
                Swal.fire({
                    text: "Are you sure you want to delete " + Name + "?",
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
                                // Update total cost display
                                const $totalCostDisplay = $('#contract_total_cost');
                                $totalCostDisplay.val(response.new_total_cost);
                                const $contract_total_discount = $(
                                    '#contract_total_discount');
                                $contract_total_discount.val(response
                                    .contract_total_discount);

                                datatableContractItem.ajax.reload(null, false);
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

        });
    </script>

    <script>
        $(document).ready(function() {
            const $totalDiscountInput = $('#contract_total_discount');
            const $totalCostDisplay = $('#contract_total_cost');
            const contractId = "{{ $item_model->id }}";

            function handleTotalDiscountChange() {
                const newDiscount = $totalDiscountInput.val();
                console.log('Total discount changed to:', newDiscount);

                $.ajax({
                    url: "{{ route(Contract::ui['route'] . '.updateTotalDiscount', ['contract' => $item_model->id]) }}",
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
@endif
