@extends('metronic.index')

@section('title', $client->name . ' - Attachments')
@section('subpageTitle', 'Clients')
@section('subpageName', $client->name . ' - Attachments')

@section('content')
    @include('clients.shared.tabs', ['client' => $client])
    <div>
        <div class="card mb-5 mb-xl-10" id="kt_client_attachments_details_view">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Client History</h3>
                </div>

            </div>


            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Tab panel-->
                <div class="tab-content">
                    @include('clients.history.accordions', [
                        'calls' => $calls,
                        'internalAppointments' => $internalAppointments,
                        'externalAppointments' => $externalAppointments,
                        'clientSMS' => $clientSMSes,
                    ])
                </div>
            </div>

        </div>
    </div>


@endsection
