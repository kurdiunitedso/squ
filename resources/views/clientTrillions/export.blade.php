<table>
    <thead>
    <tr>

        <td>{{__('SN')}}</td>
        <td>{{__('Name')}}</td>
        <td>{{__('Name en')}}</td>
        <td>{{__('Name hebrew')}}</td>
        <td>{{__('Registration Name')}}</td>
        <td>{{__('Registration Number')}}</td>
        <td>{{__('Country')}}</td>
        <td>{{__('City')}}</td>
        <td>{{__('Type')}}</td>
        <td>{{__('Telephone')}} </td>
        <td>{{__('Fax')}} </td>
        <td>{{__('Email')}} </td>
        <td>{{__('Active')}} </td>
        <td>{{__('Bank')}} </td>
        <td>{{__('Teams')}} </td>
        <td>{{__('Socials')}} </td>
        <td>{{__('Attachments')}} </td>
        <td>{{__('Claims')}} </td>
        <td>{{__('Projects')}} </td>
        <td>{{__('Created date')}}</td>


    </tr>
    </thead>
    <tbody>
    @foreach ($clientTrillions as $clientTrillion)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td>{{$clientTrillion->name}}</td>
            <td>{{$clientTrillion->name_en}}</td>
            <td>{{$clientTrillion->name_h}}</td>

            <td>{{$clientTrillion->registration_name}}</td>
            <td>{{$clientTrillion->registration_number}}</td>

            <td>{{isset($clientTrillion->country)?$clientTrillion->country->name:''}}</td>
            <td>{{isset($clientTrillion->city)?$clientTrillion->city->name:''}}</td>
            <td>{{isset($clientTrillion->type)?$clientTrillion->type->name:''}}</td>
            <td>{{$clientTrillion->telephone}}</td>
            <td>{{$clientTrillion->fax}}</td>
            <td>{{$clientTrillion->email}}</td>
            <td>{{($clientTrillion->active)?'Yes':'No'}}</td>
            <td>{{isset($clientTrillion->bank)?$clientTrillion->bank->name:''}}</td>
            <td>{{$clientTrillion->teams_count}}</td>
            <td>{{$clientTrillion->socials_count}}</td>
            <td>{{$clientTrillion->attachments_count}}</td>
            <td>{{$clientTrillion->id}}</td>
            <td>{{$clientTrillion->id}}</td>
            <td>{{$clientTrillion->created_at}}</td>



        </tr>
    @endforeach
    </tbody>
</table>
