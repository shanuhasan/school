@extends('layouts.app')
@section('title', 'My Class & Subject')
@section('my_class_subject', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Class & Subject</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('message')
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Subject Type</th>
                                <th>Today Timetable</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($classSubject->isNotEmpty())
                                <?php $i = 1; ?>
                                @foreach ($classSubject as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->class_name }}</td>
                                        <td>{{ $item->subject_name }}</td>
                                        <td>{{ $item->subject_type }}</td>
                                        <td>
                                            @php
                                                $model = $item->getTeacherClassTimetable(
                                                    $item->class_id,
                                                    $item->subject_id,
                                                );
                                            @endphp
                                            @if (!empty($model))
                                                {{ date('h:i A', strtotime($model->start_time)) . ' to ' . date('h:i A', strtotime($model->end_time)) }}
                                                <br>
                                                Room No. - {{ $model->room_no }}
                                            @endif
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        <td><a href="{{ route('teacher.timetable', ['class_id' => $item->class_id, 'subject_id' => $item->subject_id]) }}"
                                                class="btn btn-info btn-sm">Timetable</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">Record Not Found</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{-- {!! $classSubject->appends(request()->input())->links('pagination::bootstrap-5') !!} --}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
