

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
    @foreach ($insuranceCompanys as $insuranceCompany)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td>{{$insuranceCompany->name}}</td>
            <td>{{$insuranceCompany->registration_no}}</td>
            <td>{{$insuranceCompany->telephone}}</td>
            <td>{{$insuranceCompany->email}}</td>
            <td>{{$insuranceCompany->branches_count}}</td>
            <td>{{$insuranceCompany->teams_count}}</td>
            <td>{{$insuranceCompany->clients_count}}</td>
            <td>{{isset($insuranceCompany->type)?$insuranceCompany->type->name:''}}</td>
            <td>{{$insuranceCompany->commission}}</td>
            <td>{{$insuranceCompany->active}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

