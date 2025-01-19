<div class="d-flex flex-row">
    <span class="svg-icon svg-icon-2 svg-icon-primary">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect opacity="0.3" width="12" height="2" rx="1" transform="matrix(-1 0 0 1 15.5 11)"
                fill="currentColor" />
            <path
                d="M13.6313 11.6927L11.8756 10.2297C11.4054 9.83785 11.3732 9.12683 11.806 8.69401C12.1957 8.3043 12.8216 8.28591 13.2336 8.65206L16.1592 11.2526C16.6067 11.6504 16.6067 12.3496 16.1592 12.7474L13.2336 15.3479C12.8216 15.7141 12.1957 15.6957 11.806 15.306C11.3732 14.8732 11.4054 14.1621 11.8756 13.7703L13.6313 12.3073C13.8232 12.1474 13.8232 11.8526 13.6313 11.6927Z"
                fill="currentColor" />
            <path
                d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z"
                fill="currentColor" />
        </svg>
    </span>
    <h4 class="ms-3 text-primary">Incoming calls</h4>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>
                ID
            </th>
            <th>
                Call Action
            </th>
            <th>
                Patient Action
            </th>
            <th>
                Employee
            </th>
            <th>
                Next Call
            </th>
            <th>
                Notes
            </th>
            <th>
                Created at
            </th>
            <th>
                Actions
            </th>
        </tr>
    </thead>
    <tbody>
        @if (count($calls) == 0)
            <tr>
                <td colspan="8" class="fw-bold text-center text-muted">
                    No data to display
                </td>
            </tr>
        @endif
        @foreach ($calls as $call)
            <tr>
                <td>
                    {{ $call->id }}
                </td>
                <td>
                    {{ $call->callAction->name }}
                </td>
                <td>
                    {{ $call->patientAction->name }}
                </td>
                <td>
                    {{ $call->user->name }}
                </td>
                <td>
                    {{ $call->next_call->format('d/m/Y') }}
                </td>
                <td>
                    {{ $call->notes }}
                </td>
                <td>
                    {{ $call->created_at->format('d/m/Y h:i:s A') }}
                </td>
                <td>
                    @can('patient_call_delete')
                        <a data-call-name="call-id : {{ $call->id }}"
                            data-refresh-url={{ route('patients.calls.view_patients_calls', ['patient' => $patient->id]) }}
                            href="{{ route('patients.calls.delete', ['call' => $call->id]) }}"
                            class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteCall">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                            <span class="svg-icon svg-icon-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                        fill="currentColor" />
                                    <path opacity="0.5"
                                        d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                        fill="currentColor" />
                                    <path opacity="0.5"
                                        d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </a>
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
