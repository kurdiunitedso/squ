
@php
$count=0;
@endphp


    @foreach($senders as $s)
        @php

            $e=$e=\App\Models\WhatsappHistoryModel::getWhataaAppList($inputsearch?$inputsearch:[], 0, 0, 0, $s->chatId, $token,0,0)->orderby('time', 'desc')->get()->first();
        @endphp
        @if($e)
            @php

                $countChat=\App\Models\WhatsappHistoryModel::getWhataaAppList([], 1, 0, 0, $s->chatId,$token,0,2)->count();

                    $time=date('Y-m-d H:i',$s->time);
                  $pp=0;
                    $mobile = strtok($e->chatId, '@');
                    $cc=$countChat?' <span class=" countwamessages badge badge-sm badge-success">('.$countChat.')</span>':'';
                      if($e->fromMe)
                    $pp=\App\Models\PatientModel::getPatientByMobile($mobile);
                   $patient=$e->fromMe?($pp?\App\Models\PatientModel::getPatientFullName($pp->id):$mobile):$e->senderName;
                    $patientCC=$patient.$cc;
                     if ($e->type != 'chat' && $e->type != 'interactive'  && $e->type != 'chat')
                         {
                                                       $body = '<a href="' . $e->body . '" target="_blank"> click here ' . $e->caption . '</a>';
                                                   } else {
                                                       $body =  $e->body ;
                                                   }

            @endphp
            <a href="/getWhatsAppMessage?mobile={{$mobile}}&patient={{$patient}}&sender={{$sender}}"
               sender="{{$sender}}" title="Whatapp {{$patient}} {{$mobile}}:"
               class="chatWhat"
            >
                <div class="navi-link rounded border-bottom mb-15">

                    <div class="navi-text">
                        <div class="text-dark-75  font-weight-bold font-size-h6">{!!  $patientCC!!}
                            <i class="symbol-badge bg-success"></i></div>
                        <span class="text-muted font-size-sm"> - {{$time}}</span>
                        <div class="mt-2 rounded p-5 bg-light  text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                            {!! $body !!}
                        </div>
                    </div>
                </div>
            </a>
        @endif
    @endforeach



