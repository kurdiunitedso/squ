<div class="card mb-5 mb-xl-10">
    <div class="card-header">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ t('Application Setup') }}</h3>
        </div>
    </div>

    <div class="card mb-5 mb-xl-10">
        <div class="card-body p-9">
            <div id="pages-repeater">
                <div data-repeater-list="pages">
                    <div data-repeater-item class="form-group p-5 border rounded mb-3">
                        <!-- Page Name -->
                        <div class="row mb-3">
                            @foreach (config('app.locales') as $locale)
                                <div class="col-md-4">
                                    <label class="form-label">
                                        {{ t('Page Name') }}
                                        <small>({{ strtoupper($locale) }})</small>
                                    </label>
                                    <input type="text" name="name[{{ $locale }}]"
                                        class="form-control form-control-solid validate-required">
                                </div>
                            @endforeach
                        </div>

                        <!-- Questions Repeater -->
                        <div class="questions-repeater mt-5">
                            <div data-repeater-list="questions">
                                <div data-repeater-item class="border rounded p-3 mb-3">
                                    <div class="row">
                                        <!-- Question Names -->
                                        @foreach (config('app.locales') as $locale)
                                            <div class="col-md-4">
                                                <label class="form-label">
                                                    {{ t('Question') }}
                                                    <small>({{ strtoupper($locale) }})</small>
                                                </label>
                                                <input type="text" name="name[{{ $locale }}]"
                                                    class="form-control form-control-solid validate-required">
                                            </div>
                                        @endforeach

                                        <!-- Question Type -->
                                        <div class="col-md-3">
                                            <label class="form-label">{{ t('Type') }}</label>
                                            <select name="type" class="form-select form-select-solid question-type">
                                                <option value="text">{{ t('Text') }}</option>
                                                <option value="textarea">{{ t('Wide Text') }}</option>
                                                <option value="select">{{ t('Dropdown') }}</option>
                                                <option value="checkbox">{{ t('Checkbox') }}</option>
                                                <option value="tags">{{ t('Tags') }}</option>
                                                <option value="repeater">{{ t('Repeater') }}</option>
                                                <option value="file">{{ t('File Upload') }}</option>
                                            </select>
                                        </div>

                                        <!-- Required -->
                                        <div class="col-md-2">
                                            <label class="form-label">{{ t('Required') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="required"
                                                    value="1">
                                            </div>
                                        </div>

                                        <!-- Delete Question -->
                                        <div class="col-md-1">
                                            <button type="button" data-repeater-delete
                                                class="btn btn-sm btn-light-danger mt-3">
                                                <i class="la la-trash-o"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Options & Scores -->
                                    <div class="options-section mt-3" style="display: none;">
                                        <div class="options-repeater">
                                            <div data-repeater-list="options">
                                                <div data-repeater-item class="row mb-2">
                                                    @foreach (config('app.locales') as $locale)
                                                        <div class="col-md-4">
                                                            <input type="text" name="option[{{ $locale }}]"
                                                                class="form-control form-control-solid"
                                                                placeholder="{{ t('Option in ' . strtoupper($locale)) }}">
                                                        </div>
                                                    @endforeach
                                                    <div class="col-md-2">
                                                        <input type="number" name="score"
                                                            class="form-control form-control-solid"
                                                            placeholder="{{ t('Score') }}">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" data-repeater-delete
                                                            class="btn btn-sm btn-light-danger">
                                                            <i class="la la-trash-o"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" data-repeater-create
                                                class="btn btn-light-primary btn-sm mt-2">
                                                <i class="la la-plus"></i> {{ t('Add Option') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" data-repeater-create class="btn btn-light-primary btn-sm mt-2">
                                <i class="la la-plus"></i> {{ t('Add Question') }}
                            </button>
                        </div>

                        <!-- Delete Page -->
                        <div class="mt-3">
                            <button type="button" data-repeater-delete class="btn btn-light-danger">
                                <i class="la la-trash-o"></i> {{ t('Delete Page') }}
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" data-repeater-create class="btn btn-primary">
                    <i class="la la-plus"></i> {{ t('Add Page') }}
                </button>
            </div>
        </div>
    </div>
</div>
