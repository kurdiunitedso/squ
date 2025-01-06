@php
    use App\Models\Contract;
    use App\Models\ClientTrillion;
    use App\Models\ContractItem;
@endphp
@extends('metronic.index')


@section('subpageTitle', $item_model::ui['p_ucf'])

@section('title', t($item_model::ui['s_ucf'] . '- Add new ' . $item_model::ui['s_ucf']))
@section('subpageTitle', $item_model::ui['s_ucf'])
@section('subpageName', 'Add new ' . $item_model::ui['s_ucf'])
@push('styles')
    <link href="{{ asset('css/custom.css?v=1') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
            <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span
                    class="path2"></span></i>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-danger">{{ t('Something went wrong!') }}</h4>
                <span>{{ t('Please check your inputs, the error messages are :.') }}</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center p-5">
            <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                    <path
                        d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z"
                        fill="currentColor" />
                </svg>
            </span>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-success"> {{ session('status') }}</h4>
            </div>
        </div>
    @endif
    <!--begin::Content container-->
    <div class="card mb-5 mb-xl-5" id="kt_department_form_tabs">
        <div class="card-body pt-0 pb-0">
            <div class="d-flex flex-column flex-lg-row justify-content-between">
                <!--begin::Navs-->
                <ul id="myTab"
                    class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold order-lg-1 order-2">

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 active" data-bs-toggle="tab"
                            data-bs-target="#kt_tab_pane_1" href="#kt_tab_pane_1">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t($item_model::ui['s_ucf']) }}
                        </a>
                    </li>

                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5
                          {{ app()->request->active == ClientTrillion::ui['route'] ? 'active' : '' }}   "
                            data-bs-toggle="tab" data-bs-target="#kt_tab_pane_2" href="#kt_tab_pane_2">
                            <span class="svg-icon svg-icon-2 me-2">

                            </span>
                            {{ t(ClientTrillion::ui['s_ucf']) }}
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6  px-2 py-5
                        @disabled(!$item_model->exists)
                          {{ app()->request->active == ContractItem::ui['route'] ? 'active' : '' }}   "
                            data-bs-toggle="tab" id="items" data-bs-target="#kt_tab_pane_3" href="#kt_tab_pane_3">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{ t(ContractItem::ui['s_ucf']) }}
                        </a>
                    </li>



                    <!--end::Nav item-->
                    <!--begin::Nav item-->


                    {{-- <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($item_model) ? '' : 'disabled' }}"
                            data-bs-toggle="tab" data-bs-target="#kt_tab_pane_7" href="#kt_tab_pane_7">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{ __('Attachments') }} </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-6 px-2 py-5 {{ isset($item_model) ? '' : 'disabled' }}"
                            data-bs-toggle="tab" data-bs-target="#kt_tab_pane_history" href="#kt_tab_pane_history">
                            <span class="svg-icon svg-icon-2 me-2">
                            </span>
                            {{ __('History') }} </a>
                    </li> --}}


                    <!--end::Nav item-->
                    <!--begin::Nav item-->

                </ul>


            </div>
            <div class="d-flex my-4 justify-content-end order-lg-2 order-1">

                <a href="{{ route($item_model::ui['route'] . '.index') }}" class="btn btn-sm btn-light me-2"
                    id="kt_user_follow_button">
                    <span class="svg-icon svg-icon-2">
                        <!-- SVG content remains unchanged -->
                    </span>
                    {{ __('Exit') }}
                </a>
                <a href="#" class="btn btn-sm btn-primary" data-kt-{{ $item_model::ui['s_lcf'] }}-action="submit">
                    <span class="indicator-label">
                        <span class="svg-icon svg-icon-2">
                            <!-- SVG content remains unchanged -->
                        </span>
                        {{ __('Save Form') }}
                    </span>
                    <span class="indicator-progress">
                        {{ __('Please wait...') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </a>
            </div>
            <!--begin::Navs-->
        </div>
    </div>
    <!--end::Content container-->
    <!--begin::Modal - Add task-->

    <form class="tab-content" id="{{ $item_model::ui['s_lcf'] }}_form" method="post"
        action="{{ route($item_model::ui['route'] . '.addedit') }}">
        @csrf
        @if ($item_model->exists)
            <input type="hidden" name="{{ $item_model::ui['_id'] }}" value="{{ $item_model->id }}">
        @endif
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{ t($item_model::ui['s_ucf'] . ' Details') }}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                @include($item_model::ui['route'] . '.form')
                <!--end::Card body-->
            </div>

        </div>
        <div class="tab-pane fade  {{ app()->request->active == ClientTrillion::ui['route'] ? 'show active' : '' }}"
            id="kt_tab_pane_2" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{ t(ClientTrillion::ui['s_ucf'] . ' Details') }}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                @include($item_model::ui['route'] . '.' . ClientTrillion::ui['s_lcf'])



                <!--end::Card body-->
            </div>

        </div>
        <div class="tab-pane fade  {{ app()->request->active == ContractItem::ui['route'] ? 'show active' : '' }}"
            id="kt_tab_pane_3" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_itemes_details_view">
                <!--begin::Card header-->
                @if ($item_model->exists)
                    @include($item_model::ui['p_lcf'] . '.' . ContractItem::ui['p_lcf'] . '.index')
                @endif
                <!--end::Card body-->
            </div>
        </div>
        {{-- <div class="tab-pane fade" id="kt_tab_pane_7" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_attachments_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        attachments
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    @if (isset($item_model))
                        @include($item_model::ui['route'] . '.attachments.index')
                    @endif

                </div>
                <!--end::Card body-->
            </div>
        </div>


        <div class="tab-pane fade" id="kt_tab_pane_history" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_history_view">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        History
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">


                    @include($item_model::ui['route'] . '.history.index')


                </div>
                <!--end::Card body-->
            </div>
        </div> --}}

    </form>

    <div class="modal fade" id="kt_modal_general" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>

@endsection

@push('scripts')
    {{-- renderValidate --}}
    <script>
        renderValidate('#{{ $item_model::ui['s_lcf'] }}_form',
            '[data-kt-{{ $item_model::ui['s_lcf'] }}-action="submit"]');
    </script>

    {{-- objectives tags input --}}
    <script>
        $(document).ready(function() {
            // Initialize main page objectives select
            const mainObjectivesSelect = initializeObjectivesSelect('#objectives-select');
        });
    </script>

    {{-- // Initialize the contract start date picker --}}
    <script>
        $(function() {
            $("input[name='contract_start_date']").flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                allowInput: true,
                minDate: "today",
                onChange: function(selectedDates, dateStr, instance) {
                    // When the start date changes, update the minDate for the end date picker
                    console.log(selectedDates, dateStr, instance);
                    $("input[name='contract_end_date']").flatpickr().set('minDate', dateStr);
                }
            });

            // Initialize the contract end date picker
            $("input[name='contract_end_date']").flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                allowInput: true,
                minDate: "today"
            });
        });
    </script>

    {{-- ClientTrillionModel --}}
    <script>
        $(document).ready(function() {
            const ClientTrillionModel = "App\\Models\\ClientTrillion";
            const $clientTrillionSelect = $('[name="client_trillion_id"]');

            console.log('Initializing Client Trillion selector');
            initializeClientTrillionSelector();

            console.log('Setting up contract data');
            setupContractData();

            function initializeClientTrillionSelector() {
                getSelect2(ClientTrillionModel, $clientTrillionSelect, "Select a Client Trillion",
                    setClientTrillionDetails);

                // Set initial value if available
                const initialClientTrillionId =
                    "{{ old('client_trillion_id', isset($clientTrillion) ? $clientTrillion->id : '') }}";
                if (initialClientTrillionId) {
                    console.log(`Setting initial Client Trillion ID: ${initialClientTrillionId}`);
                    setClientTrillionDetails(initialClientTrillionId, ClientTrillionModel);
                }
            }

            function setupContractData() {
                const contractJson = `@json(isset($item_model) ? $item_model : null)`;
                console.log('Contract JSON string:', contractJson);

                try {
                    const contract = JSON.parse(contractJson);
                    console.log('Parsed contract:', contract);
                    if (contract && contract.client_trillion_id) {
                        console.log(`Setting Client Trillion from contract: ${contract.client_trillion_id}`);
                        setClientTrillionDetails(contract.client_trillion_id, ClientTrillionModel);
                    }
                } catch (error) {
                    console.error('Error parsing contract JSON:', error);
                }
            }
        });

        function setClientTrillionDetails(modelId, model) {
            console.log(`Setting Client Trillion details. Model ID: ${modelId}, Model: ${model}`);

            if (!modelId) {
                console.log('No model ID provided. Using old session values.');
                setFieldsFromOldValues();
                return;
            }

            console.log('Fetching Client Trillion details from server');
            $.ajax({
                url: "{{ route('getSelect2Details') }}",
                method: 'GET',
                data: {
                    model,
                    model_id: modelId
                },
                success: handleClientTrillionDataSuccess,
                // error: handleClientTrillionDataError
                error: handleAjaxErrors,

            });
        }

        function handleClientTrillionDataSuccess(data) {
            console.log('Client Trillion data received:', data);
            const clientTrillion = data.item;

            setField('name', clientTrillion.name);
            setField('name_en', clientTrillion.name_en);
            setField('name_h', clientTrillion.name_h);
            setField('representative_name', clientTrillion.representative_name);
            setField('registration_name', clientTrillion.registration_name);
            setField('registration_number', clientTrillion.registration_number);
            setSelectField('country_id', clientTrillion.country_id);
            setSelectField('city_id', clientTrillion.city_id);
            setSelectField('company_type', clientTrillion.company_type);
            setField('address', clientTrillion.address);
            setField('telephone', clientTrillion.telephone);
            setField('fax', clientTrillion.fax);
            setField('email', clientTrillion.email);

            setActiveStatus(clientTrillion.active);

            console.log('Client Trillion details set successfully');

            // Create and append the option to Select2
            var option = new Option(clientTrillion.name, clientTrillion.id, true, true);
            $('[name="client_trillion_id"]').append(option).trigger('change');
            console.log("Select2 option created and selected:", {
                name: clientTrillion.name,
                id: clientTrillion.id
            });
        }

        // function handleClientTrillionDataError(response) {
        //     console.error('Failed to fetch Client Trillion data:', response);
        //     toastr.error(response.responseJSON.message);
        // }


        function setFieldsFromOldValues() {
            setField('name');
            setField('name_en');
            setField('name_h');
            setField('representative_name');
            setField('registration_name');
            setField('registration_number');
            setSelectField('country_id');
            setSelectField('city_id');
            setSelectField('company_type');
            setField('address');
            setField('telephone');
            setField('fax');
            setField('email');

            const oldActiveStatus = "{{ old('active', 0) }}";
            setActiveStatus(parseInt(oldActiveStatus));

            console.log('Fields set from old values');
        }
    </script>
@endpush
