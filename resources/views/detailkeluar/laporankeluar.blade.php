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
                                    <input type="date" class="form-control" name="start" id="exportDateStart">
                                </div>
                                <div class="form-group col-1 mt-1 text-center">
                                    <label>-----</label>
                                </div>
                                <div class="form-group col">
                                    <input type="date" class="form-control" name="end" id="exportDateEnd">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="" id="exportAll" class="btn btn-sm btn-success">Export Semua</a>
                                <button type="submit" class="btn btn-sm btn-primary" disabled id="importButton">Export
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
                <a href="#" id="exportPdfTransaction" class="btn btn-sm btn-info my-2" data-toggle="modal" data-target="#export">Export PDF Transaksi Keluar</a>
                <a href="#" id="exportPdfDetail" class="btn btn-sm btn-info my-2" data-toggle="modal" data-target="#export">Export PDF Detail Transaksi Keluar</a>
                <a href="#" id="exportTransaction" class="btn btn-sm btn-success my-2" data-toggle="modal" data-target="#export">Export Transaksi Keluar</a>
                <a href="#" id="exportDetail" class="btn btn-sm btn-success my-2" data-toggle="modal" data-target="#export">Export Detail Transaksi Keluar</a>
                <div class="row pt-1">
                    <p class="px-3">Filter:</p>
                    <input type="date" class="form-control form-control-sm w-25 mr-1" name="start" id="dateStart">
                    <input type="date" class="form-control form-control-sm w-25 mr-1" name="end" id="dateEnd">
                    <button class="btn btn-sm btn-primary h-75 mr-1" disabled id="dateFilter">Filter</button>
                    <button class="btn btn-sm btn-warning h-75" disabled id="dateClear">Clear</button>
                </div>
                <table class="table table-bordered table-striped w-100" id="allData">
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
                $('#exportPdfTransaction').click(function (){
                    $('#exampleModalLabel').text('Export PDF Transaksi Keluar')
                    $('#exportForm').attr('action', '{{url('pdf/transaksikeluar')}}')
                    $('#exportAll').attr('href', '{{url('pdf/transaksikeluar')}}')
                })
                $('#exportPdfDetail').click(function (){
                    $('#exampleModalLabel').text('Export PDF Detail Transaksi Keluar')
                    $('#exportForm').attr('action', '{{url('pdf/detailtransaksikeluar')}}')
                    $('#exportAll').attr('href', '{{url('pdf/detailtransaksikeluar')}}')
                })
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

                $('#exportDateStart').change(function () {
                    exportDateCheck()
                })
                $('#exportDateEnd').change(function () {
                    exportDateCheck()
                })

                let exportDateCheck = function () {

                    if (exportDateCondition()) {
                        return $('#importButton').attr('disabled', false)
                    } else {
                        return $('#importButton').attr('disabled', true)
                    }
                }

                let exportDateCondition = function (){
                    let now = new Date();
                    return ($('#exportDateStart').val() < $('#exportDateEnd').val())
                        && ($('#exportDateStart').val() !== '') && ($('#exportDateEnd').val() !== '')
                        &&  ($('#exportDateStart').val() <= now.toISOString().slice(0,10))
                        && ($('#exportDateEnd').val() <= now.toISOString().slice(0,10));
                }
            })

            $(document).ready(function () {
                let table = $('#allData').DataTable({
                    processing: true,
                    serverSide: false,
                    searching: false,
                    ajax: {
                        url: "{{url('laporankeluar/data')}}",
                        dataType: 'json',
                        type: 'POST',
                        data: function (d) {
                            d.start = $('#dateStart').val()
                            d.end = $('#dateEnd').val()
                        }
                    },
                    columns: [
                        {data: 'created_at', name: 'created_at',
                            render: function (data, type, row) {
                            // console.log(row.created_at.slice(0,10))
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

                $('#dateFilter').click(function () {
                    table.ajax.reload();
                    dateCheck();
                    dateClearCheck();
                });

                $('#dateClear').click(function () {
                    $('#dateStart').val('');
                    $('#dateEnd').val('');
                    table.ajax.reload();
                    dateCheck();
                    dateClearCheck();
                });

                let toRupiah = (number) => {
                    return 'Rp. '+number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                $('#dateStart').change(function () {
                    dateCheck();
                    dateClearCheck()
                })
                $('#dateEnd').change(function () {
                    dateCheck();
                    dateClearCheck()
                })

                let dateCheck = function () {

                    if (dateCondition()) {
                        return $('#dateFilter').attr('disabled', false)
                    } else {
                        return $('#dateFilter').attr('disabled', true)
                    }
                }

                let dateClearCheck = function () {

                    if (dateClearCondition()) {
                        return $('#dateClear').attr('disabled', false)
                    } else {
                        return $('#dateClear').attr('disabled', true)
                    }
                }

                let dateCondition = function (){
                    let now = new Date();
                    return ($('#dateStart').val() < $('#dateEnd').val())
                        && ($('#dateStart').val() !== '') && ($('#dateEnd').val() !== '')
                        &&  ($('#dateStart').val() <= now.toISOString().slice(0,10))
                        && ($('#dateEnd').val() <= now.toISOString().slice(0,10));
                }

                let dateClearCondition = function (){
                    return ($('#dateStart').val() !== '' || $('#dateEnd').val() !== '')
                }





            });


        </script>

@endpush
