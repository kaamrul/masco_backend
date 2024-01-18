<div class="row" id="addressTableShow">
    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="2">
                        <h4 class="text-center">Home Address</h4>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="20%">Street Name & Number</td>
                    <td width="40%">
                        {{ $address?->home_street_address }}
                    </td>
                </tr>
                <tr>
                    <td>Suburb</td>
                    <td> {{ $address?->home_suburb }} </td>
                </tr>
                <tr>
                    <td>City</td>
                    <td> {{ ucwords($address?->home_city) }} </td>
                </tr>
                <tr>
                    <td>Post Code</td>
                    <td> {{ ucwords($address?->home_post_code) }} </td>
                </tr>

                @if(false)
                <tr>
                    <td>Latitude</td>
                    <td> {{ $address?->home_latitude ? ucwords($address?->home_latitude) : 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td>Longitude</td>
                    <td> {{ $address?->home_longitude ? ucwords($address?->home_longitude) : 'N/A' }}
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>

    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="2">
                        <h4 class="text-center">Postal Address</h4>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="20%">Street Name & Number</td>
                    <td width="40%">
                        {{ $address?->postal_street_address }}
                    </td>
                </tr>
                <tr>
                    <td>Suburb</td>
                    <td> {{ $address?->postal_suburb }} </td>
                </tr>
                <tr>
                    <td>City</td>
                    <td> {{ ucwords($address?->postal_city) }} </td>
                </tr>
                <tr>
                    <td>Post Code</td>
                    <td> {{ ucwords($address?->postal_post_code) }} </td>
                </tr>

                @if(false)
                <tr>
                    <td>Latitude</td>
                    <td> {{ $address?->postal_latitude ? ucwords($address?->postal_latitude) : 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td>Longitude</td>
                    <td> {{ $address?->postal_longitude ? ucwords($address?->postal_longitude) : 'N/A' }}
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <hr>
        <div class="text-center mt-4">
            <a href="javascript:void(0)" id="addressEdit" class="btn btn-sm btn-warning mb-2 mr-2"><i
                    class="fas fa-edit"></i> Edit </a>
        </div>
    </div>
</div>
