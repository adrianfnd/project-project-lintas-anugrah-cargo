@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom: 50px">Form Edit Data Paket</h4>
                    <form id="operatorForm" action="{{ route('operator.paket.update', $paket->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <label for="imageUpload" style="cursor: pointer;">
                                    <div class="image-upload"
                                        style="position: relative; display: inline-block; margin-bottom: 10px;">
                                        <input type="file" name="image" id="imageUpload" accept=".png, .jpg, .jpeg"
                                            onchange="previewImage()" style="display: none;">
                                        <img id="imagePreview"
                                            src="{{ $paket->image ? asset('storage/pakets/' . $paket->image) : 'https://via.placeholder.com/200' }}"
                                            alt="Pratinjau Gambar" width="200" height="200"
                                            style="object-fit: cover; border: 3px solid #ccc; border-radius: 8px;">
                                        <span id="uploadText"
                                            style="display: none; position: absolute; bottom: 5px; left: 50%; transform: translateX(-50%); background-color: rgba(255, 255, 255, 0.8); padding: 5px; border-radius: 10px;">Upload</span>
                                    </div>
                                </label>

                                <div>
                                    @if ($errors->has('image'))
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="packetName">Nama Paket</label>
                                    <input type="text" class="form-control" id="packetName" name="packet_name"
                                        placeholder="Nama Paket" value="{{ old('packet_name', $paket->packet_name) }}">
                                    @if ($errors->has('packet_name'))
                                        <span class="text-danger">{{ $errors->first('packet_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="packetType">Jenis Paket</label>
                                    <input type="text" class="form-control" id="packetType" name="packet_type"
                                        placeholder="Jenis Paket" value="{{ old('packet_type', $paket->packet_type) }}">
                                    @if ($errors->has('packet_type'))
                                        <span class="text-danger">{{ $errors->first('packet_type') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="senderName">Nama Pengirim</label>
                                    <input type="text" class="form-control" id="senderName" name="sender_name"
                                        placeholder="Nama Pengirim" value="{{ old('sender_name', $paket->sender_name) }}">
                                    @if ($errors->has('sender_name'))
                                        <span class="text-danger">{{ $errors->first('sender_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="senderAddress">Alamat Pengirim</label>
                                    <input type="text" class="form-control" id="senderAddress" name="sender_address"
                                        placeholder="Alamat Pengirim"
                                        value="{{ old('sender_address', $paket->sender_address) }}">
                                    @if ($errors->has('sender_address'))
                                        <span class="text-danger">{{ $errors->first('sender_address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="senderPhone">No. Telepon Pengirim</label>
                                    <input type="text" class="form-control" id="senderPhone" name="sender_phone"
                                        placeholder="No. Telepon Pengirim"
                                        value="{{ old('sender_phone', $paket->sender_phone) }}">
                                    @if ($errors->has('sender_phone'))
                                        <span class="text-danger">{{ $errors->first('sender_phone') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="receiverName">Nama Penerima</label>
                                    <input type="text" class="form-control" id="receiverName" name="receiver_name"
                                        placeholder="Nama Penerima"
                                        value="{{ old('receiver_name', $paket->receiver_name) }}">
                                    @if ($errors->has('receiver_name'))
                                        <span class="text-danger">{{ $errors->first('receiver_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="receiverAddress">Alamat Penerima</label>
                                    <input type="text" class="form-control" id="receiverAddress" name="receiver_address"
                                        placeholder="Alamat Penerima"
                                        value="{{ old('receiver_address', $paket->receiver_address) }}">
                                    @if ($errors->has('receiver_address'))
                                        <span class="text-danger">{{ $errors->first('receiver_address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="receiverPhone">No. Telepon Penerima</label>
                                    <input type="text" class="form-control" id="receiverPhone" name="receiver_phone"
                                        placeholder="No. Telepon Penerima"
                                        value="{{ old('receiver_phone', $paket->receiver_phone) }}">
                                    @if ($errors->has('receiver_phone'))
                                        <span class="text-danger">{{ $errors->first('receiver_phone') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="weight">Berat (kg)</label>
                                    <input type="number" class="form-control" id="weight" name="weight"
                                        placeholder="10" value="{{ old('weight', $paket->weight) }}">
                                    @if ($errors->has('weight'))
                                        <span class="text-danger">{{ $errors->first('weight') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dimensions">Dimensi (cm)</label>
                                    <input type="text" class="form-control" id="dimensions" name="dimensions"
                                        placeholder="1x1x1" value="{{ old('dimensions', $paket->dimensions) }}">
                                    @if ($errors->has('dimensions'))
                                        <span class="text-danger">{{ $errors->first('dimensions') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <input type="text" class="form-control" id="description" name="description"
                                        placeholder="Deskripsi" value="{{ old('description', $paket->description) }}">
                                    @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sender_searchbox">Wilayah Pengirim</label>
                                    <div class="input-group mb-2">
                                        <input type="text" id="sender_searchbox" name="sender_searchbox"
                                            placeholder="Cari lokasi pengirim" class="form-control" required
                                            value="{{ old('sender_searchbox', $paket->sender_address ?? '') }}">
                                        <div class="input-group-append">
                                            <button type="button" id="sender_searchbutton"
                                                class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                    @error('sender_searchbox')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="receiver_searchbox">Wilayah Penerima</label>
                                    <div class="input-group mb-2">
                                        <input type="text" id="receiver_searchbox" name="receiver_searchbox"
                                            placeholder="Cari lokasi penerima" class="form-control" required
                                            value="{{ old('receiver_searchbox', $paket->receiver_address ?? '') }}">
                                        <div class="input-group-append">
                                            <button type="button" id="receiver_searchbutton"
                                                class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                    @error('receiver_searchbox')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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

                                    <input type="hidden" id="sender" name="sender" required
                                        value="{{ old('sender') }}">
                                    <input type="hidden" id="sender_latitude" name="sender_latitude" required
                                        value="{{ old('sender_latitude', $paket->sender_latitude) }}">
                                    <input type="hidden" id="sender_longitude" name="sender_longitude" required
                                        value="{{ old('sender_longitude', $paket->sender_longitude) }}">
                                    <input type="hidden" id="receiver" name="receiver" required
                                        value="{{ old('receiver') }}">
                                    <input type="hidden" id="receiver_latitude" name="receiver_latitude" required
                                        value="{{ old('receiver_latitude', $paket->receiver_latitude) }}">
                                    <input type="hidden" id="receiver_longitude" name="receiver_longitude" required
                                        value="{{ old('receiver_longitude', $paket->receiver_longitude) }}">
                                </div>

                                <div class="form-group">
                                    <label>Jarak antara Pengirim dan Penerima:</label>
                                    <p id="distance">-</p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <a class="btn btn-light" data-toggle="modal"
                                        data-target="#cancelConfirmationModal">Cancel</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Confirmation Modal -->
    <div class="modal fade" id="submitConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="submitConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitConfirmationModalLabel">Konfirmasi Submit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin melanjutkan?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button id="confirmSubmit" type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div class="modal fade" id="cancelConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="cancelConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelConfirmationModalLabel">Konfirmasi Pembatalan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin membatalkan?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button id="confirmCancel" type="button" class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('operatorForm').addEventListener('submit', function(e) {
                e.preventDefault();
                $('#submitConfirmationModal').modal('show');
            });

            document.querySelector('.btn-light').addEventListener('click', function() {
                $('#cancelConfirmationModal').modal('show');
            });

            document.getElementById('confirmSubmit').addEventListener('click', function() {
                document.getElementById('operatorForm').submit();
            });

            document.getElementById('confirmCancel').addEventListener('click', function() {
                window.location.href = "{{ route('operator.paket.index') }}";
            });
        });
    </script>

    <script>
        function previewImage() {
            var preview = document.getElementById('imagePreview');
            var fileInput = document.getElementById('imageUpload');
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src =
                    "{{ $paket->image ? asset('storage/pakets/' . $paket->image) : 'https://via.placeholder.com/200' }}";
            }
        }

        var imageUpload = document.querySelector('.image-upload');
        var uploadText = document.getElementById('uploadText');

        imageUpload.addEventListener('mouseenter', function() {
            uploadText.style.display = 'block';
        });

        imageUpload.addEventListener('mouseleave', function() {
            uploadText.style.display = 'none';
        });
    </script>

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
        var mapZoom = oldSenderLatitude && oldSenderLongitude ? 13 : 10;

        var map = L.map('mapid').setView(mapCenter, mapZoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var senderMarker = L.marker([oldSenderLatitude, oldSenderLongitude], {
            draggable: true
        }).addTo(map);
        var receiverMarker = L.marker([oldReceiverLatitude, oldReceiverLongitude], {
            draggable: true
        }).addTo(map);
        var routingControl = null;

        var senderSearchBox = document.getElementById('sender_searchbox');
        var senderSearchButton = document.getElementById('sender_searchbutton');
        var receiverSearchBox = document.getElementById('receiver_searchbox');
        var receiverSearchButton = document.getElementById('receiver_searchbutton');

        function updateLocationInfo(lat, lon, display_name, type) {
            if (type === 'sender') {
                document.getElementById('sender').value = display_name;
                document.getElementById('sender_latitude').value = lat;
                document.getElementById('sender_longitude').value = lon;
                senderSearchBox.value = display_name;
            } else if (type === 'receiver') {
                document.getElementById('receiver').value = display_name;
                document.getElementById('receiver_latitude').value = lat;
                document.getElementById('receiver_longitude').value = lon;
                receiverSearchBox.value = display_name;
            }
        }

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
                    routeWhileDragging: true,
                    createMarker: function() {
                        return null;
                    },
                }).addTo(map);
            }
        }

        senderMarker.on('dragend', function(event) {
            var marker = event.target;
            var position = marker.getLatLng();
            var lat = position.lat;
            var lon = position.lng;

            fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&accept-language=id-ID`
                )
                .then(response => response.json())
                .then(data => {
                    var display_name = data.display_name;
                    updateLocationInfo(lat, lon, display_name, 'sender');
                    calculateDistanceAndTime();
                    marker.bindPopup(display_name).openPopup();
                })
                .catch(error => console.error('Error:', error));
        });

        receiverMarker.on('dragend', function(event) {
            var marker = event.target;
            var position = marker.getLatLng();
            var lat = position.lat;
            var lon = position.lng;

            fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&accept-language=id-ID`
                )
                .then(response => response.json())
                .then(data => {
                    var display_name = data.display_name;
                    updateLocationInfo(lat, lon, display_name, 'receiver');
                    calculateDistanceAndTime();
                    marker.bindPopup(display_name).openPopup();
                })
                .catch(error => console.error('Error:', error));
        });

        senderSearchButton.addEventListener('click', function() {
            var location = senderSearchBox.value;
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${location}&accept-language=id-ID`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        var lat = data[0].lat;
                        var lon = data[0].lon;
                        var display_name = data[0].display_name;
                        senderMarker.setLatLng([lat, lon]).addTo(map).bindPopup(display_name).openPopup();
                        map.setView([lat, lon], 13);
                        updateLocationInfo(lat, lon, display_name, 'sender');
                        calculateDistanceAndTime();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lokasi Tidak Ditemukan',
                            text: 'Mohon maaf, lokasi yang anda cari tidak ditemukan.',
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        receiverSearchButton.addEventListener('click', function() {
            var location = receiverSearchBox.value;
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${location}&accept-language=id-ID`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        var lat = data[0].lat;
                        var lon = data[0].lon;
                        var display_name = data[0].display_name;
                        receiverMarker.setLatLng([lat, lon]).addTo(map).bindPopup(display_name).openPopup();
                        map.setView([lat, lon], 13);
                        updateLocationInfo(lat, lon, display_name, 'receiver');
                        calculateDistanceAndTime();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lokasi Tidak Ditemukan',
                            text: 'Mohon maaf, lokasi yang anda cari tidak ditemukan.',
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        if (oldSenderLatitude && oldSenderLongitude) {
            var senderCoords = L.latLng(oldSenderLatitude, oldSenderLongitude);
            fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${oldSenderLatitude}&lon=${oldSenderLongitude}&accept-language=id-ID`
                )
                .then(response => response.json())
                .then(data => {
                    var display_name = data.display_name;
                    senderMarker.setLatLng(senderCoords).addTo(map).bindPopup(display_name).openPopup();
                    updateLocationInfo(oldSenderLatitude, oldSenderLongitude, display_name, 'sender');
                    calculateDistanceAndTime();
                })
                .catch(error => console.error('Error:', error));
        }

        if (oldReceiverLatitude && oldReceiverLongitude) {
            var receiverCoords = L.latLng(oldReceiverLatitude, oldReceiverLongitude);
            fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${oldReceiverLatitude}&lon=${oldReceiverLongitude}&accept-language=id-ID`
                )
                .then(response => response.json())
                .then(data => {
                    var display_name = data.display_name;
                    receiverMarker.setLatLng(receiverCoords).addTo(map).bindPopup(display_name).openPopup();
                    updateLocationInfo(oldReceiverLatitude, oldReceiverLongitude, display_name, 'receiver');
                    calculateDistanceAndTime();
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
