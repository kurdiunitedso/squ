@extends('CP.metronic.index')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Program Form Builder</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-primary" id="saveForm">
                    <i class="fas fa-save"></i> Save Form
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-5">
                <button type="button" class="btn btn-light-primary" id="addPage">
                    <i class="fas fa-plus"></i> Add Page
                </button>
            </div>

            <div id="pagesContainer"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let formStructure = {
            pages: []
        };

        const questionTypes = [{
                value: 'text',
                label: 'Text Input'
            },
            {
                value: 'textarea',
                label: 'Wide Text'
            },
            {
                value: 'select',
                label: 'Dropdown List'
            },
            {
                value: 'checkbox',
                label: 'Checkbox'
            },
            {
                value: 'tags',
                label: 'Tags'
            },
            {
                value: 'repeater',
                label: 'Repeater List'
            },
            {
                value: 'file',
                label: 'File Upload'
            }
        ];

        function addPage() {
            const pageId = Date.now();
            const pageHtml = `
        <div class="card mb-4" data-page-id="${pageId}">
            <div class="card-header">
                <input type="text" class="form-control page-name" placeholder="Page Name">
                <button class="btn btn-sm btn-danger delete-page">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="card-body">
                <button class="btn btn-light-primary add-question">
                    <i class="fas fa-plus"></i> Add Question
                </button>
                <div class="questions-container mt-4"></div>
            </div>
        </div>
    `;
            $('#pagesContainer').append(pageHtml);
        }

        function addQuestion(pageId) {
            const questionId = Date.now();
            const questionHtml = `
        <div class="card mb-3" data-question-id="${questionId}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <select class="form-control question-type">
                            ${questionTypes.map(type =>
                                `<option value="${type.value}">${type.label}</option>`
                            ).join('')}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control question-name" placeholder="Question Name">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-danger delete-question">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input question-required">
                            <label class="form-check-label">Required</label>
                        </div>
                    </div>
                    <div class="col-md-4 score-container d-none">
                        <input type="number" class="form-control question-score" placeholder="Score">
                    </div>
                </div>
                <div class="options-container mt-3 d-none"></div>
            </div>
        </div>
    `;
            $(`[data-page-id="${pageId}"] .questions-container`).append(questionHtml);
        }

        $(document).ready(function() {
            $('#addPage').click(addPage);

            $(document).on('click', '.add-question', function() {
                const pageId = $(this).closest('[data-page-id]').data('page-id');
                addQuestion(pageId);
            });

            $(document).on('change', '.question-type', function() {
                const questionCard = $(this).closest('[data-question-id]');
                const type = $(this).val();

                const scoreContainer = questionCard.find('.score-container');
                const optionsContainer = questionCard.find('.options-container');

                if (['select', 'checkbox', 'tags'].includes(type)) {
                    scoreContainer.removeClass('d-none');
                    optionsContainer.removeClass('d-none').html(`
                <button class="btn btn-light-primary add-option">
                    <i class="fas fa-plus"></i> Add Option
                </button>
                <div class="options-list"></div>
            `);
                } else {
                    scoreContainer.addClass('d-none');
                    optionsContainer.addClass('d-none');
                }
            });

            $(document).on('click', '.add-option', function() {
                const optionsList = $(this).siblings('.options-list');
                optionsList.append(`
            <div class="input-group mt-2">
                <input type="text" class="form-control option-text" placeholder="Option Text">
                <input type="number" class="form-control option-score" placeholder="Score">
                <button class="btn btn-danger delete-option">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `);
            });

            $('#saveForm').click(function() {
                const structure = {
                    pages: []
                };

                $('[data-page-id]').each(function() {
                    const page = {
                        id: $(this).data('page-id'),
                        name: $(this).find('.page-name').val(),
                        questions: []
                    };

                    $(this).find('[data-question-id]').each(function() {
                        const question = {
                            id: $(this).data('question-id'),
                            type: $(this).find('.question-type').val(),
                            name: $(this).find('.question-name').val(),
                            required: $(this).find('.question-required').prop(
                                'checked'),
                            score: $(this).find('.question-score').val(),
                            options: []
                        };

                        $(this).find('.options-list .input-group').each(function() {
                            question.options.push({
                                text: $(this).find('.option-text').val(),
                                score: $(this).find('.option-score').val()
                            });
                        });

                        page.questions.push(question);
                    });

                    structure.pages.push(page);
                });

                $.ajax({
                    method: 'POST',
                    data: {
                        structure: structure
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message);
                    }
                });
            });

            // Delete handlers
            $(document).on('click', '.delete-page', function() {
                $(this).closest('[data-page-id]').remove();
            });

            $(document).on('click', '.delete-question', function() {
                $(this).closest('[data-question-id]').remove();
            });

            $(document).on('click', '.delete-option', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>
@endpush
