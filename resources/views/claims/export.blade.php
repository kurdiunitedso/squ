

<table>
    <tr>


        <th class="">{{__('SN')}}</th>
        <th class="">{{__('Claim Title')}}</th>
        <th class="">{{__('Client')}}</th>
        <th class="">{{__('Telephone')}}</th>
        <th class="">{{__('Items')}}</th>
        <th class="">{{__('Cost')}}</th>
        <th class="">{{__('Currency')}}</th>
        <th class="">{{__('Claim Date')}}</th>
        <th class="">{{__('Service Data From')}}</th>
        <th class="">{{__('Service Data To')}}</th>
        <th class="">{{__('Payment Data')}}</th>
        <th class=" ">{{__('Active')}}</th>
        <th class="">{{__('Status')}}</th>


    </tr>

    <tbody>
    @foreach ($claims as $claim)
        @php
            $types='';
                        foreach (explode(',',$claim->types) as $k=>$v)
                            $types.=(\App\Models\Constant::find($v)?\App\Models\Constant::find($v)->name:'').",";

                        $types= rtrim($types,',');
        @endphp
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td>{{$types}}</td>
            <td>{{isset($claim->client)?$claim->client->name:''}}</td>
            <td>{{isset($claim->client)?$claim->client->telphone:''}}</td>
            <td>{{$claim->items_count}}</td>
            <td>{{$claim->cost}}</td>
            <td>{{isset($claim->currencys)?$claim->currencys->name:''}}</td>
            <td>{{$claim->claim_date}}</td>
            <td>{{$claim->service_date_from}}</td>
            <td>{{$claim->service_date_to}}</td>
            <td>{{$claim->payment_date}}</td>
            <td>{{$claim->active}}</td>
            <td>{{isset($claim->status)?$claim->status->name:''}}</td>


        </tr>
    @endforeach
    </tbody>
</table>

