@extends('layouts.template')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Satuan</h1>
                </div>
{{--                <div class="col-sm-6">--}}
{{--                    <ol class="breadcrumb float-sm-right">--}}
{{--                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>--}}
{{--                        <li class="breadcrumb-item active">Dashboard</li>--}}
{{--                    </ol>--}}
{{--                </div>--}}
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <a href="{{url('satuan/create')}}" class="btn btn-sm btn-success my-2">Tambah Data</a>
                <form action="{{url('satuan')}}" method="get">
                    <div class="input-group mb-3 w-25">
                        <input type="text" name="search" class="form-control" placeholder="Search"
                               value="{{request()->search}}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered table-striped mb-3">
                    <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Satuan</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $row)
                        <tr>
                            <td>{{$row->kode}}</td>
                            <td>{{$row->satuan}}</td>
                            <td>
                                <a href="{{route('satuan.edit', $row->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{route('satuan.destroy', $row->id)}}" method="post" class="delete d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
        </div>
        <!-- /.card -->

    </section>
@endsection

@push('css')

@endpush

@push('scripts')

    <script>
        $('.delete').submit(function () {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Setelah dihapus, Anda tidak dapat memulihkan Data ini lagi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6', // blue
                cancelButtonColor: '#d33', // red
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
            return false;
        });
    </script>

@endpush
