<div class="card">
    <div class="card-body py-sm-4">

        <form method="post" action="{{ $address ? route('admin.user.address.update', [$user_type, $address->id]) : route('admin.user.address.create', $user->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="row text-center">
                <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
                    <span class="text-center card-title">Home Address</span>
                    <div class="p-sm-3">
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group @error('home_street_address') error @enderror">
                                    <input type="text" class="form-control"
                                        value="{{ old('home_street_address', $address?->home_street_address ) }}" name="home_street_address"
                                        placeholder="{{ __('Street Name & Number ') }}" id="homeStreetAddress" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group @error('home_suburb') error @enderror">
                                    <input type="text" class="form-control" name="home_suburb"
                                        value="{{ old('home_suburb', $address?->home_suburb ) }}" placeholder="{{ __('Suburb') }}"
                                        id="homeSubRoad">
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('home_city') error @enderror">
                                    <input type="text" class="form-control" name="home_city"
                                        value="{{ old('home_city', $address?->home_city ) }}" id="homeCity"
                                        placeholder="{{ __('City') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('home_post_code') error @enderror">
                                    <input type="number" class="form-control" name="home_post_code" id="homePostCode"
                                        value="{{ old('home_post_code', $address?->home_post_code ) }}"
                                        placeholder="{{ __('Post Code') }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('home_latitude') error @enderror">
                                    <input type="number" class="form-control" name="home_latitude" step="0.00001"
                                        value="{{ old('home_latitude', $address?->home_latitude ) }}"
                                        placeholder="{{ __('Latitude (optional)') }}" id="homeLatitude">
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('home_longitude') error @enderror">
                                    <input type="number" class="form-control" name="home_longitude" step="0.00001"
                                        value="{{ old('home_longitude', $address?->home_longitude ) }}"
                                        placeholder="{{ __('Longitude (optional)') }}" id="homeLoggitude">
                                </div>
                            </div>
                        </div>
                        @error('home_street_address')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('home_suburb')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('home_city')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('home_post_code')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('home_latitude')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('home_longitude')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                </div>

                <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
                     <span class="text-center card-title">Postal Address</span> | Same as Home <input type="checkbox" id="sameAddress">

                    <div class="p-sm-3">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group @error('postal_street_address') error @enderror">
                                    <input type="text" class="form-control" value="{{ old('postal_street_address', $address?->postal_street_address ) }}"
                                        name="postal_street_address" id="postalStreetAddress"
                                        placeholder="{{ __('Street Name & Number') }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group @error('postal_suburb') error @enderror">
                                    <input type="text" class="form-control" name="postal_suburb"
                                        value="{{ old('postal_suburb', $address?->postal_suburb ) }}" id="postalSubRoad"
                                        placeholder="{{ __('Suburb') }}">
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('postal_city') error @enderror">
                                    <input type="text" class="form-control" name="postal_city"
                                        value="{{ old('postal_city', $address?->postal_city ) }}" id="postalCity" placeholder="{{ __('City') }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('postal_post_code') error @enderror">
                                    <input type="number" class="form-control" name="postal_post_code" id="postalPostCode"
                                        value="{{ old('postal_post_code', $address?->postal_post_code ) }}" placeholder="{{ __('Post Code') }}"
                                        required>
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('postal_latitude') error @enderror">
                                    <input type="number" class="form-control" name="postal_latitude" step="0.00001"
                                        value="{{ old('postal_latitude', $address?->postal_latitude ) }}"
                                        placeholder="{{ __('Latitude (optional)') }}" id="postalLatitude">
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('postal_longitude') error @enderror">
                                    <input type="number" class="form-control" name="postal_longitude" step="0.00001"
                                        value="{{ old('postal_longitude', $address?->postal_longitude ) }}"
                                        placeholder="{{ __('Longitude (optional)') }}" id="postalLoggitude">
                                </div>
                            </div>
                        </div>
                        @error('postal_street_address')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('postal_suburb')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('postal_city')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('postal_post_code')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('postal_latitude')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('postal_longitude')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="modal-footer justify-content-center col-md-12">
                    {!! \App\Library\Html::btnReset() !!}
                    {!! \App\Library\Html::btnSubmit() !!}
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@vite('resources/admin_assets/js/pages/employee/create.js')
@vite('resources/admin_assets/js/pages/address/autofill.js')
@endpush
