@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom: 50px">Form Tambah Surat Jalan</h4>
                     <form id="createForm" action="{{-- {{ route('store_data') }}--}}" method="POST" enctype="multipart/form-data"> 
                        @csrf
                        <div class="form-group">
                            <label for="driverId">Driver ID</label>
                            <input type="text" class="form-control" id="driverId" name="driver_id"
                                placeholder="Driver ID" value="{{ old('driver_id') }}">
                            @if ($errors->has('driver_id'))
                                <span class="text-danger">{{ $errors->first('driver_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="paketId">Paket ID</label>
                            <input type="text" class="form-control" id="paketId" name="paket_id"
                                placeholder="Paket ID" value="{{ old('paket_id') }}">
                            @if ($errors->has('paket_id'))
                                <span class="text-danger">{{ $errors->first('paket_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" id="status" name="status"
                                placeholder="Status" value="{{ old('status') }}">
                            @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude"
                                placeholder="Latitude" value="{{ old('latitude') }}">
                            @if ($errors->has('latitude'))
                                <span class="text-danger">{{ $errors->first('latitude') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                placeholder="Longitude" value="{{ old('longitude') }}">
                            @if ($errors->has('longitude'))
                                <span class="text-danger">{{ $errors->first('longitude') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="mapid">Location</label>
                            <div id="mapid" style="height: 400px;"></div>
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                        </div>
                        <div style="text-align: center;">
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
