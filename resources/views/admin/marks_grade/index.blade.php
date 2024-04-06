@extends('layouts.app')
@section('title', 'Marks Grade')
@section('marks_grade', 'active')
@section('exam_open', 'menu-open')
@section('exam_active', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Marks Grade</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.marks_grade.create') }}" class="btn btn-primary">New Grade</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <form action="" method="get">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name"
                                        value="{{ Request::get('name') }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Filter</button>
                        <a href="{{ route('admin.marks_grade.index') }}" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
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
                                <th>Percent From</th>
                                <th>Percent To</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($marksGrade->isNotEmpty())
                                <?php $i = 1; ?>
                                @foreach ($marksGrade as $grade)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $grade->name }}</td>
                                        <td>{{ $grade->percent_from }}</td>
                                        <td>{{ $grade->percent_to }}</td>
                                        <td>{{ getName($grade->created_by) }}</td>
                                        <td>
                                            <a href="{{ route('admin.marks_grade.edit', $grade->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void()" onclick="deleteMarksGrade({{ $grade->id }})"
                                                class="text-danger w-4 h-4 mr-1">
                                                <i class="fas fa-trash"></i>
                                            </a>
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
                <div class="card-footer clearfix">
                    {!! $marksGrade->appends(request()->input())->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        function deleteMarksGrade(id) {
            var url = "{{ route('admin.marks_grade.delete', 'ID') }}";
            var newUrl = url.replace('ID', id);

            if (confirm('Are you sure want to delete')) {
                $.ajax({
                    url: newUrl,
                    type: 'get',
                    data: {},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response['status']) {
                            window.location.href = "{{ route('admin.marks_grade.index') }}";
                        }
                    }
                });
            }
        }
    </script>
@endsection
