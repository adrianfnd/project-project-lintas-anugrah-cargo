@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-13 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">List Data Operator</p>
                    <p class="card-description">
                        <a href="{{ route('admin.operator.create') }}">
                            <button type="button" class="btn btn-primary btn-icon-text">
                                <i class="bi bi-plus btn-icon-prepend"></i>
                                Tambah Data
                            </button>
                        </a>
                    </p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Gambar</th>
                                            <th>Nomor Hp</th>
                                            <th>Nomor Lisensi</th>
                                            <th>Nama Kendaraan</th>
                                            <th>Alamat</th>
                                            <th>Rate</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>1</td>
                                        <td>Dave</td>
                                        <td>53275535</td>
                                        <td>Dave</td>
                                        <td>53275535</td>
                                        <td>Dave</td>
                                        <td>53275535</td>
                                        <td>78890865</td>
                                        <td><label class="badge badge-warning">In progress</label></td>
                                        <td>
                                            <a href="{{ route('admin.operator.detail') }}">
                                                <button type="button" class="btn btn-inverse-success btn-icon">
                                                    <i class="ti-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('admin.operator.edit') }}">
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
                            <!-- Pagination -->
                            <div class="clearfix"></div>
                            <div class="d-flex justify-content-end mt-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination" style="color: #9f5aff!important">
                                        {{ $operators->links('pagination::bootstrap-4') }}
                                    </ul>
                                </nav>
                            </div>
                            <!-- End Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
