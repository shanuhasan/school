@extends('layouts.app')
@section('title', 'Attendance Report')
@section('report', 'active')
@section('attendance_open', 'menu-open')
@section('attendance_active', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Attendance Report (Total:- {{ $data->total() }})</h1>
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
                    <h3 class="card-title">Search Attendance Report</h3>
                </div>
                <form action="" method="get" id="searchForm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="class_id">Classes</label>
                                    <select name="class_id" class="form-control" required>
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
                                        name="attendance_date" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="attendance_type">Attendance Type</label>
                                    <select name="attendance_type" class="form-control" required>
                                        <option value="">Select Class</option>
                                        @foreach (App\Models\Attendance::getAttendanceDropdown() as $key => $item)
                                            <option value="{{ $key }}"
                                                {{ Request::get('attendance_type') == $key ? 'selected' : '' }}>
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Search</button>
                        <a href="{{ route('admin.attendance.report') }}" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </section>


    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Attendance List <span class="error" style="color: red"></span></h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Class</th>
                                <th>Attendance Type</th>
                                <th>Attendance Date</th>
                                <th>Created By</th>
                                <th>Created Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $item->student_id }}</td>
                                    <td>{{ getName($item->student_id) }}</td>
                                    <td>{{ getClassName($item->class_id) }}</td>
                                    <td>{{ App\Models\Attendance::getAttendanceDropdown($item->attendance_type) }}
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($item->attendance_date)) }}</td>
                                    <td>{{ getName($item->created_by) }}</td>
                                    <td>{{ date('d-m-Y H:i A', strtotime($item->created_at)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%">Records not found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="card-footer clearfix">
                        {!! $data->appends(request()->input())->links('pagination::bootstrap-5') !!}
                    </div>
                </div>

            </div>
        </div>
        <!-- /.card -->
    </section>

@endsection

@section('script')
    <script></script>
@endsection
