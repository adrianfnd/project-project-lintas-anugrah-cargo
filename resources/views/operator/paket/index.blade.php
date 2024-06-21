@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-13 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">List Data Paket</p>
                    <p class="card-description">
                        <a href="{{ route('operator.paket.create') }}">
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
                                            <th>
                                                <center>Foto Paket</center>
                                            </th>
                                            <th>Tracking Number</th>
                                            <th>Sender Name</th>
                                            <th>Sender Address</th>
                                            <th>Receiver Name</th>
                                            <th>Receiver Address</th>
                                            <th>
                                                <center>Status</center>
                                            </th>
                                            <th>
                                                <center>Aksi</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pakets as $index => $paket)
                                            <tr>
                                                <td>{{ $pakets->firstItem() + $index }}</td>
                                                <td>
                                                    <center><img
                                                            src="{{ $paket->image ? asset('storage/pakets/' . $paket->image) : 'https://via.placeholder.com/75' }}"
                                                            alt="Foto Paket" class="img-fluid rounded-circle"
                                                            style="object-fit: cover; width: 75px; height: 75px;">
                                                    </center>
                                                </td>
                                                <td>{{ $paket->tracking_number }}</td>
                                                <td>{{ $paket->sender_name }}</td>
                                                <td>{{ $paket->sender_address }}</td>
                                                <td>{{ $paket->receiver_name }}</td>
                                                <td>{{ $paket->receiver_address }}</td>
                                                <td>
                                                    <center>
                                                        @if ($paket->status == 'diinput' or $paket->status == 'proses')
                                                            <span
                                                                class="badge badge-info">{{ ucfirst($paket->status) }}</span>
                                                        @elseif ($paket->status == 'dikirim')
                                                            <span
                                                                class="badge badge-warning">{{ ucfirst($paket->status) }}</span>
                                                        @elseif ($paket->status == 'sampai')
                                                            <span
                                                                class="badge badge-success">{{ ucfirst($paket->status) }}</span>
                                                        @else
                                                            <span class="badge badge-danger">Status tidak diketahui</span>
                                                        @endif
                                                    </center>
                                                <td>
                                                    <center>
                                                        <a href="{{ route('operator.paket.detail', $paket->id) }}">
                                                            <button type="button"
                                                                class="btn btn-inverse-success btn-rounded btn-icon">
                                                                <i class="ti-eye"></i>
                                                            </button>
                                                        </a>
                                                        @if ($paket->status == 'proses' or $paket->status == 'diinput')
                                                            <a href="{{ route('operator.paket.edit', $paket->id) }}">
                                                                <button type="button"
                                                                    class="btn btn-inverse-primary btn-rounded btn-icon">
                                                                    <i class="ti-pencil"></i>
                                                                </button>
                                                            </a>
                                                            <button type="button"
                                                                class="btn btn-inverse-danger btn-rounded btn-icon"
                                                                data-toggle="modal"
                                                                data-target="#deleteModal{{ $paket->id }}">
                                                                <i class="ti-trash"></i>
                                                            </button>
                                                        @endif
                                                    </center>
                                                </td>
                                            </tr>

                                            <!-- Modal Konfirmasi Hapus -->
                                            <div class="modal fade" id="deleteModal{{ $paket->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus
                                                                Data Paket</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus data paket ini?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                            <form
                                                                action="{{ route('operator.paket.destroy', $paket->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    {{ $pakets->links('pagination::bootstrap-4') }}
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
