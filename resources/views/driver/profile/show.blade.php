@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom: 50px">Profile Driver</h4>
                    <form id="profileForm" action="{{ route('driver.profile.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-4">
                            <label for="imageUpload" class="d-block">
                                <div class="avatar-upload position-relative d-inline-block">
                                    <input type="file" name="image" id="imageUpload" accept=".png, .jpg, .jpeg"
                                        onchange="previewImage()" class="d-none">
                                    <img id="imagePreview"
                                        src="{{ $driver->image ? asset('storage/drivers/' . $driver->image) : 'https://via.placeholder.com/200' }}"
                                        alt="Profile Picture" class="rounded-circle" width="150" height="150"
                                        style="object-fit: cover; border: 3px solid #ccc;">
                                    <span id="uploadText" class="badge badge-light position-absolute"
                                        style="bottom: 0; left: 50%; transform: translateX(-50%); display: none;">Upload</span>
                                </div>
                            </label>
                            @error('image')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputUsername">Username</label>
                                <input type="text" class="form-control" id="inputUsername" name="username"
                                    value="{{ old('username', $user->username) }}">
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputEmail">Email</label>
                                <input type="email" class="form-control" id="inputEmail" name="email"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputPassword">Password</label>
                                <input type="password" class="form-control" id="inputPassword" name="password">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputPasswordConfirmation">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="inputPasswordConfirmation"
                                    name="password_confirmation">
                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputName">Nama</label>
                                <input type="text" class="form-control" id="inputName" name="name"
                                    value="{{ old('name', $driver->name) }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputPhoneNumber">Nomor HP</label>
                                <input type="text" class="form-control" id="inputPhoneNumber" name="phone_number"
                                    value="{{ old('phone_number', $driver->phone_number) }}">
                                @error('phone_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputLicenseNumber">Nomor Plat Kendaraan</label>
                                <input type="text" class="form-control" id="inputLicenseNumber" name="license_number"
                                    value="{{ old('license_number', $driver->license_number) }}">
                                @error('license_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputVehicleName">Nama Kendaraan</label>
                                <input type="text" class="form-control" id="inputVehicleName" name="vehicle_name"
                                    value="{{ old('vehicle_name', $driver->vehicle_name) }}">
                                @error('vehicle_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="inputAddress">Alamat</label>
                            <input type="text" class="form-control" id="inputAddress" name="address"
                                value="{{ old('address', $driver->address) }}">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                            <a href="javascript:history.back()" class="btn btn-light ml-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Confirmation Modal -->
    <div class="modal fade" id="submitConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="submitConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitConfirmationModalLabel">Konfirmasi Submit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin melanjutkan?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button id="confirmSubmit" type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div class="modal fade" id="cancelConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="cancelConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelConfirmationModalLabel">Konfirmasi Pembatalan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin membatalkan?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button id="confirmCancel" type="button" class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('profileForm').addEventListener('submit', function(e) {
                e.preventDefault();
                $('#submitConfirmationModal').modal('show');
            });

            document.querySelector('.btn-light').addEventListener('click', function() {
                $('#cancelConfirmationModal').modal('show');
            });

            document.getElementById('confirmSubmit').addEventListener('click', function() {
                document.getElementById('profileForm').submit();
            });

            document.getElementById('confirmCancel').addEventListener('click', function() {
                window.location.href = "javascript:history.back()";
            });
        });
    </script>

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

    <script>
        function previewImage() {
            var preview = document.getElementById('imagePreview');
            var fileInput = document.getElementById('imageUpload');
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src =
                    "{{ $driver->image ? asset('images/' . $driver->image) : 'https://via.placeholder.com/200' }}";
            }
        }

        var avatarUpload = document.querySelector('.avatar-upload');
        var uploadText = document.getElementById('uploadText');

        avatarUpload.addEventListener('mouseenter', function() {
            uploadText.style.display = 'block';
        });

        avatarUpload.addEventListener('mouseleave', function() {
            uploadText.style.display = 'none';
        });
    </script>
@endsection
