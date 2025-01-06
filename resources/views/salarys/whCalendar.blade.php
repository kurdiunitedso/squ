@php
    $begin = new DateTime($from);
    $end = new DateTime($to);

    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end->add($interval));
    $total_hours=0;
    $total_sch=0;
    $out=0;
    $i=1;

@endphp

<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_salary_header">
        <!--begin::Modal preparation_time-->
        <h2 class="fw-bold">{{ __('Salary') }}</h2>
        <!--end::Modal preparation_time-->
        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                      <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="currentColor"/>
                  </svg>
              </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Close-->
    </div>
    <!--end::Modal header-->
    <!--begin::Modal body-->
    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <!--begin::Form-->

        <table style="width: 100%" id="">
            <thead></thead>
            <tr>
                <td style="padding: 10px ">
                    <table style="width: 100%;  text-align: center">
                        <tr>
                            <td style="text-align: center"><h3><strong> <span
                                            class="titletext">Time Attendance Report</span></strong>
                                </h3>
                            </td>
                        </tr>

                    </table>
                    <br>
                    <br>
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <strong>
                                    Employee: {{$employee->name}}
                                    <br>
                                    Date From:{{$from}} to: {{$to}}
                                </strong>

                            </td>
                        </tr>


                    </table>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover  order-column"
                           style="width: 100%;   border: 1px solid black;">

                        <tr style="width: 100%;   border: 1px solid black;">
                            <td style="border: 1px solid black">SN</td>
                            <td style="border: 1px solid black"><strong> Day</strong></td>
                            <td style="border: 1px solid black"><strong> Date</strong></td>
                            <td style="border: 1px solid black"><strong>From</strong></td>
                            <td style="border: 1px solid black"><strong>To</strong></td>
                            <td style="border: 1px solid black"><strong>Source</strong></td>
                            <td style="border: 1px solid black"><strong>Closed By</strong></td>
                            <td style="border: 1px solid black"><strong>Schedule </strong></td>
                            <td style="border: 1px solid black"><strong>Working Hours</strong></td>
                            <td style="border: 1px solid black"><strong>Schedule Hours</strong></td>
                            <td style="border: 1px solid black"><strong>Notes</strong></td>
                            <td style="border: 1px solid black"><strong>Type</strong></td>
                            <td style="border: 1px solid black"><strong>Status</strong></td>


                        </tr>
                        @foreach ($period as $dt)
                            @php
                                $hour=0;

                            $wh=\App\Models\EmployeeWhour::getWhourByEmployee($employee->id,$dt->format('Y-m-d'),date('Y-m-d',strtotime($dt->format('Y-m-d'))+60*24*60));

                            @endphp
                            @if($wh->count()==0)
                                <tr style="width: 100%;   border: 1px solid black;">
                                    <td style="border: 1px solid black">{{$i++}}</td>
                                    <td style="border: 1px solid black">{{$dt->format('l')}}</td>
                                    <td style="border: 1px solid black">{{$dt->format('d/m/Y')}}</td>
                                    <td style="border: 1px solid black">-</td>
                                    <td style="border: 1px solid black">-</td>
                                    <td style="border: 1px solid black">-</td>
                                    <td style="border: 1px solid black">-</td>
                                    @php
                                        $type='OFF';
                                        $sch=\App\Models\EmployeeSwhour::class::getWhourByEmployeeFromSchedule($dt->format('l'),0,0,$employee->id,0,0,$dt->format('Y-m-d'));
                                    @endphp

                                    <td style="border: 1px solid black">
                                        @php

                                            $schhourd=0;
                                            $v=\App\Models\Holiday::isVaction($dt->format('Y-m-d'),$employee->id);
                                            if($v)
                                            echo ("-");
                                            else{
                                                if($sch->count()>0)
                                                foreach ($sch->get() as $s)
                                                {

                                                echo(date('H:i',strtotime($s->time_from))."-".date('H:i',strtotime($s->time_to)).'<br>');
                                                   $schhourd+=(strtotime($s->time_to)-strtotime($s->time_from))/(60*60);


                                                }
                                        }

                                        @endphp
                                    </td>
                                    <td style="border: 1px solid black">0</td>
                                    <td style="border: 1px solid black">
                                        {{$schhourd}}
                                        {{--@php
                                            $v=\App\Models\Holiday::isVaction($dt->format('Y-m-d'),$employee->id);
                                              if($v)
                                              {
                                              $h=0;
                                              $m=0;
                                              }
                                              else{
                                                $h=floor($schhourd);
                                                $m=number_format(fmod(($schhourd*60),60));
                                          }
                                        @endphp
                                        {{$h}}:{{$m}}--}}

                                    </td>
                                    <td style="border: 1px solid black">-</td>
                                    <td style="border: 1px solid black">
                                        @if($v)
                                            @php $type=$v @endphp
                                        @elseif($sch->count()>0)
                                            @php $type='Absent'@endphp
                                        @elseif($sch->count()==0)
                                            @php $type='OFF'@endphp

                                        @endif
                                        {{$type}}

                                    </td>
                                    <td style="border: 1px solid black">-</td>

                                </tr>
                            @endif
                            @foreach($wh->get() as $d)
                                @php
                                    $hour=number_format((((strtotime($d->to_time != "00:00:00" ? $d->to_time : $d->from_time)) - strtotime($d->from_time)) / (60 * 60)),2);
                                    $total_hours+=$hour;
        $hour2=date_diff( date_create($d->to_time), date_create($d->from_time))->format('%H:%I');
                                @endphp
                                <tr style="width: 100%;   border: 1px solid black;">
                                    <td style="border: 1px solid black">{{$i++}}</td>
                                    <td style="border: 1px solid black">{{$dt->format('l')}}</td>
                                    <td style="border: 1px solid black">{{$dt->format('d/m/Y')}}</td>
                                    <td style="border: 1px solid black"
                                    >{{date('H:i',strtotime($d->from_time))}}</td>
                                    <td style="border: 1px solid black">{{date('H:i',strtotime($d->to_time))}}</td>
                                    @php
                                        if($d->last_ip!="176.65.31.30")
                                        $out++;
                                    @endphp
                                    <td style="border: 1px solid black">{{$d->last_ip=="176.65.31.30"?"Company":"Out Company"}}</td>
                                    <td style="border: 1px solid black">{{ \App\Models\User::getUserFullName($d->update_id)}}</td>
                                    @php

                                        $tt="";
                                         $type='Out Schedule';
                                            if(date('H:i',strtotime($d->to_time)=="00:00"))
                                               $type='Auto Check Out';
                                       $sch=\App\Models\EmployeeSwhour::getWhourByEmployeeFromSchedule($dt->format('l'),0,0,$employee->id,date('H:i',strtotime($d->from_time)),date('H:i',strtotime($d->to_time)),$dt->format('Y-m-d'));



                                    @endphp
                                    <td style="border: 1px solid black">
                                        @php
                                            $v=\App\Models\Holiday::isVaction($dt->format('Y-m-d'),$employee->id);
                                              if($v)
                                               {$type=$v;
                                                  $schhourd;
                                                  echo(0);}

                           else{
                                               if($sch->count()>0)
                                               $j=0;
                                               $schhourd=0;

                                               foreach ($sch->get() as $s)
                                               {
                                               $j++;
                                               if(strtotime($s->time_to)+60*60>=strtotime($d->to_time) &&  strtotime($s->time_from)-60*60<=strtotime($d->from_time))
                                               {
                                               $type='Schedule';
                                               }
                                               $schhourd+=(strtotime($s->time_to)-strtotime($s->time_from))/(60*60);


                                               echo(date('H:i',strtotime($s->time_from))."-".date('H:i',strtotime($s->time_to)).'<br>');
                                               }
                                          }


                                        @endphp
                                    </td>
                                    <td style="border: 1px solid black">{{$hour}}</td>
                                    <td style="border: 1px solid black">
                                        {{$schhourd}}
                                        {{--   @php
                                               $h=floor($schhourd);
                                               $m=number_format(fmod(($schhourd*60),60));
                                           @endphp
                                           {{$h}}:{{$m}}--}}

                                    </td>
                                    <td style="border: 1px solid black">{{$d->notes}}</td>
                                    <td style="border: 1px solid black">

                                        {{$type}}

                                    </td>
                                    <td style="border: 1px solid black">

                                        {{$d->status}}

                                    </td>

                                </tr>
                            @endforeach
                        @endforeach
                        @php
                            foreach ($period as $dt)
                  {
                    $v=\App\Models\Holiday::isVaction($dt->format('Y-m-d'),$employee->id);
                    if($v)
                    continue;
                      $schhourd=0;
                      $sch=\App\Models\EmployeeSwhour::getWhourByEmployeeFromSchedule($dt->format('l'),0,0,$employee->id,0,0,$dt->format('Y-m-d'));
                      foreach ($sch->get() as $s)
                      {
                          $schhourd+=(strtotime($s->time_to)-strtotime($s->time_from))/(60*60);


                      }
                        $total_sch+=$schhourd;


                  }
                       $total_hours = \App\Models\EmployeeWhour::getWhourByEmployee($employee->id, $from, $end->format('Y-m-d'), 0,93)
                        ->sum(DB::raw('TIME_TO_SEC( TIMEDIFF(to_time,from_time))')) / (60 * 60);
                        @endphp

                        <tr style="width: 100%;   border: 1px solid black;">
                            <td colspan="8" style="border: 1px solid black"><h4>Total</h4></td>

                            <td colspan="1" style="border: 1px solid black"><h4>{{number_format($total_hours,1)}}</h4>
                            </td>
                            <td colspan="1" style="border: 1px solid black"><h4>{{number_format($total_sch,1)}}</h4>
                            </td>
                            <td colspan="3" style="border: 1px solid black"></td>
                        </tr>

                    </table>
                    <table class="table table-striped table-bordered table-hover  order-column"
                           style="width: 100%;   border: 1px solid black;">
                        <tr>
                            <td>
                                <strong style="color: red">
                                    Missing
                                    Hours: {{$total_sch>=$total_hours?number_format($total_sch-$total_hours,1):0}}
                                    <br>
                                    Extra Hours:{{$total_hours>=$total_sch?number_format($total_hours-$total_sch,1):0}}
                                    <br>
                                    Available Annual Leaves Balance:{{$employee->balance}}
                                    <br>
                                    <br>
                                    Annual Leaves Balance:{{$employee->leaves}}
                                    <br>
                                    Sick Leaves Balance:{{$employee->sick}}
                                    <br>
                                    Out Company:{{$out}}
                                </strong>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>

