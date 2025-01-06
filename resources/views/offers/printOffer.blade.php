<table style="width: 100%;">
    <thead></thead>
    <tr>
        <td style="text-align: left; width: 40%">
            <div style="font-size: small; line-height: 9px;">
                <p style="">Ramalla, AlMasyoun</p>
                <p style="">Shaltaf Building, 3<small>rd</small> Floor</p>
                <p style="">Phone +972(0)593777700</p>
                <p style="">info@trillionz.ps | Trillionz.ps</p>
                <p style="text-align: left;font-weight: bolder">TO:</p>
                <p style="">{{ $offer->facility->representative_name }}</p>
                <p style="">{{ $offer->facility->registration_name }} </p>
                <p>{{ $offer->facility->telephone }}</p>
                <br>
            </div>
        </td>
        <td style="text-align: right; direction: rtl; width: 60%">
            <h4 style="color:#a96f47">OFFER #:<span style="color: black; font-weight: normal">{{ $offer->id }}</span>
            </h4>
            <h4 style="color:#a96f47">DATE:<span
                    style="color: black; font-weight: normal">{{ \Carbon\Carbon::parse($offer->offer_date)->format('d/m/Y') }}</span>
            </h4>

            <h4 style="color:#a96f47">FOR: <span style="color: black; font-weight: normal"> Marketing Price Offer</span>
            </h4>

        </td>
    </tr>
</table>

<table style="width: 100%;">
    <tr style=" border: 1px solid black; line-height: 1.8;">
        <td>
            <strong>{{ $offer->notes }}.</strong>
        </td>

    </tr>
</table>

<br>
<h4 class="strong">Details</h4>

<table style="width: 100%;">
    <tr style=" border: 1px solid black">
        <td style=" border: 1px solid black "><strong>Deliverables:</strong></td>

        <td style=" border: 1px solid black"><strong>Notes:</strong></td>

        <td style="  border: 1px solid black"><strong>Qty:</strong></td>
        <td style="  border: 1px solid black"><strong>Price:</strong></td>

    </tr>
    @foreach ($offer->items as $i)
        <tr style=" border: 1px solid black">
            <td style=" border: 1px solid black ">{{ $i->description }}</td>

            <td style=" border: 1px solid black">{{ $i->notes }}</td>

            <td style="  border: 1px solid black">{{ $i->qty }}</td>
            <td style="  border: 1px solid black">{{ $i->cost }}</td>

        </tr>
    @endforeach


</table>
<br>
<br>
<br>
<h4 style="text-align: center">
    Total <span style="color: red">{{ number_format($offer->total_cost) }} USD</span>
    {{ $offer->vat == 1 ? 'Including' : 'Excluding' }} VAT per Month</h4>
{{-- <p style="text-align: center; font-size: 12px">
    *Sponsored ads are NOT included.</p> --}}
