@extends('layouts.main')

@section('content')
    <style>
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


        .leaflet-routing-container {
            display: none;
        }
    </style>

    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom: 50px">Form Tambah Data Paket</h4>
                    <form id="operatorForm" action="{{ route('operator.paket.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <label for="imageUpload" style="cursor: pointer;">
                                    <div class="image-upload"
                                        style="position: relative; display: inline-block; margin-bottom: 10px;">
                                        <input type="file" name="image" id="imageUpload" accept=".png, .jpg, .jpeg"
                                            onchange="previewImage()" style="display: none;">
                                        <img id="imagePreview" src="https://via.placeholder.com/200" alt="Pratinjau Gambar"
                                            width="200" height="200"
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
                                        placeholder="Nama Paket" value="{{ old('packet_name') }}">
                                    @if ($errors->has('packet_name'))
                                        <span class="text-danger">{{ $errors->first('packet_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="packetType">Jenis Paket</label>
                                    <input type="text" class="form-control" id="packetType" name="packet_type"
                                        placeholder="Jenis Paket" value="{{ old('packet_type') }}">
                                    @if ($errors->has('packet_type'))
                                        <span class="text-danger">{{ $errors->first('packet_type') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="senderName">Nama Pengirim</label>
                                    <input type="text" class="form-control" id="senderName" name="sender_name"
                                        placeholder="Nama Pengirim" value="{{ old('sender_name') }}">
                                    @if ($errors->has('sender_name'))
                                        <span class="text-danger">{{ $errors->first('sender_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="senderAddress">Alamat Pengirim</label>
                                    <input type="text" class="form-control" id="senderAddress" name="sender_address"
                                        placeholder="Alamat Pengirim" value="{{ old('sender_address') }}">
                                    @if ($errors->has('sender_address'))
                                        <span class="text-danger">{{ $errors->first('sender_address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="senderPhone">Nomor Telepon Pengirim</label>
                                    <input type="text" class="form-control" id="senderPhone" name="sender_phone"
                                        placeholder="Nomor Telepon Pengirim" value="{{ old('sender_phone') }}">
                                    @if ($errors->has('sender_phone'))
                                        <span class="text-danger">{{ $errors->first('sender_phone') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="receiverName">Nama Penerima</label>
                                    <input type="text" class="form-control" id="receiverName" name="receiver_name"
                                        placeholder="Nama Penerima" value="{{ old('receiver_name') }}">
                                    @if ($errors->has('receiver_name'))
                                        <span class="text-danger">{{ $errors->first('receiver_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="receiverAddress">Alamat Penerima</label>
                                    <input type="text" class="form-control" id="receiverAddress" name="receiver_address"
                                        placeholder="Alamat Penerima" value="{{ old('receiver_address') }}">
                                    @if ($errors->has('receiver_address'))
                                        <span class="text-danger">{{ $errors->first('receiver_address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="receiverPhone">Nomor Telepon Penerima</label>
                                    <input type="text" class="form-control" id="receiverPhone" name="receiver_phone"
                                        placeholder="Nomor Telepon Penerima" value="{{ old('receiver_phone') }}">
                                    @if ($errors->has('receiver_phone'))
                                        <span class="text-danger">{{ $errors->first('receiver_phone') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="weight">Berat (kg)</label>
                                    <input type="number" class="form-control" id="weight" name="weight"
                                        placeholder="10" value="{{ old('weight') }}">
                                    @if ($errors->has('weight'))
                                        <span class="text-danger">{{ $errors->first('weight') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dimensions">Dimensi (cm)</label>
                                    <input type="text" class="form-control" id="dimensions" name="dimensions"
                                        placeholder="1x1x1" value="{{ old('dimensions') }}">
                                    @if ($errors->has('dimensions'))
                                        <span class="text-danger">{{ $errors->first('dimensions') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <input type="text" class="form-control" id="description" name="description"
                                        placeholder="Deskripsi" value="{{ old('description') }}">
                                    @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mapid">Wilayah Pengirim</label>
                                    <div class="input-group mb-2">
                                        <input type="text" id="sender_searchbox" placeholder="Cari lokasi pengirim"
                                            class="form-control" required value="{{ old('sender') }}">
                                        <div class="input-group-append">
                                            <button type="button" id="sender_searchbutton"
                                                class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                    @error('sender')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mapid">Wilayah Penerima</label>
                                    <div class="input-group mb-2">
                                        <input type="text" id="receiver_searchbox" placeholder="Cari lokasi penerima"
                                            class="form-control" required value="{{ old('receiver') }}">
                                        <div class="input-group-append">
                                            <button type="button" id="receiver_searchbutton"
                                                class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                    @error('receiver')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="loading" style="display: none;">
                                        <div class="spinner"></div>
                                        Memuat peta...
                                    </div>
                                    <div id="mapid" style="height: 500px;"></div>

                                    <input type="hidden" id="sender" name="sender" required
                                        value="{{ old('sender') }}">
                                    <input type="hidden" id="sender_latitude" name="sender_latitude" required
                                        value="{{ old('sender_latitude') }}">
                                    <input type="hidden" id="sender_longitude" name="sender_longitude" required
                                        value="{{ old('sender_longitude') }}">
                                    <input type="hidden" id="receiver" name="receiver" required
                                        value="{{ old('receiver') }}">
                                    <input type="hidden" id="receiver_latitude" name="receiver_latitude" required
                                        value="{{ old('receiver_latitude') }}">
                                    <input type="hidden" id="receiver_longitude" name="receiver_longitude" required
                                        value="{{ old('receiver_longitude') }}">
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
                preview.src = "https://via.placeholder.com/150";
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
        var senderLatitude = "{{ old('sender_latitude') }}";
        var senderLongitude = "{{ old('sender_longitude') }}";
        var senderDisplayName = "{{ old('sender') }}";
        var receiverLatitude = "{{ old('receiver_latitude') }}";
        var receiverLongitude = "{{ old('receiver_longitude') }}";
        var receiverDisplayName = "{{ old('receiver') }}";

        var mapCenter = senderLatitude && senderLongitude ? [senderLatitude, senderLongitude] : [-6.263, 106.781];
        var mapZoom = senderLatitude && senderLongitude ? 7 : 7;

        var loadingElement = document.getElementById('loading');
        loadingElement.style.display = 'block';

        var map = L.map('mapid').setView(mapCenter, mapZoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map).on('load', function() {
            loadingElement.style.display = 'none';
        });

        var senderMarker = L.marker(mapCenter, {
            draggable: true
        }).addTo(map);
        var receiverMarker = L.marker(mapCenter, {
            draggable: true
        }).addTo(map);
        var routingControl = null;

        if (senderDisplayName) {
            senderMarker.bindPopup(senderDisplayName).openPopup();
        }
        if (receiverDisplayName) {
            receiverMarker.bindPopup(receiverDisplayName).openPopup();
        }

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

        senderSearchButton.addEventListener('click', function() {
            var location = senderSearchBox.value;
            loadingElement.style.display = 'block';
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${location}&accept-language=id-ID`)
                .then(response => response.json())
                .then(data => {
                    loadingElement.style.display = 'none';
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
                .catch(error => {
                    loadingElement.style.display = 'none';
                    console.error('Error:', error);
                });
        });

        receiverSearchButton.addEventListener('click', function() {
            var location = receiverSearchBox.value;
            loadingElement.style.display = 'block';
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${location}&accept-language=id-ID`)
                .then(response => response.json())
                .then(data => {
                    loadingElement.style.display = 'none';
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
                .catch(error => {
                    loadingElement.style.display = 'none';
                    console.error('Error:', error);
                });
        });

        senderMarker.on('dragend', function(event) {
            var marker = event.target;
            var position = marker.getLatLng();
            var lat = position.lat;
            var lon = position.lng;

            loadingElement.style.display = 'block';
            fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&accept-language=id-ID`
                )
                .then(response => response.json())
                .then(data => {
                    loadingElement.style.display = 'none';
                    var display_name = data.display_name;
                    updateLocationInfo(lat, lon, display_name, 'sender');
                    calculateDistanceAndTime();
                    marker.bindPopup(display_name).openPopup();
                })
                .catch(error => {
                    loadingElement.style.display = 'none';
                    console.error('Error:', error);
                });
        });

        receiverMarker.on('dragend', function(event) {
            var marker = event.target;
            var position = marker.getLatLng();
            var lat = position.lat;
            var lon = position.lng;

            loadingElement.style.display = 'block';
            fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&accept-language=id-ID`
                )
                .then(response => response.json())
                .then(data => {
                    loadingElement.style.display = 'none';
                    var display_name = data.display_name;
                    updateLocationInfo(lat, lon, display_name, 'receiver');
                    calculateDistanceAndTime();
                    marker.bindPopup(display_name).openPopup();
                })
                .catch(error => {
                    loadingElement.style.display = 'none';
                    console.error('Error:', error);
                });
        });

        if (senderLatitude && senderLongitude && receiverLatitude && receiverLongitude) {
            calculateDistanceAndTime();
        }
    </script>
@endsection
