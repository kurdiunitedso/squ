<table>
    <thead>
    <tr>
        <th class="all">#</th>
        <th class="all">ID</th>
        <th class="all">Call Date</th>
        <th class="all">Call Type</th>
        <th class="all">Name</th>
        <th class="all">City</th>
        <th class="all">Telephone</th>
        <th class="all">Employee - Call Center</th>
        <th class="all">Action</th>
        <th class="all">Notes By Call Center</th>
        <th class="all">Notes Of Employee</th>
        <th class="all">Urgency</th>
        <th class="all">Listen</th>
        <th class="all"> Status</th>

    </tr>
    </thead>
    <tbody>


    @foreach ($calls as $call)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td>{{ $call->id }}</td>
            <td>{{ $call->created_at }}</td>
            <td>{{$call->call->caller->name}}</td>
            <td>{{$call->call->name}}</td>
            <td>{{$call->call->city->name}}</td>
            <td>{{$call->call->telephone}}</td>
            <td>{{$call->call->employee->name}}</td>
            <td>{{$call->task_actions->name}}</td>
            <td>{{$call->call->notes}}</td>
            <td>{{$call->notes}}</td>
            <td>{{$call->task_urgencys->name}}</td>
            <td>{{$call->listen}}</td>
            <td> {{$call->task_statuss->name}}</td>

        </tr>
    @endforeach
    </tbody>
</table>
