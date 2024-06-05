@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Data Operator</h4>
                    <form class="forms-sample">
                        <div class="form-group">
                            <label for="exampleInputName1">Nama</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Nomor HP</label>
                            <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Alamat</label>
                            <input type="password" class="form-control" id="exampleInputPassword4" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleSelectGender">Negara</label>
                            <select class="form-control" id="exampleSelectGender">
                                <option>Indonesia</option>
                                <option>Palestina</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mapid">Lokasi</label>
                            <div id="mapid" style="height: 400px;"></div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('operator.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
