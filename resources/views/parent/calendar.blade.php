@extends('layouts.app')
@section('title', 'Calender')
@section('children', 'active')
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
                    <h1>Calender ({{ $student->name }} {{ $student->last_name }})</h1>
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
            @foreach ($value['week'] as $week)
                events.push({
                    'title': "{{ $value['name'] }}",
                    'daysOfWeek': ["{{ $week['calendar_day'] }}"],
                    'startTime': "{{ $week['start_time'] }}",
                    'endTime': "{{ $week['end_time'] }}",
                })
            @endforeach
        @endforeach
        @foreach ($examTimetable as $value)
            @foreach ($value['examData'] as $exam)
                events.push({
                    'title': "{{ $value['exam_name'] }} - {{ $exam['subject_name'] }} ({{ date('h:i A', strtotime($exam['start_time'])) }} to {{ date('h:i A', strtotime($exam['end_time'])) }})",
                    'start': "{{ $exam['exam_date'] }}",
                    'end': "{{ $exam['exam_date'] }}",
                    color: 'red',
                    url: "{{ route('student.exam_timetable') }}"
                })
            @endforeach
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
