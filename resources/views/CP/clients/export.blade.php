<table>
    <thead>
        <tr>
            <th class="min-w-100px bold all">{{ __('SN') }}</th>
            <th class="min-w-100px bold all">{{ t('Name') }}</th>
            <th class="min-w-200px bold all">{{ t('Email') }}</th>
            <th class="min-w-200px bold all">{{ t('Phone') }}</th>
            {{-- <th class="min-w-100px bold all">{{ t('Address') }}</th> --}}
            <th class="min-w-100px bold all">{{ t('Active') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ ++$loop->index }}</td>
                <td>{{ $item->name ?? 'NA' }}</td>
                <td>{{ $item->email ?? 'NA' }}</td>
                <td>{{ $item->phone ?? 'NA' }}</td>
                <td>{{ $item->active ? 'Yes' : 'No' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
