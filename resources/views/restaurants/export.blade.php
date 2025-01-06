<table>

    <tr>

        <td class="min-w-25px bold all">{{__('SN')}}</td>
        <td class="min-w-100px bold all">{{__('Restaurant ID')}}</td>

        <td class="min-w-100px bold all">{{__('Name')}}</td>

        <td class="min-w-100px bold all">{{__('Type')}}</td>
        <td class="min-w-100px bold all">{{__('Telephone')}}</td>
        <td class="min-w-100px bold all">{{__('City')}}</td>
        <td class="min-w-100px bold all">{{__('Join Date')}}</td>
        <td class="min-w-100px bold all">{{__('Has Now')}}</td>
        <td class="min-w-100px bold all">{{__('Has Bot')}}</td>
        <td class="min-w-100px bold all">{{__('Has B2B')}}</td>
        <td class="min-w-100px bold all">{{__('Has POS')}}</td>
        <td class="min-w-100px bold all">{{__('Has Marketing')}}</td>

        <td class="min-w-100px bold all">{{__('Visits')}}</td>
        <td class="min-w-100px bold all">{{__('Tickets')}}</td>

        <td class="min-w-100px bold all">{{__('Employees')}}</td>
        <td class="min-w-100px bold all">{{__('Branches')}}</td>
        <td class="min-w-100px bold all">{{__('Attachments')}}</td>

        {{--   <td class="min-w-100px bold all">{{__('Bank')}}</td>
           <td class="min-w-100px bold all">{{__('Bank Branch')}}</td>
           <td class="min-w-100px bold all">{{__('IBAN')}}</td>
           <td class="min-w-100px bold all">{{__('Beneficiary')}}</td>--}}

        <td class="min-w-100px bold all">{{__('Printer Type')}}</td>
        <td class="min-w-100px bold all">{{__('Printer SN')}}</td>
        <td class="min-w-100px bold all">{{__('Has Box')}}</td>
        <td class="min-w-100px bold all">{{__('Box No')}}</td>


        <td class="min-w-100px bold all">{{__('Commission Cash %')}}</td>
        <td class="min-w-100px bold all">{{__('Commission Visa $')}}</td>
        <td class="min-w-100px bold all">{{__('Sales Visa $')}}</td>
        <td class="min-w-100px bold all">{{__('Sales Commission $')}}</td>
        <td class="min-w-100px bold all">{{__('Paid to Restaurant')}}</td>
        <td class="min-w-100px bold all">{{__('Net For Payemnt')}}</td>


    </tr>

    <tbody>
    @foreach ($restaurants as $restaurant)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td class="min-w-100px bold all">{{$restaurant->id}}</td>

            <td class="min-w-100px bold all">{{$restaurant->name}}</td>

            <td class="min-w-100px bold all">{{isset($restaurant->types)?$restaurant->types->name:''}}</td>
            <td class="min-w-100px bold all">{{$restaurant->telephone}}</td>
            <td class="min-w-100px bold all">{{isset($restaurant->cities)?$restaurant->cities->name:''}}</td>
            <td class="min-w-100px bold all">{{$restaurant->join_date}}</td>
            <td class="min-w-100px bold all">{{$restaurant->has_wheels_now}}</td>
            <td class="min-w-100px bold all">{{$restaurant->has_wheels_bot}}</td>
            <td class="min-w-100px bold all">{{$restaurant->has_wheels_b2b}}</td>
            <td class="min-w-100px bold all">{{$restaurant->has_pos}}</td>
            <td class="min-w-100px bold all">{{$restaurant->has_marketing}}</td>

            <td class="min-w-100px bold all">{{$restaurant->visits_count}}</td>
            <td class="min-w-100px bold all">{{$restaurant->tickets_count}}</td>

            <td class="min-w-100px bold all">{{$restaurant->employees_count}}</td>

            <td class="min-w-100px bold all">{{$restaurant->branches_count}}</td>
            <td class="min-w-100px bold all">{{$restaurant->attachments_count}}</td>
            <td class="min-w-100px bold all">{{$restaurant->printer_type}}</td>

            {{--   <td class="min-w-100px bold all">{{__('Bank')}}</td>
               <td class="min-w-100px bold all">{{__('Bank Branch')}}</td>
               <td class="min-w-100px bold all">{{__('IBAN')}}</td>
               <td class="min-w-100px bold all">{{__('Beneficiary')}}</td>--}}

            <td class="min-w-100px bold all">{{$restaurant->printer_sn}}</td>
            <td class="min-w-100px bold all">{{$restaurant->has_box}}</td>

            <td class="min-w-100px bold all">{{$restaurant->box_no}}</td>
            <td class="min-w-100px bold all">{{$restaurant->commission_cash}}</td>


            <td class="min-w-100px bold all">{{$restaurant->commission_visa}}</td>
            <td class="min-w-100px bold all">{{$restaurant->total_sales_cash}}</td>
            <td class="min-w-100px bold all">{{$restaurant->total_sales_visa}}</td>
            <td class="min-w-100px bold all">{{$restaurant->paid}}</td>
            <td class="min-w-100px bold all">{{$restaurant->net_paid}}</td>

        </tr>
    @endforeach
    </tbody>
</table>
