<table>
    <thead>
        <tr>
            <th class="min-w-100px bold all">{{ __('SN') }}</th>
            <th class="min-w-100px bold all">{{ t('Name') }}</th>
            <th class="min-w-200px bold all">{{ t('Phone') }}</th>
            <th class="min-w-200px bold all">{{ t('Email') }}</th>
            <th class="min-w-100px bold all">{{ t('Apartment') }}</th>
            <th class="min-w-100px bold all">{{ t('Price') }}</th>
            <th class="min-w-100px bold all">{{ t('Down Payment') }}</th>
            <th class="min-w-100px bold all">{{ t('Sent By Email Date') }}</th>
            <th class="min-w-100px bold all">{{ t('Status') }}</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            @php
                $lead = $item->lead;
            @endphp
            <tr>
                <td>{{ ++$loop->index }}</td>
                <td>{{ $lead->name ?? 'NA' }}</td>
                <td>{{ $lead->phone ?? 'NA' }}</td>
                <td>{{ $lead->email ?? 'NA' }}</td>
                <td>{{ $item->apartment->name ?? 'NA' }}</td>
                <td>{{ $item->price ?? 'NA' }}</td>
                <td>{{ $item->down_payment ?? 'NA' }}</td>
                <td>{{ $item->sent_by_email_date ?? 'NA' }}</td>
                <td>{{ $item->status->name ?? 'NA' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
