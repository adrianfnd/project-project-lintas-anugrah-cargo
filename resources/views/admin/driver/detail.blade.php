@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Data Driver</h4>
                    <div class="form-sample">
                        <!-- Nama -->
                        <div class="form-group">
                            <label for="driverName">Nama</label>
                            <p id="driverName">#</p>
                        </div>
                        <!-- Gambar -->
                        <div class="form-group">
                            <label for="driverImage">Gambar</label>
                            <div class="input-group col-xs-12">
                                <img src="#" class="img-fluid" alt="Driver Image">
                            </div>
                        </div>
                        <!-- Nomor HP -->
                        <div class="form-group">
                            <label for="driverPhone">Nomor HP</label>
                            <p id="driverPhone">#</p>
                        </div>
                        <!-- Nomor SIM -->
                        <div class="form-group">
                            <label for="driverLicense">Nomor SIM</label>
                            <p id="driverLicense">#</p>
                        </div>
                        <!-- Alamat -->
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <p id="address">#</p>
                        </div>
                        <!-- Negara -->
                        <div class="form-group">
                            <label for="country">Negara</label>
                            <p id="country">#</p>
                        </div>
                        <a href="{{ route('admin.driver.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
