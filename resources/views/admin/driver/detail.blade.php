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
                                    <img src="{{ $driver->image ? asset('storage/drivers/' . $driver->image) : 'https://via.placeholder.com/250' }}"
                                        class="img-fluid" alt="Driver Image"
                                        style="border-radius: 50%; object-fit: cover; border: 3px solid #ccc; width: 250px; height: 250px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-sample">
                                <div class="form-group">
                                    <label for="driverUsername">Username</label>
                                    <p id="driverUsername">{{ $user->username }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="driverEmail">Email</label>
                                    <p id="driverEmail">{{ $user->email }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="driverName">Nama</label>
                                    <p id="driverName">{{ $driver->name }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="driverPhone">Nomor HP</label>
                                    <p id="driverPhone">{{ $driver->phone_number }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="driverLicense">Nomor Plat Kendaraan</label>
                                    <p id="driverLicense">{{ $driver->license_number }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="vehicleName">Nama Kendaraan</label>
                                    <p id="vehicleName">{{ $driver->vehicle_name }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="driverAddress">Alamat</label>
                                    <p id="driverAddress">{{ $driver->address }}</p>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                                <a href="{{ route('admin.driver.index') }}" class="btn btn-light">Back</a>
                                <a href="{{ route('admin.driver.edit', $driver->id) }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
