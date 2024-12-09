@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-13 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"> List Checkpoint</p>
                    <p class="card-description">
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <input type="text" id="searchMap" placeholder="Cari lokasi di peta..." class="form-control"
                                required>
                            <div class="input-group-append">
                                <button type="button" id="searchButton" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                    </p>

                    <div class="mb-3">
                        <div id="map" style="height: 400px;"></div>
                    </div>

                    <div class="mb-3 text-right">
                        <button id="saveCheckpoint" class="btn btn-primary" style="display: none;">Save
                            Checkpoint</button>
                        <button id="cancelCheckpoint" class="btn btn-secondary" style="display: none;">Cancel</button>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Address</th>
                                            <th>
                                                <center>Aksi</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($checkpoints as $index => $checkpoint)
                                            <tr id="checkpoint-row-{{ $checkpoint->id }}"
                                                data-lat="{{ $checkpoint->latitude }}"
                                                data-lng="{{ $checkpoint->longitude }}" data-id="{{ $checkpoint->id }}">
                                                <td>{{ $checkpoints->firstItem() + $index }}</td>
                                                <td>{{ $checkpoint->latitude }}</td>
                                                <td>{{ $checkpoint->longitude }}</td>
                                                <td>{{ $checkpoint->address }}</td>
                                                <td>
                                                    <center>
                                                        <button type="button"
                                                            class="btn btn-inverse-danger btn-rounded btn-icon"
                                                            data-toggle="modal"
                                                            data-target="#deleteModal{{ $checkpoint->id }}">
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </center>
                                                </td>
                                            </tr>
                                            <!-- Modal Konfirmasi Hapus -->
                                            <div class="modal fade" id="deleteModal{{ $checkpoint->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus
                                                                Checkpoint</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus checkpoint ini?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                            <form
                                                                action="{{ route('operator.checkpoint.destroy', $checkpoint->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
            var map = L.map('map').setView([-6.2088, 106.8456], 10);
            var currentMarker = null;
            var newMarker = null;
            var saveButton = document.getElementById('saveCheckpoint');
            var cancelButton = document.getElementById('cancelCheckpoint');
            var searchMap = document.getElementById('searchMap');
            var searchButton = document.getElementById('searchButton');
            var selectedCheckpointId;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var customIcon = L.icon({
                iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            function createMarker(lat, lng, draggable = false, rowId = null) {
                if (newMarker) {
                    map.removeLayer(newMarker);
                }
                newMarker = L.marker([lat, lng], {
                    icon: customIcon,
                    draggable: draggable
                }).addTo(map);

                if (draggable) {
                    saveButton.style.display = 'inline-block';
                    cancelButton.style.display = 'inline-block';

                    newMarker.on('dragend', function(e) {
                        var position = newMarker.getLatLng();
                        newMarker.setLatLng(position, {
                            draggable: 'true'
                        }).bindPopup(position).update();
                        saveButton.style.display = 'inline-block';
                        cancelButton.style.display = 'inline-block';
                    });
                }
            }

            @foreach ($checkpoints as $checkpoint)
                var marker = L.marker([{{ $checkpoint->latitude }}, {{ $checkpoint->longitude }}], {
                        icon: customIcon
                    })
                    .addTo(map)
                    .bindPopup("{{ $checkpoint->address }}")
                    .on('click', function() {
                        document.getElementById('checkpoint-row{{ $checkpoint->id }}').click();
                    });
            @endforeach

            map.on('click', function(e) {
                createMarker(e.latlng.lat, e.latlng.lng, true);
            });

            saveButton.addEventListener('click', function() {
                if (newMarker) {
                    var lat = newMarker.getLatLng().lat;
                    var lng = newMarker.getLatLng().lng;

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
                if (newMarker) {
                    map.removeLayer(newMarker);
                    newMarker = null;
                }
                saveButton.style.display = 'none';
                cancelButton.style.display = 'none';
            });

            function saveCheckpoint(lat, lng, address) {
                var url = selectedCheckpointId ? `{{ url('operator/checkpoint') }}/${selectedCheckpointId}` :
                    '{{ route('operator.checkpoint.store') }}';
                var method = selectedCheckpointId ? 'PUT' : 'POST';

                fetch(url, {
                        method: method,
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
                                title: 'Berhasil',
                                text: data.message,
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

            function searchLocation(query) {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            var latLng = [data[0].lat, data[0].lon];
                            map.setView(latLng, 14);
                            createMarker(data[0].lat, data[0].lon, true);
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

            searchMap.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchLocation(searchMap.value);
                }
            });

            searchButton.addEventListener('click', function() {
                searchLocation(searchMap.value);
            });

            document.querySelectorAll('tbody tr').forEach(function(row) {
                row.addEventListener('click', function() {
                    var lat = parseFloat(this.getAttribute('data-lat'));
                    var lng = parseFloat(this.getAttribute('data-lng'));
                    selectedCheckpointId = this.getAttribute('data-id');
                    map.setView([lat, lng], 14);
                    createMarker(lat, lng, true);
                });
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
