@extends('layouts.app')
@section('title', 'Exam Result')
@section('exam_result', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Exam Result</h1>
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
                        <h3 class="card-title"><strong>{{ $item['exam_name'] }}</strong></h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Subjects</th>
                                    {{-- <th>Class Work</th>
                                    <th>Home Work</th>
                                    <th>Test Work</th> --}}
                                    <th>Exam</th>
                                    <th>Total Score</th>
                                    <th>Passing Marks</th>
                                    <th>Marks</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                    $totalScore = $fullMarks = $resultValidate = 0;
                                @endphp
                                @foreach ($item['subjects'] as $item)
                                    @php
                                        $totalScore = $totalScore + $item['total_score'];
                                        $fullMarks = $fullMarks + $item['marks'];
                                    @endphp
                                    <tr>
                                        <th>
                                            {{ $item['subject_name'] }}
                                        </th>
                                        {{-- <td>
                                            {{ $item['class_work'] }}
                                        </td>
                                        <th>
                                            {{ $item['home_work'] }}
                                        </th>
                                        <td>
                                            {{ $item['test_work'] }}
                                        </td> --}}
                                        <td>
                                            {{ $item['exam'] }}
                                        </td>
                                        <td>
                                            {{ $item['total_score'] }}
                                        </td>
                                        <td>
                                            {{ $item['passing_marks'] }}
                                        </td>
                                        <td>
                                            {{ $item['marks'] }}
                                        </td>
                                        <td>
                                            @if ($item['total_score'] >= $item['passing_marks'])
                                                <span style="color: green;font-weight:bold">Pass</span>
                                            @else
                                                @php
                                                    $resultValidate = 1;
                                                @endphp
                                                <span style="color: red;font-weight:bold">Fail</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="2"><b>Grand Total: {{ $totalScore }}/{{ $fullMarks }}</b></td>
                                    <td colspan="2"><b>Percentage: {{ round(($totalScore * 100) / $fullMarks, 2) }}%</b>
                                    <td colspan="5"><b>Result: </b>
                                        @if ($resultValidate == 0)
                                            <span style="color: green;font-weight:bold">Pass</span>
                                        @else
                                            <span style="color: red;font-weight:bold">Fail</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
