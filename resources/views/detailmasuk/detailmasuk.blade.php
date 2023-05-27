@extends('layouts.template')

@section('title', 'Detail Laporan Transaksi Masuk')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Laporan Transaksi Masuk</h1>
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
                <h3 class="card-title">Detail Laporan Transaksi Masuk</h3>
            </div>
            <div class="card-body">
                {{-- <a href="{{url('export/transaksimasuk')}}" class="btn btn-sm btn-success my-2">Export Transaksi Masuk</a>
                <a href="{{url('export/detailtransaksimasuk')}}" class="btn btn-sm btn-success my-2">Export Detail Transaksi Masuk</a> --}}
                <form action="{{url('detaillaporanmasuk')}}" method="get">
                    {{-- <div class="input-group mb-3 w-25">
                        <input type="text" name="search" class="form-control" placeholder="Search"
                               value="{{request()->search}}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div> --}}
                </form>

                <p><span class="font-weight-bold"><b>Tanggal : </b>{{$tm->created_at}}</span><br>
                    <span class="font-weight-bold"><b>ID Transaksi : </b>{{$tm->id}}</span><br>
                    <span class="font-weight-bold"><b>User : </b>{{$tm->user->username}}</span></p>

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        {{-- <th>Tanggal</th>
                        <th>ID Transaksi</th> --}}
                        <th>ID Barang</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Pemasok</th>
                        <th>Jumlah</th>
                        {{-- <th>User</th> --}}
                    </tr>
                    </thead>
                    <tbody>
                    @if ($detail->count()>0)
                    @foreach($detail as $row)
                        <tr>
                            <input type="hidden" class="code" value="{{$row->kode}}">
                            {{-- <td>{{$row->tanggal}}</td>
                            <td>{{$row->id_transaksi}}</td> --}}
                            <td>{{$row->id_barang}}</td>
                            <td>{{$row->barang->kode}}</td>
                            <td>{{$row->barang->nama}}</td>
                            <td>{{$row->barang->kategori->nama}}</td>
                            <td>{{$row->barang->pemasok->nama}}</td>
                            <td>{{$row->qty}}</td>
                            {{-- <td>{{$row->id_user}}</td> --}}
                        </tr>
                    @endforeach
                    </tbody>
                    @endif
                </table>
                {{-- {{ $data->links() }} --}}
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
