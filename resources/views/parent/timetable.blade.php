@extends('layouts.app')
@section('title', 'Timetable')
@section('children', 'active')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><span style="color: blue">{{ getUserFullName($student_id) }}</span> Timetable
                        ({{ getClassName($class_id) . ' - ' . getSubjectName($subject_id) }})
                    </h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ getClassName($class_id) . ' - ' . getSubjectName($subject_id) }}</h3>
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
                            @foreach ($data as $item)
                                <tr>
                                    <th>
                                        {{ $item['week_name'] }}
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
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>

@endsection
