@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-13 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">List Data Tracking Surat Jalan</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Jumlah Paket</th>
                                            <th>Wilayah Pengirim</th>
                                            <th>Wilayah Penerima</th>
                                            <th>Nama Driver</th>
                                            <th>Nomor Telpon</th>
                                            <th>Nomor Kendaraan</th>
                                            <th>
                                                <center>Status</center>
                                            </th>
                                            <th>
                                                <center>Aksi</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suratjalans as $index => $suratjalan)
                                            <tr>
                                                <td>{{ $suratjalans->firstItem() + $index }}</td>
                                                <td>{{ count(json_decode($suratjalan->list_paket)) }} Paket</td>
                                                <td>{{ $suratjalan->sender }}</td>
                                                <td>{{ $suratjalan->receiver }}</td>
                                                <td>{{ $suratjalan->driver->name }}</td>
                                                <td>{{ $suratjalan->driver->phone_number }}</td>
                                                <td>{{ $suratjalan->driver->license_number }}</td>
                                                <td>
                                                    <center>
                                                        @if ($suratjalan->status == 'proses')
                                                            <span
                                                                class="badge badge-info">{{ ucfirst($suratjalan->status) }}</span>
                                                        @elseif ($suratjalan->status == 'dikirim')
                                                            <span
                                                                class="badge badge-warning">{{ ucfirst($suratjalan->status) }}</span>
                                                        @elseif ($suratjalan->status == 'sampai')
                                                            <span
                                                                class="badge badge-success">{{ ucfirst($suratjalan->status) }}</span>
                                                        @else
                                                            <span class="badge badge-danger">Status tidak diketahui</span>
                                                        @endif
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <a
                                                            href="{{ route('operator.maptracking.detail', $suratjalan->id) }}">
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
                                <div class="d-flex justify-content-end">
                                    {{ $suratjalans->links('pagination::bootstrap-4') }}
                                </div>
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
