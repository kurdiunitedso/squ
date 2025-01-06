

    @for($i=(count($messages)-1);$i>=0;$i-- )
        @php
            $m=$messages[$i];
            $time=date('Y-m-d H:i',$m->time);
            if ($m->type != 'chat' && $m->type != 'interactive'  && $m->type != 'chat') {
                                                   $body = '<a href="' . $m->body . '" target="_blank"> click here ' . $m->caption . '</a>';
                                               } else {
                                                   $body =  $m->body ;
                                               }
        @endphp
        @if($m->fromMe==0)
            <div class="d-flex flex-column mb-5 align-items-start">
                <div class="d-flex align-items-center">

                    <div>
                        <a href="#"
                           class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">{{$patient}}</a>
                        <span class="text-muted font-size-sm">{{$time}}</span>
                    </div>
                </div>
                <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                    {!! $body !!}
                </div>
            </div>
        @endif
        @if($m->fromMe==1)
            <div class="d-flex flex-column mb-5 align-items-end">
                <div class="d-flex align-items-center">
                    <div>
                        <span class="text-muted font-size-sm">{{$time}}</span>
                        <a href="#"
                           class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">{{$sender}}</a>
                    </div>

                </div>
                <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
                    {!! $body !!}
                </div>
            </div>
        @endif

    @endfor

