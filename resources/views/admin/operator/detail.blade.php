@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Data Operator</h4>
                    <div class="row">
                        <!-- Map -->
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div id="mapid" style="height: 400px; width: 100%;"></div>
                        </div>
                        <!-- Form -->
                        <div class="col-md-8">
                            <div class="form-sample">
                                <div class="form-group">
                                    <label for="operatorUsername">Username</label>
                                    <p id="operatorUsername">{{ $user->username }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="operatorEmail">Email</label>
                                    <p id="operatorEmail">{{ $user->email }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="operatorName">Nama</label>
                                    <p id="operatorName">{{ $operator->name }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="operatorPhone">Nomor HP</label>
                                    <p id="operatorPhone">{{ $operator->phone_number }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="operatorAddress">Alamat</label>
                                    <p id="operatorAddress">{{ $operator->address }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="operatorRegion">Wilayah</label>
                                    <p id="operatorRegion">{{ $operator->region }}</p>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                                <a href="{{ route('admin.operator.index') }}" class="btn btn-light">Back</a>
                                <a href="{{ route('admin.operator.edit', $operator->id) }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var latitude = "{{ $operator->region_latitude }}";
            var longitude = "{{ $operator->region_longitude }}";
            var displayName = "{{ $operator->region }}";

            var mapCenter = (latitude && longitude) ? [latitude, longitude] : [-6.263, 106.781];
            var mapZoom = (latitude && longitude) ? 13 : 10;

            var map = L.map('mapid').setView(mapCenter, mapZoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var marker = L.marker(mapCenter).addTo(map);

            if (displayName) {
                marker.bindPopup(displayName).openPopup();
            } else {
                marker.bindPopup('Region not available').openPopup();
            }
        });
    </script>
@endsection
