@php
    $form = form_helper($prefix ?? '', $_model ?? null);
@endphp

<script>
    $(document).ready(function() {
        function updateApartments() {
            const buildingId = $('select[name="{{ $form->name('building_id') }}"]').val();
            const sizeId = $('select[name="{{ $form->name('desired_apartment_size_id') }}"]').val();
            const selectedApartmentId = '{{ $form->value('apartment_id') }}';

            if (buildingId || sizeId) {
                getSelect2WithoutSearchOrPaginate(
                    @json(App\Models\Apartment::class),
                    'select[name="{{ $form->name('apartment_id') }}"]',
                    '{{ t('Select Apartment') }}', {
                        building_id: buildingId,
                        size_id: sizeId
                    },
                    selectedApartmentId,
                    // 'or' // You can change this to 'and' if needed
                ).catch(error => {
                    console.error('Failed to fetch apartments:', error);
                    $('select[name="{{ $form->name('apartment_id') }}"]')
                        .empty()
                        .append('<option value="">{{ t('Select Apartment') }}</option>')
                        .trigger('change');
                });
            } else {
                $('select[name="{{ $form->name('apartment_id') }}"]')
                    .empty()
                    .append('<option value="">{{ t('Select Apartment') }}</option>')
                    .trigger('change');
            }
        }

        // Event listeners
        $('select[name="{{ $form->name('building_id') }}"]').on('change', updateApartments);
        $('select[name="{{ $form->name('desired_apartment_size_id') }}"]').on('change', updateApartments);

        // Handle initial values
        const initialBuildingId = @json($form->value('building_id') ?? old('building_id'));
        const initialSizeId = @json($form->value('desired_apartment_size_id') ?? old('desired_apartment_size_id'));

        if (initialBuildingId || initialSizeId) {
            if (initialBuildingId) {
                $('select[name="{{ $form->name('building_id') }}"]').val(initialBuildingId);
            }
            if (initialSizeId) {
                $('select[name="{{ $form->name('desired_apartment_size_id') }}"]').val(initialSizeId);
            }
            updateApartments();
        }
    });
</script>
