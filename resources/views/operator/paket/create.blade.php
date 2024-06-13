@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom: 50px">Form Tambah Data Paket</h4>
                    <form id="createForm" action="{{-- {{ route('store_data') }} --}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Sender -->
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
                        <!-- Sender Location -->
                        <div class="form-group">
                            <label for="senderLocation">Sender Location</label>
                            <div class="input-group mb-2">
                                <input type="text" id="senderSearchbox" placeholder="Search location"
                                    class="form-control" required value="{{ old('sender') }}">
                                <div class="input-group-append">
                                    <button type="button" id="senderSearchbutton" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                            <div id="senderMapid" style="height: 400px;"></div>
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
                        </div>

                        <!-- Receiver -->
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
                        <!-- Receiver Location -->
                        <div class="form-group">
                            <label for="receiverLocation">Receiver Location</label>
                            <div class="input-group mb-2">
                                <input type="text" id="receiverSearchbox" placeholder="Search location"
                                    class="form-control" required value="{{ old('receiver') }}">
                                <div class="input-group-append">
                                    <button type="button" id="receiverSearchbutton" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                            <!-- Use the same map for both sender and receiver -->
                        </div>

                        <div class="form-group">
                            <label for="weight">Weight</label>
                            <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight"
                                value="{{ old('weight') }}">
                            @if ($errors->has('weight'))
                                <span class="text-danger">{{ $errors->first('weight') }}</span>
                            @endif
                        </div>
                        <!-- Other fields like dimensions, description, etc. -->

                        <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a class="btn btn-light" data-toggle="modal" data-target="#cancelConfirmationModal">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Submit and Cancel Confirmation Modals -->
    <!-- JavaScript for modals and map -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sender form submission confirmation
            document.getElementById('createForm').addEventListener('submit', function(e) {
                e.preventDefault();
                $('#submitConfirmationModal').modal('show');
            });

            // Cancel button handler
            document.querySelector('.btn-light').addEventListener('click', function() {
                $('#cancelConfirmationModal').modal('show');
            });

            // Submit confirmation
            document.getElementById('confirmSubmit').addEventListener('click', function() {
                document.getElementById('createForm').submit();
            });

            // Cancel confirmation
            document.getElementById('confirmCancel').addEventListener('click', function() {
                window.location.href = "{{ route('admin.operator.index') }}";
            });

            // Initialize map for sender
            var senderMap = L.map('senderMapid').setView([-6.263, 106.781], 10);
            // Initialize marker for sender
            var senderMarker = L.marker([-6.263, 106.781], {
                draggable: true
            }).addTo(senderMap);

            // Initialize map for receiver (same map as sender)
            var receiverMap = senderMap;
            // Initialize marker for receiver
            var receiverMarker = L.marker([-6.263, 106.781], {
                draggable: true
            }).addTo(receiverMap);

            // Function to update location info for sender
            function updateSenderLocationInfo(lat, lon, display_name) {
                document.getElementById('sender_latitude').value = lat;
                document.getElementById('sender_longitude').value = lon;
                document.getElementById('senderSearchbox').value = display_name;
            }

            // Function to update location info for receiver
            function updateReceiverLocationInfo(lat, lon, display_name) {
                // Update hidden fields
                document.getElementById('receiver_latitude').value = lat;
                document.getElementById('receiver_longitude').value = lon;
                // Update search box display
                document.getElementById('receiverSearchbox').value = display_name;
            }

            // Search button handler for sender
            document.getElementById('senderSearchbutton').addEventListener('click', function() {
                var location = document.getElementById('senderSearchbox').value;
                searchLocation(location, senderMap, senderMarker, updateSenderLocationInfo);
            });

            // Search button handler for receiver
            document.getElementById('receiverSearchbutton').addEventListener('click', function() {
                var location = document.getElementById('receiverSearchbox').value;
                searchLocation(location, receiverMap, receiverMarker, updateReceiverLocationInfo);
            });

            // Function to search for location and update map and markers
            function searchLocation(location, map, marker, updateLocationInfo) {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${location}&accept-language=id-ID`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            var lat = data[0].lat;
                            var lon = data[0].lon;
                            var display_name = data[0].display_name;

                            marker.setLatLng([lat, lon]).addTo(map).bindPopup(display_name).openPopup();
                            map.setView([lat, lon], 13);

                            updateLocationInfo(lat, lon, display_name);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Location Not Found',
                                text: 'Sorry, the location you searched for was not found.',
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Event handler for marker dragend for sender
            senderMarker.on('dragend', function(event) {
                var marker = event.target;
                var position = marker.getLatLng();
                var lat = position.lat;
                var lon = position.lng;

                updateSenderLocationInfo(lat, lon, 'Marker Location');

                fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&accept-language=id-ID`)
                    .then(response => response.json())
                    .then(data => {
                        var display_name = data.display_name;

                        marker.bindPopup(display_name).openPopup();
                    })
                    .catch(error => console.error('Error:', error));
            });

            // Event handler for marker dragend for receiver
            receiverMarker.on('dragend', function(event) {
                var marker = event.target;
                var position = marker.getLatLng();
                var lat = position.lat;
                var lon = position.lng;

                updateReceiverLocationInfo(lat, lon, 'Marker Location');

                fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&accept-language=id-ID`)
                    .then(response => response.json())
                    .then(data => {
                        var display_name = data.display_name;

                        marker.bindPopup(display_name).openPopup();
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection
