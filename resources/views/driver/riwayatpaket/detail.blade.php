@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Riwayat Paket</h4>
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="form-group">
                                <div class="input-group">
                                    {{-- <img src="{{ $image ? asset($image) : 'https://via.placeholder.com/250' }}"
                                        class="img-fluid" alt="Image"
                                        style="border-radius: 50%; object-fit: cover; border: 3px solid #ccc; width: 250px; height: 250px;"> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-sample">
                                <div class="form-group">
                                    <label for="driverId">Driver ID</label>
                                    <p id="driverId">{{--{{ $driver_id }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="paketId">Paket ID</label>
                                    <p id="paketId">{{--{{ $paket_id }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="suratJalanId">Surat Jalan ID</label>
                                    <p id="suratJalanId">{{--{{ $surat_jalan_id }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <p id="status">{{--{{ $status }}--}}</p>
                                </div>
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <div id="mapid" style="height: 400px;"></div>
                                    <input type="hidden" id="latitude" name="latitude" value="{{-- {{ $suratjalan->latitude }} --}}">
                                    <input type="hidden" id="longitude" name="longitude" value="{{-- {{ $suratjalan->longitude }} --}}">
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                                <a href="{{ route('driver.riwayatpaket.index') }}" class="btn btn-light">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
