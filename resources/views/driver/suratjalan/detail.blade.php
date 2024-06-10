@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Surat Jalan</h4>
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Pic or loc</label>
                                    {{-- <img src="{{ $suratjalan->image ? asset('storage/drivers/' . $suratjalan->image) : 'https://via.placeholder.com/250' }}" 
                                        style="border-radius: 50%; object-fit: cover; border: 3px solid #ccc; width: 250px; height: 250px;"> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-sample">
                                <div class="form-group">
                                    <label for="driverId">Driver ID</label>
                                    <p id="driverId">{{-- {{ $suratjalan->driver_id }} --}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="paketId">Paket ID</label>
                                    <p id="paketId">{{-- {{ $suratjalan->paket_id }} --}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <p id="status">{{-- {{ $suratjalan->status }} --}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <p id="latitude">{{-- {{ $suratjalan->latitude }} --}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <p id="longitude">{{-- {{ $suratjalan->longitude }} --}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <div id="mapid" style="height: 400px;"></div>
                                    <input type="hidden" id="latitude" name="latitude" value="{{-- {{ $suratjalan->latitude }} --}}">
                                    <input type="hidden" id="longitude" name="longitude" value="{{-- {{ $suratjalan->longitude }} --}}">
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                                <a href="{{ route('driver.suratjalan.index') }}" class="btn btn-light">Back</a>
                                <a href="#" class="btn btn-primary">Between Packages</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        var latitude = parseFloat(document.getElementById('latitude').value);
        var longitude = parseFloat(document.getElementById('longitude').value);

        var mymap = L.map('mapid').setView([latitude, longitude], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mymap);

        var marker = L.marker([latitude, longitude]).addTo(mymap);
    </script>
@endsection
