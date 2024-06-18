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
                <div id="loading" style="display: none;">
                    <div class="spinner"></div>
                    Memuat data...
                </div>
                <div id="mapid" style="height: 400px;"></div>
                <div class="info-wrapper">
                    <div class="info-header">
                        <span class="info-icon"><i class="ti-truck"></i></span>
                        <span class="info-text">Your package is on the way.</span>
                    </div>
                    <div class="info-content">
                        <div class="profile">
                            <img src="https://via.placeholder.com/50" alt="Driver's profile picture" class="profile-pic">
                            <div class="profile-details">
                                <span class="profile-name">{{ $suratJalan->driver->name }}</span>
                                <span class="profile-rating">4.7 (256)</span>
                            </div>
                        </div>
                        <div class="delivery-details">
                            <span class="estimated-time">Estimated time: 23 min</span>
                            <span class="service-type">Service: Express</span>
                        </div>
                    </div>
                    <div class="package-photo">
                        <img src="https://via.placeholder.com/150" alt="Package photo" class="package-pic">
                    </div>
                </div>
                <button id="checkpointBtn" class="btn btn-primary">Checkpoint</button>
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

        function updateRoute() {
            if (routingControl) {
                map.removeControl(routingControl);
            }

            var waypoints = [
                L.latLng(senderLatitude, senderLongitude)
            ];

            @if (!empty($suratJalan->checkpoint_latitude))
                @foreach ($suratJalan->checkpoint_latitude as $index => $latitude)
                    waypoints.push(L.latLng({{ $latitude }}, {{ $suratJalan->checkpoint_longitude[$index] }}));
                @endforeach
            @endif

            waypoints.push(L.latLng(receiverLatitude, receiverLongitude));

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

        showLoading();

        map.on('load', function() {
            hideLoading();
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
                        console.log('Checkpoint added successfully');
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
    </script>
@endsection
