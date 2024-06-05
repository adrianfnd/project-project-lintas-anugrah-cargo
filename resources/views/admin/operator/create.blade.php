@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom: 50px">Form Tambah Data Operator</h4>
                    <form class="forms-sample" method="POST" action="{{ route('admin.operator.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="inputUsername">Username</label>
                            <input type="text" class="form-control" id="inputUsername" name="username"
                                placeholder="Username" value="{{ old('username') }}">
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email"
                                value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input type="password" class="form-control" id="inputPassword" name="password"
                                placeholder="Password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputPasswordConfirmation">Password Confirmation</label>
                            <input type="password" class="form-control" id="inputPasswordConfirmation"
                                name="password_confirmation" placeholder="Password Confirmation">
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputName">Nama</label>
                            <input type="text" class="form-control" id="inputName" name="name" placeholder="Name"
                                value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputPhone">Nomor HP</label>
                            <input type="text" class="form-control" id="inputPhone" name="phone_number"
                                placeholder="Phone Number" value="{{ old('phone_number') }}">
                            @if ($errors->has('phone_number'))
                                <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Alamat</label>
                            <input type="text" class="form-control" id="inputAddress" name="address"
                                placeholder="Address" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="mapid">Region</label>
                            <div class="input-group mb-2">
                                <input type="text" id="searchbox" placeholder="Search location" class="form-control">
                                <div class="input-group-append">
                                    <button type="button" id="searchbutton" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                            <div id="mapid" style="height: 400px;"></div>
                            <input type="hidden" id="region" name="region" required>
                            @error('region')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input type="hidden" id="region_latitude" name="region_latitude" required>
                            @error('region_latitude')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input type="hidden" id="region_longitude" name="region_longitude" required>
                            @error('region_longitude')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('admin.operator.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var map = L.map('mapid').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([51.505, -0.09], {
            draggable: true
        }).addTo(map);

        var searchBox = document.getElementById('searchbox');
        var searchButton = document.getElementById('searchbutton');

        searchButton.addEventListener('click', function() {
            var location = searchBox.value;
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${location}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        var lat = data[0].lat;
                        var lon = data[0].lon;
                        var display_name = data[0].display_name;

                        marker.setLatLng([lat, lon]).addTo(map).bindPopup(display_name).openPopup();

                        map.setView([lat, lon], 13);

                        document.getElementById('region').value = display_name;
                        document.getElementById('region_latitude').value = lat;
                        document.getElementById('region_longitude').value = lon;
                    } else {
                        alert('Location not found');
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        marker.on('dragend', function(event) {
            var marker = event.target;
            var position = marker.getLatLng();
            var lat = position.lat;
            var lon = position.lng;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                    var display_name = data.display_name;

                    document.getElementById('region').value = display_name;
                    document.getElementById('region_latitude').value = lat;
                    document.getElementById('region_longitude').value = lon;

                    marker.bindPopup(display_name).openPopup();
                    searchBox.value = display_name;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
