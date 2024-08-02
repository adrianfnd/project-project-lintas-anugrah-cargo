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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <i class="ti-truck mr-2"></i>
                        <span>Paket sedang dalam perjalanan...</span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $suratJalan->driver->image ? asset('storage/drivers/' . $suratJalan->driver->image) : 'https://via.placeholder.com/50' }}"
                                        alt="Driver's profile picture" class="rounded-circle mr-3"
                                        style="object-fit: cover; width: 75px; height: 75px;">
                                    <div>
                                        <h5 class="mb-0">{{ $suratJalan->driver->name }}</h5>
                                        <div class="text-muted">
                                            @if (is_null($suratJalan->driver->rate))
                                                <span>Rating Belum Tersedia</span>
                                            @else
                                                @for ($i = 0; $i < $suratJalan->driver->rate; $i++)
                                                    <i class="fas fa-star text-warning"></i>
                                                @endfor
                                                @for ($i = $suratJalan->driver->rate; $i < 5; $i++)
                                                    <i class="far fa-star text-warning"></i>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                    <p class="mb-2 text-muted">Estimasi waktu pengiriman</p>
                                    <h3 class="mb-0 font-weight-bold">
                                        @php
                                            $hours = floor($suratJalan->estimated_delivery_time);
                                            $minutes = round(($suratJalan->estimated_delivery_time - $hours) * 60);
                                            echo $hours . ' jam ' . $minutes . ' menit';
                                        @endphp
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <div class="position-relative mb-4">
                            <div id="loading" style="display: none;">
                                <div class="spinner"></div>
                                Memuat data...
                            </div>
                            <div id="mapid" style="height: 400px;"></div>
                        </div>

                        <div class="table-responsive">
                            <h5>List Paket</h5>
                            <table class="table table-bordered table-striped" id="paketTable">
                                <thead class="table-primary">
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

                        <div class="mt-5">
                            <h5 class="mb-4">Informasi Tracking</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($suratJalanInfos as $info)
                                    <li class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $info->information }}</h6>
                                            <small class="text-muted">
                                                <i class="far fa-clock"></i>
                                                {{ $info->checkpoint_time }}
                                            </small>
                                        </div>
                                        <p class="mb-1 location-info" data-lat="{{ $info->latitude }}"
                                            data-lon="{{ $info->longitude }}">
                                            <i class="fas fa-spinner fa-spin"></i> Memuat lokasi...
                                        </p>
                                        @if ($loop->first)
                                            <span class="badge bg-success">Lokasi Terkini</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div id="complaintForm" class="mt-4" style="display: none;">
                            <h5>Keluhan</h5>
                            <form id="finishForm" action="{{ route('driver.maptracking.finish', $suratJalan->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="keluhan" class="form-label">Keluhan:</label>
                                    <textarea id="keluhan" name="keluhan" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="images" class="form-label">Upload Images:</label>
                                    <input type="file" id="images" name="images[]" class="form-control" multiple>
                                </div>
                            </form>
                        </div>

                        <div class="mt-4">
                            <div class="d-flex flex-column flex-sm-row">
                                <div class="btn-group-vertical btn-group-sm d-sm-flex flex-sm-row mb-2 mb-sm-0">
                                    <button id="checkpointBtn" class="btn btn-primary mr-2 mb-2 mb-sm-0 me-sm-2"
                                        style="border-radius: 50rem; padding: 8px 20px;">Checkpoint</button>
                                    <button id="finishBtn" class="btn btn-success mr-2 mb-2 mb-sm-0 me-sm-2"
                                        style="border-radius: 50rem; padding: 8px 20px;" onclick="submitFinishForm()"
                                        style="display: none;">Finish</button>
                                    <button id="cancelBtn" class="btn btn-light mb-2 mb-sm-0 me-sm-2"
                                        style="border-radius: 50rem; padding: 8px 20px;"
                                        onclick="cancelDelivery()">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
        function getLocationName(lat, lon, element) {
            fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=10&accept-language=id`
                )
                .then(response => response.json())
                .then(data => {
                    if (data.display_name) {
                        element.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${data.display_name}`;
                    } else {
                        element.innerHTML = `<i class="fas fa-map-marker-alt"></i> Lokasi tidak ditemukan`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    element.innerHTML = `<i class="fas fa-exclamation-triangle"></i> Gagal memuat lokasi`;
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const locationInfos = document.querySelectorAll('.location-info');
            locationInfos.forEach(info => {
                const lat = info.dataset.lat;
                const lon = info.dataset.lon;
                getLocationName(lat, lon, info);
            });
        });

        var senderLatitude = "{{ $suratJalan->sender_latitude }}";
        var senderLongitude = "{{ $suratJalan->sender_longitude }}";
        var receiverLatitude = "{{ $suratJalan->receiver_latitude }}";
        var receiverLongitude = "{{ $suratJalan->receiver_longitude }}";

        var mapCenter = senderLatitude && senderLongitude ? [senderLatitude, senderLongitude] : [-6.263, 106.781];
        var mapZoom = senderLatitude && senderLongitude ? 7 : 7;

        var map = L.map('mapid', {
            dragging: true,
            touchZoom: true,
            doubleClickZoom: true,
            scrollWheelZoom: true,
            boxZoom: true,
            zoomControl: true
        }).setView(mapCenter, mapZoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var senderMarker = L.marker([senderLatitude, senderLongitude]).addTo(map);
        var receiverMarker = L.marker([receiverLatitude, receiverLongitude]).addTo(map);

        var greenCheckpointIcon = L.icon({
            iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var redCheckpointIcon = L.icon({
            iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        @foreach ($checkpoints as $checkpoint)
            L.marker([{{ $checkpoint->latitude }}, {{ $checkpoint->longitude }}], {
                    icon: greenCheckpointIcon
                })
                .addTo(map)
                .bindPopup("Checkpoint: {{ $checkpoint->address }}");
        @endforeach

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
                addWaypoints: false,
                draggableWaypoints: false,
                routeWhileDragging: false,
                createMarker: function(i, wp, nWps) {
                    if (i === 0) {
                        return L.marker(wp.latLng).bindPopup("Sender");
                    } else if (i === nWps - 1) {
                        return L.marker(wp.latLng).bindPopup("Receiver");
                    } else {
                        return L.marker(wp.latLng, {
                            icon: redCheckpointIcon
                        }).bindPopup("Checkpoint");
                    }
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

                var checkpoint = L.marker([latitude, longitude], {
                    icon: redCheckpointIcon
                }).addTo(map);

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
                        }).then((result) => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON.message,
                        });
                        hideLoading();
                    }
                });
            }, function(error) {
                console.error('Error saat mendapatkan lokasi:', error);
                hideLoading();
            });
        });

        @if (!empty($suratJalan->checkpoint_latitude))
            @foreach ($suratJalan->checkpoint_latitude as $index => $latitude)
                L.marker([{{ $latitude }}, {{ $suratJalan->checkpoint_longitude[$index] }}], {
                    icon: redCheckpointIcon
                }).addTo(map);
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
                        document.getElementById('cancelBtn').style.display = 'none';
                        document.getElementById('finishBtn').style.display = 'block';
                        document.getElementById('complaintForm').style.display = 'block';
                    } else {
                        document.getElementById('checkpointBtn').style.display = 'block';
                        document.getElementById('cancelBtn').style.display = 'block';
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

        function cancelDelivery() {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                $.ajax({
                    url: "{{ route('driver.maptracking.cancel', $suratJalan->id) }}",
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
                            text: 'Pengiriman berhasil dibatalkan',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href =
                                    "{{ route('driver.suratjalan.index') }}";
                            }
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON.message,
                        });
                    }
                });
            });
        }

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
                        text: 'Anda tidak berada didalam radius penerima',
                    });
                }
            }, function(error) {
                console.error('Error getting location:', error);
            });
        }
    </script>
@endsection
