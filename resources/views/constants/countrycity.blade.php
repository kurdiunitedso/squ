@extends('metronic.index')

@section('title', 'Settings - Countries & Cities')
@section('subpageTitle', 'Settings')
@section('subpageName', 'Countries & Cities')

@section('content')
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        @include('constants.country')

        @include('constants.city')
    </div>
@endsection
