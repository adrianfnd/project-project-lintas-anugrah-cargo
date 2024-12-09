@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-13 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">List Data Driver</p>
                    <p class="card-description">
                    </p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>
                                                <center>Foto Driver</center>
                                            </th>
                                            <th>
                                                <center>Rate</center>
                                            </th>
                                            <th>Nama</th>
                                            <th>Nomor Hp</th>
                                            <th>Nomor Kendaraan</th>
                                            <th>Nama Kendaraan</th>
                                            <th>Alamat</th>
                                            <th>
                                                <center>Aksi</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($drivers as $index => $driver)
                                            <tr>
                                                <td>{{ $drivers->firstItem() + $index }}</td>
                                                <td>
                                                    <center><img
                                                            src="{{ $driver->image ? asset('storage/drivers/' . $driver->image) : 'https://via.placeholder.com/75' }}"
                                                            alt="Foto Driver" class="img-fluid rounded-circle"
                                                            style="object-fit: cover; width: 75px; height: 75px;">
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        @if (is_null($driver->rate))
                                                            <span>Rating Belum Tersedia</span>
                                                        @else
                                                            @for ($i = 0; $i < $driver->rate; $i++)
                                                                <i class="fas fa-star"></i>
                                                            @endfor
                                                            @for ($i = $driver->rate; $i < 5; $i++)
                                                                <i class="far fa-star"></i>
                                                            @endfor
                                                        @endif
                                                    </center>
                                                </td>
                                                <td>{{ $driver->name }}</td>
                                                <td>{{ $driver->phone_number }}</td>
                                                <td>{{ $driver->license_number }}</td>
                                                <td>{{ $driver->vehicle_name }}</td>
                                                <td>{{ $driver->address }}</td>
                                                <td>
                                                    <center>
                                                        <a href="{{ route('operator.driver.detail', $driver->id) }}">
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
                                    {{ $drivers->links('pagination::bootstrap-4') }}
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
