@extends('layouts.main')

@section('content')
    <style>
        .leaflet-routing-container {
            display: none;
        }

        #loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-size: 16px;
            color: #333;
        }

        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border-left-color: #333;
            animation: spin 1s ease infinite;
            margin: 0 auto 10px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="info-header">
                    <span class="info-icon"><i class="ti-truck"></i></span>
                    <span class="info-text">Paket sedang dalam perjalanan...</span>
                </div>
                <div class="info-wrapper">
                    <div class="info-content">
                        <div class="profile">
                            <img src="{{ $suratJalan->driver->image ? asset('storage/drivers/' . $suratJalan->driver->image) : 'https://via.placeholder.com/50' }}"
                                alt="Driver's profile picture" class="profile-pic rounded-circle"
                                style="object-fit: cover; width: 75px; height: 75px;">
                            <div class="profile-details">
                                <span class="profile-name">{{ $suratJalan->driver->name }}</span>
                                <span class="profile-rating">
                                    @if (is_null($suratJalan->driver->rate))
                                        <span>Rating Belum Tersedia</span>
                                    @else
                                        @for ($i = 0; $i < $suratJalan->driver->rate; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @for ($i = $suratJalan->driver->rate; $i < 5; $i++)
                                            <i class="far fa-star"></i>
                                        @endfor
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="delivery-details">
                            <span class="estimated-time">Estimated time: 23 min</span>
                            <span class="service-type">Service: Express</span>
                        </div>
                    </div>
                    <div id="loading"
                        style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000; background-color: rgba(255, 255, 255, 0.8); padding: 20px; border-radius: 8px; text-align: center; font-size: 16px; color: #333;">
                        <div class="spinner"
                            style="border: 4px solid rgba(0, 0, 0, 0.1); width: 36px; height: 36px; border-radius: 50%; border-left-color: #333; animation: spin 1s ease infinite; margin: 0 auto 10px;">
                        </div>
                        Memuat data...
                    </div>
                    <div id="mapid" style="height: 400px;"></div>
                    <div class="package-list">
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <label for="list_paket">List Paket</label>
                                    <table class="table table-bordered" id="paketTable">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Paket</th>
                                                <th>Jenis Paket</th>
                                                <th>Pengirim</th>
                                                <th>Penerima</th>
                                                <th>Berat (kg)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_paket as $index => $paket)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $paket['packet_name'] }}</td>
                                                    <td>{{ $paket['packet_type'] }}</td>
                                                    <td>{{ $paket['sender_name'] }}</td>
                                                    <td>{{ $paket['receiver_name'] }}</td>
                                                    <td>{{ $paket['weight'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="complaintForm">
                        <form id="finishForm" action="{{ route('driver.maptracking.finish', $suratJalan->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="keluhan">Keluhan:</label>
                            <textarea id="keluhan" name="keluhan" class="form-control"></textarea>
                            <label for="images">Upload Images:</label>
                            <input type="file" id="images" name="images[]" class="form-control" multiple>
                        </form>
                    </div>
                    <button id="checkpointBtn" class="btn btn-primary" style="display: none;">Checkpoint</button>
                    <button id="finishBtn" class="btn btn-success" onclick="submitFinishForm()"
                        style="display: none;">Finish</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Leaflet and Leaflet Routing Machine -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function submitFinishForm() {
            radius = 0.001;

            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                var distance = getDistanceFromLatLonInKm(latitude, longitude, receiverLatitude, receiverLongitude);
                if (distance < radius) {
                    document.getElementById('finishForm').submit();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Anda tidak berada dalam radius penerima',
                    });
                }
            }, function(error) {
                console.error('Error getting location:', error);
            });
        }
    </script>

    <script>
        var senderLatitude = "{{ $suratJalan->sender_latitude }}";
        var senderLongitude = "{{ $suratJalan->sender_longitude }}";
        var receiverLatitude = "{{ $suratJalan->receiver_latitude }}";
        var receiverLongitude = "{{ $suratJalan->receiver_longitude }}";

        var mapCenter = senderLatitude && senderLongitude ? [senderLatitude, senderLongitude] : [-6.263, 106.781];
        var mapZoom = senderLatitude && senderLongitude ? 7 : 7;

        var map = L.map('mapid').setView(mapCenter, mapZoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var senderMarker = L.marker([senderLatitude, senderLongitude]).addTo(map);
        var receiverMarker = L.marker([receiverLatitude, receiverLongitude]).addTo(map);

        var routingControl = null;
        var waypoints = [
            L.latLng(senderLatitude, senderLongitude),
            @if (!empty($suratJalan->checkpoint_latitude))
                @foreach ($suratJalan->checkpoint_latitude as $index => $latitude)
                    L.latLng({{ $latitude }}, {{ $suratJalan->checkpoint_longitude[$index] }}),
                @endforeach
            @endif
            L.latLng(receiverLatitude, receiverLongitude)
        ];

        function updateRoute() {
            if (routingControl) {
                map.removeControl(routingControl);
            }

            routingControl = L.Routing.control({
                waypoints: waypoints,
                routeWhileDragging: false,
                createMarker: function(i, wp, nWps) {
                    return L.marker(wp.latLng).bindPopup(i === 0 ? "Sender" : (i === nWps - 1 ? "Receiver" :
                        "Checkpoint"));
                },
            }).addTo(map);
        }

        var checkpointBtn = document.getElementById('checkpointBtn');
        var loadingElement = document.getElementById('loading');

        function showLoading() {
            loadingElement.style.display = 'block';
        }

        function hideLoading() {
            loadingElement.style.display = 'none';
        }

        map.whenReady(function() {
            hideLoading();
            updateRoute();
        });

        checkpointBtn.addEventListener('click', function() {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                var checkpoint = L.marker([latitude, longitude]).addTo(map);

                showLoading();

                $.ajax({
                    url: "{{ route('driver.maptracking.addcheckpoint', $suratJalan->id) }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        latitude: latitude,
                        longitude: longitude
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Checkpoint berhasil ditambahkan',
                        });
                        waypoints.splice(waypoints.length - 1, 0, L.latLng(latitude,
                            longitude));
                        updateRoute();
                        hideLoading();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menambahkan checkpoint',
                        });
                        console.error('Error adding checkpoint', xhr);
                        hideLoading();
                    }
                });
            }, function(error) {
                console.error('Error getting location:', error);
                hideLoading();
            });
        });

        @if (!empty($suratJalan->checkpoint_latitude))
            @foreach ($suratJalan->checkpoint_latitude as $index => $latitude)
                L.marker([{{ $latitude }}, {{ $suratJalan->checkpoint_longitude[$index] }}]).addTo(map);
            @endforeach
            updateRoute();
        @endif

        function checkIfReachedDestination() {
            var receiverLatitude = {{ $suratJalan->receiver_latitude }};
            var receiverLongitude = {{ $suratJalan->receiver_longitude }};
            var radius = 0.001;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    var distance = getDistanceFromLatLonInKm(latitude, longitude, receiverLatitude,
                        receiverLongitude);
                    if (distance < radius) {
                        document.getElementById('checkpointBtn').style.display = 'none';
                        document.getElementById('finishBtn').style.display = 'block';
                        document.getElementById('complaintForm').style.display = 'block';
                    } else {
                        document.getElementById('checkpointBtn').style.display = 'block';
                        document.getElementById('finishBtn').style.display = 'none';
                        document.getElementById('complaintForm').style.display = 'none';
                    }
                });
            }
        }

        function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
            var R = 6371;
            var dLat = deg2rad(lat2 - lat1);
            var dLon = deg2rad(lon2 - lon1);
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var d = R * c;
            return d;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        setInterval(checkIfReachedDestination, 10000);
        checkIfReachedDestination();
    </script>
@endsection
