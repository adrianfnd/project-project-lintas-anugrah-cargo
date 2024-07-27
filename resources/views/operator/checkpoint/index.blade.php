@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-13 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Checkpoints</p>
                    <p class="card-description">
                        <input type="text" id="searchMap" class="form-control" placeholder="Cari lokasi di peta...">
                    </p>

                    <div id="map" style="height: 400px;"></div>

                    <div class="mt-3">
                        <button id="saveCheckpoint" class="btn btn-primary" style="display: none;">Save Checkpoint</button>
                        <button id="cancelCheckpoint" class="btn btn-secondary" style="display: none;">Cancel</button>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($checkpoints as $checkpoint)
                                            <tr>
                                                <td>{{ $checkpoint->id }}</td>
                                                <td>{{ $checkpoint->latitude }}</td>
                                                <td>{{ $checkpoint->longitude }}</td>
                                                <td>{{ $checkpoint->address }}</td>
                                                <td>
                                                    <form
                                                        action="{{ route('operator.checkpoint.destroy', $checkpoint->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    {{ $checkpoints->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([0, 0], 2);
            var marker;
            var saveButton = document.getElementById('saveCheckpoint');
            var cancelButton = document.getElementById('cancelCheckpoint');
            var searchMap = document.getElementById('searchMap');

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            @foreach ($checkpoints as $checkpoint)
                L.marker([{{ $checkpoint->latitude }}, {{ $checkpoint->longitude }}])
                    .addTo(map)
                    .bindPopup("{{ $checkpoint->address }}");
            @endforeach

            map.on('click', function(e) {
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker(e.latlng).addTo(map);
                saveButton.style.display = 'inline-block';
                cancelButton.style.display = 'inline-block';
            });

            saveButton.addEventListener('click', function() {
                if (marker) {
                    var lat = marker.getLatLng().lat;
                    var lng = marker.getLatLng().lng;

                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                        .then(response => response.json())
                        .then(data => {
                            var address = data.display_name;
                            saveCheckpoint(lat, lng, address);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            saveCheckpoint(lat, lng, "Address not found");
                        });
                }
            });

            cancelButton.addEventListener('click', function() {
                if (marker) {
                    map.removeLayer(marker);
                    marker = null;
                }
                saveButton.style.display = 'none';
                cancelButton.style.display = 'none';
            });

            function saveCheckpoint(lat, lng, address) {
                fetch('{{ route('operator.checkpoint.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            latitude: lat,
                            longitude: lng,
                            address: address
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Checkpoint berhasil disimpan',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal menyimpan checkpoint',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan saat menyimpan checkpoint',
                            text: error
                        });
                    });
            }

            searchMap.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    var query = searchMap.value;
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                var latLng = [data[0].lat, data[0].lon];
                                map.setView(latLng, 14);
                                if (marker) {
                                    map.removeLayer(marker);
                                }
                                marker = L.marker(latLng).addTo(map);
                                saveButton.style.display = 'inline-block';
                                cancelButton.style.display = 'inline-block';
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lokasi tidak ditemukan',
                                    text: 'Pastikan kata kunci yang Anda masukkan benar.'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan saat mencari lokasi',
                                text: error
                            });
                        });
                }
            });
        });

        var successMessage = '{{ session('success') }}';
        var errorMessage = '{{ session('error') }}';
        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successMessage,
                showConfirmButton: false,
                timer: 2000
            });
        }

        if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: errorMessage,
                showConfirmButton: false,
                timer: 2000
            });
        }
    </script>
@endsection
