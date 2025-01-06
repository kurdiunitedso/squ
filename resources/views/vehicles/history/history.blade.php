@extends('metronic.index')

@section('title', $captin->name . ' - Attachments')
@section('subpageTitle', 'Captins')
@section('subpageName', $captin->name . ' - Attachments')

@section('content')
    @include('captins.shared.tabs', ['captin' => $captin])
    <div>
        <div class="card mb-5 mb-xl-10" id="kt_captin_attachments_details_view">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Captin History</h3>
                </div>

            </div>


            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Tab panel-->
                <div class="tab-content">
                    @include('captins.history.accordions', [
                        'calls' => $calls,
                        'internalAppointments' => $internalAppointments,
                        'externalAppointments' => $externalAppointments,
                        'captinSMS' => $captinSMSes,
                    ])
                </div>
            </div>

        </div>
    </div>


@endsection
