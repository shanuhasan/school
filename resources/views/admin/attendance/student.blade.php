@extends('layouts.app')
@section('title', 'Student Attendance')
@section('attendance', 'active')
@section('attendance_open', 'menu-open')
@section('attendance_active', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student Attendance</h1>
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
                    <h3 class="card-title">Search Student Attendance</h3>
                </div>
                <form action="" method="get" id="searchForm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="class_id">Classes</label>
                                    <select name="class_id" id="class_id" class="form-control" required>
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
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="attendance_date">Attendance Date</label>
                                    <input type="date" class="form-control" value="{{ Request::get('attendance_date') }}"
                                        name="attendance_date" required id="attendance_date">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Search</button>
                        <a href="{{ route('admin.attendance.student') }}" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </section>

    @if (!empty(Request::get('class_id')) && !empty(Request::get('attendance_date')))
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Student List <span class="error" style="color: red"></span></h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Attendance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($students) && !empty($students->count()))
                                    @foreach ($students as $student)
                                        @php
                                            $attendance_type = '';
                                            $getAttendance = $student->getAttendance(
                                                $student->id,
                                                Request::get('class_id'),
                                                Request::get('attendance_date'),
                                            );

                                            if (!empty($getAttendance)) {
                                                $attendance_type = $getAttendance->attendance_type;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $student->id }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>
                                                <label for="">
                                                    <input type="radio"
                                                        {{ $attendance_type == App\Models\Attendance::PRESENT ? 'checked' : '' }}
                                                        value="{{ App\Models\Attendance::PRESENT }}"
                                                        name="attendance{{ $student->id }}" id="{{ $student->id }}"
                                                        class="saveAttendance">Present
                                                </label>
                                                <label for="">
                                                    <input type="radio"
                                                        {{ $attendance_type == App\Models\Attendance::ABSENT ? 'checked' : '' }}
                                                        value="{{ App\Models\Attendance::ABSENT }}"
                                                        name="attendance{{ $student->id }}" id="{{ $student->id }}"
                                                        class="saveAttendance">Absent
                                                </label>
                                                <label for="">
                                                    <input type="radio"
                                                        {{ $attendance_type == App\Models\Attendance::LATE ? 'checked' : '' }}
                                                        value="{{ App\Models\Attendance::LATE }}"
                                                        name="attendance{{ $student->id }}" id="{{ $student->id }}"
                                                        class="saveAttendance">Late
                                                </label>
                                                <label for="">
                                                    <input type="radio"
                                                        {{ $attendance_type == App\Models\Attendance::HALF_DAY ? 'checked' : '' }}
                                                        value="{{ App\Models\Attendance::HALF_DAY }}"
                                                        name="attendance{{ $student->id }}" id="{{ $student->id }}"
                                                        class="saveAttendance">HalfDay
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- /.card -->
        </section>
    @endif

@endsection

@section('script')
    <script>
        $('.saveAttendance').change(function(e) {
            e.preventDefault();
            var studentId = $(this).attr('id');
            var attendance_type = $(this).val();
            var classId = $('#class_id').val();
            var attendance_date = $('#attendance_date').val();

            $.ajax({
                url: "{{ route('admin.attendance.save') }}",
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    studentId: studentId,
                    attendance_type: attendance_type,
                    classId: classId,
                    attendance_date: attendance_date
                },
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                }
            });

        });
    </script>
@endsection
