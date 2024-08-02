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
                <div class="card-body">
                    <h4 class="card-title">Detail Riwayat Paket</h4>

                    <!-- Informasi Driver -->
                    <div class="col-md-12">
                        <label>Driver</label>
                        <div class="form-group" style="text-align: center;">
                            <div class="image-upload" style="position: relative; display: inline-block; margin-bottom: 10px;">
                                <img src="{{ $riwayatpaket->driver->image ? asset('storage/drivers/' . $riwayatpaket->driver->image) : 'https://via.placeholder.com/200' }}"
                                    alt="Pratinjau Gambar" width="200" height="200"
                                    style="object-fit: cover; border: 3px solid #ccc; border-radius: 8px;">
                            </div>
                            <div style="text-align: center;">
                                <p><strong>Nama:</strong> {{ $riwayatpaket->driver->name ?? '-' }}</p>
                                <p><strong>Nomor HP:</strong> {{ $riwayatpaket->driver->phone_number ?? '-' }}</p>
                                <p><strong>Nama Kendaraan:</strong> {{ $riwayatpaket->driver->vehicle_name ?? '-' }}</p>
                                <p><strong>Nomor Plat Kendaraan:</strong>
                                    {{ $riwayatpaket->driver->license_number ?? '-' }}</p>
                                <p><strong>Alamat:</strong> {{ $riwayatpaket->driver->address ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="table-responsive">
                            <label for="list_paket">List Paket</label>
                            <table class="table table-bordered table-striped" id="paketTable">
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

                    <div class="col-md-12 mt-3">
                        <div class="position-relative mb-4">
                            <div id="loading" style="display: none;">
                                <div class="spinner"></div>
                                Memuat data...
                            </div>
                            <div id="mapid" style="height: 400px;"></div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <label>Informasi Tracking</label>
                            </div>
                            <div class="card-body">
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
                                                <span class="badge bg-success">Paket Sampai</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if ($riwayatpaket->laporan)
                        <div class="col-md-12 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <label>Laporan Masalah</label>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h6><strong>Keluhan:</strong></h6>
                                            <p>{{ $riwayatpaket->laporan->keluhan }}</p>
                                        </div>
                                    </div>
                                    @if ($riwayatpaket->laporan->image)
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <h6><strong>Gambar Laporan:</strong></h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @foreach (json_decode($riwayatpaket->laporan->image, true) as $image)
                                                <div class="col-md-3 col-sm-6 mb-3">
                                                    <a href="{{ asset('storage/laporan/' . $image) }}" target="_blank">
                                                        <div
                                                            style="width: 100%; padding-top: 100%; position: relative; overflow: hidden;">
                                                            <img src="{{ asset('storage/laporan/' . $image) }}"
                                                                alt="Laporan Image"
                                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                                                                class="img-thumbnail">
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-12 mt-3">
                            <div class="alert alert-info">
                                Tidak ada laporan untuk pengiriman ini.
                            </div>
                        </div>
                    @endif

                    <div class="form-group mt-4">
                        <a href="{{ route('operator.riwayat.index') }}" class="btn btn-light">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Leaflet and Leaflet Routing Machine -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

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

        var senderLatitude = "{{ $riwayatpaket->suratJalan->sender_latitude }}";
        var senderLongitude = "{{ $riwayatpaket->suratJalan->sender_longitude }}";
        var receiverLatitude = "{{ $riwayatpaket->suratJalan->receiver_latitude }}";
        var receiverLongitude = "{{ $riwayatpaket->suratJalan->receiver_longitude }}";

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
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=10`)
                .then(response => response.json())
                .then(data => callback(data.display_name))
                .catch(error => console.log('Error:', error));
        }

        function createMarker(lat, lng, label) {
            getAddress(lat, lng, function(address) {
                var markerColor = label === "Checkpoint" ? "green" : "blue";
                var markerIcon = L.icon({
                    iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-${markerColor}.png`,
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                L.marker([lat, lng], {
                    icon: markerIcon
                }).addTo(map).bindPopup(`${label}: ${address}`).openPopup();
            });
        }
        createMarker(senderLatitude, senderLongitude, "Sender");
        createMarker(receiverLatitude, receiverLongitude, "Receiver");

        var routingControl = null;
        var waypoints = [
            L.latLng(senderLatitude, senderLongitude),
            @if (!empty($riwayatpaket->suratJalan->checkpoint_latitude))
                @foreach ($riwayatpaket->suratJalan->checkpoint_latitude as $index => $latitude)
                    L.latLng({{ $latitude }}, {{ $riwayatpaket->suratJalan->checkpoint_longitude[$index] }}),
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
                    var markerColor = label === "Checkpoint" ? "green" : "blue";
                    var markerIcon = L.icon({
                        iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-${markerColor}.png`,
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });

                    getAddress(wp.latLng.lat, wp.latLng.lng, function(address) {
                        L.marker(wp.latLng, {
                            icon: markerIcon
                        }).bindPopup(`${label}: ${address}`).addTo(map);
                    });
                    return L.marker(wp.latLng, {
                        icon: markerIcon
                    });
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

        @if (!empty($riwayatpaket->suratJalan->checkpoint_latitude))
            @foreach ($riwayatpaket->suratJalan->checkpoint_latitude as $index => $latitude)
                createMarker({{ $latitude }}, {{ $riwayatpaket->suratJalan->checkpoint_longitude[$index] }},
                    "Checkpoint");
            @endforeach
        @endif
    </script>

@endsection
