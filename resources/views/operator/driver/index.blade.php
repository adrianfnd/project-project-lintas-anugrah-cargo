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
                                            <th>Created By</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Phone Number</th>
                                            <th>License Number</th>
                                            <th>Vehicle Name</th>
                                            <th>Address</th>
                                            <th>Rate</th>
                                            <th>
                                                <center>Aksi</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    {{-- <tbody>
                                        @foreach ($drivers as $driver)
                                            <tr>
                                                <td>{{ $driver->created_by }}</td>
                                                <td>{{ $driver->name }}</td>
                                                <td><img src="{{ $driver->image }}" alt="Image"
                                                        style="width: 50px; height: auto;"></td>
                                                <td>{{ $driver->phone_number }}</td>
                                                <td>{{ $driver->license_number }}</td>
                                                <td>{{ $driver->vehicle_name }}</td>
                                                <td>{{ $driver->address }}</td>
                                                <td>{{ $driver->rate }}</td>
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
