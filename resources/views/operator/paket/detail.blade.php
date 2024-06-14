@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom: 50px">Detail Data Paket</h4>
                    <div class="form-sample">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <div class="image-upload"
                                    style="position: relative; display: inline-block; margin-bottom: 10px;">
                                    <img id="imagePreview"
                                        src="{{ $paket->image ? asset('storage/pakets/' . $paket->image) : 'https://via.placeholder.com/200' }}"
                                        alt="Pratinjau Gambar" width="200" height="200"
                                        style="object-fit: cover; border: 3px solid #ccc; border-radius: 8px;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="packetName">Nama Paket</label>
                                    <p class="form-control-static">{{ $paket->packet_name }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="packetType">Jenis Paket</label>
                                    <p class="form-control-static">{{ $paket->packet_type }}</p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="senderName">Nama Pengirim</label>
                                    <p class="form-control-static">{{ $paket->sender_name }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="senderAddress">Alamat Pengirim</label>
                                    <p class="form-control-static">{{ $paket->sender_address }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="senderPhone">No. Telepon Pengirim</label>
                                    <p class="form-control-static">{{ $paket->sender_phone }}</p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="receiverName">Nama Penerima</label>
                                    <p class="form-control-static">{{ $paket->receiver_name }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="receiverAddress">Alamat Penerima</label>
                                    <p class="form-control-static">{{ $paket->receiver_address }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="receiverPhone">No. Telepon Penerima</label>
                                    <p class="form-control-static">{{ $paket->receiver_phone }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="weight">Berat (kg)</label>
                                    <p class="form-control-static">{{ $paket->weight }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dimensions">Dimensi (cm)</label>
                                    <p class="form-control-static">{{ $paket->dimensions }}</p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <p class="form-control-static">{{ $paket->description }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sender_searchbox">Wilayah Pengirim</label>
                                    <p id="sender_location" class="form-control-static"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="receiver_searchbox">Wilayah Penerima</label>
                                    <p id="receiver_location" class="form-control-static"></p>
                                </div>
                            </div>

                            <style>
                                .leaflet-routing-container {
                                    display: none;
                                }
                            </style>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="mapid" style="height: 400px;" class="mt-4"></div>

                                    <input type="hidden" id="sender_latitude" name="sender_latitude" required
                                        value="{{ $paket->sender_latitude }}">
                                    <input type="hidden" id="sender_longitude" name="sender_longitude" required
                                        value="{{ $paket->sender_longitude }}">
                                    <input type="hidden" id="receiver_latitude" name="receiver_latitude" required
                                        value="{{ $paket->receiver_latitude }}">
                                    <input type="hidden" id="receiver_longitude" name="receiver_longitude" required
                                        value="{{ $paket->receiver_longitude }}">
                                </div>

                                <div class="form-group">
                                    <label>Jarak antara Pengirim dan Penerima:</label>
                                    <p id="distance">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                        <a href="{{ route('operator.paket.index') }}" class="btn btn-light">Back</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

        <script>
            var oldSenderLatitude = "{{ $paket->sender_latitude }}";
            var oldSenderLongitude = "{{ $paket->sender_longitude }}";
            var oldReceiverLatitude = "{{ $paket->receiver_latitude }}";
            var oldReceiverLongitude = "{{ $paket->receiver_longitude }}";

            var mapCenter = oldSenderLatitude && oldSenderLongitude ? [oldSenderLatitude, oldSenderLongitude] : [-6.263,
                106.781
            ];
            var mapZoom = oldSenderLatitude && oldSenderLongitude ? 7 : 7;

            var map = L.map('mapid').setView(mapCenter, mapZoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var senderMarker = L.marker([oldSenderLatitude, oldSenderLongitude]).addTo(map);
            var receiverMarker = L.marker([oldReceiverLatitude, oldReceiverLongitude]).addTo(map);
            var routingControl = null;

            function calculateDistanceAndTime() {
                var senderLat = parseFloat(document.getElementById('sender_latitude').value);
                var senderLon = parseFloat(document.getElementById('sender_longitude').value);
                var receiverLat = parseFloat(document.getElementById('receiver_latitude').value);
                var receiverLon = parseFloat(document.getElementById('receiver_longitude').value);

                if (!isNaN(senderLat) && !isNaN(senderLon) && !isNaN(receiverLat) && !isNaN(receiverLon)) {
                    var from = L.latLng(senderLat, senderLon);
                    var to = L.latLng(receiverLat, receiverLon);
                    var distance = from.distanceTo(to) / 1000;
                    var speed = 40;

                    var timeInHours = distance / speed;
                    var hours = Math.floor(timeInHours);
                    var minutes = Math.round((timeInHours - hours) * 60);

                    var formattedTime;
                    if (minutes === 60) {
                        hours++;
                        minutes = 0;
                    }

                    if (hours > 0 && minutes > 0) {
                        formattedTime = hours + ' jam ' + minutes + ' menit';
                    } else if (hours > 0) {
                        formattedTime = hours + ' jam';
                    } else {
                        formattedTime = minutes + ' menit';
                    }

                    document.getElementById('distance').innerText = distance.toFixed(2) + ' km ( estimasi waktu : ' +
                        formattedTime + ')';

                    if (routingControl) {
                        map.removeControl(routingControl);
                    }

                    routingControl = L.Routing.control({
                        waypoints: [from, to],
                        routeWhileDragging: false,
                        createMarker: function() {
                            return null;
                        },
                    }).addTo(map);
                }
            }

            fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${oldSenderLatitude}&lon=${oldSenderLongitude}&accept-language=id-ID`
                )
                .then(response => response.json())
                .then(data => {
                    var senderLocation = data.display_name;
                    document.getElementById('sender_location').innerText = senderLocation;
                })
                .catch(error => console.error('Error fetching sender location:', error));

            fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${oldReceiverLatitude}&lon=${oldReceiverLongitude}&accept-language=id-ID`
                )
                .then(response => response.json())
                .then(data => {
                    var receiverLocation = data.display_name;
                    document.getElementById('receiver_location').innerText = receiverLocation;
                })
                .catch(error => console.error('Error fetching receiver location:', error));

            calculateDistanceAndTime();
        </script>
    @endsection
