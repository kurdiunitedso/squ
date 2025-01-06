

<table>
    <tr>
        <td>{{__('SN')}}</td>
        <td>{{__('Captin')}}</td>
        <td>{{__('Vehicle type')}}</td>
        <td>{{__('Vehicle Model')}}</td>
        <td>{{__('Vehicle year')}}</td>
        <td>{{__('Motor CC')}}</td>
        <td>{{__('Fuel Type')}}</td>
        <td>{{__('Vehicle No')}}</td>
        <td>{{__('Box No')}}</td>
        <td>{{__('Signed promissor')}}</td>
        <td>{{__('Promissory #')}}</td>
        <td>{{__('License Expire Date')}}</td>
        <td>{{__('Has Insurance')}}</td>
        <td>{{__('Insurance Company')}}</td>
        <td>{{__('Insurance Type')}}</td>
        <td>{{__('Insurance Expire')}}</td>

    </tr>

    <tbody>
    @foreach ($vehicles as $vehicle)
        <tr>
            <td>{{ ++$loop->index }}</td>

            <td>{{isset($vehicle->captin)?$vehicle->captin->name:''}}</td>
            <td>{{isset($vehicle->vehicle_types)?$vehicle->vehicle_types->name:''}}</td>
            <td>{{isset($vehicle->vehicle_models)?$vehicle->vehicle_models->name:''}}</td>
            <td>{{$vehicle->vehicle_year}}</td>
            <td>{{isset($vehicle->motor_ccs)?$vehicle->motor_ccs->name:''}}</td>
            <td>{{isset($vehicle->fuel_types)?$vehicle->fuel_types->name:''}}</td>
            <td>{{$vehicle->vehicle_no}}</td>
            <td>{{$vehicle->box_no}}</td>
            <td>{{$vehicle->sign_permission}}</td>
            <td>{{$vehicle->promissory}}</td>
            <td>{{$vehicle->license_expire_date2}}</td>
            <td>{{$vehicle->has_insurance}}</td>
            <td>{{isset($vehicle->insurance_companys)?$vehicle->insurance_companys->name:''}}</td>
            <td>{{isset($vehicle->insurance_types)?$vehicle->insurance_types->name:''}}</td>
            <td>{{$vehicle->policy_expire}}</td>


        </tr>
    @endforeach
    </tbody>
</table>

