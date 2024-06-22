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
                                            <th>Nama Driver</th>
                                            <th>Waktu Mulai</th>
                                            <th>Estimasi</th>
                                            <th>Waktu Sampai</th>
                                            <th>Jumlah Paket</th>
                                            <th>Status</th>
                                            <th>
                                                <center>Aksi</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($riwayatpakets as $index => $riwayatpaket)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $riwayatpaket->suratJalan->driver->name }}</td>
                                                <td>{{ $riwayatpaket->suratJalan->start_delivery_time }}</td>
                                                <td>{{ $riwayatpaket->suratJalan->estimated_delivery_time }}</td>
                                                <td>{{ $riwayatpaket->suratJalan->end_delivery_time ?? 'Belum sampai' }}
                                                </td>
                                                <td>{{ count(json_decode($riwayatpaket->suratJalan->list_paket, true)) }}
                                                </td>
                                                <td>{{ $riwayatpaket->status }}</td>
                                                <td>
                                                    <center>
                                                        <a href="{{ route('operator.riwayat.detail', $riwayatpaket->id) }}">
                                                            <button type="button"
                                                                class="btn btn-inverse-success btn-rounded btn-icon">
                                                                <i class="ti-eye"></i>
                                                            </button>
                                                        </a>
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
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
