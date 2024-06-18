@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div id="loading" class="loading">Memuat data...</div>
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
                createMarker: function() {
                    return null;
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
