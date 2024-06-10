@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Data Paket</h4>
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Pic or loc</label>
                                   {{-- <img src=" {{-- {{ $paket->image ? asset('storage/drivers/' . $paket->image) : 'https://via.placeholder.com/250' }}" 
                                        style="border-radius: 50%; object-fit: cover; border: 3px solid #ccc; width: 250px; height: 250px;"> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-sample">
                                <div class="form-group">
                                    <label for="trackingNumber">Tracking Number</label>
                                    <p id="trackingNumber">{{--{{ $paket->tracking_number }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="senderName">Sender Name</label>
                                    <p id="senderName">{{--{{ $paket->sender_name }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="senderAddress">Sender Address</label>
                                    <p id="senderAddress">{{--{{ $paket->sender_address }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="senderLatitude">Sender Latitude</label>
                                    <p id="senderLatitude">{{--{{ $paket->sender_latitude }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="senderLongitude">Sender Longitude</label>
                                    <p id="senderLongitude">{{--{{ $paket->sender_longitude }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="receiverName">Receiver Name</label>
                                    <p id="receiverName">{{--{{ $paket->receiver_name }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="receiverAddress">Receiver Address</label>
                                    <p id="receiverAddress">{{--{{ $paket->receiver_address }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="receiverLatitude">Receiver Latitude</label>
                                    <p id="receiverLatitude">{{--{{ $paket->receiver_latitude }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="receiverLongitude">Receiver Longitude</label>
                                    <p id="receiverLongitude">{{--{{ $paket->receiver_longitude }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="weight">Weight</label>
                                    <p id="weight">{{--{{ $paket->weight }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="dimensions">Dimensions</label>
                                    <p id="dimensions">{{--{{ $paket->dimensions }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <p id="description">{{--{{ $paket->description }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <p id="image">{{--{{ $paket->image }}</p>
                                    <img src="{{--{{ $paket->image ? asset('storage/drivers/' . $paket->image) : 'https://via.placeholder.com/200' }}"
                                        alt="Driver Image" style="max-width: 100%; height: auto;">--}}
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <p id="status">{{--{{ $paket->status }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <div id="mapid" style="height: 400px;"></div>
                                    <input type="hidden" id="latitude" name="latitude" value="{{--{{ $paket->latitude }}--}}">
                                    <input type="hidden" id="longitude" name="longitude" value="{{--{{ $paket->longitude }}--}}">
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                                <a href="{{ route('operator.paket.index') }}" class="btn btn-light">Back</a>
                                <a href="{{ route('operator.paket.edit'{{--, $paket->id--}}) }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        var latitude = parseFloat(document.getElementById('latitude').value);
        var longitude = parseFloat(document.getElementById('longitude').value);

        var mymap = L.map('mapid').setView([latitude, longitude], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mymap);

        var marker = L.marker([latitude, longitude]).addTo(mymap);
    </script>
@endsection
