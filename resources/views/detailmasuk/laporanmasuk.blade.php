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
                                <button type="submit" class="btn btn-sm btn-primary" id="importButton" disabled>Export
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
                <a href="#" id="exportPdfTransaction" class="btn btn-sm btn-info my-2" data-toggle="modal" data-target="#export">Export PDF Transaksi Masuk</a>
                <a href="#" id="exportPdfDetail" class="btn btn-sm btn-info my-2" data-toggle="modal" data-target="#export">Export PDF Detail Transaksi Masuk</a>
                <a href="#" id="exportTransaction" class="btn btn-sm btn-success my-2" data-toggle="modal" data-target="#export">Export Transaksi Masuk</a>
                <a href="#" id="exportDetail" class="btn btn-sm btn-success my-2" data-toggle="modal" data-target="#export">Export Detail Transaksi Masuk</a>
                <div class="row pt-1">
                    <p class="px-3">Filter:</p>
                    <input type="date" class="form-control form-control-sm w-25 mr-1" name="start" id="dateStart">
                    <input type="date" class="form-control form-control-sm w-25 mr-1" name="end" id="dateEnd">
                    <button class="btn btn-sm btn-primary h-75 mr-1" disabled id="dateFilter">Filter</button>
                    <button class="btn btn-sm btn-warning h-75" disabled id="dateClear">Clear</button>
                </div>
                <table class="table table-bordered table-striped w-100" id="dataTable">
                    <thead>
                    <tr>
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
            $('#exportPdfTransaction').click(function (){
                $('#exampleModalLabel').text('Export PDF Transaksi Masuk')
                $('#exportForm').attr('action', '{{url('pdf/transaksimasuk')}}')
                $('#exportAll').attr('href', '{{url('pdf/transaksimasuk')}}')
            })
            $('#exportPdfDetail').click(function (){
                $('#exampleModalLabel').text('Export PDF Detail Transaksi Masuk')
                $('#exportForm').attr('action', '{{url('pdf/detailtransaksimasuk')}}')
                $('#exportAll').attr('href', '{{url('pdf/detailtransaksimasuk')}}')
            })
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
            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: false,
                searching: false,
                ajax: {
                    url: "{{url('laporanmasuk/data')}}",
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
