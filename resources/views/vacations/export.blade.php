<table>
    <thead>
    <tr>
        <th>{{__('ID')}}</th>
        <th>{{__('Employee')}}</th>
        <th>{{__('Type')}}</th>
        <th>{{__('From Date')}}</th>
        <th>{{__('To Date')}}</th>
        <th>{{__('Days')}}</th>
        <th>{{__('Balance')}}</th>
        <th>{{__('Request date')}}</th>
        <th>{{__('Status')}}</th>


    </tr>
    </thead>
    <tbody>
    @foreach ($vacations as $vacation)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td>{{isset($vacation->employees)?$vacation->employees->name:''}}</td>
            <td>{{isset($vacation->types)?$vacation->types->name:''}}</td>
            <td>{{$vacation->from_date}}</td>
            <td>{{$vacation->to_date}}</td>

            <td>{{$vacation->days}}</td>
            <td>{{$vacation->balance}}</td>
            <td>{{$vacation->orders_now}}</td>
            <td>{{$vacation->created_at}}</td>
            <td>{{isset($vacation->statuss)?$vacation->statuss->name:''}}</td>


        </tr>
    @endforeach
    </tbody>
</table>
