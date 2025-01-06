<table>
    <thead>
        <tr>
            <th class="min-w-100px bold all">{{ __('SN') }}</th>
            <th class="min-w-100px bold all">{{ __('Name AR') }}</th>
            <th class="min-w-200px bold all">{{ __('Name EN') }}</th>
            <th class="min-w-100px bold ">{{ __('Active') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ ++$loop->index }}</td>
                <td class="min-w-200px bold all">{{ $item->name }}</td>
                <td class="min-w-200px bold all">{{ $item->name_en }}</td>
                <td class="min-w-100px bold all">{{ $item->active ? 'Yes' : 'No' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
