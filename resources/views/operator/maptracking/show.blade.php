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

                        <div class="mt-4">
                            <div class="d-flex flex-column flex-sm-row">
                                <div class="btn-group-vertical btn-group-sm d-sm-flex flex-sm-row mb-2 mb-sm-0">
                                    <a href="{{ route('operator.maptracking.index') }}" class="btn btn-light">Back</a>
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

            function getAddress(lat, lng, callback) {
                fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=10&accept-language=id`
                    )
                    .then(response => response.json())
                    .then(data => callback(data.display_name))
                    .catch(error => console.log('Error:', error));
            }

            function createMarker(lat, lng, label) {
                getAddress(lat, lng, function(address) {
                    L.marker([lat, lng]).addTo(map).bindPopup(`${label}: ${address}`).openPopup();
                });
            }

            createMarker(senderLatitude, senderLongitude, "Sender");
            createMarker(receiverLatitude, receiverLongitude, "Receiver");

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
                    createMarker: function(i, wp, nWps) {
                        var label = i === 0 ? "Sender" : (i === nWps - 1 ? "Receiver" : "Checkpoint");
                        getAddress(wp.latLng.lat, wp.latLng.lng, function(address) {
                            L.marker(wp.latLng).bindPopup(`${label}: ${address}`).addTo(map);
                        });
                        return L.marker(wp.latLng);
                    },
                }).addTo(map);
            }

            var routingControl = null;

            map.whenReady(function() {
                updateRoute();
            });

            @if (!empty($suratJalan->checkpoint_latitude))
                @foreach ($suratJalan->checkpoint_latitude as $index => $latitude)
                    createMarker({{ $latitude }}, {{ $suratJalan->checkpoint_longitude[$index] }}, "Checkpoint");
                @endforeach
            @endif

            setInterval(checkIfReachedDestination, 10000);
            checkIfReachedDestination();
        </script>
    @endsection
