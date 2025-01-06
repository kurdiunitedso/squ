<table>
    <thead>
    <tr>
        <td>{{__('SN')}}</td>
        <td>{{__('City')}}</td>
        <td>{{__('Name')}}</td>
        <td>{{__('Client ID')}}</td>
        <td>{{__('Mobile')}}</td>
        <td>{{__('Category')}}</td>
        <td>{{__('Status')}}</td>
        <td>{{__('Total Orders Box')}}</td>
        <td>{{__('Total Orders Bot')}}</td>
        <td>{{__('Total Orders Now')}}</td>
        <td>{{__('Last order Box')}}</td>
        <td>{{__('Last order Bot')}}</td>
        <td>{{__('Last order Now')}}</td>
        <td>{{__('Active')}}</td>


    </tr>
    </thead>
    <tbody>
    @foreach ($clients as $client)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td>{{isset($client->citys)?$client->citys->name:''}}</td>
            <td>{{$client->name}}</td>
            <td>{{$client->client_id}}</td>
            <td>{{$client->telephone}}</td>
            <td>{{isset($client->categorys)?$client->categorys->name:''}}</td>
            <td>{{isset($client->statuss)?$client->statuss->name:''}}</td>
            <td>{{$client->orders_box}}</td>
            <td>{{$client->orders_bot}}</td>
            <td>{{$client->orders_now}}</td>
            <td>{{$client->last_orders_box}}</td>
            <td>{{$client->last_orders_bot}}</td>
            <td>{{$client->last_orders_now}}</td>
            <td>{{$client->active}}</td>


        </tr>
    @endforeach
    </tbody>
</table>
