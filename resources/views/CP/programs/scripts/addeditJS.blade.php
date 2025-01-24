<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>



<script>
    $(document).ready(function() {
        $('#important-dates-repeater').repeater({
            initEmpty: false,
            show: function() {
                console.log('sdsdsd', $(this));

                $(this).slideDown();
                $(this).find('input[name^="important_dates"][name$="[date]"]').each(function() {
                    flatpickr(this, {
                        dateFormat: "Y-m-d",
                        // minDate: "today",
                        allowInput: true
                    });
                });
            },
            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        const form = document.querySelector('#program_form');
        form.addEventListener('submit', function(e) {
            let isValid = true;

            $('[data-repeater-item]').each(function() {
                const title = $(this).find('[name="title"]');
                const date = $(this).find('[name="date"]');

                if (!title.val()) {
                    isValid = false;
                    title.addClass('is-invalid');
                }

                if (!date.val()) {
                    isValid = false;
                    date.addClass('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                toastr.error('Please fill in all required fields in Important Dates');
            }
        });
    });
</script>




<script>
    $(document).ready(function() {
        // Initialize pages repeater
        $('#pages-repeater').repeater({
            initEmpty: false,
            show: function() {
                $(this).slideDown();
                initializeFormSelects();
                initQuestionTypeHandlers($(this));
            }
        });

        // Initialize questions repeater
        $('.questions-repeater').repeater({
            initEmpty: false,
            show: function() {
                $(this).slideDown();
                initializeFormSelects();
                initQuestionTypeHandlers($(this));
            }
        });

        // Initialize options repeater
        $('.options-repeater').repeater({
            initEmpty: false,
            show: function() {
                $(this).slideDown();
            }
        });

        // Handle question type change
        function initQuestionTypeHandlers(container) {
            container.find('.question-type').on('change', function() {
                const optionsSection = $(this).closest('[data-repeater-item]').find('.options-section');
                const hasOptions = ['select', 'checkbox', 'tags'].includes($(this).val());
                optionsSection.toggle(hasOptions);
            });
        }

        // Initialize handlers for existing items
        initQuestionTypeHandlers($('.questions-repeater'));
    });
</script>
