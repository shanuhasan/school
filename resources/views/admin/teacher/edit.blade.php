@extends('layouts.app')
@section('title', 'Edit Teacher')
@section('teacher', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Teacher</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.teacher.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" id="userForm" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ $teacher->name }}"
                                        class="form-control text-to-upper" placeholder="Name">
                                    <p></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender">Gender<span style="color:red">*</span></label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">select</option>
                                        @foreach (gender() as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $teacher->gender == $key ? 'selected' : '' }}>{{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dob">DOB<span style="color:red">*</span></label>
                                    <input type="date" name="dob" id="dob" class="form-control"
                                        placeholder="DOB" value="{{ $teacher->dob }}">
                                    <p class="error"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="admission_date">Date of Joining<span style="color:red">*</span></label>
                                    <input type="date" name="admission_date" id="admission_date" class="form-control"
                                        placeholder="Date of Joining" value="{{ $teacher->admission_date }}">
                                    <p class="error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" placeholder="Address" cols="5" rows="5">{{ $teacher->address }}</textarea>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city" class="form-control"
                                        placeholder="City" value="{{ $teacher->city }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" name="pincode" id="pincode" maxlength="6"
                                        class="form-control only-number" placeholder="Pincode"
                                        value="{{ $teacher->pincode }}">
                                    <p class="error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="permanent_address">Permanent Address</label>
                                    <textarea name="permanent_address" id="permanent_address" class="form-control" placeholder="Permanent Address"
                                        cols="10" rows="5">{{ $teacher->permanent_address }}</textarea>
                                    <p class="error"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control only-number"
                                        placeholder="Phone" value="{{ $teacher->phone }}">
                                    <p class="error"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" value="{{ $teacher->email }}" readonly
                                        id="email" class="form-control" placeholder="Email">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        @foreach (status() as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $teacher->status == $key ? 'selected' : '' }}>{{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" placeholder="Password" id="password"
                                        name="password">
                                    <span>To change password you have to enter a value, otherwise leave blank.</span>
                                    <p class="error"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <input type="hidden" name="image_id" id="image_id" value="">
                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($teacher->image))
                                    <div class="image">
                                        <img width="200" src="{{ asset('uploads/user/' . $teacher->image) }}"
                                            class="img-circle elevation-2" width='40'>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('admin.teacher.index') }}" class="btn btn-info">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $('#userForm').submit(function(e) {
            e.preventDefault();
            var elements = $(this);
            $('button[type=submit]').prop('disabled', true);
            $.ajax({
                url: "{{ route('admin.teacher.update', $teacher->id) }}",
                type: 'put',
                data: elements.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false);
                    if (response['status'] == true) {

                        window.location.href = "{{ route('admin.teacher.index') }}";
                        $('.error').removeClass('invalid-feedback').html('');
                        $('input[type="text"],input[type="number"],select').removeClass('is-invalid');
                    } else {

                        if (response['notFound'] == true) {
                            window.location.href = "{{ route('admin.teacher.index') }}";
                        }

                        var errors = response['errors'];

                        $('.error').removeClass('invalid-feedback').html('');
                        $('input[type="text"],input[type="number"],select').removeClass('is-invalid');
                        $.each(errors, function(key, val) {
                            $('#' + key).addClass('is-invalid').siblings('p').addClass(
                                'invalid-feedback').html(val);
                        });
                    }
                },
                error: function(jqXHR) {
                    console.log('Something went wrong.');
                }
            });
        });

        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                $("#image_id").val(response.image_id);
                //console.log(response)
            }
        });
    </script>
@endsection
