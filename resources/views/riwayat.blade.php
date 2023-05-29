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
                                <a href="{{url('export/riwayat')}}" id="exportAll" class="btn btn-sm btn-success">Export Semua</a>
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
                <h3 class="card-title">Riwayat</h3>
            </div>
            <div class="card-body">
                <a href="#" class="btn btn-sm btn-success my-2" data-toggle="modal" data-target="#export">Export Riwayat</a>
                <table class="table table-bordered table-striped" id="dataTable" >
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
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{url('riwayat/data')}}",
                    dataType: 'json',
                    type: 'POST',
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
        });
    </script>


@endpush
