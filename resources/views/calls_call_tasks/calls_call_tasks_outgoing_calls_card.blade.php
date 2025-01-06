<div class="d-flex flex-row">
    <span class="svg-icon svg-icon-2 svg-icon-primary">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect opacity="0.3" x="4" y="11" width="12" height="2" rx="1"
                fill="currentColor" />
            <path
                d="M5.86875 11.6927L7.62435 10.2297C8.09457 9.83785 8.12683 9.12683 7.69401 8.69401C7.3043 8.3043 6.67836 8.28591 6.26643 8.65206L3.34084 11.2526C2.89332 11.6504 2.89332 12.3496 3.34084 12.7474L6.26643 15.3479C6.67836 15.7141 7.3043 15.6957 7.69401 15.306C8.12683 14.8732 8.09458 14.1621 7.62435 13.7703L5.86875 12.3073C5.67684 12.1474 5.67684 11.8526 5.86875 11.6927Z"
                fill="currentColor" />
            <path
                d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z"
                fill="currentColor" />
        </svg>
    </span>
    <h4 class="ms-3 text-primary">Calls</h4>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>
                ID
            </th>

            <th>
                CallTask Action
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
                    @can('callTask_call_delete')
                        <a data-call-name="register-id : {{ $call->id }}"
                            data-refresh-url={{ route('calls.callTask.view_calls', ['callTask' => $callTask->id]) }}
                            href="{{ route('calls.callTask.delete', ['callTask' => $call->id]) }}"
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
                    @if ($call->call_questionnaire_responses_count > 0)
                        <a href="{{ route('calls.callTask.view_call_questionnaire_responses', ['callTask' => $call->id]) }}"
                            data-bs-custom-class="tooltip-inverse" id="{{ $loop->first ? 'myTooltip' : '' }}"
                            data-bs-placement="bottom" title="Questionnaire Responses"
                            class="btn btn-icon btn-active-light-primary w-30px h-30px btnShowQuestionnaireLog">
                            <span class="svg-icon svg-icon-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M18 22C19.7 22 21 20.7 21 19C21 18.5 20.9 18.1 20.7 17.7L15.3 6.30005C15.1 5.90005 15 5.5 15 5C15 3.3 16.3 2 18 2H6C4.3 2 3 3.3 3 5C3 5.5 3.1 5.90005 3.3 6.30005L8.7 17.7C8.9 18.1 9 18.5 9 19C9 20.7 7.7 22 6 22H18Z"
                                        fill="currentColor" />
                                    <path d="M18 2C19.7 2 21 3.3 21 5H9C9 3.3 7.7 2 6 2H18Z" fill="currentColor" />
                                    <path d="M9 19C9 20.7 7.7 22 6 22C4.3 22 3 20.7 3 19H9Z" fill="currentColor" />
                                </svg>
                            </span>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
