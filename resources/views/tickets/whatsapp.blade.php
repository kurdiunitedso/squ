
<div class="scrollWhatAppHis scrollable scroll scroll-pull" id="scrollWhatAppHis">
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->

                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <table class="table table-striped table-bordered table-hover  order-column" id="">
                        <thead>
                        <tr>
                            <th class="min-w-100px all bold">{{__('Date')}}</th>
                            <th class="min-w-100px all bold">{{__('Text')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $count=1 @endphp
                        @foreach (\App\Models\WhatsappHistory::getWhataaAppList([],0,0,0,isset($ticket) ? $ticket->telephone : (isset($call)?$call:''))->get() as $m)

                            <tr>
                                <td>
                                    <small>{{ date('Y-m-d H:i',$m->time) }}</small>
                                </td>

                                <td>

                                    @if($m->fromMe==0)
                                        <div class="d-flex flex-column mb-5 align-items-start">

                                            <div
                                                class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                                                {!! $m->body !!}
                                            </div>
                                        </div>
                                    @endif
                                    @if($m->fromMe==1)
                                        <div class="d-flex flex-column mb-5 align-items-end">

                                            <div
                                                class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
                                                {!! $m->body  !!}
                                            </div>
                                        </div>
                                    @endif


                                </td>


                            </tr>
                            @php $count++ @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
