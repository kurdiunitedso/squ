<script>
    $(document).ready(function() {
        function updateApartments() {
            const buildingId = $('select[name="lead_building_id"]').val();
            const sizeId = $('select[name="lead_desired_apartment_size_id"]').val();
            const selectedApartmentId =
                '{{ old('lead_apartment_id', isset($_model->lead) && $_model->lead->apartment_id ? $_model->lead->apartment_id : '') }}';

            if (buildingId || sizeId) {
                getSelect2WithoutSearchOrPaginate(
                    @json(App\Models\Apartment::class),
                    'select[name="lead_apartment_id"]',
                    'Select Apartment', {
                        building_id: buildingId,
                        size_id: sizeId
                    },
                    selectedApartmentId,
                    // 'or' // You can change this to 'and' if needed
                ).catch(error => {
                    console.error('Failed to fetch apartments:', error);
                    $('select[name="lead_apartment_id"]')
                        .empty()
                        .append('<option value="">Select Apartment</option>')
                        .trigger('change');
                });
            } else {
                $('select[name="lead_apartment_id"]')
                    .empty()
                    .append('<option value="">Select Apartment</option>')
                    .trigger('change');
            }
        }

        // Event listeners
        $('select[name="lead_building_id"]').on('change', updateApartments);
        $('select[name="lead_desired_apartment_size_id"]').on('change', updateApartments);

        // Handle initial values
        const initialBuildingId = @json(old('lead_building_id', isset($_model->lead) ? $_model->lead->building_id : ''));
        const initialSizeId = @json(old('lead_desired_apartment_size_id', isset($_model->lead) ? $_model->lead->desired_apartment_size_id : ''));

        if (initialBuildingId || initialSizeId) {
            if (initialBuildingId) {
                $('select[name="lead_building_id"]').val(initialBuildingId);
            }
            if (initialSizeId) {
                $('select[name="lead_desired_apartment_size_id"]').val(initialSizeId);
            }
            updateApartments();
        }
    });
</script>

<script>
    // Lead Handler with initial ID logic
    class LeadSelect2Handler extends Select2BaseModelHandler {
        constructor() {
            super({
                model: "App\\Models\\Lead",
                selector: '[name="lead_id"]',
                prefix: 'lead',
                placeholder: "Select a Lead",
                fields: [
                    'name[en]', 'name[ar]', 'email', 'phone', 'apartment_id', 'lead_form_type_id',
                    'number_family_members',
                    'building_id',
                    'status_id',
                    'desired_apartment_size_id', 'subject', 'notes'
                ],
                relatedFields: {},
                initialIdLogic: `{{ old('lead_id', isset($_model->lead) ? $_model->lead->id : '') }}`
            });
        }
    }

    // Client Handler
    class ClientHandler extends Select2BaseModelHandler {
        constructor() {
            super({
                model: "App\\Models\\Client",
                selector: '[name="lead_client_id"]',
                prefix: 'lead_client',
                placeholder: "Select a Client",
                fields: [
                    'name', 'email', 'phone', 'address', 'city',
                    'country_id', 'identification_number', 'notes'
                ],
                relatedFields: {
                    contracts: ['number', 'status']
                }
            });
        }
    }

    // Apartment Handler
    class ApartmentHandler extends Select2BaseModelHandler {
        constructor() {
            super({
                model: "App\\Models\\Apartment",
                selector: '[name="apartment_id"]',
                prefix: 'apartment',
                placeholder: "Select an Apartment",
                fields: [
                    'building_id',
                    'status_id',
                    'name',
                    'floor_number',
                    // 'type_id',
                    'size_id',
                    'rooms_number',
                    'bedrooms_number',
                    'balcoines_number',
                    'orientation_id',
                    'parking_type_id',
                    'description',
                    'price',
                    // 'add_ons_total_cost',
                    // 'total_cost',
                    // 'total_discount',
                ],
                relatedFields: {},
                initialIdLogic: `{{ old('apartment_id', isset($_model->apartment) ? $_model->apartment->id : '') }}`

            });
        }
    }

    // Initialize handlers where needed
    $(document).ready(function() {
        // Initialize only the handlers needed for the current page
        if ($('[name="lead_id"]').length) {
            const leadSelect2Handler = new LeadSelect2Handler();
            leadSelect2Handler.initialize();
        }

        if ($('[name="apartment_id"]').length) {
            const apartmentHandler = new ApartmentHandler();
            apartmentHandler.initialize();
        }
    });
</script>
