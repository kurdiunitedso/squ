<table>
    <thead>
        <tr>
            <th class="min-w-100px bold all">{{ __('SN') }}</th>
            <th class="min-w-100px bold all">{{ t('Client') }}</th>
            <th class="min-w-200px bold all">{{ t('Contract Type') }}</th>
            <th class="min-w-100px bold all">{{ t('Service') }}</th>
            <th class="min-w-100px bold all">{{ t('Duration') }}</th>
            <th class="min-w-100px bold all">{{ t('Objectives') }}</th>
            <th class="min-w-100px bold all">{{ t('Team Lead / Account Manager') }}</th>
            <th class="min-w-100px bold all">{{ t('Art Manager') }}</th>
            <th class="min-w-100px bold all">{{ t('Assigned Employees') }}</th>
            {{-- <th class="min-w-100px bold ">{{ t('Status') }}</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ ++$loop->index }}</td>
                <td class="min-w-200px bold all">{{ $item->contract->client_trillion->name ?? '' }}</td>
                <td class="min-w-200px bold all">{{ $item->project_type->name ?? '' }}</td>
                <td class="min-w-200px bold all">{{ $item->item->description ?? '' }}</td>
                <td class="min-w-200px bold all">{{ $item->duration ?? '' }}</td>
                <td class="min-w-200px bold all">{{ $item->objectives ?? '' }}</td>
                <td class="min-w-200px bold all">{{ $item->account_manager->name ?? '' }}</td>
                <td class="min-w-200px bold all">{{ $item->art_manager->name ?? '' }}</td>
                <td class="min-w-200px bold all">{{ $item->project_employees_count ?? '' }}</td>
                {{-- <td class="min-w-200px bold all">{{ $item->status->name ?? '' }}</td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
