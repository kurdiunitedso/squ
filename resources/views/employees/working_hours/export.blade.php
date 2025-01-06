<table>
    <thead>
    <tr>
        <td class="">ID</td>
        <td class="">Date</td>
        <td class="">From</td>
        <td class="">To</td>
        <td class="">Qty</td>
        <td class="">Qty2</td>
        <td class="">Notes</td>
        <td class="">Status</td>
    </tr>
    </thead>
    <tbody>
    @php
    $total=0;
    @endphp
    @foreach ($whours as $whour)

        <tr>
            <td>{{ ++$loop->index }}</td>
            <td class="">{{$whour->work_date}}</td>
            <td class="">{{$whour->from_time}}</td>
            <td class="">{{$whour->to_time}}</td>
            <td class="">{{date_diff(date_create($whour->to_time != "00:00:00" ? $whour->to_time : date('Y-m-d H:i:s')), date_create(($whour->from_time)))->format('%H:%I') }}</td>
            <td class="">{{number_format(abs((strtotime($whour->to_time != "00:00:00" ? $whour->to_time : date('Y-m-d H:i:s')) - strtotime(($whour->from_time))) / (60 * 60)), 1)}}</td>
            <td class="">{{$whour->notes}}</td>
            <td class="">{{$whour->statuss?$whour->statuss->name:''}}</td>


        </tr>
        @php
            $total+=number_format(abs((strtotime($whour->to_time != "00:00:00" ? $whour->to_time : date('Y-m-d H:i:s')) - strtotime(($whour->from_time))) / (60 * 60)), 1);
        @endphp
    @endforeach
    <tr>
        <td>Total Hrs</td>
        <td colspan="7">{{$total}}</td>


    </tr>
    </tbody>
</table>

