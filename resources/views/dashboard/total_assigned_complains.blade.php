<div class="card border">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-800">Assigned complains</span>
            {{-- <span class="text-gray-400 mt-1 fw-semibold fs-6"></span> --}}
        </h3>
        <!--end::Title-->

    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body p-2">
        <!--begin::Table-->
        <table class="table align-middle table-bordered fs-6 gy-3" id="total_assigned_complains">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-100px">Employee Name</th>
                    <th class="min-w-100px">Processing</th>
                    <th class="min-w-100px">Solved</th>
                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-bold text-gray-600">
                @foreach ($total_assigned_complains->pluck('name')->unique() as $userName)
                <tr>
                    <td>
                        {{ $userName }}
                    </td>
                    <td>
                        {{ isset($total_assigned_complains->where('status', 'in process')->where('name', $userName)->first()->complains_count)? $total_assigned_complains->where('status', 'in process')->where('name', $userName)->first()->complains_count: '' }}
                    </td>
                    <td>
                        {{ isset($total_assigned_complains->where('status', 'solved')->where('name', $userName)->first()->complains_count) ? $total_assigned_complains->where('status', 'solved')->where('name', $userName)->first()->complains_count: '' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>

@push('scripts')
    <script>
        $(function() {
            var table = $('#total_assigned_complains').DataTable({
                responsive: false,
                searching: false,
                order: false,
                info: false,
                paging: false,
                createdRow: (row, data, index) => {
                    var rowTotal = 0;

                    for (var i = 1; i < data.length; i++) { // Start from index 1 to skip first column
                        var data = Number.isNaN(data[i]) ? 0 : data[i];
                        rowTotal += parseFloat(data);
                    }
                    var totalCell = document.createElement('td');
                    totalCell.style.color = "#181C32";
                    totalCell.innerHTML = rowTotal;
                    row.appendChild(totalCell);
                }

            });
            // Add "Total" column header
            var totalHeader = document.createElement('th');
            totalHeader.innerHTML = 'Total';
            $('#total_assigned_complains thead tr').append(totalHeader);

        });
    </script>
@endpush

