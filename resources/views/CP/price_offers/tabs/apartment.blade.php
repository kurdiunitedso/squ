@php
    use App\Models\Apartment;
    $apartment_prifx = Apartment::ui['s_lcf'];
@endphp

<div class="card mb-5 mb-xl-10">
    <div class="card-header">
        <div class="card-title m-0 w-600px">
            <select class="form-select form-select-solid mb-3 mb-lg-0" id="{{ Apartment::ui['_id'] }}"
                data-control="select2" name="{{ Apartment::ui['_id'] }}" data-placeholder="{{ t('Select Apartment') }}"
                data-allow-clear="true">
                <option></option>
            </select>
        </div>
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body p-9">
            <div class="row">
                {{-- Building Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Building') }}</label>
                        <select name="apartment_building_id"
                            class="form-select form-select-solid validate-required @error('apartment_building_id') is-invalid @enderror">
                            <option value="">{{ t('Select Building') }}</option>
                            @foreach ($building_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('apartment_building_id', isset($_model) ? $_model->building_id : '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('apartment_building_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Name/Code Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Name/Code') }}</label>
                        <input type="text" name="apartment_name"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required @error('apartment_name') is-invalid @enderror"
                            placeholder="{{ t('Enter Apartment Name/code') }}"
                            value="{{ old('apartment_name', isset($_model) ? $_model->name : '') }}" />
                        @error('apartment_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Floor # Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Floor #') }}</label>
                        <input type="number" name="apartment_floor_number"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('apartment_floor_number') is-invalid @enderror"
                            placeholder="{{ t('Enter Floor Number') }}"
                            value="{{ old('apartment_floor_number', isset($_model) ? $_model->floor_number : '') }}" />
                        @error('apartment_floor_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- orientation_id Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Orientation') }}</label>
                        <select name="apartment_orientation_id"
                            class="form-select form-select-solid validate-required @error('apartment_orientation_id') is-invalid @enderror">
                            <option value="">{{ t('Select Orientation') }}</option>
                            @foreach ($orientation_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('apartment_orientation_id', isset($_model) ? $_model->orientation_id : '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('apartment_orientation_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Apartment Size Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Apartment Size') }}</label>
                        <select name="apartment_size_id"
                            class="form-select form-select-solid validate-required @error('apartment_size_id') is-invalid @enderror">
                            <option value="">{{ t('Select Apartment Size') }}</option>
                            @foreach ($apartment_size_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('apartment_size_id', isset($_model) ? $_model->size_id : '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('apartment_size_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Parking Type Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Parking Type') }}</label>
                        <select name="apartment_parking_type_id"
                            class="form-select form-select-solid validate-required @error('apartment_parking_type_id') is-invalid @enderror">
                            <option value="">{{ t('Select Parking Type') }}</option>
                            @foreach ($parking_type_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('apartment_parking_type_id', isset($_model) ? $_model->parking_type_id : '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('apartment_parking_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Rooms Number Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Rooms Number') }}</label>
                        <input type="number" name="apartment_rooms_number"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('apartment_rooms_number') is-invalid @enderror"
                            placeholder="{{ t('Enter Rooms Number') }}"
                            value="{{ old('apartment_rooms_number', isset($_model) ? $_model->rooms_number : '') }}" />
                        @error('apartment_rooms_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Bedrooms Number Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Bedrooms Number') }}</label>
                        <input type="number" name="apartment_bedrooms_number"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('apartment_bedrooms_number') is-invalid @enderror"
                            placeholder="{{ t('Enter Bedrooms Number') }}"
                            value="{{ old('apartment_bedrooms_number', isset($_model) ? $_model->bedrooms_number : '') }}" />
                        @error('apartment_bedrooms_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Balconies Number Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Balconies Number') }}</label>
                        <input type="number" name="apartment_balcoines_number"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('apartment_balcoines_number') is-invalid @enderror"
                            placeholder="{{ t('Enter Balconies Number') }}"
                            value="{{ old('apartment_balcoines_number', isset($_model) ? $_model->balcoines_number : '') }}" />
                        @error('apartment_balcoines_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    {{-- Price Field --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Price') }}</label>
                            <input type="number" name="apartment_price"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('apartment_price') is-invalid @enderror"
                                placeholder="{{ t('Enter Price') }}"
                                value="{{ old('apartment_price', isset($_model) ? $_model->price : '') }}" />
                            @error('apartment_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Discount Field --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Total Discount') }}</label>
                            <input type="number" name="apartment_total_discount"
                                class="form-control form-control-solid mb-3 mb-lg-0
                                {{-- validate-required --}}
                                 validate-number validate-min-0 @error('apartment_total_discount') is-invalid @enderror"
                                placeholder="{{ t('Enter Total Discount') }}"
                                value="{{ old('apartment_total_discount', isset($_model) ? $_model->total_discount : '') }}" />
                            @error('apartment_total_discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Status Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Status') }}</label>
                        <select name="apartment_status_id" class="form-select form-select-solid">
                            <option value="">{{ t('Select Status') }}</option>
                            @foreach ($apartment_status_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('apartment_status_id', isset($_model) ? $_model->status_id : '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('apartment_status_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Description Field --}}
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Description') }}</label>
                        <textarea name="apartment_description"
                            class="form-control form-control-solid mb-3 mb-lg-0 @error('apartment_description') is-invalid @enderror"
                            rows="4" placeholder="{{ t('Enter description') }}">{{ old('apartment_description', isset($_model) ? $_model->description : '') }}</textarea>
                        @error('apartment_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
