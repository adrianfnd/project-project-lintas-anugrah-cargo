{{-- EDIT VIEW --}}

@extends('layouts.main')

@section('content')
    {{-- SIDEBAR --}}
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.admin') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">List Data</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('operator.index') }}">Operator</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('driver.index') }}">Driver</a></li>
                    </ul>
                </div>
    </nav>
    {{-- AKHIR SIDEBAR --}}

    {{-- FORM --}}
    <div class="main-panel">
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
        {{-- AKHIR FORM --}}
    @endsection