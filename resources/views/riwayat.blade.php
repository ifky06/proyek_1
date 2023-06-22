@extends('layouts.template')

@section('title', 'Riwayat Perubahan Data')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Riwayat</h1>
                </div>
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
                        <h5 class="modal-title" id="exampleModalLabel">Export Riwayat Perubahan Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="exportForm" method="post" action="{{url('export/riwayat')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <label>Tanggal Riwayat</label>
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
                                <a href="{{url('export/riwayat')}}" id="exportAll" class="btn btn-sm btn-success">Export Semua</a>
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
                <h3 class="card-title">Riwayat</h3>
            </div>
            <div class="card-body">
                <a href="#" class="btn btn-sm btn-success my-2" data-toggle="modal" data-target="#export">Export Riwayat</a>
                <div class="row pt-1">
                    <p class="px-3">Filter:</p>
                    <input type="date" class="form-control form-control-sm w-25 mr-1" name="start" id="dateStart">
                    <input type="date" class="form-control form-control-sm w-25 mr-1" name="end" id="dateEnd">
                    <button class="btn btn-sm btn-primary h-75 mr-1" disabled id="dateFilter">Filter</button>
                    <button class="btn btn-sm btn-warning h-75" disabled id="dateClear">Clear</button>
                </div>
                <table class="table table-bordered table-striped w-100" id="dataTable" >
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>User</th>
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
        $(document).ready(function () {
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


            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: false,
                searching: false,
                ajax: {
                    url: "{{url('riwayat/data')}}",
                    dataType: 'json',
                    type: 'POST',
                    data: function (d) {
                        d.start = $('#dateStart').val()
                        d.end = $('#dateEnd').val()
                    }
                },
                columns: [
                    {data: 'tanggal', name: 'tanggal', orderData: 0,
                        render: function (data, type, row) {
                            return row.tanggal.slice(0,10)
                        },
                    },
                    {data: 'jenis', name: 'jenis'},
                    {data: 'lokasi', name: 'lokasi'},
                    {data: 'keterangan', name: 'keterangan'},
                    {data: 'id_user', name: 'id_user'},
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
