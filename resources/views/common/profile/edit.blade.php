@extends('layouts.app')
@section('title', 'Profile')
@section('profile', 'active')
@section('content')

    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ getRoutes()['routeDashboard'] }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('message')
            <form method="post" action="{{ getRoutes()['routeProfileUpdate'] }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid	@enderror" placeholder="Name"
                                        value="{{ $user->name }}">
                                    @error('name')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" readonly disabled name="email" id="email"
                                        class="form-control" placeholder="Email" value="{{ $user->email }}">
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
                                                {{ $user->gender == $key ? 'selected' : '' }}>{{ $value }}
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
                                        placeholder="DOB" value="{{ $user->dob }}">
                                    <p class="error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" placeholder="Address" cols="5" rows="5">{{ $user->address }}</textarea>
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

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="permanent_address">Permanent Address</label>
                                    <textarea name="permanent_address" id="permanent_address" class="form-control" placeholder="Permanent Address"
                                        cols="10" rows="5">{{ $user->permanent_address }}</textarea>
                                    <p class="error"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control only-number"
                                        placeholder="Phone" value="{{ $user->phone }}">
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
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>

@endsection

@section('script')
    <script>
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
