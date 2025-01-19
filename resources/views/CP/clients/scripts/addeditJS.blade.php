<script>
    $(document).ready(function() {
        const bankSelector = 'select[name="bank_id"]';
        const bankBranchSelector = 'select[name="bank_branch_id"]';

        // Function to update bank branches
        function updateBankBranches() {
            const bankId = $(bankSelector).val();
            const selectedBranchId = '{{ old('bank_id', $_model->bank_branch_id) }}';
            console.log('selectedBranchId', selectedBranchId);


            if (bankId) {
                getSelect2WithoutSearchOrPaginate(
                    @json(App\Models\Constant::class),
                    bankBranchSelector,
                    '{{ t('Select Bank Branch') }}', {
                        parent_id: bankId,
                        field: "{{ \App\Enums\DropDownFields::bank_branches }}"
                    },
                    selectedBranchId
                ).catch(error => {
                    console.error('Failed to fetch bank branches:', error);
                    $(bankBranchSelector)
                        .empty()
                        .append('<option value="">{{ t('Select Bank Branch') }}</option>')
                        .trigger('change');
                });
            } else {
                $(bankBranchSelector)
                    .empty()
                    .append('<option value="">{{ t('Select Bank Branch') }}</option>')
                    .trigger('change');
            }
        }
        // Add event listener for bank selection change
        $(bankSelector).on('change', updateBankBranches);

        // Handle initial bank value if exists
        const initialBankId = @json(old('bank_id', $_model->bank_id));
        if (initialBankId) {
            $(bankSelector).val(initialBankId);
            updateBankBranches();
        }
    });
</script>
