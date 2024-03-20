@extends('layouts.app')
@section('title', 'Children Subjects')
@section('children', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Children Subjects <span style="color:blue">({{ $user->name }})</span></h1>
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
                                <th>Name</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($subjects->isNotEmpty())
                                <?php $i = 1; ?>
                                @foreach ($subjects as $subject)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ getSubjectName($subject->subject_id) }}</td>
                                        <td>{{ getSubjectDetail($subject->subject_id)->type }}</td>
                                        <td><a href="{{ route('parent.timetable', ['class_id' => $subject->class_id, 'subject_id' => $subject->subject_id, 'student_id' => $user->id]) }}"
                                                class="btn btn-info btn-sm">Timetable</a></td>
                                        </td>
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
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
