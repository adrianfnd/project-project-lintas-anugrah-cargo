@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom: 50px">Form Tambah Data Paket</h4>
                     <form id="createForm" action="{{-- {{ route('store_data') }}--}}" method="POST" enctype="multipart/form-data"> 
                        @csrf
                        <div class="form-group">
                            <label for="trackingNumber">Tracking Number</label>
                            <input type="text" class="form-control" id="trackingNumber" name="tracking_number"
                                placeholder="Tracking Number" value="{{ old('tracking_number') }}">
                            @if ($errors->has('tracking_number'))
                                <span class="text-danger">{{ $errors->first('tracking_number') }}</span>
                            @endif
                        </div>
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
                            <label for="senderLatitude">Sender Latitude</label>
                            <input type="text" class="form-control" id="senderLatitude" name="sender_latitude"
                                placeholder="Sender Latitude" value="{{ old('sender_latitude') }}">
                            @if ($errors->has('sender_latitude'))
                                <span class="text-danger">{{ $errors->first('sender_latitude') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="senderLongitude">Sender Longitude</label>
                            <input type="text" class="form-control" id="senderLongitude" name="sender_longitude"
                                placeholder="Sender Longitude" value="{{ old('sender_longitude') }}">
                            @if ($errors->has('sender_longitude'))
                                <span class="text-danger">{{ $errors->first('sender_longitude') }}</span>
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
                            <label for="receiverLatitude">Receiver Latitude</label>
                            <input type="text" class="form-control" id="receiverLatitude" name="receiver_latitude"
                                placeholder="Receiver Latitude" value="{{ old('receiver_latitude') }}">
                            @if ($errors->has('receiver_latitude'))
                                <span class="text-danger">{{ $errors->first('receiver_latitude') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="receiverLongitude">Receiver Longitude</label>
                            <input type="text" class="form-control" id="receiverLongitude" name="receiver_longitude"
                                placeholder="Receiver Longitude" value="{{ old('receiver_longitude') }}">
                            @if ($errors->has('receiver_longitude'))
                                <span class="text-danger">{{ $errors->first('receiver_longitude') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight</label>
                            <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight"
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
                            <label>Image</label>
                            <input type="file" name="img[]" class="file-upload-default" style="display: none;"
                                accept="image/*" id="image">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                            @if ($errors->has('img'))
                                <span class="text-danger">{{ $errors->first('img') }}</span>
                            @endif
                            <div class="form-group mt-3">
                                <img id="imagePreview" src="#" alt="Image Preview"
                                    style="display: none; max-width: 100%; height: auto;">
                            </div>
                        </div>
                        <script>
                            document.querySelector('.file-upload-browse').addEventListener('click', function() {
                                var fileInput = document.querySelector('.file-upload-default');
                                fileInput.click();
                            });

                            document.querySelector('.file-upload-default').addEventListener('change', function() {
                                var fileName = this.value.split('\\').pop();
                                document.querySelector('.file-upload-info').value = fileName;
                            });
                        </script>
                        @if ($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" id="status" name="status"
                                placeholder="Status" value="{{ old('status') }}">
                            @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="mapid">Location</label>
                            <div id="mapid" style="height: 400px;"></div>
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                        </div>
                        <div style="text-align: center;">
                            <!-- Image upload section remains unchanged -->
                        </div>
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
        <!-- Modal content remains unchanged -->
    </div>

    <!-- Cancel Confirmation Modal -->
    <div class="modal fade" id="cancelConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="cancelConfirmationModalLabel" aria-hidden="true">
        <!-- Modal content remains unchanged -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('createForm').addEventListener('submit', function(e) {
                e.preventDefault();
                $('#submitConfirmationModal').modal('show');
            });

            document.getElementById('confirmSubmit').addEventListener('click', function() {
                document.getElementById('createForm').submit();
            });
        });
    </script>
@endsection
