

<table>
    <thead>
    <tr>
        <th class="">{{__('SN')}}</th>
        <th class="all">{{__('Name')}}</th>
        <th class="all">{{__('Mobile')}}</th>
        <th class="all">{{__('Email')}}</th>
        <th class="all">{{__('Username')}}</th>

        <th class="all">{{__('Balance')}}</th>

        <th class="all">{{__('Active')}}</th>


    </tr>
    </thead>
    <tbody>
    @foreach ($employees as $employee)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <th class="all">{{$employee->name}}</th>
            <th class="all">{{$employee->mobile}}</th>
            <th class="all">{{$employee->email}}</th>
            <th class="all">{{isset($employee->user)?$employee->user->email:''}}</th>

            <th class="all">{{$employee->balance}}</th>

            <th class="all">{{$employee->active?'Yes':'No'}}</th>



        </tr>
    @endforeach
    </tbody>
</table>

