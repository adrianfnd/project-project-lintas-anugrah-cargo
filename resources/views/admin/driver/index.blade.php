@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-13 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">List Data Operator</p>
                    <p class="card-description">
                        <a href="{{ route('admin.driver.create') }}">
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
                                            <th>SIM</th>
                                            <th>Alamat</th>
                                            <th>Negara</th>
                                            <th>
                                            <th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>1</td>
                                        <td>Dave</td>
                                        <td><img src="#" alt="Gambar" width="100"></td>
                                        <td>Dave</td>
                                        <td>eee</td>
                                        <td>dddd</td>
                                        <td>Dave</td>
                                        <td><label class="badge badge-warning">In progress</label></td>
                                        <td>
                                            <a href="{{ route('admin.driver.detail') }}">
                                                <button type="button" class="btn btn-inverse-success btn-icon">
                                                    <i class="ti-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('admin.driver.edit') }}">
                                                <button type="button" class="btn btn-inverse-primary btn-rounded btn-icon">
                                                    <i class="ti-pencil"></i>
                                                </button>
                                            </a>
                                            <button type="button" class="btn btn-inverse-danger btn-icon">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
