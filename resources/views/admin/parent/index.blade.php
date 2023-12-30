@extends('layouts.app')
@section('title', 'Parents')
@section('parent', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Parents (Total : {{ $parents->total() }})</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.parent.create') }}" class="btn btn-primary">New Parent</a>
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
                                <a href="{{ route('admin.parent.index') }}" class="btn btn-danger">Reset</a>
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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($parents->isNotEmpty())
                                <?php $i = 1; ?>
                                @foreach ($parents as $parent)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <div class="image">
                                                <img src="{{ !empty($parent->image) ? asset('uploads/user/' . $parent->image) : asset('admin-assets/dist/img/avatar5.png') }}"
                                                    class="img-circle elevation-2" width='40'>
                                            </div>
                                        </td>
                                        <td>{{ $parent->name }}</td>
                                        <td>{{ $parent->email }}</td>
                                        <td>{{ $parent->phone }}</td>
                                        <td>
                                            @if ($parent->status == 1)
                                                <i class="fas fa-check"></i>
                                            @else
                                                <i class="fas fa-times"></i>
                                            @endif

                                        </td>
                                        <td>
                                            <a href="{{ route('admin.parent.edit', $parent->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void()" onclick="deleteParent({{ $parent->id }})"
                                                class="text-danger w-4 h-4 mr-1">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <a href="{{ route('admin.parent.student.index', $parent->id) }}"
                                                class="btn btn-primary btn-sm">
                                                My Student
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
                    {!! $parents->appends(request()->input())->links('pagination::bootstrap-5') !!}
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
