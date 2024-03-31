@extends('layouts.app')
@section('title', 'Exam Schedule')
@section('exam_schedule', 'active')
@section('exam_open', 'menu-open')
@section('exam_active', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Exam Schedule</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('message')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Search Exam Schedule</h3>
                </div>
                <form action="" method="get" id="searchForm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="exam_id">Exam</label>
                                    <select name="exam_id" id="exam_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($getExams as $item)
                                            <option value="{{ $item->id }}"
                                                {{ Request::get('exam_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="class_id">Classes</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">Select Class</option>
                                        @foreach ($getClass as $item)
                                            <option value="{{ $item->id }}"
                                                {{ Request::get('class_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Search</button>
                        <a href="{{ route('admin.exam_schedule.index') }}" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </section>

    @if (!empty(Request::get('class_id')) && !empty(Request::get('exam_id')))

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <form id="scheduleForm" method="post">
                    @csrf
                    <input type="hidden" value="{{ Request::get('class_id') }}" name="class_id">
                    <input type="hidden" value="{{ Request::get('exam_id') }}" name="exam_id">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Exam Schedule</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Exam Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Room No.</th>
                                        <th>Marks</th>
                                        <th>Passing Marks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($data as $item)
                                        <tr>
                                            <th>
                                                <input type="hidden" value="{{ $item['subject_id'] }}"
                                                    name="schedule[{{ $i }}][subject_id]">
                                                {{ getSubjectName($item['subject_id']) }}
                                            </th>
                                            <td>
                                                <input type="date" value="{{ $item['exam_date'] }}"
                                                    name="schedule[{{ $i }}][exam_date]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="time" value="{{ $item['start_time'] }}"
                                                    name="schedule[{{ $i }}][start_time]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="time" value="{{ $item['end_time'] }}"
                                                    name="schedule[{{ $i }}][end_time]" class="form-control">
                                            </td>
                                            <td>
                                                <input style="width: 200px" type="text"
                                                    name="schedule[{{ $i }}][room_no]"
                                                    value="{{ $item['room_no'] }}" class="form-control">
                                            </td>
                                            <td>
                                                <input style="width: 200px" type="text"
                                                    name="schedule[{{ $i }}][marks]"
                                                    value="{{ $item['marks'] }}" class="form-control">
                                            </td>
                                            <td>
                                                <input style="width: 200px" type="text"
                                                    name="schedule[{{ $i }}][passing_marks]"
                                                    value="{{ $item['passing_marks'] }}" class="form-control">
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="text-align: center;padding:20px">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
    @endif
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $('#scheduleForm').submit(function(e) {
            e.preventDefault();
            var elements = $(this);
            $('button[type=submit]').prop('disabled', true);
            $.ajax({
                url: "{{ route('admin.exam_schedule.store') }}",
                type: 'post',
                data: elements.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false);
                    if (response['status'] == true) {
                        window.location.href = "{{ route('admin.exam_schedule.index') }}";
                        $('.error').removeClass('invalid-feedback').html('');
                        $('input[type="text"],input[type="time"],select').removeClass('is-invalid');
                    } else {
                        var errors = response['errors'];

                        if (response['notFound'] == true) {
                            window.location.href = "{{ route('admin.exam_schedule.index') }}";
                        }

                        $('.error').removeClass('invalid-feedback').html('');
                        $('input[type="text"],input[type="time"],select').removeClass('is-invalid');
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
    </script>
@endsection
