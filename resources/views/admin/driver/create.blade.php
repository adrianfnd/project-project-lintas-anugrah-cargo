@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom: 50px">Form Tambah Data Driver</h4>
                    <form action="{{ route('admin.driver.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div style="text-align: center;">
                            <label for="imageUpload" style="cursor: pointer;">
                                <div class="avatar-upload"
                                    style="position: relative; display: inline-block; margin-bottom: 10px;">
                                    <input type="file" name="image" id="imageUpload" accept=".png, .jpg, .jpeg"
                                        onchange="previewImage()" style="display: none;">
                                    <img id="imagePreview" src="https://via.placeholder.com/200" alt="Image Preview"
                                        width="200" height="200"
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
                                placeholder="Username" value="{{ old('username') }}">
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email"
                                value="{{ old('email') }}">
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
                            <label for="inputPasswordConfirmation">Password Confirmation</label>
                            <input type="password" class="form-control" id="inputPasswordConfirmation"
                                name="password_confirmation" placeholder="Password Confirmation">
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputName">Nama</label>
                            <input type="text" class="form-control" id="inputName" name="name" placeholder="Name"
                                value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputPhoneNumber">Nomor HP</label>
                            <input type="text" class="form-control" id="inputPhoneNumber" name="phone_number"
                                placeholder="Phone Number" value="{{ old('phone_number') }}">
                            @if ($errors->has('phone_number'))
                                <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputLicenseNumber">Nomor Plan Kendaraan</label>
                            <input type="text" class="form-control" id="inputLicenseNumber" name="license_number"
                                placeholder="License Number" value="{{ old('license_number') }}">
                            @if ($errors->has('license_number'))
                                <span class="text-danger">{{ $errors->first('license_number') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputVehicleName">Nama Kendaraan</label>
                            <input type="text" class="form-control" id="inputVehicleName" name="vehicle_name"
                                placeholder="Vehicle Name" value="{{ old('vehicle_name') }}">
                            @if ($errors->has('vehicle_name'))
                                <span class="text-danger">{{ $errors->first('vehicle_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Alamat</label>
                            <input type="text" class="form-control" id="inputAddress" name="address"
                                placeholder="Address" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>

                        <div class="form-group" style="margin-top: 50px; margin-bottom: 20px">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a href="{{ route('admin.driver.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                preview.src = "https://via.placeholder.com/150";
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
