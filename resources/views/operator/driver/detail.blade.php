@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Data Driver</h4>
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>Driver Image</label>
                                   <img src="{{--{{ $driver->image ? asset('storage/drivers/' . $driver->image) : 'https://via.placeholder.com/250' }}--}}" 
                                        style="border-radius: 50%; object-fit: cover; border: 3px solid #ccc; width: 250px; height: 250px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-sample">
                                <div class="form-group">
                                    <label for="createdBy">Created By</label>
                                    </div>
                                <p id="createdBy">{{--{{ $driver->created_by }}--}}</p>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    </div>
                                <p id="name">{{--{{ $driver->name }}--}}</p>
                                <div class="form-group">
                                    <label for="phoneNumber">Phone Number</label>
                                    </div>
                                <p id="phoneNumber">{{--{{ $driver->phone_number }}--}}</p>
                                <div class="form-group">
                                    <label for="licenseNumber">License Number</label>
                                    <p id="licenseNumber">{{--{{ $driver->license_number }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="vehicleName">Vehicle Name</label>
                                    <p id="vehicleName">{{--{{ $driver->vehicle_name }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <p id="address">{{--{{ $driver->address }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="rate">Rate</label>
                                    <p id="rate">{{--{{ $driver->rate }}--}}</p>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                                <a href="{{ route('operator.driver.index') }}" class="btn btn-light">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
