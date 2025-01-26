<table>
    <thead>
        <tr>
            <th class="min-w-100px bold all">{{ __('SN') }}</th>
            <th class="min-w-100px bold all">{{ t('Name') }}</th>
            <th class="min-w-200px bold all">{{ t('Phone') }}</th>
            <th class="min-w-200px bold all">{{ t('Email') }}</th>
            <th class="min-w-100px bold all">{{ t('Apartment') }}</th>
            <th class="min-w-100px bold all">{{ t('Lead Form Type') }}</th>
            <th class="min-w-100px bold all">{{ t('Number Of Family Members') }}</th>
            <th class="min-w-100px bold all">{{ t('Desired Apartment Size') }}</th>
            <th class="min-w-100px bold all">{{ t('Subject') }}</th>
            <th class="min-w-100px bold all">{{ t('Notes') }}</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ ++$loop->index }}</td>
                <td>{{ $item->name ?? 'NA' }}</td>
                <td>{{ $item->phone ?? 'NA' }}</td>
                <td>{{ $item->email ?? 'NA' }}</td>
                <td>{{ $item->apartment->name ?? 'NA' }}</td>
                <td>{{ $item->lead_form_type->name ?? 'NA' }}</td>
                <td>{{ $item->number_family_members ?? 'NA' }}</td>
                <td>{{ $item->desired_apartment_size ?? 'NA' }}</td>
                <td>{{ $item->subject ?? 'NA' }}</td>
                <td>{{ $item->notes ?? 'NA' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
