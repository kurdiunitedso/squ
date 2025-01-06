@isset($employee)
    <div>

        <table class="table table-striped table-bordered table-hover  order-column" id="">
            <thead>
            <tr>
                <th>ID</th>
                <th>Action</th>

                <th>Employee</th>
                <th>Notes</th>

                <th>Date</th>

            </tr>
            </thead>
            <tbody>
            @php $count=1;  @endphp

            @foreach($audits as $audit)
                @php
                    $metadata = $audit->getMetadata();
                    $createdAt = $metadata['audit_created_at'];
                    $formattedCreatedAt = \Carbon\Carbon::parse($createdAt)->format('Y-m-d H:i:s');

                    // Update the 'audit_created_at' field in the metadata with the formatted value
                    $metadata['audit_created_at'] = $formattedCreatedAt;
                @endphp



                <tr>
                    <td>{{$count++}}</td>
                    <td> {{ ucfirst($audit->event) }}</td>
                    <td>{{isset($audit->user)?$audit->user->name:'Auto'}}</td>
               {{--     <td>
                        @foreach ($audit->getModified() as $attribute => $modified)
                            @if ($audit->event == 'updated')

                                <p>@lang( $audit->event . ' ' . $attribute." ".  $modified['old'] .' to '. $modified['new'])</p>
                            @else
                                @lang( $audit->event . '.metadata', $metadata)
                            @endif
                        @endforeach
                    </td>--}}
                    <td>{{ $formattedCreatedAt}} </td>

                </tr>

            @endforeach
            </tbody>
        </table>
        <hr>

    </div>
    @if(count($attachmentAudits)>0)
        <table class="table table-striped table-bordered table-hover  order-column" id="">
            <thead>
            <tr>
                <th>ID</th>
                <th>Action</th>

                <th>Employee</th>
                <th>Notes</th>

                <th>Date</th>

            </tr>
            </thead>
            <tbody>
            @php $count=1;  @endphp
            @foreach($attachmentAudits as $audit)
                @php
                    $metadata = $audit->getMetadata();
                    $createdAt = $metadata['audit_created_at'];
                    $formattedCreatedAt = \Carbon\Carbon::parse($createdAt)->format('Y-m-d H:i:s');

                    // Update the 'audit_created_at' field in the metadata with the formatted value
                    $metadata['audit_created_at'] = $formattedCreatedAt;
                @endphp



       {{--         <tr>
                    <td>{{$count++}}</td>
                    <td> {{ ucfirst($audit->event) }}</td>
                    <td>{{isset($audit->user)?$audit->user->name:'Auto'}}</td>
                    <td>
                        @foreach ($audit->getModified() as $attribute => $modified)
                            @if ($audit->event == 'updated')

                                <p>@lang( $audit->event . ' ' . $attribute." ".  $modified['old'] .' to '. $modified['new'])</p>
                            @else
                                <p> @lang( $audit->event . ' '.$attribute.'= '.$modified['new'])</p>
                            @endif
                        @endforeach
                    </td>
                    <td>{{ $formattedCreatedAt}} </td>

                </tr>--}}

            @endforeach
            </tbody>
        </table>


    @endif
@endisset
