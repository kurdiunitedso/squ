<table>
    <tr>
        <td>{{__('SN')}}</td>
        <td>{{__('Captin')}}</td>
        <td>{{__('Assign City')}}</td>
        <td>{{__('ID')}}</td>
        <td>{{__('Mobile')}}</td>
        <td>{{__('Policy Type')}}</td>
        <td>{{__('Insurance Company')}}</td>
        <td>{{__('Cost')}}</td>
        <td>{{__('Policy ID')}}</td>

        <td>{{__('Attachments')}}</td>
        <td>{{__('Create Date')}}</td>
        <td>{{__('Source')}}</td>
        <td>{{__('Status')}}</td>



    </tr>


    @foreach ($policyOffers as $policyOffer)
        <tr>
            <td>{{ ++$loop->index }}</td>

            <td>{{isset($policyOffer->captin)?$policyOffer->captin->name:''}}</td>
            <td>{{isset($policyOffer->captin->city)?$policyOffer->captin->city->name:''}}</td>
            <td>{{isset($policyOffer->captin)?$policyOffer->captin->captin_id:''}}</td>
            <td>{{isset($policyOffer->captin)?$policyOffer->captin->mobile1:''}}</td>

            <td>{{isset($policyOffer->policy_offer_types)?$policyOffer->policy_offer_types->name:''}}</td>
            <td>{{isset($policyOffer->insurance_company)?$policyOffer->insurance_company->name:''}}</td>
            <td>{{$policyOffer->offer_approved_cost}}</td>
            <td>{{$policyOffer->attachments_count}}</td>
            <td>{{$policyOffer->created_at}}</td>
            <td>{{$policyOffer->source}}</td>
            <td>{{isset($policyOffer->status)?$policyOffer->status->name:''}}</td>

        </tr>
    @endforeach

</table>

