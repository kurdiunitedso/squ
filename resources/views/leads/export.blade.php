

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
    @foreach ($leads as $lead)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td>{{$lead->name}}</td>
            <td>{{$lead->registration_no}}</td>
            <td>{{$lead->telephone}}</td>
            <td>{{$lead->email}}</td>
            <td>{{$lead->branches_count}}</td>
            <td>{{$lead->teams_count}}</td>
            <td>{{$lead->clients_count}}</td>
            <td>{{isset($lead->type)?$lead->type->name:''}}</td>
            <td>{{$lead->commission}}</td>
            <td>{{$lead->active}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

