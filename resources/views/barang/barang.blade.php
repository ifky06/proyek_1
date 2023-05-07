@extends('layouts.template')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Barang</h1>
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
            <div class="card-header">
                <h3 class="card-title">Title</h3>
            </div>
            <div class="card-body">

                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Pemasok</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $row)
                        <tr>
                            <td>{{$row->nama}}</td>
                            <td>{{$row->kategori->nama}}</td>
                            <td>{{$row->pemasok->nama}}</td>
                            <td>{{$row->satuan->satuan}}</td>
                            <td>{{$row->harga}}</td>
                            <td>{{$row->stok}}</td>
                            <td>
                                <a href="{{route('barang.edit', $row->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{route('barang.destroy', $row->id)}}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')">Delete</button>
                                </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->

    </section>
@endsection

@push('css')

@endpush

@push('scripts')

    {{--    <script>--}}
    {{--        alert('Selamat Datang');--}}
    {{--    </script>--}}

@endpush
