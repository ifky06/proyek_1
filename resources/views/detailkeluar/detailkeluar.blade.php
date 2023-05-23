@extends('layouts.template')

@section('title', 'Laporan Transaksi Keluar')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Laporan Transaksi Keluar</h1>
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
                <h3 class="card-title">Laporan Transaksi Keluar</h3>
            </div>
            <div class="card-body">
                <a href="{{url('export/transaksikeluar')}}" class="btn btn-sm btn-success my-2">Export Transaksi Keluar</a>
                <a href="{{url('export/detailtransaksikeluar')}}" class="btn btn-sm btn-success my-2">Export Detail Transaksi Keluar</a>
                <form action="{{url('laporankeluar')}}" method="get">
                    <div class="input-group mb-3 w-25">
                        <input type="text" name="search" class="form-control" placeholder="Search"
                               value="{{request()->search}}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>ID Transaksi</th>
                        <th>ID Barang</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Pemasok</th>
                        <th>Jumlah</th>
                        <th>User</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $row)
                        <tr>
                            <input type="hidden" class="code" value="{{$row->kode}}">
                            <td>{{$row->tanggal}}</td>
                            <td>{{$row->id_transaksi}}</td>
                            <td>{{$row->id_barang}}</td>
                            <td>{{$row->barang->kode}}</td>
                            <td>{{$row->barang->nama}}</td>
                            <td>{{$row->barang->kategori->nama}}</td>
                            <td>{{$row->barang->pemasok->nama}}</td>
                            <td>{{$row->qty}}</td>
                            <td>{{$row->id_user}}</td>
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

    {{--    <script>--}}
    {{--        alert('Selamat Datang');--}}
    {{--    </script>--}}

@endpush
