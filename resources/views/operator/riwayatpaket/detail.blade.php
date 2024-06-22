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

                    <!-- List Paket -->
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

                    <!-- Map -->
                    <h5>Rute Pengiriman</h5>
                    <div class="position-relative mb-4">
                        <div id="loading" style="display: none;">
                            <div class="spinner"></div>
                            Memuat data...
                        </div>
                        <div id="mapid" style="height: 400px;"></div>
                    </div>

                    <!-- Laporan -->
                    <h5>Laporan</h5>
                    @if ($riwayatpaket->laporan)
                        <p><strong>Keluhan:</strong> {{ $riwayatpaket->laporan->keluhan }}</p>
                        @if ($riwayatpaket->laporan->image)
                            <h6>Gambar Laporan:</h6>
                            <div class="row">
                                @foreach (json_decode($riwayatpaket->laporan->image, true) as $image)
                                    <div class="col-md-3 mb-3">
                                        <img src="{{ asset('storage/laporan/' . $image) }}" alt="Laporan Image"
                                            class="img-fluid">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <p>Tidak ada laporan untuk pengiriman ini.</p>
                    @endif

                    <div class="form-group mt-4">
                        <a href="{{ route('operator.riwayat.index') }}" class="btn btn-light">Kembali</a>
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

        var senderMarker = L.marker([senderLatitude, senderLongitude]).addTo(map);
        var receiverMarker = L.marker([receiverLatitude, receiverLongitude]).addTo(map);

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

        @if (!empty($riwayatpaket->suratJalan->checkpoint_latitude))
            @foreach ($riwayatpaket->suratJalan->checkpoint_latitude as $index => $latitude)
                L.marker([{{ $latitude }}, {{ $riwayatpaket->suratJalan->checkpoint_longitude[$index] }}]).addTo(map);
            @endforeach
            updateRoute();
        @endif
    </script>
@endsection
