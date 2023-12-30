@extends('layouts.app')
@section('title', 'Students')
@section('student', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Students (Total : {{ $students->total() }})</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.student.create') }}" class="btn btn-primary">New Student</a>
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
                                    <label for="name">First Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name"
                                        value="{{ Request::get('name') }}">
                                </div>
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('admin.student.index') }}" class="btn btn-danger">Reset</a>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Name"
                                        value="{{ Request::get('last_name') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="class_id">Class</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">Select Class</option>
                                        @foreach ($getClass as $item)
                                            <option value="{{ $item->id }}"
                                                {{ Request::get('class_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
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
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Class</th>
                                <th>Status</th>
                                <th>Action</th>
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
                                        <td>{{ $student->name }} {{ $student->last_name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ studentClassName($student->class_id) }}</td>
                                        <td>
                                            @if ($student->status == 1)
                                                <i class="fas fa-check"></i>
                                            @else
                                                <i class="fas fa-times"></i>
                                            @endif

                                        </td>
                                        <td>
                                            <a href="{{ route('admin.student.edit', $student->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void()" onclick="deleteStudent({{ $student->id }})"
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
                    {!! $students->appends(request()->input())->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        function deleteStudent(id) {
            var url = "{{ route('admin.student.delete', 'ID') }}";
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
                            window.location.href = "{{ route('admin.student.index') }}";
                        }
                    }
                });
            }
        }
    </script>
@endsection
