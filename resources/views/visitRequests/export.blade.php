<table>

    <tr>
        <th class="all">{{__('SN')}}</th>
        <th class="all">{{__('Category')}}</th>
        <th class="all">{{__('Name')}}</th>
        <th class="all">{{__('Telephone')}}</th>
        <th class="all">{{__('Type')}}</th>
        <th class="all">{{__('Employee')}}</th>

        <th class="all">{{__('Max Visit Date')}}</th>


        <th class="all">{{__('Visits')}}</th>
        <th class="all">{{__('Status')}}</th>


    </tr>


    @foreach ($visits as $visit)
        <tr>
            <td >{{$visit->id}} </td>
            <td >{{isset($visit->categories)?$visit->categories->name:'' }} </td>
            <td >{{$visit->visit_name}} </td>
            <td >{{$visit->telephone}} </td>
            <td >{{isset($visit->visit_types)?$visit->visit_types->name:''}} </td>
            <td >{{isset($visit->employees)?$visit->employees->name:'' }}  </td>
            <td >{{$visit->last_date}} </td>
            <td >{{$visit->visits_count}} </td>
            <td >{{isset($visit->statuses)?$visit->statuses->name:''}} </td>





        </tr>
    @endforeach

</table>
