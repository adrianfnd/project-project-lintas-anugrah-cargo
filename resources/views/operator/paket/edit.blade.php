@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom: 50px">Form Edit Data Paket</h4>
                    <form id="driverForm" action="{{-- {{ route('operator.paket.update', $paket->id) }}--}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="trackingNumber">Tracking Number</label>
                            <input type="text" class="form-control" id="trackingNumber" name="tracking_number"
                                placeholder="Tracking Number" {{--value="{{ old('tracking_number', $paket->tracking_number) }}">
                            @if ($errors->has('tracking_number'))
                                <span class="text-danger">{{ $errors->first('tracking_number') }}</span>
                            @endif--}}
                        </div>
                        <div class="form-group">
                            <label for="senderName">Sender Name</label>
                            <input type="text" class="form-control" id="senderName" name="sender_name" placeholder="Sender Name" {{-- value="{{ old('sender_name', $paket->sender_name) }}">
                            @if ($errors->has('sender_name'))
                                <span class="text-danger">{{ $errors->first('sender_name') }}</span>
                            @endif --}}
                        </div>
                        <div class="form-group">
                            <label for="senderAddress">Sender Address</label>
                           <input type="text" class="form-control" id="senderAddress" name="sender_address" placeholder="Sender Address"  {{--  value="{{ old('sender_address', $paket->sender_address) }}">
                            @if ($errors->has('sender_address'))
                                <span class="text-danger">{{ $errors->first('sender_address') }}</span>
                            @endif --}}
                        </div>
                        <div class="form-group">
                            <label for="senderLatitude">Sender Latitude</label>
                            <input type="text" class="form-control" id="senderLatitude" name="sender_latitude" placeholder="Sender Latitude" {{--  value="{{ old('sender_latitude', $paket->sender_latitude) }}">
                            @if ($errors->has('sender_latitude'))
                                <span class="text-danger">{{ $errors->first('sender_latitude') }}</span>
                            @endif --}}
                        </div>
                        <div class="form-group">
                            <label for="senderLongitude">Sender Longitude</label>
                             <input type="text" class="form-control" id="senderLongitude" name="sender_longitude" placeholder="Sender Longitude" {{-- value="{{ old('sender_longitude', $paket->sender_longitude) }}">
                            @if ($errors->has('sender_longitude'))
                                <span class="text-danger">{{ $errors->first('sender_longitude') }}</span>
                            @endif --}}
                        </div>
                        <div class="form-group">
                            <label for="receiverName">Receiver Name</label>
                            <input type="text" class="form-control" id="receiverName" name="receiver_name" placeholder="Receiver Name" {{-- value="{{ old('receiver_name', $paket->receiver_name) }}">
                            @if ($errors->has('receiver_name'))
                                <span class="text-danger">{{ $errors->first('receiver_name') }}</span>
                            @endif --}}
                        </div>
                        <div class="form-group">
                            <label for="receiverAddress">Receiver Address</label>
                            <input type="text" class="form-control" id="receiverAddress" name="receiver_address" placeholder="Receiver Address"  {{-- value="{{ old('receiver_address', $paket->receiver_address) }}">
                            @if ($errors->has('receiver_address'))
                                <span class="text-danger">{{ $errors->first('receiver_address') }}</span>
                            @endif --}}
                        </div>
                        <div class="form-group">
                            <label for="receiverLatitude">Receiver Latitude</label>
                            <input type="text" class="form-control" id="receiverLatitude" name="receiver_latitude" placeholder="Receiver Latitude" {{-- value="{{ old('receiver_latitude', $paket->receiver_latitude) }}">
                            @if ($errors->has('receiver_latitude'))
                                <span class="text-danger">{{ $errors->first('receiver_latitude') }}</span>
                            @endif --}}
                        </div>
                        <div class="form-group">
                            <label for="receiverLongitude">Receiver Longitude</label>
                            <input type="text" class="form-control" id="receiverLongitude" name="receiver_longitude" placeholder="Receiver Longitude" {{-- value="{{ old('receiver_longitude', $paket->receiver_longitude) }}">
                            @if ($errors->has('receiver_longitude'))
                                <span class="text-danger">{{ $errors->first('receiver_longitude') }}</span>
                            @endif --}}
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight</label>
                            <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight" {{--  value="{{ old('weight', $paket->weight) }}">
                            @if ($errors->has('weight'))
                                <span class="text-danger">{{ $errors->first('weight') }}</span>
                            @endif --}}
                        </div>
                        <div class="form-group">
                            <label for="dimensions">Dimensions</label>
                           <input type="text" class="form-control" id="dimensions" name="dimensions" placeholder="Dimensions"  {{--  value="{{ old('dimensions', $paket->dimensions) }}">
                            @if ($errors->has('dimensions'))
                                <span class="text-danger">{{ $errors->first('dimensions') }}</span>
                            @endif --}}
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                             <input type="text" class="form-control" id="description" name="description" placeholder="Description"  {{-- value="{{ old('description', $paket->description) }}">
                            @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif --}}
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="file-upload-default" style="display: none;" accept=" image/*" id="imageUpload">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                            <div class="form-group mt-3">
                                <img id="imagePreview" src=" {{--{{ $paket->image ? asset('storage/drivers/' . $paket->image) : 'https://via.placeholder.com/200' }}"--}} alt="Image Preview" style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="pending" {{-- {{ old('status', $paket->status) == 'pending' ? 'selected' : '' }}--}}>Pending</option>
                                <option value="delivered" {{-- {{ old('status', $paket->status) == 'delivered' ? 'selected' : '' }}--}}>Delivered</option>
                                <option value="in_transit" {{-- {{ old('status', $paket->status) == 'in_transit' ? 'selected' : '' }}--}}>In Transit</option>
                            </select>
                            {{-- @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif --}}
                        </div>
                        <div class="form-group">
                            <label for="mapid">Location</label>
                            <div id="mapid" style="height: 400px;"></div>
                            <input type="hidden" id="latitude" name="latitude" value="{{-- {{ old('latitude') }}--}}">
                            <input type="hidden" id="longitude" name="longitude" value="{{-- {{ old('longitude') }}--}}">
                        </div>
                        <!-- Add JavaScript for file upload preview -->
                        {{-- <script>
                            document.querySelector('.file-upload-browse').addEventListener('click', function() {
                                var fileInput = document.querySelector('.file-upload-default');
                                fileInput.click();
                            });

                            document.querySelector('.file-upload-default').addEventListener('change', function() {
                                var fileName = this.value.split('\\').pop();
                                document.querySelector('.file-upload-info').value = fileName;
                                // Preview image
                                previewImage();
                            });

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
                                    preview.src = "{{ $paket->image ? asset('storage/drivers/' . $paket->image) : 'https://via.placeholder.com/200' }}";
                                }
                            }
                        </script>

                        <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a href="{{ route('admin.driver.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

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
            document.getElementById('driverForm').addEventListener('submit', function(e) {
                e.preventDefault();
                $('#submitConfirmationModal').modal('show');
            });

            document.querySelector('.btn-light').addEventListener('click', function() {
                $('#cancelConfirmationModal').modal('show');
            });

            document.getElementById('confirmSubmit').addEventListener('click', function() {
                document.getElementById('driverForm').submit();
            });

            document.getElementById('confirmCancel').addEventListener('click', function() {
                window.location.href = "{{ route('admin.driver.index') }}";
            });
        });
    </script>
@endsection
