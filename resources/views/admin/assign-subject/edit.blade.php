@extends('layouts.app')
@section('title', 'Edit Assign Subject')
@section('assign_subject', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Assign Subject</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.assign_subject.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" id="subjectForm" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="class_id">Class</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">Select Class</option>
                                        @foreach ($getClass as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $subject->class_id == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="subject_id">Subjects</label>
                                    <div>
                                        @foreach ($getSubject as $item)
                                            @php
                                                $checked = '';
                                            @endphp
                                            @foreach ($subjectIds as $assignSubject)
                                                @if ($assignSubject->subject_id == $item->id)
                                                    @php
                                                        $checked = 'checked';
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <input {{ $checked }} type="checkbox" value="{{ $item->id }}"
                                                id="subject_id" name="subject_id[]"> {{ $item->name }} <br>
                                        @endforeach
                                    </div>
                                    <p class="error subject_id" style="color: red"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ $subject->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ $subject->status == 0 ? 'selected' : '' }} value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.assign_subject.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $('#subjectForm').submit(function(e) {
            e.preventDefault();
            var elements = $(this);
            $('button[type=submit]').prop('disabled', true);
            $.ajax({
                url: "{{ route('admin.assign_subject.update', $subject->id) }}",
                type: 'post',
                data: elements.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false);
                    if (response['status'] == true) {

                        window.location.href = "{{ route('admin.assign_subject.index') }}";
                        $('.error').removeClass('invalid-feedback').html('');
                        $('input[type="text"],input[type="number"],select').removeClass('is-invalid');
                        $('.subject_id').html('');
                    } else {

                        if (response['notFound'] == true) {
                            window.location.href = "{{ route('admin.assign_subject.index') }}";
                        }

                        var errors = response['errors'];

                        $('.error').removeClass('invalid-feedback').html('');
                        $('input[type="text"],input[type="number"],select').removeClass('is-invalid');
                        $.each(errors, function(key, val) {
                            $('#' + key).addClass('is-invalid').siblings('p').addClass(
                                'invalid-feedback').html(val);
                        });

                        if (errors['subject_id']) {
                            $('.subject_id').html(errors['subject_id']);
                        } else {
                            $('.subject_id').html('');
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
