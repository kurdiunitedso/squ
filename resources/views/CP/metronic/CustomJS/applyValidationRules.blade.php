<script>
    // Validation rules configuration object
    const VALIDATION_RULES = {
        required: {
            rule: 'notEmpty',
            getMessage: (label) => `${label} is required`
        },
        number: {
            rule: 'numeric',
            options: {
                decimalSeparator: '.'
            },
            message: 'The value must be a valid number'
        },
        min0: {
            rule: 'greaterThan',
            options: {
                min: 0
            },
            message: 'The value must be greater than or equal to 0'
        },
        min1: {
            rule: 'greaterThan',
            options: {
                min: 1
            },
            message: 'The value must be greater than or equal to 1'
        },
        email: {
            rule: 'emailAddress',
            message: 'The value must be a valid email address'
        },
        date: {
            rule: 'date',
            message: 'The value must be a valid date'
        },
        dateMin: {
            rule: 'date',
            options: {
                min: 'today'
            },
            message: 'The date must not be in the past'
        },
        dateMax: {
            rule: 'date',
            options: {
                max: 'today'
            },
            message: 'The date must not be in the future'
        },
        datetime: {
            rule: 'date',
            options: {
                format: 'YYYY-MM-DD HH:mm'
            },
            message: 'The value must be a valid date and time'
        }
    };

    // Validation class mapping
    const VALIDATION_CLASSES = {
        'validate-required': 'required',
        'validate-number': 'number',
        'validate-min-0': 'min0',
        'validate-min-1': 'min1',
        'validate-email': 'email',
        'date-picker': 'date',
        'date-picker-future': 'dateMin',
        'date-picker-dob': 'dateMax',
        'date-picker-past': 'dateMax',
        'date-time-picker': 'datetime'
    };

    class FormValidationManager {
        constructor(form, validatorFields = {}) {
            this.form = form;
            this.validatorFields = validatorFields;
            this.validator = this.initializeValidator();
        }

        initializeValidator() {
            return FormValidation.formValidation(
                this.form, {
                    fields: this.validatorFields,
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );
        }

        applyValidationRules() {
            $(this.form).find('input, select, textarea').each((index, element) => {
                const field = $(element);
                const fieldName = field.attr('name');

                if (!fieldName) return;

                const validators = this.buildValidatorsForField(field);

                if (Object.keys(validators).length > 0) {
                    this.validator.addField(fieldName, {
                        validators
                    });
                }
            });

            return this.validator;
        }

        buildValidatorsForField(field) {
            const validators = {};
            const fieldClasses = field[0].className.split(/\s+/);

            fieldClasses.forEach(className => {
                if (VALIDATION_CLASSES[className]) {
                    const ruleKey = VALIDATION_CLASSES[className];
                    const rule = VALIDATION_RULES[ruleKey];
                    const label = this.getFieldLabel(field);

                    // Special handling for date fields
                    if (rule.rule === 'date') {
                        validators[rule.rule] = {
                            message: rule.getMessage ? rule.getMessage(label) :
                                `Please select a valid ${label.toLowerCase()}`,
                            format: rule.options?.format || 'YYYY-MM-DD',
                            ...rule.options
                        };

                        // Add required validator if the field has validate-required class
                        if (fieldClasses.includes('validate-required')) {
                            validators.notEmpty = {
                                message: `${label} is required`
                            };
                        }
                    } else {
                        validators[rule.rule] = {
                            message: rule.rule === 'notEmpty' ?
                                rule.getMessage(label) : rule.message,
                            ...rule.options
                        };
                    }
                }
            });

            return validators;
        }

        getFieldLabel(field) {
            // Try to get label from the closest label element
            const label = field.closest('.fv-row').find('label').text().trim();

            // Remove optional text in parentheses and any trailing colon
            return label.replace(/\s*\([^)]*\)/g, '').replace(/:$/, '');
        }

        getValidator() {
            return this.validator;
        }
    }
</script>
