

<table>
    <thead>
    <tr>
        <th class="min-w-25px all"><input type="checkbox" id="select-all"></th>
        <th class="min-w-100px bold all">{{__('SN')}}</th>
        <th class="min-w-100px bold all">{{__('Assign City')}}</th>
        <th class="min-w-200px bold all">{{__('Name')}}</th>
        <th class="min-w-200px bold all">{{__('Full Name')}}</th>
        <th class="min-w-100px bold all">{{__('ID')}}</th>
        <th class="min-w-100px bold all">{{__('Birth Date')}}</th>
        <th class="min-w-100px bold all">{{__('Mobile')}}</th>
        <th class="min-w-100px bold all">{{__('Active')}}</th>
        <th class="min-w-100px bold all">{{__('Vehicle Type')}}</th>
        <th class="min-w-100px bold all">{{__('Vehicle Model')}}</th>
        <th class="min-w-100px bold all">{{__('Vehicle year')}}</th>
        <th class="min-w-100px bold all">{{__('Has Insurance')}}</th>
        <th class="min-w-100px bold all">{{__('Insurance Company')}}</th>
        <th class="min-w-100px bold all">{{__('Policy End Date')}}</th>
        <th class="min-w-100px bold all">{{__('Bank')}}</th>
        <th class="min-w-100px bold all">{{__('IBAN')}}</th>
        <th class="min-w-100px bold all">{{__('Payment Type')}}</th>
        <th class="min-w-100px bold all">{{__('Payment Due')}}</th>

        <th class="min-w-100px bold all">{{__('Commission')}}</th>
        <th class="min-w-100px bold all">{{__('Box No')}}</th>
        <th class="min-w-100px bold all">{{__('Join Date')}}</th>
        <th class="min-w-100px bold all">{{__('Shift')}}</th>
        <th class="min-w-100px bold all">{{__('Total Orders')}}</th>
        <th class="min-w-100px bold all">{{__('Amount of Total Orders')}}</th>
        <th class="min-w-100px bold all">{{__('Last Order Date')}}</th>
        <th class="min-w-100px bold all">{{__('Last Ticket Date')}}</th>
        <th class="min-w-100px bold all">{{__('Last Visit Date')}}</th>
        <th class="min-w-100px bold all">{{__('Last Visit Request Date')}}</th>

        <th class="min-w-100px bold all">{{__('Attachments')}}</th>

        <th class="min-w-100px bold all">{{__('Total Visits')}}</th>

        <th class="min-w-100px bold all">{{__('Total Tickets')}}</th>


    </tr>
    </thead>
    <tbody>
    @foreach ($captins as $captin)
        <tr>
            <td>{{ ++$loop->index }}</td>

            <td class="min-w-100px bold all">{{$captin->city?$captin->city->name:''}}</td>
            <td class="min-w-200px bold all">{{$captin->name}}</td>
            <td class="min-w-200px bold all">{{$captin->full_name}}</td>
            <td class="min-w-100px bold all">{{$captin->captin_id}}</td>
            <td class="min-w-100px bold all">{{$captin->dob}}</td>
            <td class="min-w-100px bold all">{{$captin->mobile1}}</td>
            <td class="min-w-100px bold all">{{$captin->active}}</td>
            <td class="min-w-100px bold all">{{$captin->vehicle?$captin->vehicle->name:''}}</td>
            <td class="min-w-100px bold all">{{$captin->vehicle_model}}</td>
            <td class="min-w-100px bold all">{{$captin->vehicle_year}}</td>
            <td class="min-w-100px bold all">{{$captin->has_insurance}}</td>
            <td class="min-w-100px bold all">{{$captin->insuranceCompany?$captin->insuranceCompany->name:''}}</td>
            <td class="min-w-100px bold all">{{$captin->policy_expire}}</td>
            <td class="min-w-100px bold all">{{$captin->bankName?$captin->bankName->name:''}}</td>
            <td class="min-w-100px bold all">{{$captin->iban}}</td>
            <td class="min-w-100px bold all">{{$captin->payment_types?$captin->payment_types->name:''}}</td>
            <td class="min-w-100px bold all">{{$captin->total_commission}}</td>

            <td class="min-w-100px bold all">{{$captin->box_no}}</td>
            <td class="min-w-100px bold all">{{$captin->join_date}}</td>
            <td class="min-w-100px bold all">{{$captin->shifts?$captin->shifts->name:''}}</td>
            <td class="min-w-100px bold all">{{$captin->total_orders}}</td>
            <td class="min-w-100px bold all">{{$captin->total_orders_cost}}</td>
            <td class="min-w-100px bold all">{{$captin->last_order_date}}</td>
            <td class="min-w-100px bold all">{{$captin->last_ticket_date}}</td>
            <td class="min-w-100px bold all">{{$captin->last_ticket_date}}</td>
            <td class="min-w-100px bold all">{{$captin->last_visit_date}}</td>
            <td class="min-w-100px bold all">{{$captin->last_visit_request_date}}</td>

            <td class="min-w-100px bold all">{{$captin->attachments_count}}</td>

            <td class="min-w-100px bold all">{{$captin->visits_count}}</td>

            <td class="min-w-100px bold all">{{$captin->tickets_count}}</td>


        </tr>
    @endforeach
    </tbody>
</table>

