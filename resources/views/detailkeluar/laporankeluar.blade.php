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
        <div class="modal fade" id="export" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="exportForm" method="post" action=""
                              enctype="multipart/form-data">
                            @csrf
                            <label>Tanggal Transaksi</label>
                            <div class="form-row">
                                <div class="form-group col">
                                    <input type="date" class="form-control" name="start">
                                </div>
                                <div class="form-group col-1 mt-1 text-center">
                                    <label>-----</label>
                                </div>
                                <div class="form-group col">
                                    <input type="date" class="form-control" name="end">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="" id="exportAll" class="btn btn-sm btn-success">Export Semua</a>
                                <button type="submit" class="btn btn-sm btn-primary" id="importButton">Export
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Laporan Transaksi Keluar</h3>
            </div>
            <div class="card-body">
                <a href="#" id="exportTransaction" class="btn btn-sm btn-success my-2" data-toggle="modal" data-target="#export">Export Transaksi Keluar</a>
                <a href="#" id="exportDetail" class="btn btn-sm btn-success my-2" data-toggle="modal" data-target="#export">Export Detail Transaksi Keluar</a>
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
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>User</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $row)
                        <tr>
                            <input type="hidden" class="code" value="{{$row->kode}}">
                            <td>{{$row->created_at}}</td>
                            <td>{{$row->qty}}</td>
                            <td>{{$row->grand_total}}</td>
                            <td>{{$row->bayar}}</td>
                            <td>{{$row->kembalian}}</td>
                            <td>{{$row->id_users}}</td>
                            <td>
                                <a href="{{url('/laporankeluar/'. $row->id.'/detaillaporankeluar/')}}"
                                    class="btn btn-sm btn-warning">Detail Laporan</a>
                            </td>
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
            $(document).ready(function (){
                $('#exportTransaction').click(function (){
                    $('#exampleModalLabel').text('Export Transaksi Keluar')
                    $('#exportForm').attr('action', '{{url('export/transaksikeluar')}}')
                    $('#exportAll').attr('href', '{{url('export/transaksikeluar')}}')
                })
                $('#exportDetail').click(function (){
                    $('#exampleModalLabel').text('Export Detail Transaksi Keluar')
                    $('#exportForm').attr('action', '{{url('export/detailtransaksikeluar')}}')
                    $('#exportAll').attr('href', '{{url('export/detailtransaksikeluar')}}')
                })
            })
        </script>

@endpush
