@extends('layouts.app')
@section('title', 'My Students')
@section('my_student', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Students</h1>
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
                                <th>Image</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($students->isNotEmpty())
                                <?php $i = 1; ?>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <div class="image">
                                                <img src="{{ !empty($student->image) ? asset('uploads/user/' . $student->image) : asset('admin-assets/dist/img/avatar5.png') }}"
                                                    class="img-circle elevation-2" width='40'>
                                            </div>
                                        </td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ studentClassName($student->class_id) }}</td>
                                        <td>{{ $student->email }}</td>
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
                    {!! $students->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
