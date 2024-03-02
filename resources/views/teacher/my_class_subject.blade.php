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
                                <th>Created By</th>
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
                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
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
