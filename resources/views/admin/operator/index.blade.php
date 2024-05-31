{{-- ADMIN VIEW --}}

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
                        <li class="nav-item"> <a class="nav-link" href="{{ route('operator.index') }}">Driver</a></li>
                    </ul>
                </div>
    </nav>
    {{-- AKHIR SIDEBAR --}}

    {{-- DASHBOARD --}}
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-13 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">List Data Operator</p>
                        <p class="card-description">
                            <a href="{{ route('operator.create') }}">
                                <button type="button" class="btn btn-primary btn-icon-text">
                                    <i class="bi bi-plus btn-icon-prepend"></i>
                                    Tambah Data
                                </button>
                            </a>
                        </p>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="example" class="display expandable-table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>Gambar</th>
                                                <th>Nomor Hp</th>
                                                <th>Alamat</th>
                                                <th>Negara</th>
                                                <th>Alamat</th>
                                                <th>Nama Kendaraan</th>
                                                <th>Rate</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Dave</td>
                                                <td>53275535</td>
                                                <td>Dave</td>
                                                <td>53275535</td>
                                                <td>Dave</td>
                                                <td>53275535</td>
                                                <td>78890865</td>
                                                <td class="rate" data-rate="4.5">
                                                </td>
                                                <td>
                                                    <a href="{{ route('operator.detail') }}">
                                                        <button type="button" class="btn btn-inverse-success btn-icon">
                                                            <i class="ti-eye"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('operator.edit') }}">
                                                        <button type="button"
                                                            class="btn btn-inverse-primary btn-rounded btn-icon">
                                                            <i class="ti-pencil"></i>
                                                        </button>
                                                    </a>
                                                    <button type="button" class="btn btn-inverse-danger btn-icon">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Add more rows as needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- AKHIR DASHBOARD --}}
    @endsection
