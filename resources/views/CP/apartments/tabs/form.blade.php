<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ t($_model::ui['s_ucf'] . ' Details') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body p-9">

            <div class="row">
                {{-- Building Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Building') }}</label>
                        <select name="building_id"
                            class="form-select form-select-solid validate-required @error('building_id') is-invalid @enderror">
                            <option value="">{{ t('Select Building') }}</option>
                            @foreach ($building_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ $_model->building_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('building_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Name/Code Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Name/Code') }}</label>
                        <input type="text" name="name"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required @error('name') is-invalid @enderror"
                            placeholder="{{ t('Enter Apartment Name/code') }}" value="{{ $_model->name }}" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Floor # Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Floor #') }}</label>
                        <input type="number" name="floor_number"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('floor_number') is-invalid @enderror"
                            placeholder="{{ t('Enter Floor Number') }}" value="{{ $_model->floor_number }}" />
                        @error('floor_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- orientation_id Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Orientation') }}</label>
                        <select name="orientation_id"
                            class="form-select form-select-solid validate-required @error('orientation_id') is-invalid @enderror">
                            <option value="">{{ t('Select Orientation') }}</option>
                            @foreach ($orientation_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ $_model->orientation_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('orientation_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- Apartment Type Field --}}
                {{-- <div class="col-md-4">
        <div class="fv-row mb-7">
            <label class="fw-semibold fs-6 mb-2">{{ t('Apartment Type') }}</label>
            <select name="type_id"
                class="form-select form-select-solid validate-required @error('type_id') is-invalid @enderror">
                <option value="">{{ t('Select Apartment Type') }}</option>
                @foreach ($apartment_type_list ?? [] as $item)
                    <option value="{{ $item->id }}" {{ $_model->type_id == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            @error('type_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div> --}}

                {{-- Apartment Size Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Apartment Size') }}</label>
                        <select name="size_id"
                            class="form-select form-select-solid validate-required @error('size_id') is-invalid @enderror">
                            <option value="">{{ t('Select Apartment Size') }}</option>
                            @foreach ($apartment_size_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ $_model->size_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('size_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- Parking Type Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Parking Type') }}</label>
                        <select name="parking_type_id"
                            class="form-select form-select-solid validate-required @error('parking_type_id') is-invalid @enderror">
                            <option value="">{{ t('Select Parking Type') }}</option>
                            @foreach ($parking_type_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ $_model->parking_type_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parking_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                {{-- Rooms Number Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Rooms Number') }}</label>
                        <input type="number" name="rooms_number"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('rooms_number') is-invalid @enderror"
                            placeholder="{{ t('Enter Rooms Number') }}" value="{{ $_model->rooms_number }}" />
                        @error('rooms_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Bedrooms Number Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Bedrooms Number') }}</label>
                        <input type="number" name="bedrooms_number"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('bedrooms_number') is-invalid @enderror"
                            placeholder="{{ t('Enter Bedrooms Number') }}" value="{{ $_model->bedrooms_number }}" />
                        @error('bedrooms_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Balconies Number Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Balconies Number') }}</label>
                        <input type="number" name="balcoines_number"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('balcoines_number') is-invalid @enderror"
                            placeholder="{{ t('Enter Balconies Number') }}" value="{{ $_model->balcoines_number }}" />
                        @error('balcoines_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    {{-- Price Field --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Price') }}</label>
                            <input type="number" name="price"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('price') is-invalid @enderror"
                                placeholder="{{ t('Enter Price') }}" value="{{ $_model->price }}" />
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- Disscount Field --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Total Disscount') }}</label>
                            <input type="number" name="total_discount"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('total_discount') is-invalid @enderror"
                                placeholder="{{ t('Enter Total Disscount') }}"
                                value="{{ $_model->total_discount }}" />
                            @error('total_discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Status Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Status') }}</label>
                        <select name="status_id"
                            class="form-select form-select-solid
                {{-- validate-required @error('status_id') is-invalid @enderror" --}}
                >
                <option value="">{{ t('Select Status') }}
                            </option>
                            @foreach ($apartment_status_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ $_model->status_id === $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Description Field --}}
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Description') }}</label>
                        <textarea name="description"
                            class="form-control form-control-solid mb-3 mb-lg-0 @error('description') is-invalid @enderror" rows="4"
                            placeholder="{{ t('Enter description') }}">{{ $_model->description }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
