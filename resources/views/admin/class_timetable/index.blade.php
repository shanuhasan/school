@extends('layouts.app')
@section('title', 'Class Timetable')
@section('class_timetable', 'active')
@section('academic_open', 'menu-open')
@section('academic_active', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Class Timetable</h1>
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
                <form action="" method="get" id="searchForm">
                    <div class="card-body">
                        <div class="row">
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

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="subject_id">Subjects</label>
                                    <select name="subject_id" id="subject_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($getSubjects as $item)
                                            <option value="{{ $item->subject_id }}"
                                                {{ Request::get('subject_id') == $item->subject_id ? 'selected' : '' }}>
                                                {{ getSubjectName($item->subject_id) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-success">Search</button>
                        <a href="{{ route('admin.class_timetable.index') }}" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </section>

    @if (!empty(Request::get('class_id')) && !empty(Request::get('subject_id')))

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <form id="timeTableForm" method="post">
                    @csrf
                    <input type="hidden" value="{{ Request::get('class_id') }}" name="class_id">
                    <input type="hidden" value="{{ Request::get('subject_id') }}" name="subject_id">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Class Timetable</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Week</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Room No.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($week as $item)
                                        <tr>
                                            <th>
                                                <input type="hidden" value="{{ $item['week_id'] }}"
                                                    name="timetable[{{ $i }}][week_id]">
                                                {{ $item['week_name'] }}
                                            </th>
                                            <td>
                                                <input type="time" value="{{ $item['start_time'] }}"
                                                    name="timetable[{{ $i }}][start_time]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="time" value="{{ $item['end_time'] }}"
                                                    name="timetable[{{ $i }}][end_time]" class="form-control">
                                            </td>
                                            <td>
                                                <input style="width: 200px" type="text"
                                                    name="timetable[{{ $i }}][room_no]"
                                                    value="{{ $item['room_no'] }}" class="form-control">
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
    <script type="text/javascript">
        $("#class_id").change(function(e) {
            e.preventDefault();
            var class_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.class_timetable.getSubject') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    class_id: class_id,
                },
                dataType: "json",
                success: function(response) {
                    $('#subject_id').html(response.html);
                }
            });
        });

        $("#subject_id,#class_id").change(function(e) {
            $('#searchForm').submit();
        });
    </script>

    <script>
        $('#timeTableForm').submit(function(e) {
            e.preventDefault();
            var elements = $(this);
            $('button[type=submit]').prop('disabled', true);
            $.ajax({
                url: "{{ route('admin.class_timetable.store') }}",
                type: 'post',
                data: elements.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false);
                    if (response['status'] == true) {
                        window.location.href = "{{ route('admin.class_timetable.index') }}";
                        $('.error').removeClass('invalid-feedback').html('');
                        $('input[type="text"],input[type="time"],select').removeClass('is-invalid');
                    } else {
                        var errors = response['errors'];

                        if (response['notFound'] == true) {
                            window.location.href = "{{ route('admin.class_timetable.index') }}";
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
