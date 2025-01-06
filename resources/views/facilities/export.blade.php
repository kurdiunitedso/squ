<table>

    <tr>

        <td class="min-w-25px bold all">{{__('SN')}}</td>
        <td class="min-w-100px bold all">{{__('Facility ID')}}</td>

        <td class="min-w-100px bold all">{{__('Name')}}</td>
        <td class="min-w-100px bold all">{{__('Category')}}</td>
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
        <td class="min-w-100px bold all">{{__('Paid to Facility')}}</td>
        <td class="min-w-100px bold all">{{__('Net For Payemnt')}}</td>


    </tr>

    <tbody>
    @foreach ($facilities as $facility)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td class="min-w-100px bold all">{{$facility->id}}</td>

            <td class="min-w-100px bold all">{{$facility->name}}</td>
            <td class="min-w-100px bold all">{{isset($facility->category)?$facility->category->name:''}}</td>
            <td class="min-w-100px bold all">{{isset($facility->types)?$facility->types->name:''}}</td>
            <td class="min-w-100px bold all">{{$facility->telephone}}</td>
            <td class="min-w-100px bold all">{{isset($facility->cities)?$facility->cities->name:''}}</td>
            <td class="min-w-100px bold all">{{$facility->join_date}}</td>
            <td class="min-w-100px bold all">{{$facility->has_wheels_now}}</td>
            <td class="min-w-100px bold all">{{$facility->has_wheels_bot}}</td>
            <td class="min-w-100px bold all">{{$facility->has_wheels_b2b}}</td>
            <td class="min-w-100px bold all">{{$facility->has_pos}}</td>
            <td class="min-w-100px bold all">{{$facility->has_marketing}}</td>

            <td class="min-w-100px bold all">{{$facility->visits_count}}</td>
            <td class="min-w-100px bold all">{{$facility->tickets_count}}</td>

            <td class="min-w-100px bold all">{{$facility->employees_count}}</td>

            <td class="min-w-100px bold all">{{$facility->branches_count}}</td>
            <td class="min-w-100px bold all">{{$facility->attachments_count}}</td>
            <td class="min-w-100px bold all">{{$facility->printer_type}}</td>

            {{--   <td class="min-w-100px bold all">{{__('Bank')}}</td>
               <td class="min-w-100px bold all">{{__('Bank Branch')}}</td>
               <td class="min-w-100px bold all">{{__('IBAN')}}</td>
               <td class="min-w-100px bold all">{{__('Beneficiary')}}</td>--}}

            <td class="min-w-100px bold all">{{$facility->printer_sn}}</td>
            <td class="min-w-100px bold all">{{$facility->has_box}}</td>

            <td class="min-w-100px bold all">{{$facility->box_no}}</td>
            <td class="min-w-100px bold all">{{$facility->commission_cash}}</td>


            <td class="min-w-100px bold all">{{$facility->commission_visa}}</td>
            <td class="min-w-100px bold all">{{$facility->total_sales_cash}}</td>
            <td class="min-w-100px bold all">{{$facility->total_sales_visa}}</td>
            <td class="min-w-100px bold all">{{$facility->paid}}</td>
            <td class="min-w-100px bold all">{{$facility->net_paid}}</td>

        </tr>
    @endforeach
    </tbody>
</table>
