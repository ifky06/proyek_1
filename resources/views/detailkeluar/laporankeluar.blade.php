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
                <table class="table table-bordered table-striped w-100" id="allData">
                    <thead>
                    <tr>
                        <th>No</th>
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

            $(document).ready(function () {
                $('#allData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{url('laporankeluar/data')}}",
                        dataType: 'json',
                        type: 'POST',
                    },
                    columns: [
                        {data: 'number', name: 'number', searchable: false, orderable: false},
                        {data: 'created_at', name: 'created_at',
                            render: function (data, type, row) {
                                return row.created_at.slice(0,10)
                            }
                        },
                        {data: 'qty', name: 'qty'},
                        {data: 'grand_total', name: 'grand_total',
                            render: function (data, type, row) {
                                return toRupiah(row.grand_total);
                            }},
                        {data: 'bayar', name: 'bayar',
                            render: function (data, type, row) {
                                return toRupiah(row.bayar);
                            }
                        },
                        {data: 'kembalian', name: 'kembalian',
                            render: function (data, type, row) {
                                return toRupiah(row.kembalian);
                            }},
                        {data: 'id_users', name: 'id_users'},
                        {data: 'id', name: 'id', searchable: false, orderable: false,
                            render: function (data, type, row) {
                                return '<a href="{{url('/laporankeluar/')}}/'+row.id+'/detaillaporankeluar/" class="btn btn-sm btn-warning">Detail Laporan</a>'
                            }
                        },
                    ]

                });

                let toRupiah = (number) => {
                    return 'Rp. '+number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

            });
        </script>

@endpush
