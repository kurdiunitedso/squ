{{-- <script>
    jQuery(document).ready(function () {
        $(".chatWhat").on('click', function () {
            $(this).find('.countwamessages').html('');
            window.open($(this).attr("href"), 'popup', 'width=600,height=600,scrollbars=no,resizable=no');
            return false;
        });

        $("#moreChat").on('click', function () {
            var page = $(this).attr('page');
            var sender = $(this).attr('sender');
            var thisDiv = jQuery('.moreChat');

            $.ajax({
                url: '/getUnreadMessages?sender=' + sender + "&page=" + page + "&inputsearch=" + $('.searchinputWhat').val(),
                success: function (data) {
                    thisDiv.append(data);
                },
                beforeSend: function () {
                    jQuery('.loadmoreChat').html('<div class="spinner spinner-primary spinner-lg spinner-center"></div>');

                },
                complete: function () {

                    $("#moreChat").attr('page', parseFloat(page) + 1);
                    jQuery('.loadmoreChat').html('');
                    $(".chatWhat").on('click', function () {
                        $(this).find('.countwamessages').html('');
                        window.open($(this).attr("href"), 'popup', 'width=600,height=600,scrollbars=no,resizable=no');
                        return false;
                    });
                },
                dataType: 'html'
            });
        });
        setInterval(function () {


        }, 5000);

    });
</script> --}}
@php
    $count = 0;
@endphp

<div class="newChat">

</div>
@foreach ($senders as $s)
    @php

        $e = \App\Models\WhatsappHistory::getWhataaAppList(
            $inputsearch ? $inputsearch : [],
            0,
            0,
            0,
            $s->chatId,
            $token,
            0,
            0,
        )
            ->orderby('time', 'desc')
            ->get()
            ->first();
    @endphp
    @if ($e)
        @php

            $countChat = \App\Models\WhatsappHistory::getWhataaAppList([], 1, 0, 0, $s->chatId, $token, 0, 2)->count();

            $time = date('Y-m-d H:i', $s->time);
            $pp = 0;
            $mobile = strtok($e->chatId, '@');
            $cc = $countChat
                ? ' <spa
                n class=" countwamessages badge badge-sm badge-success">(' .
                    $countChat .
                    ')</span>'
                : '';
            if ($e->fromMe) {
                $pp = \App\Models\Client::getClientByMobile($mobile);
            }
            $client = $e->fromMe ? ($pp ? \App\Models\Client::getClientFullName($pp->id) : $mobile) : $e->senderName;
            $clientCC = $client . $cc;
            if ($e->type != 'chat' && $e->type != 'interactive' && $e->type != 'chat') {
                $body = '<a href="' . $e->body . '" target="_blank"> click here ' . $e->caption . '</a>';
            } else {
                $body = $e->body;
            }

        @endphp
        <a href="/getWhatsAppMessage?mobile={{ $mobile }}&client={{ $client }}&sender={{ $sender }}"
            sender="{{ $sender }}" title="Whatapp {{ $client }} {{ $mobile }}:" class="chatWhat">
            <div class="navi-link rounded border-bottom mb-15">

                <div class="navi-text">
                    <div class="text-dark-75  font-weight-bold font-size-h6">{!! $clientCC !!}
                        <i class="symbol-badge bg-success"></i>
                    </div>
                    <span class="text-muted font-size-sm"> - {{ $time }}</span>
                    <div
                        class="mt-2 rounded p-5 bg-light  text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                        {!! $body !!}
                    </div>
                </div>
            </div>
        </a>
    @endif
@endforeach
<div class="moreChat">

</div>
<div class="loadmoreChat">

</div>
<p>

    <button class="btn btn-secondary" type="button" limit="10" page="{{ $page }}"
        sender="{{ $sender }}" id="moreChat">Load
        More
    </button>

</p>
