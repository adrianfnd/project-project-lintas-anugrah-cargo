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
                    <h4 class="card-title" style="margin-bottom: 50px">Form Tambah Surat Jalan</h4>
                    <form id="operatorForm" action="{{ route('operator.suratjalan.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="driver">Driver</label>
                                <div class="form-group" style="text-align: center;">
                                    <div class="image-upload"
                                        style="position: relative; display: inline-block; margin-bottom: 10px;">
                                        <img id="driverImagePreview" src="https://via.placeholder.com/200"
                                            alt="Pratinjau Gambar" width="200" height="200"
                                            style="object-fit: cover; border: 3px solid #ccc; border-radius: 8px;">
                                    </div>
                                    <div style="text-align: center;">
                                        <p id="driverName"><strong>Name:</strong></p>
                                        <p id="driverPhone"><strong>Nomor HP:</strong></p>
                                        <p id="driverVehicle"><strong>Nama Kendaraan:</strong></p>
                                        <p id="driverPlate"><strong>Nomor Plat Kendaraan:</strong></p>
                                        <p id="driverAddress"><strong>Alamat:</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="driverSelect">Cari Driver</label>
                                    <select id="driverSelect" name="driver" class="form-control">
                                        <option value="">Pilih Driver</option>
                                        @foreach ($drivers as $driver)
                                            <option name="driver" value="{{ $driver->id }}"
                                                data-name="{{ $driver->name }}" data-phone="{{ $driver->phone_number }}"
                                                data-vehicle="{{ $driver->vehicle_name }}"
                                                data-plate="{{ $driver->license_number }}"
                                                data-address="{{ $driver->address }}"
                                                data-latitude="{{ $driver->latitude }}"
                                                data-longitude="{{ $driver->longitude }}"
                                                data-image="{{ asset('storage/drivers/' . $driver->image) }}">
                                                {{ $driver->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('driver'))
                                        <span class="text-danger">{{ $errors->first('driver') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="paketSelect">Cari Paket</label>
                                    <div class="input-group">
                                        <select id="paketSelect" name="paket" class="form-control">
                                            <option value="">Pilih Paket</option>
                                            @foreach ($pakets as $paket)
                                                <option name="paket" value="{{ $paket->id }}"
                                                    data-name="{{ $paket->packet_name }}"
                                                    data-type="{{ $paket->packet_type }}"
                                                    data-sender="{{ $paket->sender_name }}"
                                                    data-receiver="{{ $paket->receiver_name }}"
                                                    data-weight="{{ $paket->weight }}"
                                                    data-sender-latitude="{{ $paket->sender_latitude }}"
                                                    data-sender-longitude="{{ $paket->sender_longitude }}"
                                                    data-receiver-latitude="{{ $paket->receiver_latitude }}"
                                                    data-receiver-longitude="{{ $paket->receiver_longitude }}"
                                                    data-image="{{ asset('storage/pakets/' . $paket->image) }}">
                                                    {{ $paket->packet_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" id="addPaketButton" class="btn btn-primary">Add</button>
                                        </div>
                                    </div>
                                    @if ($errors->has('paket'))
                                        <span class="text-danger">{{ $errors->first('paket') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="paket">Paket</label>
                                <div class="form-group" style="text-align: center;">
                                    <div class="image-upload"
                                        style="position: relative; display: inline-block; margin-bottom: 10px;">
                                        <img id="paketImagePreview" src="https://via.placeholder.com/200"
                                            alt="Pratinjau Gambar" width="200" height="200"
                                            style="object-fit: cover; border: 3px solid #ccc; border-radius: 8px;">
                                    </div>
                                    <div style="text-align: center;">
                                        <p id="paketName"><strong>Nama Paket:</strong></p>
                                        <p id="paketType"><strong>Jenis Paket:</strong></p>
                                        <p id="paketSender"><strong>Nama Pengirim:</strong></p>
                                        <p id="paketReceiver"><strong>Nama Penerima:</strong></p>
                                        <p id="paketWeight"><strong>Berat (kg):</strong></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <label for="list_paket">List Paket</label>
                                        <table class="table table-bordered table-striped" id="paketTable">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Paket</th>
                                                    <th>Jenis Paket</th>
                                                    <th>Nama Pengirim</th>
                                                    <th>Nama Penerima</th>
                                                    <th>Berat (kg)</th>
                                                    <th>
                                                        <center>Aksi</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (session('pakets'))
                                                    @foreach (session('pakets') as $index => $paket)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $paket['name'] }}</td>
                                                            <td>{{ $paket['type'] }}</td>
                                                            <td>{{ $paket['sender'] }}</td>
                                                            <td>{{ $paket['receiver'] }}</td>
                                                            <td>{{ $paket['weight'] }}</td>
                                                            <td><button type="button"
                                                                    class="btn btn-danger btn-sm remove-paket"
                                                                    data-id="{{ $paket['id'] }}">Hapus</button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="list_paket" id="list_paket">
                                        @if ($errors->has('list_paket'))
                                            <span class="text-danger">{{ $errors->first('list_paket') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-4">
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

                            <div class="col-md-6 mt-4">
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
                window.location.href = "{{ route('operator.suratjalan.index') }}";
            });
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var driverSelect = document.getElementById('driverSelect');
            var paketSelect = document.getElementById('paketSelect');
            var loadingElement = document.getElementById('loading');

            driverSelect.addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var driverData = {
                    name: selectedOption.getAttribute('data-name'),
                    phone: selectedOption.getAttribute('data-phone'),
                    vehicle: selectedOption.getAttribute('data-vehicle'),
                    plate: selectedOption.getAttribute('data-plate'),
                    address: selectedOption.getAttribute('data-address'),
                    latitude: parseFloat(selectedOption.getAttribute('data-latitude')),
                    longitude: parseFloat(selectedOption.getAttribute('data-longitude')),
                    image: selectedOption.getAttribute('data-image')
                };
                updateDriverInfo(driverData);
            });

            paketSelect.addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var paketData = {
                    name: selectedOption.getAttribute('data-name'),
                    type: selectedOption.getAttribute('data-type'),
                    sender: selectedOption.getAttribute('data-sender'),
                    receiver: selectedOption.getAttribute('data-receiver'),
                    weight: selectedOption.getAttribute('data-weight'),
                    senderLatitude: parseFloat(selectedOption.getAttribute('data-sender-latitude')),
                    senderLongitude: parseFloat(selectedOption.getAttribute('data-sender-longitude')),
                    receiverLatitude: parseFloat(selectedOption.getAttribute('data-receiver-latitude')),
                    receiverLongitude: parseFloat(selectedOption.getAttribute(
                        'data-receiver-longitude')),
                    image: selectedOption.getAttribute('data-image')
                };
                updatePaketInfo(paketData);
            });

            function updateDriverInfo(driverData) {
                document.getElementById('driverImagePreview').src = driverData.image;
                document.getElementById('driverName').innerText = 'Nama: ' + driverData.name;
                document.getElementById('driverPhone').innerText = 'Nomor HP: ' + driverData.phone;
                document.getElementById('driverVehicle').innerText = 'Nama Kendaraan: ' + driverData.vehicle;
                document.getElementById('driverPlate').innerText = 'Nomor Plat Kendaraan: ' + driverData.plate;
                document.getElementById('driverAddress').innerText = 'Alamat: ' + driverData.address;
            }

            function updatePaketInfo(paketData) {
                document.getElementById('paketImagePreview').src = paketData.image;
                document.getElementById('paketName').innerText = 'Nama Paket: ' + paketData.name;
                document.getElementById('paketType').innerText = 'Jenis Paket: ' + paketData.type;
                document.getElementById('paketSender').innerText = 'Nama Pengirim: ' + paketData.sender;
                document.getElementById('paketReceiver').innerText = 'Nama Penerima: ' + paketData.receiver;
                document.getElementById('paketWeight').innerText = 'Berat (kg): ' + paketData.weight;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paketTable = document.getElementById('paketTable');
            const addPaketButton = document.getElementById('addPaketButton');
            const listPaketInput = document.getElementById('list_paket');

            addPaketButton.addEventListener('click', function() {
                const paketSelect = document.getElementById('paketSelect');
                const paketId = paketSelect.value;
                const paketOption = paketSelect.options[paketSelect.selectedIndex];

                if (paketId && !isPaketInList(paketId)) {
                    const paketData = {
                        id: paketId,
                        name: paketOption.getAttribute('data-name'),
                        type: paketOption.getAttribute('data-type'),
                        sender: paketOption.getAttribute('data-sender'),
                        receiver: paketOption.getAttribute('data-receiver'),
                        weight: paketOption.getAttribute('data-weight')
                    };
                    addPaketRow(paketData);
                    updateListPaketField();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Paket Sudah Ada',
                        text: 'Paket ini sudah ditambahkan ke dalam list paket.',
                    });
                }
            });

            function isPaketInList(paketId) {
                const paketRows = paketTable.querySelectorAll('tr');
                let found = false;
                paketRows.forEach(function(row) {
                    if (row.dataset.paketId === paketId) {
                        found = true;
                    }
                });
                return found;
            }

            function addPaketRow(paketData) {
                const row = document.createElement('tr');
                row.dataset.paketId = paketData.id;

                const rowCount = paketTable.querySelector('tbody').children.length + 1;

                const html = `
        <td>${rowCount}</td>
        <td>${paketData.name}</td>
        <td>${paketData.type}</td>
        <td>${paketData.sender}</td>
        <td>${paketData.receiver}</td>
        <td>${paketData.weight}</td>
        <td><center>
                <button type="button" class="btn btn-sm btn-danger remove-paket">Hapus</button>
            </center>
        </td>
        <input type="hidden" name="paket_ids[]" value="${paketData.id}">
        `;
                row.innerHTML = html;

                paketTable.querySelector('tbody').appendChild(row);
            }

            function updateListPaketField() {
                const paketIds = [];
                paketTable.querySelectorAll('tr').forEach(function(row) {
                    const paketId = row.dataset.paketId;
                    if (paketId) {
                        paketIds.push(paketId);
                    }
                });
                listPaketInput.value = JSON.stringify(paketIds);
            }

            paketTable.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-paket')) {
                    const row = event.target.closest('tr');
                    row.parentNode.removeChild(row);
                    updateListPaketField();
                }
            });
        });
    </script>
@endsection
