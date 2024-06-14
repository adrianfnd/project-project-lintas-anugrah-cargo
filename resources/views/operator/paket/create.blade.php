@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom: 50px">Form Tambah Data Paket</h4>
                    <form id="createForm" action="{{ route('operator.paket.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="senderName">Sender Name</label>
                            <input type="text" class="form-control" id="senderName" name="sender_name"
                                placeholder="Sender Name" value="{{ old('sender_name') }}">
                            @if ($errors->has('sender_name'))
                                <span class="text-danger">{{ $errors->first('sender_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="senderAddress">Sender Address</label>
                            <input type="text" class="form-control" id="senderAddress" name="sender_address"
                                placeholder="Sender Address" value="{{ old('sender_address') }}">
                            @if ($errors->has('sender_address'))
                                <span class="text-danger">{{ $errors->first('sender_address') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="receiverName">Receiver Name</label>
                            <input type="text" class="form-control" id="receiverName" name="receiver_name"
                                placeholder="Receiver Name" value="{{ old('receiver_name') }}">
                            @if ($errors->has('receiver_name'))
                                <span class="text-danger">{{ $errors->first('receiver_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="receiverAddress">Receiver Address</label>
                            <input type="text" class="form-control" id="receiverAddress" name="receiver_address"
                                placeholder="Receiver Address" value="{{ old('receiver_address') }}">
                            @if ($errors->has('receiver_address'))
                                <span class="text-danger">{{ $errors->first('receiver_address') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight</label>
                            <input type="number" class="form-control" id="weight" name="weight" placeholder="Weight"
                                value="{{ old('weight') }}">
                            @if ($errors->has('weight'))
                                <span class="text-danger">{{ $errors->first('weight') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="dimensions">Dimensions</label>
                            <input type="text" class="form-control" id="dimensions" name="dimensions"
                                placeholder="Dimensions" value="{{ old('dimensions') }}">
                            @if ($errors->has('dimensions'))
                                <span class="text-danger">{{ $errors->first('dimensions') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Description" value="{{ old('description') }}">
                            @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="mapid">Sender Region</label>
                            <div class="input-group mb-2">
                                <input type="text" id="sender_searchbox" placeholder="Search sender location"
                                    class="form-control" required value="{{ old('sender') }}">
                                <div class="input-group-append">
                                    <button type="button" id="sender_searchbutton" class="btn btn-primary">Search</button>
                                </div>
                            </div>

                            <label for="mapid">Receiver Region</label>
                            <div class="input-group mb-2">
                                <input type="text" id="receiver_searchbox" placeholder="Search receiver location"
                                    class="form-control" required value="{{ old('receiver') }}">
                                <div class="input-group-append">
                                    <button type="button" id="receiver_searchbutton"
                                        class="btn btn-primary">Search</button>
                                </div>
                            </div>

                            <div id="mapid" style="height: 400px;"></div>

                            <input type="hidden" id="sender" name="sender" required value="{{ old('sender') }}">
                            @error('sender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input type="hidden" id="sender_latitude" name="sender_latitude" required
                                value="{{ old('sender_latitude') }}">
                            @error('sender_latitude')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input type="hidden" id="sender_longitude" name="sender_longitude" required
                                value="{{ old('sender_longitude') }}">
                            @error('sender_longitude')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input type="hidden" id="receiver" name="receiver" required
                                value="{{ old('receiver') }}">
                            @error('receiver')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input type="hidden" id="receiver_latitude" name="receiver_latitude" required
                                value="{{ old('receiver_latitude') }}">
                            @error('receiver_latitude')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input type="hidden" id="receiver_longitude" name="receiver_longitude" required
                                value="{{ old('receiver_longitude') }}">
                            @error('receiver_longitude')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jarak antara Sender dan Receiver:</label>
                            <p id="distance">Silahkan masukan sender dan receiver</p>
                        </div>

                        <style>
                            .leaflet-routing-container {
                                display: none;
                            }
                        </style>

                        <!-- SweetAlert2 -->
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

                        <script>
                            var oldSenderLatitude = "{{ old('sender_latitude') }}";
                            var oldSenderLongitude = "{{ old('sender_longitude') }}";
                            var oldSenderDisplayName = "{{ old('sender') }}";
                            var oldReceiverLatitude = "{{ old('receiver_latitude') }}";
                            var oldReceiverLongitude = "{{ old('receiver_longitude') }}";
                            var oldReceiverDisplayName = "{{ old('receiver') }}";

                            var mapCenter = oldSenderLatitude && oldSenderLongitude ? [oldSenderLatitude, oldSenderLongitude] : [-6.263,
                                106.781
                            ];
                            var mapZoom = oldSenderLatitude && oldSenderLongitude ? 13 : 10;

                            var map = L.map('mapid').setView(mapCenter, mapZoom);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);

                            var senderMarker = L.marker(mapCenter, {
                                draggable: true
                            }).addTo(map);
                            var receiverMarker = L.marker(mapCenter, {
                                draggable: true
                            }).addTo(map);
                            var routingControl = null;

                            if (oldSenderDisplayName) {
                                senderMarker.bindPopup(oldSenderDisplayName).openPopup();
                            }
                            if (oldReceiverDisplayName) {
                                receiverMarker.bindPopup(oldReceiverDisplayName).openPopup();
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

                                    var time = distance / speed;
                                    document.getElementById('distance').innerText = distance.toFixed(2) + ' km (' + time.toFixed(2) + ' jam)';

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

                            if (oldSenderLatitude && oldSenderLongitude && oldReceiverLatitude && oldReceiverLongitude) {
                                calculateDistanceAndTime();
                            }
                        </script>

                        <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a class="btn btn-light" data-toggle="modal"
                                data-target="#cancelConfirmationModal">Cancel</a>
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
                window.location.href = "{{ route('admin.operator.index') }}";
            });
        });
    </script>
@endsection
