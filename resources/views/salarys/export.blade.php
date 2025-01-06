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
    @foreach ($salarys as $salary)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td>{{isset($salary->employees)?$salary->employees->name:''}}</td>
            <td>{{isset($salary->types)?$salary->types->name:''}}</td>
            <td>{{$salary->from_date}}</td>
            <td>{{$salary->to_date}}</td>

            <td>{{$salary->days}}</td>
            <td>{{$salary->balance}}</td>
            <td>{{$salary->orders_now}}</td>
            <td>{{$salary->created_at}}</td>
            <td>{{isset($salary->statuss)?$salary->statuss->name:''}}</td>


        </tr>
    @endforeach
    </tbody>
</table>
