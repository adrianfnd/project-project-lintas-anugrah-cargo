@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Data Operator</h4>
                    <div class="form-sample">
                        <!-- Nama -->
                        <div class="form-group">
                            <label for="driverName">Nama</label>
                            <p id="driverName">#</p>
                        </div>
                        <!-- Nomor HP -->
                        <div class="form-group">
                            <label for="driverPhone">Nomor HP</label>
                            <p id="driverPhone">#</p>
                        </div>
                        <!-- Alamat -->
                        <div class="form-group">
                            <label for="driverLicense">Alamat</label>
                            <p id="driverLicense">#</p>
                        </div>
                        <!-- Negara -->
                        <div class="form-group">
                            <label for="vehicleName">Nama Kendaraan</label>
                            <p id="vehicleName">#</p>
                        </div>
                        <!-- Lokasi -->
                        <div class="form-group">
                            <label for="mapid">Lokasi</label>
                            <div id="mapid" style="height: 400px;"></div>
                        </div>
                        <a href="{{ route('operator.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
