@extends('layouts.app')
@section('title', 'Calender')
@section('calendar', 'active')
@section('style')
    <style>
        .fc-daygrid-event {
            white-space: normal;
        }
    </style>

@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Calender</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div id="calendar"></div>
        </div>
        <!-- /.card -->
    </section>

@endsection

@section('script')
    <script src="{{ asset('admin-assets/dist/js/fullcalendar/index.global.js') }}"></script>
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        var events = new Array();
        @foreach ($timetable as $value)
            events.push({
                'title': "Class:- {{ $value['class_name'] }} - {{ $value['subject_name'] }}",
                'daysOfWeek': ["{{ $value['calendar_day'] }}"],
                'startTime': "{{ $value['start_time'] }}",
                'endTime': "{{ $value['end_time'] }}",
            })
        @endforeach
        @foreach ($examTimetable as $value)
            events.push({
                'title': "Exam:- {{ $value['class_name'] }} - {{ $value['exam_name'] }} - {{ $value['subject_name'] }} ({{ date('h:i A', strtotime($value['start_time'])) }} to {{ date('h:i A', strtotime($value['end_time'])) }})",
                'start': "{{ $value['exam_date'] }}",
                'end': "{{ $value['exam_date'] }}",
                color: 'red',
                url: "{{ route('teacher.exam_timetable') }}"
            })
        @endforeach


        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            initialDate: "<?= date('Y-m-d') ?>",
            navLinks: true, // can click day/week names to navigate views
            //businessHours: true, // display business hours
            editable: false,
            // selectable: true,
            events: events
        });

        calendar.render();
        // });
    </script>
@endsection
