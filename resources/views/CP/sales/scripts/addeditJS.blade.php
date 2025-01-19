{{-- @dd($_model->paymentPlan->id, route('payments.schedules.data', ['paymentPlan' => ':id'])) --}}
@php
    $paymentPlan = $_model->paymentPlan;
    // dd($paymentPlan);
@endphp
@if (isset($paymentPlan))
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Column definitions for payment schedules table
            const paymentScheduleColumns = [{
                    data: 'payment_type.name', // Changed from payment_type
                    render: function(data, type, row) {
                        // Handle null case and ensure proper display
                        if (!data) return 'N/A';
                        return typeof data === 'object' ? data.en : data; // Assuming name is translatable
                    }
                },
                {
                    data: 'due_date'
                },
                {
                    data: 'amount',
                    render: function(data) {
                        return '$' + parseFloat(data).toFixed(2);
                    }
                },
                {
                    data: 'paid_amount',
                    render: function(data) {
                        return '$' + parseFloat(data).toFixed(2);
                    }
                },
                {
                    data: 'remaining_amount',
                    render: function(data, type, row) {
                        return data !== null ? '$' + parseFloat(data).toFixed(2) : '$0.00';
                    }
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        if (!data || !data.name) return 'N/A';

                        const statusName = data.name;
                        const bgColor = data.color || '#6c757d';
                        const textColor = getContrastYIQ(bgColor);

                        return `<span class="badge" style="background-color: ${bgColor}; color: ${textColor}; padding: 5px 10px;">
            ${statusName.charAt(0).toUpperCase() + statusName.slice(1)}
        </span>`;
                    }
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ];

            const payment_plan_id = "{{ $paymentPlan->id }}"
            let url = "{{ route('payments.schedules.data', ['paymentPlan' => ':id']) }}"
            url = url.replace(':id', payment_plan_id);
            const sale_id = "{{ $_model->id }}"
            // Initialize payment schedules datatable
            const paymentSchedulesTable = createDataTable(
                '#payment_schedules_table',
                paymentScheduleColumns,
                url,
                [
                    [1, 'asc']
                ], // Order by due date ascending
                {
                    sale_id,
                    payment_plan_id
                }
            );






            // Record Payment Button Click Handler
            $(document).on('click', '.recordPaymentBtn', function(e) {
                e.preventDefault();
                const button = $(this);
                button.attr("data-kt-indicator", "on");
                const url = button.attr('href');

                ModalRenderer.render({
                    url: url,
                    button: button,
                    modalId: '#kt_modal_general',
                    modalBootstrap: new bootstrap.Modal(document.querySelector(
                        '#kt_modal_general')),
                    formId: '#recordPaymentForm',
                    dataTableId: paymentSchedulesTable,
                    submitButtonName: "[data-kt-modal-action='submitPayment']",
                    callBackFunction: function() {
                        $('select[name="payment_method_id"]').on('change', function() {
                            const method = $(this).find('option:selected').text()
                                .toLowerCase();
                            const bankFields = $('.bank-fields');
                            const checkFields = $('.check-fields');

                            if (method.includes('check') || method.includes(
                                    'bank transfer')) {
                                bankFields.removeClass('d-none');
                                checkFields.toggleClass('d-none', !method.includes(
                                    'check'));

                                // Add/remove required attributes
                                if (method.includes('check')) {
                                    $('input[name="check_number"]').prop('required',
                                        true);
                                } else {
                                    $('input[name="check_number"]').prop('required',
                                        false);
                                }

                                $('select[name="bank_id"]').prop('required', true);
                            } else {
                                bankFields.addClass('d-none');
                                checkFields.addClass('d-none');
                                $('select[name="bank_id"], input[name="check_number"]')
                                    .prop('required', false);
                            }
                        });
                    },
                    onFormSuccessCallBack: async function(response, form, modalBootstrap,
                        dataTableId) {
                        // Let the default callback handle basic operations
                        ModalFormHandler.prototype.defaultSuccessCallback(response, form,
                            modalBootstrap, dataTableId);

                        // Update summary data
                        if (response.data?.summary) {
                            $('.total-amount').text('$' + parseFloat(response.data.summary
                                .total_amount).toFixed(2));
                            $('.paid-amount').text('$' + parseFloat(response.data.summary
                                .paid_amount).toFixed(2));
                            $('.remaining-amount').text('$' + parseFloat(response.data.summary
                                .remaining_amount).toFixed(2));
                            $('.next-payment-date').text(response.data.summary
                                .next_payment_date || 'N/A');
                        }
                    }
                });
            });

            // Remove or update the separate updatePaymentSummary function to use classes
            function updatePaymentSummary(summary) {
                if (summary) {
                    $('.total-amount').text('$' + parseFloat(summary.total_amount).toFixed(2));
                    $('.paid-amount').text('$' + parseFloat(summary.paid_amount).toFixed(2));
                    $('.remaining-amount').text('$' + parseFloat(summary.remaining_amount).toFixed(2));
                    $('.next-payment-date').text(summary.next_payment_date || 'N/A');
                }
            }
        });
    </script>
    <script>
        $(document).on('click', '.viewTransactionsBtn', function(e) {
            e.preventDefault();
            const button = $(this);
            button.attr("data-kt-indicator", "on");
            const url = button.attr('href');

            ModalRenderer.render({
                url: url,
                button: button,
                modalId: '#kt_modal_general',
                modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general'))
            });
        });
    </script>
@endif



{{-- ClientHandler --}}
<script>
    $(document).ready(function() {
        const clientSelector = 'select[name="client_id"]';
        class ClientHandler extends Select2BaseModelHandler {
            constructor() {
                const config = {
                    model: "App\\Models\\Client",
                    selector: clientSelector,
                    prefix: 'client',
                    placeholder: "{{ t('Select an Client') }}",
                    fields: [
                        'name',
                        'email',
                        'phone',
                        'address',
                        'number_family_members',
                        'lead_id',
                        'active',
                        'bank_id',
                        'bank_branch_id',
                        'bank_iban',
                        'bank_account_number',
                    ],
                    relatedFields: {}
                };
                super(config);
            }
        }


        if ($(clientSelector).length) {
            const clientHandler = new ClientHandler();
            setTimeout(() => {
                clientHandler.initialize();
            }, 0);
        }
    });
</script>
{{-- ApartmentHandler --}}
<script>
    $(document).ready(function() {
        const apartmentSelector = 'select[name="apartment_id"]';

        class ApartmentHandler extends Select2BaseModelHandler {
            constructor() {
                const config = {
                    model: "App\\Models\\Apartment",
                    selector: apartmentSelector,
                    prefix: 'apartment',
                    placeholder: "{{ t('Select an Apartment') }}",
                    fields: [
                        'building_id',
                        'status_id',
                        'name',
                        'floor_number',
                        'type_id',
                        'size_id',
                        'rooms_number',
                        'bedrooms_number',
                        'balcoines_number',
                        'orientation_id',
                        'parking_type_id',
                        'description',
                        'price',
                    ],
                    relatedFields: {}
                };
                super(config);
            }
        }

        if ($(apartmentSelector).length) {
            const apartmentHandler = new ApartmentHandler();
            setTimeout(() => {
                apartmentHandler.initialize();
            }, 0);
        }
    });
</script>


{{-- Client bank handler --}}
<script>
    $(document).ready(function() {
        const bankSelector = 'select[name="client_bank_id"]';
        const bankBranchSelector = 'select[name="client_bank_branch_id"]';

        // Function to update bank branches
        function updateBankBranches() {
            const bankId = $(bankSelector).val();
            const selectedBranchId = '{{ old('client_bank_id', optional($_model->client)->bank_branch_id) }}';
            console.log('selectedBranchId', selectedBranchId);


            if (bankId) {
                getSelect2WithoutSearchOrPaginate(
                    @json(App\Models\Constant::class),
                    bankBranchSelector,
                    '{{ t('Select Bank Branch') }}', {
                        parent_id: bankId,
                        field: "{{ \App\Enums\DropDownFields::bank_branches }}"
                    },
                    selectedBranchId
                ).catch(error => {
                    console.error('Failed to fetch bank branches:', error);
                    $(bankBranchSelector)
                        .empty()
                        .append('<option value="">{{ t('Select Bank Branch') }}</option>')
                        .trigger('change');
                });
            } else {
                $(bankBranchSelector)
                    .empty()
                    .append('<option value="">{{ t('Select Bank Branch') }}</option>')
                    .trigger('change');
            }
        }
        // Add event listener for bank selection change
        $(bankSelector).on('change', updateBankBranches);

        // Handle initial bank value if exists
        const initialBankId = @json(old('client_bank_id', optional($_model->client)->bank_id));
        if (initialBankId) {
            $(bankSelector).val(initialBankId);
            updateBankBranches();
        }
    });
</script>
