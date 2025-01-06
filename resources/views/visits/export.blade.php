<table>

    <tr>
        <td >{{__('SN')}} </td>
        <td >{{__('Max Visit Date')}} </td>
        <td >{{__('Date')}} </td>
        <td >{{__('Time')}} </td>
        <td >{{__('Since')}} </td>
        <td >{{__('Visit Number')}} </td>
        <td >{{__('Type')}} </td>
        <td >{{__('Name')}} </td>
        <td >{{__('Telephone')}} </td>

        <td >{{__('City')}} </td>
        <td >{{__('Period')}} </td>
        <td >{{__('Category')}} </td>
        <td >{{__('Purpose')}} </td>
        <td >{{__('Employee')}} </td>
        <td >{{__('Rating_Company')}} </td>
        <td >{{__('Rating_Captin')}} </td>
        <td >{{__('Details')}} </td>
        <td >{{__('Source')}} </td>


    </tr>


    @foreach ($visits as $visit)
        <tr>
            <td >{{$visit->id}} </td>
            <td >{{$visit->last_date}} </td>
            <td >{{$visit->visit_date}} </td>
            <td >{{$visit->visit_time}} </td>
            <td >{{\Carbon\Carbon::parse($visit->created_at)->diffForHumans()}} </td>
            <td >{{$visit->visit_number}} </td>
            <td >{{isset($visit->visit_types)?$visit->visit_types->name:''}} </td>
            <td >{{$visit->visit_name}} </td>
            <td >{{$visit->telephone}} </td>

            <td >{{isset($visit->cities)?$visit->cities->name:''}} </td>
            <td >{{isset($visit->periods)?$visit->periods->name:''}} </td>
            <td >{{isset($visit->categories)?$visit->categories->name:'' }} </td>
            <td >{{isset($visit->purposes)?$visit->purposes->name:'' }}  </td>
            <td >{{isset($visit->employees)?$visit->employees->name:'' }}  </td>
            <td >{{$visit->rate_captin}}  </td>
            <td >{{$visit->rate_captin}} </td>
            <td >{{$visit->details}}</td>
            <td >{{$visit->source}} </td>


        </tr>
    @endforeach

</table>
