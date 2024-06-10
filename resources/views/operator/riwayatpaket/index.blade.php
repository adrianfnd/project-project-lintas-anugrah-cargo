@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-13 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">List Riwayat Paket</p>
                    <p class="card-description">
                    </p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Image</th>
                                            <th>Driver ID</th>
                                            <th>Paket ID</th>
                                            <th>Surat Jalan ID</th>
                                            <th>Status</th>
                                            <th>
                                                <center>Aksi</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    {{-- <tbody>
                                        {{-- Looping untuk menampilkan data riwayat paket
                                        @foreach ($riwayatpakets as $index => $riwayatpaket)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><img src="{{ $riwayatpaket->image }}" alt="Image"
                                                        style="width: 50px; height: auto;"></td>
                                                <td>{{ $riwayatpaket->driver_id }}</td>
                                                <td>{{ $riwayatpaket->paket_id }}</td>
                                                <td>{{ $riwayatpaket->surat_jalan_id }}</td>
                                                <td>{{ $riwayatpaket->status }}</td>
                                                <td>
                                                    <center>
                                                        <a href="{{ route('operator.riwayatpaket.detail', $riwayatpaket->id) }}">
                                                            <button type="button"
                                                                class="btn btn-inverse-success btn-rounded btn-icon">
                                                                <i class="ti-eye"></i>
                                                            </button>
                                                        </a>
                                                    </center>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody> --}}
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        var successMessage = '{{ session('success') }}';
        var errorMessage = '{{ session('error') }}';
        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successMessage,
                showConfirmButton: false,
                timer: 2000
            });
        }

        if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: errorMessage,
                showConfirmButton: false,
                timer: 2000
            });
        }
    </script>
@endsection
