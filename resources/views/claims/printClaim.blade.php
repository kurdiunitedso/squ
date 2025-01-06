@php
    $qty=0;
    $cost=0;
    $types='';
                    foreach (explode(',',$claim->types) as $k=>$v)
                        $types.=(\App\Models\Constant::find($v)?\App\Models\Constant::find($v)->name:'').",";

                    $types= rtrim($types,',');
                         $processing = \App\Models\Constant::where('module', \App\Enums\Modules::CLAIM)->Where('field', \App\Enums\DropDownFields::status)->where('name', 'processing')->get()->first();
        $processing = isset($processing) ? $processing->id : 0;

@endphp

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
                <p style="">{{$claim->client->representative_name}}</p>
                <p style="">{{$claim->client->registration_name}} </p>
                <p>{{$claim->client->telephone}}</p>
                <br>
            </div>
        </td>
        <td style="text-align: right; direction: rtl; width: 60%">
            <h4 style="color:#a96f47">CLAIM #:<span style="color: black; font-weight: normal">{{$claim->id}}</span>
            </h4>
            <h4 style="color:#a96f47">DATE:<span
                    style="color: black; font-weight: normal">{{\Carbon\Carbon::parse($claim->claim_date)->format('d/m/Y')}}</span>
            </h4>

            <h4 style="color:#a96f47">FOR <span style="color: black; font-weight: normal">{{$types}}</span></h4>

        </td>
    </tr>
</table>


<h4 class="strong">Details</h4>
<table style="width: 100%;">
    <tr style=" border-bottom: 2px solid skyblue; border-top: 1px solid skyblue;">
        <td style="; border-bottom: 2px solid skyblue; border-top: 1px solid skyblue "><strong style=";color:#a96f47">Description<br></strong>
        </td>
        <td style="padding: 40px;border-bottom: 2px solid skyblue; border-top: 1px solid skyblue "><strong
                style=";color:#a96f47">Month</strong></td>
        <td style="padding: 40px;border-bottom: 2px solid skyblue; border-top: 1px solid skyblue "><strong
                style=";color:#a96f47">Qty</strong></td>
        <td style="padding: 40px;border-bottom: 2px solid skyblue; border-top: 1px solid skyblue "><strong
                style=";color:#a96f47">Cost
                ({{\App\Models\Constant::find($claim->currency)?\App\Models\Constant::find($claim->currency)->name:''}}
                )</strong></td>

    </tr>
    @foreach($claim->items as $i)
        <tr style="border-bottom: 1px solid skyblue ">
            <td style="border-bottom: 1px solid skyblue  ">{{$i->description}}</td>
            <td style="border-bottom: 1px solid skyblue  ">{{\App\Models\Constant::find($i->month)?\App\Models\Constant::find($i->month)->name:''}}
                @ {{$i->year}}</td>
            <td style=" border-bottom: 1px solid skyblue ">{{$i->qty}}</td>
            <td style=" border-bottom: 1px solid skyblue ">{{number_format(($i->cost*$i->qty)-$i->discount,1)}}</td>

        </tr>
        @php
            $qty+=$i->qty;
            $cost+=($i->cost*$i->qty)-$i->discount;
        @endphp

    @endforeach
    <tr style="border-bottom: 1px solid skyblue ">
        <td style="border-bottom: 1px solid skyblue  ">

            <strong>Total</strong>

        </td>
        <td style="border-bottom: 1px solid skyblue  "></td>
        <td style=" border-bottom: 1px solid skyblue "><h4><strong>{{$qty}}</strong></h4></td>
        <td style=" border-bottom: 1px solid skyblue "><h4>
                <strong>{{number_format($cost,1)}}  </strong>{{\App\Models\Constant::find($claim->currency)?\App\Models\Constant::find($claim->currency)->name:''}}
            </h4>


        </td>
    </tr>

</table>
<div style="font-size: smaller; line-height: 8.5px;">
    <h4 style="text-align: left">
        Discount:{{$claim->discount?number_format($claim->discount,1):0}} {{\App\Models\Constant::find($claim->currency)?\App\Models\Constant::find($claim->currency)->name:''}}</h4>
    <h4 style="text-align: left">Total
        Cost: {{number_format($claim->cost,1)}} {{\App\Models\Constant::find($claim->currency)?\App\Models\Constant::find($claim->currency)->name:''}}</h4>

    @foreach(\App\Models\Constant::where('module', \App\Enums\Modules::CLAIM)->where('field', \App\Enums\DropDownFields::currency)->get() as $c)
        <h4 style="text-align: left; font-weight:bolder; color: red">Outstanding Balance {{$c->name}} :<span
                style="color: red; text-decoration: underline">  {{number_format(\App\Models\Claim::where('client_id',$claim->client_id)->where('status_id',$processing)->where('currency',$c->id)->where('claim_date','<=',\Carbon\Carbon::parse($claim->claim_date)->format('Y-m-d'))->sum('cost'),1)}}
                  </span></h4>
    @endforeach

    @if($claim->vat!=1)
        <p style="text-align: left">*Price including VAT</p>
    @else
        <p style="text-align: left">Price not including VAT</p>
    @endif
    <p>**{{$claim->notes}}</p>

</div>
<br>


<hr>
<div style="font-size: small; line-height: 7px;">
    <h4 style="text-align: left;font-size: small">Payment Terms and Options</h4>
    <h4 style="text-align: left;font-size: small">Cash:</h4>
    <p>If the Payment is to be made in Cash, please contact our representative below
    <p>Mr. Yousef - 0594815155</p>

    <hr>

    <h4 style="text-align: left;font-size: small">Cheque:</h4>
    <p>If the Payment is to be made in Cheque, please contact our representative below</p>
    <p>Mr. Yousef -0594815155 </p>


    <h4 style="text-align: left;font-size: small">Please make all checks payable to Trillionz Marketing Agency شركة
        تريليونز للدعاية و
        الاعلان</h4>

    <hr>

    <h4 style="text-align: left;font-size: small">Bank Transfer:</h4>
    <p>Bank of Palestine</p>
    <p>Beneficiary Name: Trillionz Marketing Agency</p>
    <p>V.A.T NO.: 562592618</p>
    <p>Bank Name: Bank Of Palestine.</p>
    <p>Branch Name: Masyoun branch.</p>
    <p>Bank NO.: 89</p>
    <p>Branche NO.: 471</p>
    <p>Bank Account NO.: 611739.</p>
    <p>SWIFT NO.: PALSPS22.</p>
    <p>IBAN ($): PS10PALS047106117390013000000</p>
    <p>IBAN (NIS): PS92PALS047106117390993000000</p>

</div>





