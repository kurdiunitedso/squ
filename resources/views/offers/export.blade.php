<table>
    <tr>
        <td class="">{{__('SN')}}</td>
        <td class="">{{__('Facility Name')}}</td>
        <td class="">{{__('Facility Type')}}</td>
        <td class="">{{__('Facility Telephone')}}</td>
        <td class="">{{__('Visit ID')}}</td>
        <td class="">{{__('Items')}}</td>
        <td class="">{{__('Offer Type')}}</td>
        <td class="">{{__('Wheels')}}</td>
        <td class="">{{__('Duration')}}</td>
        <td class="">{{__('Discount')}}</td>
        <td class="">{{__('Total Cost')}}</td>
        <td class="">{{__('Status')}}</td>


    </tr>

    <tbody>
    @foreach ($offers as $offer)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td class="">{{$offer->facility?$offer->facility->name:''}}</td>
            <td class="">{{$offer->facility?($offer->facility->category?$offer->facility->category->name:''):'' }}</td>
            <td class="">{{$offer->facility?$offer->facility->telephone:''}}</td>
            <td class="">{{$offer->visit_id}}</td>
            <td class="">{{$offer->items_count}}</td>
            <td class="">{{$offer->type?$offer->type->name:''}}</td>
            <td class="">{{$offer->wheels?'Yes':'No'}}</td>
            <td class="">{{$offer->duration}}</td>
            <td class="">{{$offer->discount}}</td>
            <td class="">{{$offer->total_cost}}</td>
            <td class="">{{$offer->status?$offer->status->name:''}}</td>

        </tr>
    @endforeach
    </tbody>
</table>

