<script>
    // Enhanced DataTable initialization with expandable rows
    var selectedItemsModelsRows = [];
    var selectedItemModelsData = [];

    const columnDefs = [{
            data: null,
            render: function(data, type, row, meta) {
                var isChecked = selectedItemsModelsRows.includes(row.id.toString()) ? 'checked' : '';
                return '<input type="checkbox" class="row-checkbox" ' + isChecked + '>';
            },
            orderable: false
        },
        {
            className: 'dt-control',
            orderable: false,
            data: null,
            defaultContent: '',
            render: function(data, type, row, meta) {
                return '<button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3 expand-details">' +
                    '<i class="ki-duotone ki-plus fs-2"></i>' +
                    '</button>';
            }
        },
        {
            data: 'id',
            name: 'id',
            render: function(data, type, row) {
                return data || 'NA';
            }
        },
        {
            data: 'sale_id',
            name: 'sale_id',
            title: 'Sale ID',
            render: function(data, type, row) {
                return `<span class="badge badge-light-primary">#${data}</span>`;
            }
        },
        {
            data: 'client_name',
            name: 'client_name',
            title: 'Client Name',
            render: function(data, type, row) {
                return `<div class="d-flex align-items-center">
                        <div class="symbol symbol-circle symbol-35px overflow-hidden me-3">
                            <span class="symbol-label bg-light-primary text-primary fs-6 fw-bolder">
                                ${data.charAt(0).toUpperCase()}
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-gray-800 text-hover-primary mb-1">${data}</span>
                        </div>
                    </div>`;
            }
        },
        {
            data: 'apartment_name',
            name: 'apartment_name',
            title: 'Apartment'
        },
        {
            data: 'total_amount',
            name: 'total_amount',
            title: 'Total Amount',
            render: function(data, type, row) {
                return `<span class="fw-bold text-dark">${data}</span>`;
            }
        },
        {
            data: 'downpayment_amount',
            name: 'downpayment_amount',
            title: 'Down Payment'
        },
        {
            data: 'installment_amount',
            name: 'installment_amount',
            title: 'Installment'
        },
        {
            data: 'number_of_installments',
            name: 'number_of_installments',
            title: 'Installments',
            render: function(data, type, row) {
                return `<span class="badge badge-light-info">${data}</span>`;
            }
        },
        {
            data: 'start_date',
            name: 'start_date',
            title: 'Start Date',
            render: function(data, type, row) {
                return moment(data).format('MMM DD, YYYY');
            }
        },
        {
            data: 'payment_frequency',
            name: 'payment_frequency',
            title: 'Frequency',
            render: function(data, type, row) {
                const badges = {
                    'monthly': 'light-primary',
                    'quarterly': 'light-warning',
                    'yearly': 'light-success'
                };
                return `<span class="badge badge-${badges[data.toLowerCase()] || 'light-info'}">${data}</span>`;
            }
        },
        {
            data: row => row.status || 'NA',
            name: `status.name->${currentLocale}`
        },
        {
            data: 'action',
            name: 'action',
            title: 'Actions',
            orderable: false,
            searchable: false
        }
    ];

    // Initialize DataTable with enhanced features
    var datatable = createDataTable('#kt_table_items_model', columnDefs,
        "{{ route($_model::ui['route'] . '.index') }}", [
            [0, "ASC"]
        ], {
            orderCellsTop: true,
            fixedHeader: true,
            responsive: true
        }
    );

    // Add expand/collapse functionality
    function formatPaymentDetails(row) {
        const progress = calculateProgress(row);
        const paidAmount = calculatePaidAmount(row);
        const remainingAmount = calculateRemainingAmount(row);
        const nextPaymentDate = getNextPaymentDate(row);
        const nextPaymentAmount = row.payment_summary?.next_payment_amount || row.installment_amount;

        return `<div class="px-5 py-4 bg-light-secondary rounded">
        <div class="row g-5">
            <div class="col-md-4">
                <h4 class="mb-3">Payment Progress</h4>
                <div class="d-flex flex-column">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Completion:</span>
                        <span class="fw-bold">${progress}%</span>
                    </div>
                    <div class="progress h-5px">
                        <div class="progress-bar bg-primary" role="progressbar"
                             style="width: ${progress}%"
                             aria-valuenow="${progress}"
                             aria-valuemin="0"
                             aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="mb-3">Payment Summary</h4>
                <div class="d-flex flex-column">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Paid Amount:</span>
                        <span class="fw-bold text-success">${formatMoney(paidAmount)}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Remaining:</span>
                        <span class="fw-bold text-danger">${formatMoney(remainingAmount)}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="mb-3">Next Payment</h4>
                <div class="d-flex flex-column">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Due Date:</span>
                        <span class="fw-bold">${nextPaymentDate}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Amount Due:</span>
                        <span class="fw-bold">${formatMoney(nextPaymentAmount)}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
    }

    // Helper functions for payment calculations
    function calculateProgress(row) {
        if (!row.payment_summary) return 0;
        return row.payment_summary.completion_percentage || 0;
    }

    function calculatePaidAmount(row) {
        if (!row.payment_summary) return 0;
        return row.payment_summary.paid_amount || 0;
    }

    function calculateRemainingAmount(row) {
        if (!row.payment_summary) return row.total_amount;
        return row.payment_summary.remaining_amount || row.total_amount;
    }

    function getNextPaymentDate(row) {
        if (!row.payment_summary || !row.payment_summary.next_payment_date) {
            return 'N/A';
        }
        return moment(row.payment_summary.next_payment_date).format('MMM DD, YYYY');
    }

    function formatMoney(amount) {
        return new Intl.NumberFormat('en-US').format(amount);
    }

    // Event Handlers
    $('#kt_table_items_model tbody').on('click', 'td.dt-control button.expand-details', function() {
        const tr = $(this).closest('tr');
        const row = datatable.row(tr);
        const icon = $(this).find('i');

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            icon.removeClass('ki-minus').addClass('ki-plus');
        } else {
            row.child(formatPaymentDetails(row.data())).show();
            tr.addClass('shown');
            icon.removeClass('ki-plus').addClass('ki-minus');
        }
    });

    // Initialize tooltips and other Bootstrap features
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Add DataTable search delay
        const filterSearch = document.querySelector('[data-kt-table-filter="search"]');
        filterSearch.onkeydown = debounce(keyPressCallback, 400);
    });

    // Your existing event handlers for checkboxes and filters...
    // [Previous checkbox handling code remains the same]
</script>

<script>
    $(document).on('click', '#filterBtn', function(e) {
        e.preventDefault();
        datatable.ajax.reload();
    });

    $(document).on('click', '#resetFilterBtn', function(e) {
        e.preventDefault();
        $('#filter-form').trigger('reset');
        $('.datatable-input').each(function() {
            if ($(this).hasClass('filter-selectpicker')) {
                $(this).val('');
                $(this).trigger('change');
            }
            if ($(this).hasClass('flatpickr-input')) {
                const fp = $(this)[0]._flatpickr;
                fp.clear();
            }
        });
        datatable.ajax.reload();
    });

    $(document).on('click', '#exportBtn', function(e) {
        e.preventDefault();
        const url = $(this).data('export-url');
        console.log(url);
        const myUrlWithParams = new URL(url);

        const parameters = filterParameters();
        //myUrlWithParams.searchParams.append('params',JSON.stringify( parameters))
        Object.keys(parameters).map((key) => {
            myUrlWithParams.searchParams.append(key, parameters[key]);
        });
        console.log(myUrlWithParams);
        window.open(myUrlWithParams, "_blank");

    });
</script>
