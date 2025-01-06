<table>

    <tr>
        <td>{{__('SN')}}</td>
        <td>{{__('Date')}}</td>
        <td>{{__('Time')}}</td>
        <td>{{__('Since')}}</td>
        <td>{{__('Ticket Number')}}</td>
        <td>{{__('Department')}}</td>
        <td>{{__('Employee')}}</td>
        <td>{{__('Telephone')}}</td>
        <td>{{__('City')}}</td>
        <td>{{__('Category')}}</td>
        <td>{{__('Name')}}</td>
        <td>{{__('Purpose')}}</td>

        <td>{{__('Details')}}</td>

        <td>{{__('Priority')}}</td>
        <td>{{__('Status')}}</td>
        <td>{{__('Source')}}</td>


    </tr>


    @foreach ($tickets as $ticket)
        <tr>
            <td>{{$ticket->id}}</td>
            <td>{{$ticket->ticket_date}}</td>
            <td>{{$ticket->ticket_time}}</td>
            <td>{{\Carbon\Carbon::parse($ticket->created_at)->diffForHumans()}} </td>
            <td>{{$ticket->ticket_number}}</td>
            <td>{{isset($ticket->ticket_types)?$ticket->ticket_types->name:''}} </td>
            <td>{{isset($ticket->employees)?$ticket->employees->name:''}} </td>
            <td>{{$ticket->mobile}}</td>
            <td>{{isset($ticket->cities)?$ticket->cities->name:''}} </td>
            <td>{{isset($ticket->categories)?$ticket->categories->name:''}} </td>
            <td>{{$ticket->request_name}}</td>
            <td>{{isset($ticket->purposes)?$ticket->purposes->name:''}} </td>

            <td>{{$ticket->details}}</td>

            <td>{{isset($ticket->priorities)?$ticket->priorities->name:''}} </td>
            <td>{{isset($ticket->statuses)?$ticket->statuses->name:''}} </td>
            <td>{{$ticket->source}}</td>


        </tr>
    @endforeach

</table>
