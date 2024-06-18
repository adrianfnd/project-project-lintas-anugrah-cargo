@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom: 50px">Form Edit Data Driver</h4>
                    <form id="driverForm" action="{{ route('admin.driver.update', $driver->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div style="text-align: center;">
                            <label for="imageUpload" style="cursor: pointer;">
                                <div class="avatar-upload"
                                    style="position: relative; display: inline-block; margin-bottom: 10px;">
                                    <input type="file" name="image" id="imageUpload" accept=".png, .jpg, .jpeg"
                                        onchange="previewImage()" style="display: none;">
                                    <img id="imagePreview"
                                        src="{{ $driver->image ? asset('storage/drivers/' . $driver->image) : 'https://via.placeholder.com/200' }}"
                                        alt="Image Preview" width="200" height="200"
                                        style="border-radius: 50%; object-fit: cover; border: 3px solid #ccc;">
                                    <span id="uploadText"
                                        style="display: none; position: absolute; bottom: 5px; left: 50%; transform: translateX(-50%); background-color: rgba(255, 255, 255, 0.8); padding: 5px; border-radius: 10px;">Upload</span>
                                </div>
                            </label>
                            <div>
                                @if ($errors->has('image'))
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputUsername">Username</label>
                            <input type="text" class="form-control" id="inputUsername" name="username"
                                placeholder="Username" value="{{ old('username', $user->username) }}">
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email"
                                value="{{ old('email', $user->email) }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input type="password" class="form-control" id="inputPassword" name="password"
                                placeholder="Password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputPasswordConfirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="inputPasswordConfirmation"
                                name="password_confirmation" placeholder="Konfirmasi Password">
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputName">Nama</label>
                            <input type="text" class="form-control" id="inputName" name="name" placeholder="Nama"
                                value="{{ old('name', $driver->name) }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputPhoneNumber">Nomor HP</label>
                            <input type="text" class="form-control" id="inputPhoneNumber" name="phone_number"
                                placeholder="Nomor HP" value="{{ old('phone_number', $driver->phone_number) }}">
                            @if ($errors->has('phone_number'))
                                <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputLicenseNumber">Nomor Plat Kendaraan</label>
                            <input type="text" class="form-control" id="inputLicenseNumber" name="license_number"
                                placeholder="Nomor Plat Kendaraan"
                                value="{{ old('license_number', $driver->license_number) }}">
                            @if ($errors->has('license_number'))
                                <span class="text-danger">{{ $errors->first('license_number') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputVehicleName">Nama Kendaraan</label>
                            <input type="text" class="form-control" id="inputVehicleName" name="vehicle_name"
                                placeholder="Nama Kendaraan" value="{{ old('vehicle_name', $driver->vehicle_name) }}">
                            @if ($errors->has('vehicle_name'))
                                <span class="text-danger">{{ $errors->first('vehicle_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Alamat</label>
                            <input type="text" class="form-control" id="inputAddress" name="address"
                                placeholder="Alamat" value="{{ old('address', $driver->address) }}">
                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a class="btn btn-light">Cancel</a>
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
            document.getElementById('driverForm').addEventListener('submit', function(e) {
                e.preventDefault();
                $('#submitConfirmationModal').modal('show');
            });

            document.querySelector('.btn-light').addEventListener('click', function() {
                $('#cancelConfirmationModal').modal('show');
            });

            document.getElementById('confirmSubmit').addEventListener('click', function() {
                document.getElementById('driverForm').submit();
            });

            document.getElementById('confirmCancel').addEventListener('click', function() {
                window.location.href = "{{ route('admin.driver.index') }}";
            });
        });
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
                    "{{ $driver->image ? asset('storage/drivers/' . $driver->image) : 'https://via.placeholder.com/200' }}";
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
