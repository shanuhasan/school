@extends('layouts.app')
@section('title', 'Parent Students')
@section('parent', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Parent Students ({{ $parent->name }})</h1>
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
                                    <label for="id">StudentID</label>
                                    <input type="text" name="id" class="form-control" placeholder="Id"
                                        value="{{ Request::get('id') }}">
                                </div>
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('admin.parent.student.index', $parentId) }}"
                                    class="btn btn-danger">Reset</a>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name"
                                        value="{{ Request::get('name') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                                        value="{{ Request::get('last_name') }}">
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
            @if (!empty($students))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Students List</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Parent Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                        <td>{{ $student->email }}</td>
                                        <td>{{ getName($student->parent_id) }}</td>
                                        <td>
                                            @if ($student->status == 1)
                                                <i class="fas fa-check"></i>
                                            @else
                                                <i class="fas fa-times"></i>
                                            @endif

                                        </td>
                                        <td>
                                            <a href="{{ route('admin.parent.student_assign', ['student_id' => $student->id, 'parent_id' => $parentId]) }}"
                                                class="btn btn-primary btn-sm">
                                                Add Student To Parent
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Parent Student List</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Parent Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($parentStudents as $student)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        <div class="image">
                                            <img src="{{ !empty($student->image) ? asset('uploads/user/' . $student->image) : asset('admin-assets/dist/img/avatar5.png') }}"
                                                class="img-circle elevation-2" width='40'>
                                        </div>
                                    </td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ getName($student->parent_id) }}</td>
                                    <td>
                                        @if ($student->status == 1)
                                            <i class="fas fa-check"></i>
                                        @else
                                            <i class="fas fa-times"></i>
                                        @endif

                                    </td>
                                    <td>
                                        <a href="{{ route('admin.parent.student_assign_delete', ['student_id' => $student->id]) }}"
                                            class="text-danger w-4 h-4 mr-1">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        function deleteParent(id) {
            var url = "{{ route('admin.parent.delete', 'ID') }}";
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
                            window.location.href = "{{ route('admin.parent.index') }}";
                        }
                    }
                });
            }
        }
    </script>
@endsection
