@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Data Driver</h4>
                    <form class="forms-sample" method="POST" action="{{ route('admin.driver.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputName1">Nama</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Name"
                                name="name" value="{{ old('name'), $driver->name }}">
                        </div>
                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" name="image" class="file-upload-default" id="imageUpload">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Upload Image" id="imageUploadText">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button"
                                        onclick="document.getElementById('imageUpload').click();">Upload</button>
                                </span>
                            </div>
                            <img id="imgPreview" class="img-preview" src="" alt="Image Preview">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Nomor HP</label>
                            <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Phone Number"
                                name="phone_number" value="{{ old('phone_number'), $driver->phone_number }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Nomor SIM</label>
                            <input type="text" class="form-control" id="exampleInputPassword4"
                                placeholder="License Number" name="license_number"
                                value="{{ old('license_number'), $driver->license_number }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputCity1">Nama Kendaraan</label>
                            <input type="text" class="form-control" id="exampleInputCity1" placeholder="Vehicle Name"
                                name="vehicle_name" value="{{ old('vehicle_name'), $driver->vehicle_name }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputCity1">Alamat</label>
                            <input type="text" class="form-control" id="exampleInputCity1" placeholder="Address"
                                name="address" value="{{ old('address'), $driver->address }}">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('admin.driver.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
