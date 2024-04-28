@extends('layouts.app')
@section('title', 'Marks Register')
@section('marks_register', 'active')
@section('exam_open', 'menu-open')
@section('exam_active', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Marks Register</h1>
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
                    <h3 class="card-title">Search Marks Register</h3>
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
                                            <option value="{{ $item->exam_id }}"
                                                {{ Request::get('exam_id') == $item->exam_id ? 'selected' : '' }}>
                                                {{ getExamName($item->exam_id) }}
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
                                            <option value="{{ $item->class_id }}"
                                                {{ Request::get('class_id') == $item->class_id ? 'selected' : '' }}>
                                                {{ getClassName($item->class_id) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Search</button>
                        <a href="{{ route('teacher.marks_register') }}" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </section>

    @if (!empty($subjects) && !empty($subjects->count()))
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Marks Register <span class="error" style="color: red"></span></h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    @foreach ($subjects as $item)
                                        <th>{{ $item->subject_name }}
                                            ({{ $item->subject_type }}: {{ $item->passing_marks }}/{{ $item->marks }})
                                        </th>
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($students) && !empty($students->count()))
                                    @foreach ($students as $student)
                                        <form class="marksRegisterForm" method="post">
                                            @csrf
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <input type="hidden" name="exam_id" value="{{ Request::get('exam_id') }}">
                                            <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                                            <tr>
                                                <td>{{ $student->name }} {{ $student->last_name }}</td>
                                                @php
                                                    $i = 1;
                                                    $grandTotal = 0;
                                                    $grandSubjectTotal = 0;
                                                    $totalPassingMarks = 0;
                                                    $pass_fail = 0;
                                                @endphp
                                                @foreach ($subjects as $item)
                                                    @php
                                                        $totalMark = 0;
                                                        $getMark = $item->getMark(
                                                            $student->id,
                                                            Request::get('exam_id'),
                                                            Request::get('class_id'),
                                                            $item->subject_id,
                                                        );
                                                        if (!empty($getMark)) {
                                                            $totalMark =
                                                                // $getMark->class_work +
                                                                // $getMark->home_work +
                                                                // $getMark->test_work +
                                                                $getMark->exam;
                                                        }
                                                        $grandTotal = $grandTotal + $totalMark;
                                                        $grandSubjectTotal = $grandSubjectTotal + $item->marks;
                                                        $totalPassingMarks = $totalPassingMarks + $item->passing_marks;
                                                    @endphp
                                                    <td>
                                                        <input type="hidden" name="marks[{{ $i }}][id]"
                                                            value="{{ $item->id }}">
                                                        <input type="hidden" name="marks[{{ $i }}][subject_id]"
                                                            value="{{ $item->subject_id }}">
                                                        {{-- <div style="margin-bottom: 10px">
                                                            Class Work
                                                            <input type="text"
                                                                name="marks[{{ $i }}][class_work]"
                                                                placeholder="Enter Marks" style="width: 200px"
                                                                class="form-control only-number"
                                                                id="class_work_{{ $student->id }}{{ $item->subject_id }}"
                                                                value="{{ !empty($getMark->class_work) ? $getMark->class_work : '' }}">
                                                        </div>
                                                        <div style="margin-bottom: 10px">
                                                            Home Work
                                                            <input type="text"
                                                                name="marks[{{ $i }}][home_work]"
                                                                placeholder="Enter Marks" style="width: 200px"
                                                                class="form-control only-number"
                                                                id="home_work_{{ $student->id }}{{ $item->subject_id }}"
                                                                value="{{ !empty($getMark->home_work) ? $getMark->home_work : '' }}">
                                                        </div>
                                                        <div style="margin-bottom: 10px">
                                                            Test Work
                                                            <input type="text"
                                                                name="marks[{{ $i }}][test_work]"
                                                                placeholder="Enter Marks" style="width: 200px"
                                                                class="form-control only-number"
                                                                id="test_work_{{ $student->id }}{{ $item->subject_id }}"
                                                                value="{{ !empty($getMark->test_work) ? $getMark->test_work : '' }}">
                                                        </div> --}}
                                                        <div style="margin-bottom: 10px">
                                                            {{-- Exam --}}
                                                            <input type="text" name="marks[{{ $i }}][exam]"
                                                                placeholder="Enter Marks" style="width: 200px"
                                                                class="form-control only-number"
                                                                id="exam_{{ $student->id }}{{ $item->subject_id }}"
                                                                value="{{ !empty($getMark->exam) ? $getMark->exam : '' }}">
                                                        </div>
                                                        <div style="margin-bottom: 10px">
                                                            <button type="button" class="btn btn-primary saveSingleData"
                                                                id="{{ $student->id }}"
                                                                data-sub="{{ $item->subject_id }}"
                                                                data-exam="{{ Request::get('exam_id') }}"
                                                                data-class="{{ Request::get('class_id') }}"
                                                                data-schedule="{{ $item->id }}">Save</button>
                                                        </div>
                                                        @if (!empty($getMark))
                                                            <div style="margin-bottom: 10px">
                                                                <b>Total Mark:</b> {{ $totalMark }}<br>
                                                                <b>Passing Mark:</b> {{ $item->passing_marks }}<br>
                                                                @php
                                                                    $getMarkGrade = App\Models\MarkGrade::getGrade(
                                                                        $totalMark,
                                                                    );
                                                                @endphp
                                                                @if (!empty($getMarkGrade))
                                                                    <b>Grade:</b> {{ $getMarkGrade }}<br>
                                                                @endif
                                                                @if ($item->passing_marks >= $totalMark)
                                                                    <b style="color: red">Fail</b>
                                                                    @php
                                                                        $pass_fail = 1;
                                                                    @endphp
                                                                @else
                                                                    <b style="color: green">Pass</b>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        <p class="error_{{ $student->id }}{{ $item->subject_id }}"
                                                            style="color: red"></p>
                                                    </td>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach
                                                <td>
                                                    <button type="submit" class="btn btn-success">Save</button>
                                                    <br>
                                                    @if (!empty($grandTotal))
                                                        <span>Grand Total:
                                                            {{ $grandTotal }}/{{ $grandSubjectTotal }}</span>
                                                        <br>
                                                        @php
                                                            $per = ($grandTotal * 100) / $grandSubjectTotal;
                                                            $getGrade = App\Models\MarkGrade::getGrade($per);
                                                        @endphp
                                                        <span>Percenrage: {{ round($per, 2) }}%</span>
                                                        <br>
                                                        @if (!empty($getGrade))
                                                            <span>Grade: {{ $getGrade }}</span>
                                                            <br>
                                                        @endif
                                                        @if ($pass_fail == 1)
                                                            Result: <b style="color: red">Fail</b>
                                                        @else
                                                            Result: <b style="color: green">Pass</b>
                                                        @endif
                                                    @endif

                                                </td>
                                            </tr>
                                        </form>
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
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $('.marksRegisterForm').submit(function(e) {
            e.preventDefault();
            var elements = $(this);
            $('button[type=submit]').prop('disabled', true);
            $.ajax({
                url: "{{ route('teacher.marks_register.store') }}",
                type: 'post',
                data: elements.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false);
                    if (response['status'] == true) {
                        // window.location.href = "{{ route('teacher.marks_register') }}";
                        location.reload();
                        $('.error').html('');
                    } else {
                        $('.error').html(response.message);
                        location.reload();
                    }
                },
                error: function(jqXHR) {
                    console.log('Something went wrong.');
                }
            });
        });

        $('.saveSingleData').click(function(e) {
            e.preventDefault();
            var id = $(this).attr('data-schedule');
            var studentId = $(this).attr('id');
            var subjectId = $(this).attr('data-sub');
            var examId = $(this).attr('data-exam');
            var classId = $(this).attr('data-class');
            var classWork = $('#class_work_' + studentId + subjectId).val();
            var homeWork = $('#home_work_' + studentId + subjectId).val();
            var testWork = $('#test_work_' + studentId + subjectId).val();
            var exam = $('#exam_' + studentId + subjectId).val();

            $.ajax({
                url: "{{ route('teacher.marks_register.single') }}",
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                    studentId: studentId,
                    subjectId: subjectId,
                    examId: examId,
                    classId: classId,
                    classWork: classWork,
                    homeWork: homeWork,
                    testWork: testWork,
                    exam: exam,
                },
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false);
                    if (response['status'] == true) {
                        location.reload();
                        $('.error_' + studentId + subjectId).html('');
                    } else {
                        $('.error_' + studentId + subjectId).html(response.message);
                        location.reload();
                    }
                }
            });

        });
    </script>
@endsection
