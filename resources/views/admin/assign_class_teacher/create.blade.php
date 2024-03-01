@extends('layouts.app')
@section('title', 'Assign Class Teacher Add')
@section('assign_class_teacher', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Assign Class To Teacher</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.assign_class_teacher.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" id="assignClassTeacherForm" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="class_id">Class Name</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">Select Class</option>
                                        @foreach ($getClass as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="teacher_id">Teacher Name</label>
                                    <div>
                                        @foreach ($getTeacher as $item)
                                            <input type="checkbox" value="{{ $item->id }}" id="teacher_id"
                                                name="teacher_id[]"> {{ $item->name }} {{ $item->last_name }} <br>
                                        @endforeach
                                    </div>
                                    <p class="error teacher_id" style="color: red"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        @foreach (status() as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Assign</button>
                    <a href="{{ route('admin.assign_class_teacher.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $('#assignClassTeacherForm').submit(function(e) {
            e.preventDefault();
            var elements = $(this);
            $('button[type=submit]').prop('disabled', true);
            $.ajax({
                url: "{{ route('admin.assign_class_teacher.store') }}",
                type: 'post',
                data: elements.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false);
                    if (response['status'] == true) {
                        window.location.href = "{{ route('admin.assign_class_teacher.index') }}";
                        $('.error').removeClass('invalid-feedback').html('');
                        $('input[type="text"],input[type="number"],select').removeClass('is-invalid');

                        $('.teacher_id').html('');
                    } else {
                        var errors = response['errors'];

                        if (response['notFound'] == true) {
                            window.location.href = "{{ route('admin.assign_class_teacher.index') }}";
                        }

                        $('.error').removeClass('invalid-feedback').html('');
                        $('input[type="text"],input[type="number"],select').removeClass('is-invalid');
                        $.each(errors, function(key, val) {
                            $('#' + key).addClass('is-invalid').siblings('p').addClass(
                                'invalid-feedback').html(val);
                        });

                        if (errors['teacher_id']) {
                            $('.teacher_id').html(errors['teacher_id']);
                        } else {
                            $('.teacher_id').html('');
                        }
                    }
                },
                error: function(jqXHR) {
                    console.log('Something went wrong.');
                }
            });
        });
    </script>
@endsection
