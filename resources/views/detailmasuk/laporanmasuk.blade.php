@extends('layouts.template')

@section('title', 'Laporan Transaksi Masuk')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Laporan Transaksi Masuk</h1>
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
                <h3 class="card-title">Laporan Transaksi Masuk</h3>
            </div>
            <div class="card-body">
                <a href="#" id="exportTransaction" class="btn btn-sm btn-success my-2" data-toggle="modal" data-target="#export">Export Transaksi Masuk</a>
                <a href="#" id="exportDetail" class="btn btn-sm btn-success my-2" data-toggle="modal" data-target="#export">Export Detail Transaksi Masuk</a>
                <table class="table table-bordered table-striped w-100" id="dataTable">
                    <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>User</th>
                        <th style="width: 15%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
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

    <script>
        $(document).ready(function (){
            $('#exportTransaction').click(function (){
                $('#exampleModalLabel').text('Export Transaksi Masuk')
                $('#exportForm').attr('action', '{{url('export/transaksimasuk')}}')
                $('#exportAll').attr('href', '{{url('export/transaksimasuk')}}')
            })
            $('#exportDetail').click(function (){
                $('#exampleModalLabel').text('Export Detail Transaksi Masuk')
                $('#exportForm').attr('action', '{{url('export/detailtransaksimasuk')}}')
                $('#exportAll').attr('href', '{{url('export/detailtransaksimasuk')}}')
            })
        })

        $(document).ready(function () {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{url('laporanmasuk/data')}}",
                    dataType: 'json',
                    type: 'POST',
                },
                columns: [
                    {data: 'number', name: 'number'},
                    {data: 'created_at', name: 'created_at',
                        render: function (data, type, row) {
                            return row.created_at.slice(0,10)
                        },
                    },
                    {data: 'qty', name: 'qty'},
                    {data: 'id_user', name: 'id_user'},
                    {data: 'id', name: 'id',
                        render: function (data, type, row) {
                            return '<a href="{{url('/laporanmasuk/')}}/'+row.id+'/detaillaporanmasuk/" class="btn btn-sm btn-warning">Detail Laporan</a>'
                        },
                    },
                ]

            });
        });
    </script>

@endpush
