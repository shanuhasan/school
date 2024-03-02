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
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.assign_class_teacher.create') }}" class="btn btn-primary">Assign Class</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    {{-- <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <form action="" method="get">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="class_id">Classes</label>
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
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('admin.assign_class_teacher.index') }}" class="btn btn-danger">Reset</a>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="teacher_id">Teacher</label>
                                    <select name="teacher_id" id="teacher_id" class="form-control">
                                        <option value="">Select Teacher</option>
                                        @foreach ($getTeacher as $item)
                                            <option value="{{ $item->id }}"
                                                {{ Request::get('teacher_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </section> --}}
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

@section('script')
    <script>
        function deleteClassTeacher(id) {
            var url = "{{ route('admin.assign_class_teacher.delete', 'ID') }}";
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
                            window.location.href = "{{ route('admin.assign_class_teacher.index') }}";
                        }
                    }
                });
            }
        }
    </script>
@endsection
