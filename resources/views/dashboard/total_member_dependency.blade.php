<div class="card border">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-800">Member dependency </span>
            <span class="text-gray-400 mt-1 fw-semibold fs-6">Active patients</span>
        </h3>
        <!--end::Title-->

    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body p-2">
        <!--begin::Table-->
        <table class="table align-middle table-bordered fs-6 gy-3" id="total_member_dependency">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-100px">Type</th>
                    <th class="min-w-100px">#</th>
                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->

            <!--begin::Table body-->
            <tbody class="fw-bold text-gray-600">
                <tr>
                    <td>
                        Independent Parent
                    </td>
                    <td>
                        <a target="_blank"
                            href="{{ route('patients.index', [
                                'dashboard_filter_is_parent' => 'YES',
                                'active_only' => 'YES',
                                'dashboard_filter_is_independent' => 'YES',
                            ]) }}">
                            {{ @$total_member_dependency->first()->independent_parent }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        Independet - not parent
                    </td>
                    <td>
                        <a target="_blank"
                            href="{{ route('patients.index', [
                                'dashboard_filter_is_parent' => 'NO',
                                'active_only' => 'YES',
                                'dashboard_filter_is_independent' => 'YES',
                            ]) }}">
                            {{ @$total_member_dependency->first()->independent_not_parent }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        Dependant
                    </td>
                    <td>
                        <a target="_blank"
                            href="{{ route('patients.index', ['dashboard_filter_is_independent' => 'YES', 'active_only' => 'YES']) }}">
                            {{ @$total_member_dependency->first()->independent }}
                        </a>
                    </td>
                </tr>


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
            var table = $('#total_member_dependency').DataTable({
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
