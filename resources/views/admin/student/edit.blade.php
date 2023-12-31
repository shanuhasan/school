@extends('layouts.app')
@section('title', 'Edit Student')
@section('student', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Student</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.student.index') }}" class="btn btn-primary">Back</a>
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
                                    <input type="text" name="name" id="name" value="{{ $user->name }}"
                                        class="form-control" placeholder="Name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="class_id">Class<span style="color:red">*</span></label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">Select Class</option>
                                        @foreach ($getClass as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $user->class_id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        placeholder="Address" value="{{ $user->address }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city" class="form-control"
                                        placeholder="City" value="{{ $user->city }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" name="pincode" id="pincode" class="form-control only-number"
                                        placeholder="Pincode" value="{{ $user->pincode }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="admission_no">Admission Number<span style="color:red">*</span></label>
                                    <input type="text" name="admission_no" id="admission_no" class="form-control"
                                        placeholder="Admission Number" value="{{ $user->admission_no }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="admission_date">Admission Date<span style="color:red">*</span></label>
                                    <input type="date" name="admission_date" id="admission_date" class="form-control"
                                        placeholder="Admission Date" value="{{ $user->admission_date }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        placeholder="Phone" value="{{ $user->phone }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rollno">Roll No.</label>
                                    <input type="text" name="rollno" id="rollno" class="form-control"
                                        placeholder="Roll No." value="{{ $user->rollno }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender">Gender<span style="color:red">*</span></label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">select</option>
                                        @foreach (gender() as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $user->gender == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dob">DOB<span style="color:red">*</span></label>
                                    <input type="date" name="dob" id="dob" class="form-control"
                                        placeholder="DOB" value="{{ $user->dob }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="caste">Caste</label>
                                    <input type="text" name="caste" id="caste" class="form-control"
                                        placeholder="Caste" value="{{ $user->caste }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="religion">Religion<span style="color:red">*</span></label>
                                    <select name="religion" id="religion" class="form-control">
                                        <option value="">select</option>
                                        @foreach (religion() as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $user->religion == $key ? 'selected' : '' }}>{{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="blood_group">Blood Group</label>
                                    <input type="text" name="blood_group" id="blood_group" class="form-control"
                                        placeholder="Blood Group" value="{{ $user->blood_group }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="height">Height</label>
                                    <input type="text" name="height" id="height" class="form-control"
                                        placeholder="Height" value="{{ $user->height }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="weight">Weight</label>
                                    <input type="text" name="weight" id="weight" class="form-control"
                                        placeholder="Weight" value="{{ $user->weight }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" value="{{ $user->email }}" readonly
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
                                                {{ $user->status == $key ? 'selected' : '' }}>{{ $value }}</option>
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
                                @if (!empty($user->image))
                                    <div>
                                        <img width="200" src="{{ asset('uploads/user/' . $user->image) }}"
                                            alt="">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.student.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
                url: "{{ route('admin.student.update', $user->id) }}",
                type: 'put',
                data: elements.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false);
                    if (response['status'] == true) {

                        window.location.href = "{{ route('admin.student.index') }}";
                        $('.error').removeClass('invalid-feedback').html('');
                        $('input[type="text"],input[type="number"],select').removeClass('is-invalid');
                    } else {

                        if (response['notFound'] == true) {
                            window.location.href = "{{ route('admin.student.index') }}";
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
