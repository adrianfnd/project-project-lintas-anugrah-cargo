@extends('layouts.main')

@section('content')
    {{-- SIDEBAR --}}
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.admin') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">List Data</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('operator.index') }}">Operator</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('driver.index') }}">Driver</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
    {{-- AKHIR SIDEBAR --}}

    {{-- FORM --}}
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Data Operator</h4>
                        <form class="forms-sample" method="POST" action="{{ route('operator.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="Username">Username</label>
                                <input type="text" class="form-control" id="Username" placeholder="Username"
                                    name="username" required>
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" class="form-control" id="Email" placeholder="Email" name="email"
                                    required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Password">Password</label>
                                <input type="password" class="form-control" id="Password" placeholder="Password"
                                    name="password" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Nama">Nama</label>
                                <input type="text" class="form-control" id="Nama" placeholder="Nama" name="nama"
                                    required>
                                @error('nama')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Nomor HP">Nomor HP</label>
                                <input type="phone" class="form-control" id="Nomor HP" placeholder="Nomor HP"
                                    name="nomor_hp" required>
                                @error('nomor_hp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Alamat">Alamat</label>
                                <input type="text" class="form-control" id="Alamat" placeholder="Alamat"
                                    name="alamat" required>
                                @error('alamat')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="mapid">Region</label>
                                <input type="text" id="searchbox" placeholder="Search location"
                                    class="form-control mb-2">
                                <button type="button" id="searchbutton" class="btn btn-primary mb-2">Search</button>
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
                            <a href="{{ route('operator.index') }}" class="btn btn-light">Cancel</a>
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

                            L.marker([lat, lon]).addTo(map)
                                .bindPopup(display_name)
                                .openPopup();

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
        </script>
        {{-- AKHIR FORM --}}
    @endsection
