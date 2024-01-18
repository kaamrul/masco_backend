<div class="row">
    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
        <div class="p-sm-3">

            <div class="form-group row">
                <label class="col-sm-3 col-form-label required">{{ __('Home Address') }}</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group @error('address.home_street_address') error @enderror">
                                <input type="text" class="form-control" value="{{ old('address.home_street_address') }}"
                                    name="address[home_street_address]" placeholder="{{ __('Street Name & Number ') }}"
                                    id="homeStreetAddress" required>

                                <span class="error-message text-danger" id="error-homeStreetAddress"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group @error('address.home_suburb') error @enderror">
                                <input type="text" class="form-control" name="address[home_suburb]"
                                    value="{{ old('address.home_suburb') }}" placeholder="{{ __('Suburb') }}"
                                    id="homeSubRoad">

                                <span class="error-message text-danger" id="error-homeSubRoad"></span>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-3">
                            <div class="form-group @error('address.home_city') error @enderror">
                                <input type="text" class="form-control" name="address[home_city]"
                                    value="{{ old('address.home_city') }}" id="homeCity" placeholder="{{ __('City') }}"
                                    required>

                                <span class="error-message text-danger" id="error-homeCity"></span>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-3">
                            <div class="form-group @error('address.home_post_code') error @enderror">
                                <input type="number" class="form-control" name="address[home_post_code]"
                                    id="homePostCode" value="{{ old('address.home_post_code') }}"
                                    placeholder="{{ __('Post Code') }}" required>

                                <span class="error-message text-danger" id="error-homePostCode"></span>
                            </div>
                        </div>

                        <div class="col-sm-6 mt-3">
                            <div class="form-group @error('address.home_latitude') error @enderror">
                                <input type="number" class="form-control" name="address[home_latitude]" id="homeLatitude"
                                    value="{{ old('address.home_latitude') }}" step="0.00001"
                                    placeholder="{{ __('Latitude (optional)') }}">
                            </div>
                        </div>

                        <div class="col-sm-6 mt-3">
                            <div class="form-group @error('address.home_longitude') error @enderror">
                                <input type="number" class="form-control" name="address[home_longitude]"
                                    id="homeLoggitude" value="{{ old('address.home_longitude') }}" step="0.00001"
                                    placeholder="{{ __('Longitude (optional)') }}">
                            </div>
                        </div>
                    </div>
                    @error('address.home_street_address')
                    <p class="error-message text-danger">{{ $message }}</p>
                    @enderror
                    @error('address.home_suburb')
                    <p class="error-message text-danger">{{ $message }}</p>
                    @enderror
                    @error('address.home_city')
                    <p class="error-message text-danger">{{ $message }}</p>
                    @enderror
                    @error('address.home_post_code')
                    <p class="error-message text-danger">{{ $message }}</p>
                    @enderror
                    @error('address.home_latitude')
                    <p class="error-message text-danger">{{ $message }}</p>
                    @enderror
                    @error('address.home_longitude')
                    <p class="error-message text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

        </div>
    </div>

    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
        <div class="p-sm-3">
            <div class="form-group row">

                <div class="col-sm-3">
                    <label class="col-form-label required">{{ __('Postal Address') }}</label><br>
                    Same as <input type="checkbox" id="sameAddress">
                </div>

                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group @error('address.postal_street_address') error @enderror">
                                <input type="text" class="form-control"
                                    value="{{ old('address.postal_street_address') }}"
                                    name="address[postal_street_address]" id="postalStreetAddress"
                                    placeholder="{{ __('Street Name & Number') }}" required>

                                <span class="error-message text-danger" id="error-postalStreetAddress"></span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group @error('address.postal_suburb') error @enderror">
                                <input type="text" class="form-control" name="address[postal_suburb]"
                                    value="{{ old('address.postal_suburb') }}" id="postalSubRoad"
                                    placeholder="{{ __('Suburb') }}">

                                <span class="error-message text-danger" id="error-postalSubRoad"></span>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-3">
                            <div class="form-group @error('address.postal_city') error @enderror">
                                <input type="text" class="form-control" name="address[postal_city]"
                                    value="{{ old('address.postal_city') }}" id="postalCity"
                                    placeholder="{{ __('City') }}" required>

                                <span class="error-message text-danger" id="error-postalCity"></span>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-3">
                            <div class="form-group @error('address.postal_post_code') error @enderror">
                                <input type="number" class="form-control" name="address[postal_post_code]"
                                    id="postalPostCode" value="{{ old('address.postal_post_code') }}"
                                    placeholder="{{ __('Post Code') }}" required>

                                <span class="error-message text-danger" id="error-postalPostCode"></span>
                            </div>
                        </div>

                        <div class="col-sm-6 mt-3">
                            <div class="form-group @error('address.postal_latitude') error @enderror">
                                <input type="number" class="form-control" id="postalLatitude" step="0.00001"
                                    name="address[postal_latitude]" value="{{ old('address.postal_latitude') }}"
                                    placeholder="{{ __('Latitude (optional)') }}">
                            </div>
                        </div>

                        <div class="col-sm-6 mt-3">
                            <div class="form-group @error('address.postal_longitude') error @enderror">
                                <input type="number" class="form-control" id="postalLoggitude" step="0.00001"
                                    name="address[postal_longitude]" value="{{ old('address.postal_longitude') }}"
                                    placeholder="{{ __('Longitude (optional)') }}">
                            </div>
                        </div>
                    </div>
                    @error('address.postal_street_address')
                    <p class="error-message text-danger">{{ $message }}</p>
                    @enderror
                    @error('address.postal_suburb')
                    <p class="error-message text-danger">{{ $message }}</p>
                    @enderror
                    @error('address.postal_city')
                    <p class="error-message text-danger">{{ $message }}</p>
                    @enderror
                    @error('address.postal_post_code')
                    <p class="error-message text-danger">{{ $message }}</p>
                    @enderror
                    @error('address.postal_latitude')
                    <p class="error-message text-danger">{{ $message }}</p>
                    @enderror
                    @error('address.postal_longitude')
                    <p class="error-message text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

        </div>
    </div>
</div>
@push('scripts')
@vite('resources/admin_assets/js/pages/address/autofill.js')
@endpush
