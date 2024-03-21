@extends('layouts.app')
@section('title', 'Exam Timetable')
@section('exam_timetable', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Exam Timetable</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @foreach ($data as $item)
                <div class="card">
                    <div class="card-header">
                        <h3>Class:- {{ $item['class_name'] }}</h3>
                    </div>
                </div>
                @foreach ($item['exam'] as $vl)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Exam Name:- <strong>{{ $vl['exam_name'] }}</strong></h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Day</th>
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
                                    @foreach ($vl['subject'] as $item)
                                        <tr>
                                            <th>
                                                {{ $item['subject_name'] }}
                                            </th>
                                            <td>
                                                {{ !empty($item['exam_date']) ? date('l', strtotime($item['exam_date'])) : '' }}
                                            </td>
                                            <th>
                                                {{ $item['exam_date'] }}
                                            </th>
                                            <td>
                                                {{ !empty($item['start_time']) ? date('h:i A', strtotime($item['start_time'])) : '' }}
                                            </td>
                                            <td>
                                                {{ !empty($item['end_time']) ? date('h:i A', strtotime($item['end_time'])) : '' }}
                                            </td>
                                            <td>
                                                {{ $item['room_no'] }}
                                            </td>
                                            <td>
                                                {{ $item['marks'] }}
                                            </td>
                                            <td>
                                                {{ $item['passing_marks'] }}
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
