

<table>
    <tr>
      <td class="">{{__('SN')}}</td>
      <td class="min-w-250px bold all">{{__('Name')}}</td>
      <td class="">{{__('Registration Number')}}</td>
      <td class="">{{__('Telephone')}}</td>
      <td class="">{{__('Email')}}</td>
      <td class="">{{__('Branches')}}</td>
      <td class="">{{__('Teams')}}</td>
        <td class="">{{__('Clients')}}</td>
      <td class="">{{__('Type')}}</td>
      <td class="">{{__('Commission')}}</td>
        <td class="">{{__('Actvie')}}</td>

    </tr>

    <tbody>
    @foreach ($marketingAgencys as $marketingAgency)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td>{{$marketingAgency->name}}</td>
            <td>{{$marketingAgency->registration_no}}</td>
            <td>{{$marketingAgency->telephone}}</td>
            <td>{{$marketingAgency->email}}</td>
            <td>{{$marketingAgency->branches_count}}</td>
            <td>{{$marketingAgency->teams_count}}</td>
            <td>{{$marketingAgency->clients_count}}</td>
            <td>{{isset($marketingAgency->type)?$marketingAgency->type->name:''}}</td>
            <td>{{$marketingAgency->commission}}</td>
            <td>{{$marketingAgency->active}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

