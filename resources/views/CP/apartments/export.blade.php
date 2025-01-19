<table>
    <thead>
        <tr>
            <th class="min-w-100px bold all">{{ __('SN') }}</th>
            <th class="min-w-100px bold all">{{ t('Name/Code') }}</th>
            <th class="min-w-200px bold all">{{ t('Building Name') }}</th>
            <th class="min-w-100px bold all">{{ t('Floor #') }}</th>
            <th class="min-w-100px bold all">{{ t('Apartment Type') }}</th>
            <th class="min-w-100px bold all">{{ t('Price') }}</th>
            <th class="min-w-100px bold all">{{ t('description') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ ++$loop->index }}</td>
                <td>{{ $item->name ?? 'NA' }}</td>
                <td>{{ $item->building->name ?? 'N/A' }}</td>
                <td>{{ $item->floor_number ?? 'NA' }}</td>
                <td>{{ $item->apartment_type->name ?? 'NA' }}</td>
                <td>{{ $item->price ?? '0' }}</td>
                <td>{{ $item->description ?? 'NA' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
