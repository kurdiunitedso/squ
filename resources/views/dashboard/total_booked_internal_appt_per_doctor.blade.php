<div class="card border">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-800">Booked Internal Appt per Doctor</span>
            {{-- <span class="text-gray-400 mt-1 fw-semibold fs-6"></span> --}}
        </h3>
        <!--end::Title-->

    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body p-2">
        <!--begin::Table-->
        <table class="table align-middle table-bordered fs-6 gy-3" id="total_booked_internal_appt_per_doctor">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-100px">Doctor Name</th>
                    <th class="min-w-100px">#</th>
                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-bold text-gray-600">
                @foreach ($total_booked_internal_appt_per_doctor as $doctor)
                    <tr>
                        <td>
                            {{ $doctor->name_en }}
                        </td>
                        <td>
                            <a target="_blank"
                                href="{{ route('internal_appointments.index', ['dashboard_filter_doctor_id' => $doctor->doctor_id, 'dashboard_filter_appt_status' => 'booked']) }}">
                                {{ @$doctor->booked_internal_appointments_per_doctor_count }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th class="font-italic text-dark-65 text-right"></th>
                </tr>
            </tfoot>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>


@push('scripts')
    <script>
        $(function() {
            var table = $('#total_booked_internal_appt_per_doctor').DataTable({
                responsive: false,
                searching: false,
                order: false,
                info: false,
                paging: false,
                footerCallback: function(row, data, start, end, display) {
                    let api = this.api();
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };
                    TotalCurrent = api
                        .column(1)
                        .data()
                        .reduce(function(a, b) {
                            var a = String(a).replace(/(<([^>]+)>)/ig, '').trim();
                            var b = String(b).replace(/(<([^>]+)>)/ig, '').trim();
                            return intVal(a) + intVal(b);
                        }, 0);
                    $(api.column(1).footer()).html(
                        TotalCurrent
                    );
                }
            });
        });
    </script>
@endpush