<table>
    <thead>
        <tr>
            <th class="min-w-100px bold all">{{ __('SN') }}</th>
            <th class="min-w-100px bold all">{{ t('Name EN') }}</th>
            <th class="min-w-100px bold all">{{ t('Name AR') }}</th>
            <th class="min-w-200px bold all">{{ t('Code') }}</th>
            <th class="min-w-100px bold all">{{ t('City') }}</th>
            <th class="min-w-100px bold all">{{ t('address') }}</th>
            <th class="min-w-100px bold all">{{ t('floors_number') }}</th>
            <th class="min-w-100px bold all">{{ t('apartments_number') }}</th>
            <th class="min-w-100px bold all">{{ t('description') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            @php
                Log::info('Rendering row for item:', ['item_id' => $item->id]);

                $nameTranslations = $item->getTranslations('name');
                $cityName = optional($item->city)->name ?? 'N/A';
            @endphp
            <tr>
                <td>{{ ++$loop->index }}</td>
                @foreach (config('app.locales') as $locale)
                    <td>{{ $nameTranslations[$locale] ?? 'N/A' }}</td>
                @endforeach
                <td>{{ $item->code ?? 'NA' }}</td>
                <td>{{ $cityName }}</td>
                <td>{{ $address ?? 'NA' }}</td>
                <td>{{ $item->floors_number ?? '0' }}</td>
                <td>{{ $item->apartments_number ?? '0' }}</td>
                <td>{{ $item->description ?? 'NA' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
