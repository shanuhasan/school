@extends('layouts.app')
@section('title', 'Teachers')
@section('teacher', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Teachers (Total : {{ $teachers->total() }})</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.teacher.create') }}" class="btn btn-primary">New Teacher</a>
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
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('admin.teacher.index') }}" class="btn btn-danger">Reset</a>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" class="form-control" placeholder="Email"
                                        value="{{ Request::get('email') }}">
                                </div>
                            </div>

                        </div>
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
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date of Joining</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($teachers->isNotEmpty())
                                <?php $i = 1; ?>
                                @foreach ($teachers as $teacher)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <div class="image">
                                                <img src="{{ !empty($teacher->image) ? asset('uploads/user/' . $teacher->image) : asset('admin-assets/dist/img/avatar5.png') }}"
                                                    class="img-circle elevation-2" width='40'>
                                            </div>
                                        </td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->phone }}</td>
                                        <td>{{ date('d-m-Y', strtotime($teacher->admission_date)) }}</td>
                                        <td>{{ $teacher->gender }}</td>
                                        <td>
                                            @if ($teacher->status == 1)
                                                <i class="fas fa-check"></i>
                                            @else
                                                <i class="fas fa-times"></i>
                                            @endif

                                        </td>
                                        <td>
                                            <a href="{{ route('admin.teacher.edit', $teacher->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void()" onclick="deleteTeacher({{ $teacher->id }})"
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
                    {!! $teachers->appends(request()->input())->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        function deleteTeacher(id) {
            var url = "{{ route('admin.teacher.delete', 'ID') }}";
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
                            window.location.href = "{{ route('admin.teacher.index') }}";
                        }
                    }
                });
            }
        }
    </script>
@endsection
