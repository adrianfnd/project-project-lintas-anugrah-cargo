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
                    <h4 class="card-title" style="margin-bottom: 50px">Form Edit Surat Jalan</h4>
                    <form id="operatorForm" action="{{ route('operator.suratjalan.update', $suratjalan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                                data-image="{{ asset('storage/drivers/' . $driver->image) }}"
                                                {{ $suratjalan->driver_id == $driver->id ? 'selected' : '' }}>
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
                                                data-image="{{ asset('storage/pakets/' . $paket->image) }}"
                                                {{ $suratjalan->paket_id == $paket->id ? 'selected' : '' }}>
                                                {{ $paket->packet_name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="loading" style="display: none;">
                                        <div class="spinner"></div>
                                        Memuat data...
                                    </div>
                                    <div id="mapid" style="height: 400px;" class="mt-4"></div>
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
        var map = null;

        document.addEventListener('DOMContentLoaded', function() {
            var driverSelect = document.getElementById('driverSelect');
            var paketSelect = document.getElementById('paketSelect');
            var loadingElement = document.getElementById('loading');

            var selectedDriverOption = document.querySelector('#driverSelect option:checked');
            var driverData = {
                name: selectedDriverOption.getAttribute('data-name'),
                phone: selectedDriverOption.getAttribute('data-phone'),
                vehicle: selectedDriverOption.getAttribute('data-vehicle'),
                plate: selectedDriverOption.getAttribute('data-plate'),
                address: selectedDriverOption.getAttribute('data-address'),
                latitude: parseFloat(selectedDriverOption.getAttribute('data-latitude')),
                longitude: parseFloat(selectedDriverOption.getAttribute('data-longitude')),
                image: selectedDriverOption.getAttribute('data-image')
            };
            updateDriverInfo(driverData);

            var selectedPaketOption = document.querySelector('#paketSelect option:checked');
            var paketData = {
                name: selectedPaketOption.getAttribute('data-name'),
                type: selectedPaketOption.getAttribute('data-type'),
                sender: selectedPaketOption.getAttribute('data-sender'),
                receiver: selectedPaketOption.getAttribute('data-receiver'),
                weight: selectedPaketOption.getAttribute('data-weight'),
                senderLatitude: parseFloat(selectedPaketOption.getAttribute(
                    'data-sender-latitude')),
                senderLongitude: parseFloat(selectedPaketOption.getAttribute(
                    'data-sender-longitude')),
                receiverLatitude: parseFloat(selectedPaketOption.getAttribute(
                    'data-receiver-latitude')),
                receiverLongitude: parseFloat(selectedPaketOption.getAttribute(
                    'data-receiver-longitude')),
                image: selectedPaketOption.getAttribute('data-image')
            };
            updatePaketInfo(paketData);
            updateMap();


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
                updateMap();
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

            function updateMap() {
                if (map !== null) {
                    map.remove();
                }

                var senderLatitude = parseFloat(paketSelect.selectedOptions[0].getAttribute(
                    'data-sender-latitude'));
                var senderLongitude = parseFloat(paketSelect.selectedOptions[0].getAttribute(
                    'data-sender-longitude'));
                var receiverLatitude = parseFloat(paketSelect.selectedOptions[0].getAttribute(
                    'data-receiver-latitude'));
                var receiverLongitude = parseFloat(paketSelect.selectedOptions[0].getAttribute(
                    'data-receiver-longitude'));

                var mapCenter = senderLatitude && senderLongitude ? [senderLatitude, senderLongitude] : [-6.263,
                    106.781
                ];
                var mapZoom = senderLatitude && senderLongitude ? 7 : 7;

                loadingElement.style.display = 'block';

                map = L.map('mapid').setView(mapCenter, mapZoom);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map).on('load', function() {
                    loadingElement.style.display = 'none';
                });

                var senderMarker = L.marker([senderLatitude, senderLongitude]).addTo(map);
                var receiverMarker = L.marker([receiverLatitude, receiverLongitude]).addTo(map);
                var routingControl = null;

                function calculateDistanceAndTime() {
                    var from = L.latLng(senderLatitude, senderLongitude);
                    var to = L.latLng(receiverLatitude, receiverLongitude);
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

                    document.getElementById('distance').innerText = distance.toFixed(2) + ' km (estimasi waktu: ' +
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

                function fetchData(url, elementId) {
                    loadingElement.style.display = 'block';
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            loadingElement.style.display = 'none';
                            var location = data.display_name;
                            document.getElementById(elementId).innerText = location;
                        })
                        .catch(error => {
                            loadingElement.style.display = 'none';
                            console.error('Error fetching location:', error);
                        });
                }

                fetchData(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${senderLatitude}&lon=${senderLongitude}&accept-language=id-ID`,
                    'sender_location'
                );

                fetchData(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${receiverLatitude}&lon=${receiverLongitude}&accept-language=id-ID`,
                    'receiver_location'
                );

                calculateDistanceAndTime();
            }
        });
    </script>
@endsection
